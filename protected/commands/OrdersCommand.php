<?php

/**
 *
 * @desc       OrdersCommand.php file.
 *
 * @author     Qiu Xincai <qiuxc@eileengrays.com>
 * @link       http://www.eileengrays.com/
 * @copyright  EileenGrays.Com 2013-2015
 * @license    http://www.eileengrays.com/
 */
class OrdersCommand extends CConsoleCommand
{
    const PLATFORM_ALIEXPRESS = 'aliExpress';
    const PLATFORM_AMAZON = 'amazon';
    const PLATFORM_EBAY = 'ebay';
    const PLATFORM_MAGENTO = 'magento';

    public function behaviors()
    {
        return array(
            array(
                'class' => 'application.components.OaSaveOrderBehavior'
            ),
            array(
                'class' => 'application.components.ErpSaveOrderBehavior',
//                ''
            )
        );
    }

    public function actionImport($platform, $store)
    {
        ini_set("display_errors", 'On');
        error_reporting(11);
        $platformConfig = CConfigHelper::getConfig($platform);
        $service = $this->createService($platform);
        $storeConfig = isset($platformConfig['stores'][$store]) ? $platformConfig['stores'][$store] : array();
        print_r($storeConfig);
        $pageCurrent = 0;
        $pageSize = 50;
        do {
            $pageCurrent++;
            $pageTotal = 1;
            //第一步 获取订单列表
            $orderList = $service->getOrderList($storeConfig,$pageCurrent,$pageSize);
            var_dump($orderList);exit();
            $orderList = array(1);
//            //第二步 遍历订单列表
            foreach ($orderList as $order) {
                //获取订单详情
                $orderInfo = $service->getOrderById($order['id']);
                //转换sku
                $this->
                $order = array(
                    'xxxx' => 111,
                    'zzzzzz' => 3333
                );
                $orderId = $this->saveOrder($order, $store);
                echo "return OrderId :" . $orderId . "\r\n";
                //第三步 获取订单支付信息
                $service->getOrderPayment($order);
                //保存订单信息
                $this->savePayment($order, $store);
                //第四步 获取订单收货地址
                $service->getOrderShippingAddress($order);
                //保存订单地址
                $this->saveAddress($order, $store);
                //第五步 获取订单产品列表
                $service->getOrderItemList($order);
                foreach (array(1, 1) as $item) {
                    $this->saveOrderItem($item, $store);
                }
            }

        } while ($pageTotal > $pageCurrent);
    }

    /**
     * @param $platform
     * @return AliExpress|Amazon|Ebay|Magento|null
     */
    protected function createService($platform)
    {
        $service = null;
        switch ($platform) {
            case OrdersCommand::PLATFORM_ALIEXPRESS:
                $service = new AliExpressOrderService();
                break;
            case OrdersCommand::PLATFORM_AMAZON:
                $service = new AmazonOrderService();
                break;
            case OrdersCommand::PLATFORM_EBAY:
                $service = new EbayOrderService();
                break;
            case OrdersCommand::PLATFORM_MAGENTO:
                $service = new MagentoOrderService();
                break;
            default:
                $this->usageError('');
                break;
        }

        return $service;
    }

    protected function saveOrder($order, $store)
    {
        $event = new CConsoleCommandEvent($this, $order, $store);
        if ($this->hasEventHandler('onSaveOrder'))
            $this->onSaveOrder($event);
        return $event->exitCode;
    }

    protected function savePayment($payment, $store)
    {
        $event = new CConsoleCommandEvent($this, $payment, $store);
        if ($this->hasEventHandler('onSaveOrder'))
            $this->onSavePayment($event);
        return $event->exitCode;
    }

    protected function saveAddress($address, $store)
    {
        $event = new CConsoleCommandEvent($this, $address, $store);
        if ($this->hasEventHandler('onSaveOrder'))
            $this->onSaveAddress($event);
        return $event->exitCode;
    }

    protected function saveOrderItem($item, $store)
    {
        $event = new CConsoleCommandEvent($this, $item, $store);
        if ($this->hasEventHandler('onSaveOrder'))
            $this->onSaveOrderItem($event);
        return $event->exitCode;
    }

    protected function onSaveOrder($event)
    {
        return $this->raiseEvent('onSaveOrder', $event);
    }

    protected function onSavePayment($event)
    {
        $this->raiseEvent('onSavePayment', $event);
    }

    protected function onSaveAddress($event)
    {
        $this->raiseEvent('onSaveAddress', $event);
    }

    protected function onSaveOrderItem($event)
    {
        $this->raiseEvent('onSaveOrderItem', $event);
    }
}