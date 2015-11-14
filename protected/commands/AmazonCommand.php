<?php

/**
 *
 * @desc       AmazonCommand.php file.
 *
 * @author     Qiu Xincai <qiuxc@eileengrays.com>
 * @link       http://www.eileengrays.com/
 * @copyright  EileenGrays.Com 2013-2015
 * @license    http://www.eileengrays.com/
 */
class AmazonCommand extends CConsoleCommand
{
    public function actionImport()
    {
        $amazonConfig = CConfigHelper::getConfig('amazon');
        $config = $amazonConfig['lb'];
        set_time_limit(0);
        $service = new Amazon();
        $erp = $this->initErp();
        $lastUpdatedAfter = gmdate('Y-m-d\TH:i:s', time() - 1 * 86400);
        $orderStatus = array('Unshipped', 'PartiallyShipped', 'Shipped');
        $response = $service->getListOrders($config,$lastUpdatedAfter,$orderStatus);
        $dom = new DOMDocument();
        $dom->loadXML($response->toXML());
        $xmlObj = simplexml_import_dom($dom);
        $orders = $xmlObj->ListOrdersResult->Orders->Order;

        foreach($orders as $order)
        {
            $erpFlag = true;
            $store_name = 'amazon_lb';
            $orderId = $order->AmazonOrderId;

            //过滤刷单
            if (!$this->isNormalOrder('amazon', trim($orderId))) {
                continue;
            }

            $oAOrder = Orders::model()->findByAttributes(array('increment_id' => $orderId));
            if ($oAOrder != null) {
                echo "OA has finished import\r\n";
                continue;
            }
            //检查订单是否导入ERP
            try{
                $erpOrderExists = $erp->search('oa.order', [['increment_id', '=', $orderId]], 0, 1);
            }
            catch(Exception $e)
            {
                echo "Search ERP Order failed .";
            }
            if ($erpOrderExists) {
                $erpFlag = false;
                echo "ERP has finished import\r\n";
            }
            $created_at = date('Y-m-d H:i:s', strtotime($order->LastUpdateDate));
            $subtotal = $order->OrderTotal->Amount;
            $grand_total = $subtotal;
            $order_currency_code = $order->OrderTotal->CurrencyCode;
            $total_paid = $subtotal;


            $shipping_method = $order->FulfillmentChannel;
            $customer_id = $order->BuyerName;
            $customer_firstname = $order->BuyerName;
            $customer_lastname = $customer_firstname;
            if ($shipping_method == 'AFN') {
                $status = 'fba';
            } else {
                $status = 'new';
            }
            //订单基本信息
            $currency_rate = 1;
            $sysVariateModel = SysVariate::model()->findByAttributes(array('title'=>$order_currency_code));
            if($sysVariateModel != null)
                $currency_rate =  $sysVariateModel->value;

            $ordersData = array(
                'increment_id' => $orderId,
                'create_at' => $created_at,
                'subtotal' => $subtotal,
                'grand_total' => $grand_total,
                'order_currency_code' => $order_currency_code,
                'total_paid' => $total_paid,
                'store_name' => $store_name,
                'status' => $status,
                'shipping_method' => $shipping_method,
                'customer_id' => $customer_id,
                'customer_firstname' => $customer_firstname,
                'customer_lastname' => $customer_lastname,
                'currency_rate' => $currency_rate,
                'import_at' => date("Y-m-d H:i:s", time())
            );

            $ordersModel = new Orders();
            $ordersModel->setAttributes($ordersData);
            $ordersModel->save();
            $oAOrderId = $ordersModel->getAttribute('id');

            $paymentsData = array(
                'order_id' => $oAOrderId,
                'amount_ordered' => $grand_total,
                'method' => strval($order->PaymentMethod)
            );
            //地址信息
            $address = $order->ShippingAddress->AddressLine1;
            if (isset($order->ShippingAddress->AddressLine2)) {
                $address .= " " . $order->ShippingAddress->AddressLine2;
            }

            if (isset($order->ShippingAddress->AddressLine3)) {
                $address .= " " . $order->ShippingAddress->AddressLine3;
            }

            $shippingBillingAddressData = array(
                'order_id' => $oAOrderId,
                'firstname' => strval($order->ShippingAddress->Name),
                'street' => strval($address),
                'city' => strval($order->ShippingAddress->City),
                'region' => strval($order->ShippingAddress->StateOrRegion),
                'postcode' => strval($order->ShippingAddress->PostalCode),
                'country_id' => strval($order->ShippingAddress->CountryCode),
                'telephone' => strval($order->ShippingAddress->Phone),
                'mobile' => strval($order->ShippingAddress->Phone)
            );
            if (!empty($oAOrderId)) {
                echo "Import Amazon Order into OA system success\r\n";

                try {
                    $paymentsModel = new Payments();
                    $paymentsModel->setAttributes($paymentsData);
                    $paymentsModel->save();
                    if ($paymentsModel->hasErrors()) {
                        throw new Exception(CModelHelper::getError($paymentsModel));
                    }
                    echo "Import Amazon Order Payments into OA system success.\r\n";
                } catch (Exception $e) {
                    echo "Import Amazon Order Payments into OA system failed. message:".$e->getMessage()."\r\n";
                }

                //收货地址
                try {
                    $shippingBillingAddressModel = new ShippingBillingAddress();
                    $shippingBillingAddressModel->setAttributes($shippingBillingAddressData);
                    $shippingBillingAddressModel->save();
                    if ($shippingBillingAddressModel->hasErrors()) {
                        throw new Exception(CModelHelper::getError($shippingBillingAddressModel));
                    }
                    echo "Import Amazon Order Shipping Billing Address into OA system success.\r\n";
                } catch (Exception $e) {
                    echo "Import Amazon Order Shipping Billing Address into OA system failed. message:".$e->getMessage()."\r\n";
                }
            } else {
                echo "Import Amazon Order into OA system failed.message:".CModelHelper::getError($ordersModel)."\r\n";
            }

            if($erpFlag && !empty($oAOrderId))
            {
                //导入订单信息
                if(empty($ordersData['shipping_method']))
                {
                    unset($ordersData['shipping_method']);
                }

                $erpOrders =  array_merge($ordersData, array(
                    'ref_order_id' => $orderId
                ));
                try {
                    $erpOrderId = $erp->create('oa.order',$erpOrders);
                    echo "Import Amazon Order into ERP system success .\r\n";
                } catch (Exception $e) {
                    echo "Import Amazon Order into ERP system failed . message:" . $e->getMessage() . ", code: " . $e->getCode() . "\r\n";
                }

                if (!empty($erpOrderId)) {
                    try {
                        if($paymentsData)
                        {
                            $erpPaymentsData = array_merge($paymentsData,array(
                                'order_id' => $erpOrderId
                            ));
                            $erp->create('oa.payments', $erpPaymentsData);
                            echo "Import Amazon Order payments into ERP system success .\r\n";
                        }
                    } catch (Exception $e) {
                        echo "Import Amazon Order payments into ERP system failed . message:" . $e->getMessage() . ", code: " . $e->getCode() . "\r\n";
                    }

                    try {
                        if($shippingBillingAddressData)
                        {
                            $erpShippingBillingAddressData = array_merge($shippingBillingAddressData,array(
                                'order_id' => $erpOrderId
                            ));
                            $erp->create('oa.shipping.billing.address', $erpShippingBillingAddressData);
                            echo "Import Amazon Order shipping billing address into ERP system success .\r\n";
                        }
                    } catch (Exception $e) {
                        echo "Import Amazon Order shipping billing address into ERP system failed . message:" . $e->getMessage() . ", code: " . $e->getCode() . "\r\n";
                    }
                    //导入收货地址
                }
            }
            $itemResponse = $service->getListOrderItems($config,$orderId);
            $itemDom = new DOMDocument();
            $itemDom->loadXML($itemResponse->toXML());
            $itemXmlObj = simplexml_import_dom($itemDom);
            $orderItems = $itemXmlObj->ListOrderItemsResult->OrderItems->OrderItem;
            $ShippingPrice = 0;
            foreach ($orderItems as $item) {
                $sku = $item->SellerSKU;
                // echo "\nitemSKU:".$sku;
                $sku = strtoupper($sku);
                $sku = trim($sku);
                if(isset($replaceSkuArray[$sku])){
                    $sku = $replaceSkuArray[$sku];
                }else{
                    $skuToSkuModel = SkuToSku::model()->findByAttributes(array('old_sku'=>$sku));
                    if($skuToSkuModel != null)
                    {
                        $sku = $skuToSkuModel['new_sku'];
                    }
                }

                $name = $item->Title;
                $item_id = $item->OrderItemId;
                $qty_ordered = $item->QuantityOrdered;
                $row_total = $item->ItemPrice->Amount;
                $ShippingPrice += $item->ShippingPrice->Amount;
                $price = $row_total / $qty_ordered;

                $orderItem = array(
                    'order_id' => $oAOrderId,
                    'sku' => $sku,
                    'name' => $name,
                    'item_id' => $item_id,
                    'qty_ordered' => $qty_ordered,
                    'row_total' => $row_total,
                    'price' => $price,
//                    'pictureurl' => $pictureurl,
//                    'product_options' => $product_options
                );

                try {
                    $paymentsModel = new OrderItems();
                    $paymentsModel->setAttributes($orderItem);
                    $paymentsModel->save();
                    if ($paymentsModel->hasErrors()) {
                        throw new Exception(CModelHelper::getError($paymentsModel));
                    }
                    echo "Import AliExpress Order item into OA system success\r\n";
                } catch (Exception $e) {
                    echo "Import AliExpress Order item into OA system failed . message:".$e->getMessage()."\r\n";
                }

                if ($erpFlag) {
                    //导入订单明细
                    try {
                        $erpOrderItem = array_merge($orderItem,array(
                            'order_id' => $erpOrderId
                        ));
                        $erpOrderItem['product_options'] = htmlspecialchars($erpOrderItem['product_options']);
                        $erpOrderItem = $this->getSafeData($erpOrderItem);
                        $erp->create('oa.order.item', $erpOrderItem);
                        echo "Import AliExpress Order item into ERP system success .\r\n";
                    } catch (Exception $e) {
                        echo "\r\n";
                        echo "Import AliExpress Order item into  ERP system failed . message:" . $e->getMessage() . ", code: " . $e->getCode() . "\r\n";
                    }
                }
            }
            //更新运费
            if($ShippingPrice){
                Orders::model()->updateByPk($oAOrderId,array(
                    'shipping_amount' =>$ShippingPrice
                ),'id=:id',array(":id"=>$orderId));
            }
        }
    }

