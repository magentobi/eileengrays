<?php

/**
 *
 * @desc       ImportOrdersCommand.php file.
 *
 * @author     Qiu Xincai <qiuxc@eileengrays.com>
 * @link       http://www.eileengrays.com/
 * @copyright  EileenGrays.Com 2013-2015
 * @license    http://www.eileengrays.com/
 */
class ImportOrdersCommand extends CConsoleCommand
{
    public function actionPlatformList()
    {

    }
    public function actionImport($platform,$store)
    {
        $platformConfig = CConfigHelper::getConfig('platformConfig');
        $storeConfig = isset($platformConfig[$platform][$store])?$platformConfig[$platform][$store]:'';
        $platform = PlatformFactory::create($platformConfig);
        $service = new OrdersService($platform);
        $pageCurrent = 0;
        $pageSize = 50;
        do{
            $pageCurrent ++ ;
            $condition = array(
                'page' => $pageCurrent,
                'pageSize' => $pageSize
            );
            //第一步 获取订单列表
            list($pageTotal,$orderList) = $service->getOrderList($storeConfig,$condition);
            //第二步 遍历订单列表
            foreach($orderList as $order)
            {
                //第三步 获取订单支付信息
                $service->getPayment($order);
                //第四步 获取订单收货地址
                $service->getAddress($order);
                //第五步 获取订单产品列表
                $service->getOrderItemList($order);
            }
        }while($pageTotal>$pageCurrent);
    }
}