<?php

/**
 *
 * @desc       Amazon.php file.
 *
 * @author     Qiu Xincai <qiuxc@eileengrays.com>
 * @link       http://www.eileengrays.com/
 * @copyright  EileenGrays.Com 2013-2015
 * @license    http://www.eileengrays.com/
 */
class Amazon extends ApiServiceComponent
{
    const TIME_TYPE_CREATED = 'Created';
    const TIME_TYPE_UPDATED = 'Updated';

    /**
     * 获取亚马逊服务列表
     * @return array
     */
    public function getServiceList(){
        return array();
    }

    /**
     * 获取亚马逊服务状态
     * @param $config
     * @param $serviceName  @see $this->getServiceList();
     * @return mixed
     */
    public function getServiceStatus($config,$serviceName){
        $service = $this->getService($config,$serviceName);
        $method = 'GetServiceStatus';
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config){
            $request->setSellerId($config['MERCHANT_ID']);
        });
        return $response;
    }

    /**
     * 获取订单列表
     * @param        $config
     * @param        $timeAfter
     * @param        $timeBefore
     * @param array  $orderStatus array('Unshipped', 'PartiallyShipped', 'Shipped')
     * @param string $timeType
     * @param string $fulfillmentChannel
     * @param string $buyerEmail
     * @param string $sellerOrderId
     * @param string $paymentMethod
     * @param string $TFMShipmentStatus
     * @param int    $maxResultsPerPage
     * @return null
     */
    public function listOrders($config,
                               $timeAfter,
                               $timeBefore,
                               $orderStatus = array(),
                               $timeType = Amazon::TIME_TYPE_UPDATED,
                               $fulfillmentChannel='',
                               $buyerEmail = '',
                               $sellerOrderId = '',
                               $paymentMethod = '',
                               $TFMShipmentStatus = '',
                               $maxResultsPerPage = 100)
    {
        $serviceName = 'MarketplaceWebServiceOrders';
        $service = $this->getService($config);
        $method = 'ListOrders';
        $response = $this->invoke($service,$serviceName,$method,function($request)use(
            $config,
            $timeType,
            $timeAfter,
            $timeBefore,
            $orderStatus,
            $fulfillmentChannel,
            $buyerEmail,
            $sellerOrderId,
            $paymentMethod,
            $TFMShipmentStatus,
            $maxResultsPerPage){
            /**
             * @var $request MarketplaceWebServiceOrders_Model_ListOrdersRequest
             */
            $request->setSellerId($config['MERCHANT_ID']);
            $request->setMarketplaceId($config['MARKETPLACE_ID']);
            if($sellerOrderId){
                $request->setSellerOrderId($sellerOrderId);
            }
            if(!$request->isSetSellerOrderId($sellerOrderId)){
                //时间格式    DATE_ISO8601
                switch($timeType){
                    case Amazon::TIME_TYPE_UPDATED:
                        $request->setLastUpdatedAfter($timeAfter);
                        $request->setLastUpdatedBefore($timeBefore);
                        break;
                    case Amazon::TIME_TYPE_CREATED:
                        $request->setCreatedAfter($timeAfter);
                        $request->setCreatedBefore($timeBefore);
                        break;
                    default:
                        break;
                }
            }
            $orderStatusList = Amazon::orderStatus;
            foreach($orderStatus as $status)
                if(isset($orderStatusList[$status]))
                    $request->setOrderStatus($status);

            $fulfillmentChannelList = Amazon::fulfillmentChannel;
            if(isset($fulfillmentChannelList[$fulfillmentChannel])){
                $request->setFulfillmentChannel($fulfillmentChannel);
            }

            $paymentMethodList = Amazon::paymentMethod;
            if(isset($paymentMethodList[$paymentMethod]))
                $request->setPaymentMethod($paymentMethod);

            if(!$request->isSetLastUpdatedAfter()){
                $request->setBuyerEmail($buyerEmail);
                $request->setSellerOrderId($sellerOrderId);
            }

            $request->setMaxResultsPerPage(100);

            $TFMShipmentStatusList = Amazon::TFMShipmentStatus;
            if(isset($TFMShipmentStatusList[$TFMShipmentStatus]))
                $request->setTFMShipmentStatus($TFMShipmentStatus);

        });

        return $response;
    }
    /**
     * 根据订单分页token获取下一页数据
     * @param $config
     * @param $nextToken
     * @return mixed
     */
    public function listOrdersByNextToken($config,$nextToken)
    {
        $serviceName = 'MarketplaceWebServiceOrders';
        $method = 'ListOrdersByNextToken';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$nextToken){
            /**
             * @var $request MarketplaceWebServiceOrders_Model_ListOrdersByNextTokenRequest
             */
            $request->setSellerId($config['MERCHANT_ID']);
            $request->setNextToken($nextToken);
        });
        return $response;
    }


    /**
     * 获取订单中产品列表数据
     * @param $config
     * @param $orderId
     * @return null
     */
    public function listOrderItems($config, $orderId)
    {
        $service = $this->getService($config);
        $serviceName = 'MarketplaceWebServiceOrders';
        $method = 'ListOrderItems';
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$orderId){
            /**
             * @var $request MarketplaceWebServiceOrders_Model_ListOrderItemsRequest
             */
            $request->setSellerId($config['MERCHANT_ID']);
            $request->setAmazonOrderId($orderId);
        });

        return $response;
    }

    /**
     * 根据订单编号获取订单数据
     * @param $config
     * @param $orderId
     * @return mixed
     */
    public function getOrder($config,$orderId)
    {
        $service = $this->getService($config);
        $serviceName = 'MarketplaceWebServiceOrders';
        $method = 'GetOrder';
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$orderId){
            $request->setSellerId($config['MERCHANT_ID']);
            $request->setAmazonOrderId($orderId);
        });
        return $response;
    }

    /**
     * 取消一个或多个上传数据提交，并返回已取消的上传数据提交计数。
     * @param $config
     * @param $feedSubmissionIdList
     * @param $feedTypeList
     * @param $submittedFromDate
     * @param $submittedToDate
     * @return mixed
     */
    public function cancelFeedSubmissions($config,
                                          $feedSubmissionIdList,
                                          $feedTypeList,
                                          $submittedFromDate,
                                          $submittedToDate){
        $serviceName = 'MarketplaceWebService';
        $method = 'CancelFeedSubmissions';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$feedSubmissionIdList,$feedTypeList,$submittedFromDate,$submittedToDate){
            $request->setSellerId($config['MERCHANT_ID']);
            $request->setFeedSubmissionIdList($feedSubmissionIdList);
            $request->setFeedTypeList($feedTypeList);
            $request->setSubmittedFromDate($submittedFromDate);
            $request->setSubmittedToDate($submittedToDate);
        });
        return $response;
    }

    /**
     * 取消一个或多个报告请求。
     * @param $config
     * @param $reportRequestIdList
     * @param $reportTypeList
     * @param $reportProcessingStatusList
     * @param $requestedFromDate
     * @param $requestedToDate
     * @return mixed
     */
    public function cancelReportRequests($config,
                                         $reportRequestIdList,
                                         $reportTypeList,
                                         $reportProcessingStatusList,
                                         $requestedFromDate,
                                         $requestedToDate){
        $serviceName = 'MarketplaceWebService';
        $method = 'CancelReportRequests';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use(
            $config,
            $reportRequestIdList,
            $reportTypeList,
            $reportProcessingStatusList,
            $requestedFromDate,
            $requestedToDate){

            $request->setSellerId($config['MERCHANT_ID']);
            $request->setReportRequestIdList($reportRequestIdList);
            $request->setReportTypeList($reportTypeList);
            $request->setReportProcessingStatusList($reportProcessingStatusList);
            $request->setRequestedFromDate($requestedFromDate);
            $request->setSubmittedToDate($requestedToDate);
        });
        return $response;
    }

    /**
     * 返回过去 90 天内提交的上传数据计数。
     * @param $config
     * @param $feedTypeList
     * @param $feedProcessingStatusList
     * @param $submittedFromDate
     * @param $submittedToDate
     * @return mixed
     */
    public function getFeedSubmissionCount($config,
                                           $feedTypeList,
                                           $feedProcessingStatusList,
                                           $submittedFromDate,
                                           $submittedToDate){
        $serviceName = 'MarketplaceWebService';
        $method = 'GetFeedSubmissionCount';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use(
            $config,
            $feedTypeList,
            $feedProcessingStatusList,
            $submittedFromDate,
            $submittedToDate){

            $request->setSellerId($config['MERCHANT_ID']);
            $request->setFeedProcessingStatusList($feedProcessingStatusList);
            $request->setFeedTypeList($feedTypeList);
            $request->setSubmittedFromDate($submittedFromDate);
            $request->setSubmittedToDate($submittedToDate);
        });
        return $response;
    }

    /**
     * 返回使用 NextToken 参数的上传数据提交列表。
     * @param $config
     * @param $nextToken
     * @return mixed
     */
    public function getFeedSubmissionListByNextToken($config,$nextToken){
        $serviceName = 'MarketplaceWebService';
        $method = 'GetFeedSubmissionListByNextToken';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$nextToken){
            $request->setSellerId($config['MERCHANT_ID']);
            $request->setNextToken($nextToken);
        });
        return $response;
    }
    public function getFeedSubmissionList($config){

    }
    public function getFeedSubmissionResult($config,$feedSubmissionId){
        $serviceName = 'MarketplaceWebService';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,'GetFeedSubmissionResult',function($request)use($config,$feedSubmissionId){
            $request->setMerchant($config['MERCHANT_ID']);
            $request->setFeedSubmissionId($feedSubmissionId);
            $request->setFeedSubmissionResult(@fopen('php://memory', 'rw+'));
        });
        return $response;

    }
    public function getReportCount(){}
    public function getReportListByNextToken(){}
    public function getReportList(){}
    public function getReportRequestCount(){}
    public function getReportRequestListByNextToken(){}
    public function getReportRequestList(){}
    public function getReport(){}
    public function getReportScheduleCount(){}
    public function getReportScheduleListByNextToken(){}
    public function getReportScheduleList(){}
    public function manageReportSchedule(){}
    public function requestReport(){}
    public function submitFeed($config,$orders,$orderItemIdList)
    {
        $service = $this->getService($config,"MarketplaceWebService");
        $feedTemplate = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<AmazonEnvelope xsi:noNamespaceSchemaLocation="amzn-envelope.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <Header>
        <DocumentVersion>1.01</DocumentVersion>
        <MerchantIdentifier>%s</MerchantIdentifier>
    </Header>
    <MessageType>OrderFulfillment</MessageType>
    <Message>
        <MessageID>1</MessageID>
        <OperationType>Update</OperationType>
        <OrderFulfillment>
            <AmazonOrderID>%s</AmazonOrderID>
            <FulfillmentDate>%s</FulfillmentDate>
            <ShipperTrackingNumber>%s</ShipperTrackingNumber>
            <FulfillmentData>
                <CarrierName>%s</CarrierName>
                <ShippingMethod>%s</ShippingMethod>
            </FulfillmentData>
            %s
        </OrderFulfillment>
    </Message>
</AmazonEnvelope>
EOD;
        $item = "";
        foreach($orderItemIdList as $item)
        {
            $item .= sprintf("<Item>
                <AmazonOrderItemCode>%s</AmazonOrderItemCode>
                <Quantity>%d</Quantity>
            </Item>",strval($item['id']),strval($item['quantity']));
        }

        $feed = sprintf($feedTemplate,$config['MARKETPLACE_ID'],$orders['increment_id'],date('Y-m-dTH:i:s-08:00'),$orders['tracking_number'],'',$orders['shipping_method'],$item);
        // Constructing the MarketplaceId array which will be passed in as the the MarketplaceIdList
        // parameter to the SubmitFeedRequest object.
//        $marketplaceIdArray = array("Id" => array('<Marketplace_Id_1>', '<Marketplace_Id_2>'));
        $marketplaceIdArray = array("Id" => array($config['MARKETPLACE_ID']));

        $feedHandle = @fopen('php://temp', 'rw+');
        $response = $this->invoke($service, 'MarketplaceWebService', 'submitFeed',function($request)use($config,$marketplaceIdArray,$feed,$feedHandle){
            /********* Begin Comment Block *********/
            fwrite($feedHandle, $feed);
            rewind($feedHandle);
            $request->setMerchant($config['MERCHANT_ID']);
            $request->setMarketplaceIdList($marketplaceIdArray);
            $request->setFeedType('_POST_ORDER_FULFILLMENT_DATA_');
            $request->setContentMd5(base64_encode(md5(stream_get_contents($feedHandle), true)));
            rewind($feedHandle);
            $request->setPurgeAndReplace(false);
            $request->setFeedContent($feedHandle);
            rewind($feedHandle);
            /********* End Comment Block *********/
        });
        @fclose($feedHandle);

        return $response;
    }
    public function updateReportAcknowledgements(){}


    public function confirmTransportRequest($config){
        $serviceName = '';
        $methodName = '';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$methodName,function($request)use($config){
            $request->setSellerId($config);
        });
        return $response;
    }
    public function createInboundShipmentPlan(){}
    public function createInboundShipment(){}
    public function estimateTransportRequest(){}
    public function getBillOfLading(){}
    public function getPackageLabels(){}
    public function getPalletLabels(){}
    public function getPrepInstructionsForASIN(){}
    public function getPrepInstructionsForSkU(){}
    public function getTransportContent(){}
    public function getUniquePackageLabels(){}
    public function listInboundShipmentItemsByNextToken(){}
    public function listInboundShipmentItems(){}
    public function listInboundShipmentsByNextToken(){}
    public function listInboundShipments(){}
    public function putTransportContent(){}
    public function updateInboundShipment(){}
    public function voidTransport(){}

    public function cancelFulfillmentOrder(){}
    public function createFulfillmentOrder(){}
    public function getFulfillmentOrder(){}
    public function getFulfillmentPreview(){}
    public function getPackageTrackingDetails(){}
    public function listAllFulfillmentOrdersByNextToken(){}
    public function listAllFulfillmentOrders(){}
    public function updateFulfillmentOrder(){}

    public function listMarketplaceParticipationsByNextToken(){}
    public function listMarketplaceParticipations(){}

    public function listFinancialEventGroupsByNextToken(){}
    public function listFinancialEventGroups(){}
    public function listFinancialEventsByNextToken(){}
    public function listFinancialEvents(){}

    public function getLastUpdatedTimeForRecommendations(){}
    public function listRecommendationsByNextToken(){}
    public function listRecommendations(){}


    /**
     * @param        $config
     * @param string $serviceName
     * @param array  $options
     * @return null
     */
    protected function getService($config,
                                  $serviceName = 'MarketplaceWebServiceOrders',
                                  $options = array()){
        $clientClass = $serviceName.'/Client';
        $clientClassFile = $serviceName.'_Client';
        require_once($clientClassFile.'.php');
        $serviceConfig = $this->getServiceConfig($config,$serviceName,$options);
        switch($serviceName)
        {
            case 'MarketplaceWebServiceOrders':
            case 'FulfillmentInboundShipment':
                $service = new $clientClass(
                    $config['AWS_ACCESS_KEY_ID'],
                    $config['AWS_SECRET_ACCESS_KEY'],
                    $config['APPLICATION_NAME'],
                    $config['APPLICATION_VERSION'],
                    $serviceConfig);
                break;
            case 'MarketplaceWebService':
                $service = new $clientClass(
                    $config['AWS_ACCESS_KEY_ID'],
                    $config['AWS_SECRET_ACCESS_KEY'],
                    $serviceConfig,
                    $config['APPLICATION_NAME'],
                    $config['APPLICATION_VERSION']
                );
                break;
            default:
                $service = null;
                break;
        }
        return $service;
    }

    protected function getServiceConfig($config,$serviceName,$options)
    {
        $serviceConfig = array_merge(array(
            'ServiceURL' => $this->getServiceUrl($config,$serviceName),
            'ProxyHost' => null,
            'ProxyPort' => -1,
            'ProxyUsername' => null,
            'ProxyPassword' => null,
            'MaxErrorRetry' => 10,
        ), $options);

        return $serviceConfig;
    }

    protected function getServiceUrl($config,$serviceName)
    {
        $clientClass = $serviceName."_Client";
        $servicePrefix = 'MarketplaceWebService';

        if(is_numeric(strpos($serviceName,$servicePrefix)))
        {
            $serviceName = substr($serviceName,strlen($servicePrefix),strlen($serviceName)-strlen($servicePrefix));
        }

        if(empty($serviceName)){
            return $config['URL'];
        }else{
            return $config['URL']."/".$serviceName.'/'.$clientClass::SERVICE_VERSION;
        }
    }

    /**
     * @param $service
     * @param $serviceName
     * @param $methodName
     * @param $callback
     * @return mixed
     * @internal param $method
     */
    protected function invoke($service,$serviceName,$methodName,$callback)
    {
        try {

            if('ConfirmTransport' == $methodName){
                $requestName = $methodName.'InputRequest';
            }else{
                $requestName = $methodName.'Request';
            }

            $requestClassFile = implode('/',array($serviceName,'Model',$requestName));
            $requestClass = implode('_',array($serviceName,'Model',$requestName));

            require_once($requestClassFile.'.php');

            $request = new $requestClass();

            call_user_func($callback,$request);

            if (method_exists($service, $methodName))
                $response = $service->$methodName($request);
            else
                return new Exception($methodName.' is not found.',500);

            return $response;

        } catch (Exception $ex) {
            return new Exception($ex->getMessage(),$ex->getCode(),$ex);
        }
    }





























    protected function importOrders($config,$lastUpdateAfter,$lastUpdateBefore,$orderStatus)
    {
        //检查配置文件以及服务状态
        if($this->beforeGetOrders($config)){
            //获取订单列表
            $response = $this->listOrders($config,$lastUpdateAfter,$lastUpdateBefore,$orderStatus);

            //处理订单数据
            $orders = $this->afterGetOrders($response);
            foreach($orders as $order){
                if($orderId = $this->beforeGetOrder($order))
                {
                    $this->afterGetOrder($order);
                }
                $orderItems = $this->listOrderItems($config,$orderId);
                foreach($orderItems as $item){
                    if($this->beforeGetOrderItem($item)){
                        $this->afterGetOrderItem($item);
                    }
                }
            }
        }
    }
}