    public function actionSubmitFeed()
    {
        echo "submitFeed start:\r\n";
        $amazonConfig = CConfigHelper::getConfig('amazon');
        $config = $amazonConfig['lb'];
        $amazon = new Amazon();

        $response = $amazon->submitFeed($config,Amazon::END_POINT_UNITED_STATES);

        $itemDom = new DOMDocument();
        $itemDom->loadXML($response->toXML());
        $itemXmlObj = simplexml_import_dom($itemDom);

        var_dump($itemXmlObj);
    }

    protected function initErp()
    {
        require_once Yii::getPathOfAlias('application.vendors') . '/simbigo/openerp-api/OpenERP.php';
        require_once Yii::getPathOfAlias('application.vendors') . '/simbigo/openerp-api/XmlRpcClient.php';

        $erpConfig = Yii::app()->params['erpConfig'];

        $erp = new \Simbigo\OpenERP\OpenERP($erpConfig['host'], $erpConfig['encoding']);

        try {
            $erp->login($erpConfig['db'], $erpConfig['user'], $erpConfig['password']);
            echo "ERP system login success .\r\n";
            return $erp;
        } catch (Exception $e) {
            echo "ERP login failed , message :" . $e->getMessage() . ",   code :" . $e->getCode() . "\r\n";
            exit();
        }
    }

    protected function isNormalOrder($platform,$value)
    {
        switch ($platform) {
            case 'ebay':
                $key = "buyer_id";
                break;
            case 'amazon':
                $key = "order_id";
                break;
            default :
                return TRUE;
        }
        $internalOrdersModelList = InternalOrders::model()->findAllByAttributes(array(
            'platfrom' => $platform,
            'key' => $key,
            'value' => $value
        ));

        if(count($internalOrdersModelList) > 0)
        {
            return false;
        }

        return true;
    }
}