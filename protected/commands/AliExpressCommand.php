<?php

/**
 * Created by PhpStorm.
 * User: john
 * Date: 2015/10/20
 * Time: 9:46
 */
class AliExpressCommand extends CConsoleCommand
{

    public function getHelp()
    {
        return <<<HELP

HELP;
    }

    public function actionImport($args = 'lc')
    {
        $store = 'lc';
        echo "AliExpress's order import start:\r\n";
        $aliExpress = new AliExpress();
        $erp = $this->initErp();
        //获取配置文件
        $configArray = CConfigHelper::getConfig('aliExpress');
        $config = $configArray[$store];
        //更新ACCESSTOKEN
        /**
         * @var $cache CFileCache
         */
//        $cache = Yii::app()->getCache();
//        if($cache->offsetExists('access_token_'.$store) &&  $accessToken = $cache->offsetGet('access_token_'.$store)) {
//
//        }else{
//            $refreshToken = '13a7eb34-843a-4a37-ad36-937790098771';
//            $response = $aliExpress->refreshToken($config, $refreshToken);
//            $result = json_decode($response, true);
//            $accessToken = $result['access_token'];
//            $accessToken = $cache->offsetGet('access_token_'.$store,$accessToken);
//        }
        $accessToken = 'd787d7a4-70cc-4b00-be59-3d59d911d2c5';
        //构造参数获取订单
        $createDateStart = date('m/d/Y 00:00:00', gmmktime(0, 0, 0, date('m'), date('d') - 25, date('Y')));
        $page = 0;
        $pageSize = 50;
        do {
            $page ++;
            $response = $aliExpress->findOrderListQuery($config, $accessToken, $createDateStart, $page, $pageSize);
            $result = json_decode($response, true);

            $pages = ceil($result['totalItem'] / $pageSize);
            echo "Page : " . $page . "/" . $pages . "\r\n";
            if ($result['totalItem'] > 0) {
                $orderList = $result['orderList'];
                foreach ($orderList as $key => $order) {
                    $orderId = $order['orderId'];
                    echo "Order Id :" . $orderId ."\r\n";
                    $erpFlag = true;
                    //检查订单是否已经导入OA
                    $oAOrder = Orders::model()->findByAttributes(array('increment_id' => $orderId));
                    if ($oAOrder != null) {
                        echo "OA has finished import\r\n";
                        continue;
                    }
                    //检查订单是否导入ERP
                    try{
                        $erpOrderExists = $erp->search('oa.order', [['increment_id', '=', $orderId]], 0, 1);

                        if ($erpOrderExists) {
                            $erpFlag = false;
                            echo "ERP has finished import\r\n";
                        }
                    }
                    catch(Exception $e)
                    {
                        echo "Search ERP Order failed .\r\n";
                    }

                    //获取订单详情
                    $response = $aliExpress->findOrderById($config, $accessToken, $orderId);
                    $orderInfo = json_decode($response, true);
                    //创建时间
                    $created_at = date('Y-m-d H:i:s', strtotime(substr($orderInfo['gmtCreate'], 0, 17)));
                    $total_paid = $subtotal = $grand_total = $orderInfo['orderAmount']['amount'];
                    $order_currency_code = $orderInfo['orderAmount']['currencyCode'];
                    $store_name = 'aliexpress';
                    $shipping_method = '';
                    $customer_id = $orderInfo['buyerloginid'];
                    $customer_firstname = $orderInfo['buyerInfo']['firstName'] . ' ' . $orderInfo['buyerInfo']['lastName'];
                    $customer_lastname = $orderInfo['buyerInfo']['lastName'];
                    //$logisticInfo = current($order->productList[0]->logisticsServiceName);
                    //$shipping_method = '';
                    $status = 'new';
                    //根据汇率
                    $currency_rate = 1;
                    $sysVariateModel = SysVariate::model()->findByAttributes(array('title'=>$order_currency_code));
                    if($sysVariateModel != null)
                        $currency_rate =  $sysVariateModel->value;

                    $import_at = date("Y-m-d H:i:s", time());

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
                        'import_at' => $import_at
                    );
                    $method = 'AliPay';

                    $ordersModel = new Orders();
                    $ordersModel->setAttributes($ordersData);
                    $ordersModel->save();
                    $oAOrderId = $ordersModel->id;
                    //支付信息
                    $paymentsData = array(
                        'order_id' => $ordersModel->id,
                        'amount_ordered' => $grand_total,
                        'method' => $method
                    );
                    //地址信息
                    $address = $orderInfo['receiptAddress'];
                    if (empty($address['phoneArea']) || empty($address['phoneNumber'])) {
                        $phone = '';
                    } else {
                        $phone = $address['phoneCountry'] . '-' . $address['phoneArea'] . '-' . $address['phoneNumber'];
                    }

                    if (empty($address['mobileNo'])) {
                        $mobileNo = '';
                    } else {
                        $mobileNo = $address['mobileNo'];
                    }

                    $country = strtoupper($address['country']) == 'UK' ? 'United Kingdom' : $address['country'];
                    //收货地址
                    $street_address = $address['detailAddress'];

                    if (!empty($address['address2'])) {
                        $street_address .= ' ' . $address['address2'];
                    }
                    $shippingBillingAddressData = array(
                        'order_id' => $oAOrderId,
                        'firstname' => $address['contactPerson'],
                        'street' => $street_address,
                        'city' => $address['city'],
                        'region' => $address['province'],
                        'postcode' => $address['zip'],
                        'country_id' => $country,
                        'telephone' => $phone,
                        'mobile' => $mobileNo
                    );

                    if ($erpFlag && !empty($oAOrderId)) {
                        echo "Import AliExpress Order into OA system success\r\n";

                        try {
                            $paymentsModel = new Payments();
                            $paymentsModel->setAttributes($paymentsData);
                            $paymentsModel->save();
                            if ($paymentsModel->hasErrors()) {
                                throw new Exception(CModelHelper::getError($paymentsModel));
                            }
                            echo "Import AliExpress Order Payments into OA system success.\r\n";
                        } catch (Exception $e) {
                            echo "Import AliExpress Order Payments into OA system failed. message:".$e->getMessage()."\r\n";
                        }

                        //收货地址
                        try {
                            $shippingBillingAddressModel = new ShippingBillingAddress();
                            $shippingBillingAddressModel->setAttributes($shippingBillingAddressData);
                            $shippingBillingAddressModel->save();
                            if ($shippingBillingAddressModel->hasErrors()) {
                                throw new Exception(CModelHelper::getError($shippingBillingAddressModel));
                            }
                            echo "Import AliExpress Order Shipping Billing Address into OA system success.\r\n";
                        } catch (Exception $e) {
                            echo "Import AliExpress Order Shipping Billing Address into OA system failed. message:".$e->getMessage()."\r\n";
                        }
                    } else {
                        echo "Import AliExpress Order into OA system failed.message:".CModelHelper::getError($ordersModel)."\r\n";
                    }

                    if ($erpFlag && !empty($oAOrderId)) {
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
                            echo "Import AliExpress Order into ERP system success .\r\n";
                        } catch (Exception $e) {
                            echo "Import AliExpress Order into ERP system failed . message:" . $e->getMessage() . ", code: " . $e->getCode() . "\r\n";
                        }

                        if (!empty($erpOrderId)) {
                            try {
                                if($paymentsData)
                                {
                                    $erpPaymentsData = array_merge($paymentsData,array(
                                        'order_id' => $erpOrderId
                                    ));
                                    $erp->create('oa.payments', $erpPaymentsData);
                                    echo "Import AliExpress Order payments into ERP system success .\r\n";
                                }
                            } catch (Exception $e) {
                                echo "Import AliExpress Order payments into ERP system failed . message:" . $e->getMessage() . ", code: " . $e->getCode() . "\r\n";
                            }

                            try {
                                if($shippingBillingAddressData)
                                {
                                    $erpShippingBillingAddressData = array_merge($shippingBillingAddressData,array(
                                        'order_id' => $erpOrderId
                                    ));
                                    $erp->create('oa.shipping.billing.address', $erpShippingBillingAddressData);
                                    echo "Import AliExpress Order shipping billing address into ERP system success .\r\n";
                                }
                            } catch (Exception $e) {
                                echo "Import AliExpress Order shipping billing address into ERP system failed . message:" . $e->getMessage() . ", code: " . $e->getCode() . "\r\n";
                            }
                            //导入收货地址
                        }
                    }


                    $childOrderList = $orderInfo['childOrderList'];
                    foreach ($childOrderList as $childOrder) {
                        $sku = trim(strtoupper($childOrder['skuCode']));
                        $memo = '';
                        if (!empty($order['productList'][$key]['memo'])) {
                            $memo = $order['productList'][$key]['memo'];
                        }
                        $logisticsServiceName = $order['productList'][$key]['logisticsServiceName'];
                        $logisticsType = $order['productList'][$key]['logisticsType'];

                        $name = $childOrder['productName'];
                        $item_id = $childOrder['productId'];
                        $qty_ordered = $childOrder['productCount'];
                        $row_total = $childOrder['initOrderAmt']['amount'];
                        $price = $childOrder['productPrice']['amount'];
                        $pictureurl = $order['productList'][$key]['productSnapUrl'];
                        $options = json_decode($childOrder['productAttributes']);

                        $product_options = '';
                        foreach ($options->sku as $ov) {
                            $option_value = $ov->selfDefineValue ? $ov->selfDefineValue : $ov->pValue;
                            $product_options .= '<dt>' . $ov->pName . '</dt><dd>' . $option_value . '</dd>';
                        }
                        if ($memo) {
                            $product_options .= '<dt>备注</dt><dd>' . $memo . '</dd>';
                        }
                        $product_options .= '<dt>物流:</dt><dd>' . $logisticsServiceName . '</dd>';
                        $product_options = '<dl>' . $product_options . '</dl>';

                        $orderItem = array(
                            'order_id' => $oAOrderId,
                            'sku' => $sku,
                            'name' => $name,
                            'item_id' => $item_id,
                            'qty_ordered' => $qty_ordered,
                            'row_total' => $row_total,
                            'price' => $price,
                            'pictureurl' => $pictureurl,
                            'product_options' => $product_options
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
                    //更新物流信息
//                    Orders::model()->updateByPk($oAOrderId,array('logistics'=>$logisticsType));

                }
            }
        } while ($pages > $page);

        echo "AliExpress's order import finished .\r\n";
    }

    /**
     * 获取店铺配置信息
     * @param $store
     * @return bool
     * @throws Exception
     */
    protected function getStoreConfig($store)
    {
        $config = isset($this->stores[$store]) ? $this->stores[$store] : false;

        if ($config == false) {
            throw new Exception('Store :' . $store . ' does not exists.');
        }

        if (empty($config['appKey']) || empty($config['appSecret'])) {
            throw new Exception('Store :' . $store . ' configuration is invalid.');
        }

        return $config;
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
    protected function getSafeData($data)
    {
        if(is_array($data))
        {
            foreach($data as $key => $value)
            {
                if(empty($value))unset($data[$key]);
            }
        }

        return $data;
    }
}