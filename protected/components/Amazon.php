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
     * @param array $config
     * @param string $serviceName  @see $this->getServiceList();
     * @return mixed
     */
    public function getServiceStatus($config,$serviceName){
        $service = $this->getService($config,$serviceName);
        $method = 'GetServiceStatus';
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$serviceName){

            if($serviceName == ''){
                $request->setSellerId($config['MERCHANT_ID']);
            }else{
                $request->setMerchant($config['MERCHANT_ID']);
            }
        });
        return $response;
    }

    /**
     * 返回您在指定时间段内所创建或更新的订单。
     * @param array $config
     * @param string  $timeAfter
     * @param string  $timeBefore
     * @param array|string  $orderStatus array('Unshipped', 'PartiallyShipped', 'Shipped')
     * @param string $timeType
     * @param string $fulfillmentChannel
     * @param string $buyerEmail
     * @param string $sellerOrderId
     * @param string $paymentMethod
     * @param string $TFMShipmentStatus
     * @param int    $maxResultsPerPage
     * @return MarketplaceWebServiceOrders_Model_ListOrdersResponse
     */
    public function listOrders($config,
                               $timeAfter,
                               $timeBefore,
                               $orderStatus,
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
            $request->setOrderStatus($orderStatus);

            $request->setFulfillmentChannel($fulfillmentChannel);


            $request->setPaymentMethod($paymentMethod);

            if(!$request->isSetLastUpdatedAfter()){
                $request->setBuyerEmail($buyerEmail);
                $request->setSellerOrderId($sellerOrderId);
            }

            $request->setMaxResultsPerPage(100);

            $request->setTFMShipmentStatus($TFMShipmentStatus);

        });

        return $response;
    }
    /**
     * 使用 NextToken 参数返回下一页订单
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
            /**
             * @var MarketplaceWebServiceOrders_Model_GetOrderRequest $request
             */
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
            /**
             * @var MarketplaceWebService_Model_CancelFeedSubmissionsRequest $request
             */
            $request->setMerchant($config['MERCHANT_ID']);
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
            /**
             * @var MarketplaceWebService_Model_CancelReportRequestsRequest $request
             */
            $request->setMerchant($config['MERCHANT_ID']);
            $request->setReportRequestIdList($reportRequestIdList);
            $request->setReportTypeList($reportTypeList);
            $request->setReportProcessingStatusList($reportProcessingStatusList);
            $request->setRequestedFromDate($requestedFromDate);
            $request->setRequestedToDate($requestedToDate);
        });
        return $response;
    }

    /**
     * 返回过去 90 天内提交的上传数据计数。
     * @param array $config
     * @param array|string $feedTypeList
     * @param array|string $feedProcessingStatusList
     * @param string $submittedFromDate
     * @param string $submittedToDate
     * @return MarketplaceWebService_Model_GetFeedSubmissionCountResponse
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
            /**
             * @var MarketplaceWebService_Model_GetFeedSubmissionCountRequest $request
             */
            $request->setMerchant($config['MERCHANT_ID']);
            $request->setFeedProcessingStatusList($feedProcessingStatusList);
            $request->setFeedTypeList($feedTypeList);
            $request->setSubmittedFromDate($submittedFromDate);
            $request->setSubmittedToDate($submittedToDate);
        });
        return $response;
    }

    /**
     * 返回使用 NextToken 参数的上传数据提交列表。
     * @param array $config
     * @param string $nextToken
     * @return MarketplaceWebService_Model_GetFeedSubmissionListByNextTokenResponse
     */
    public function getFeedSubmissionListByNextToken($config,$nextToken){
        $serviceName = 'MarketplaceWebService';
        $method = 'GetFeedSubmissionListByNextToken';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$nextToken){
            /**
             * @var MarketplaceWebService_Model_GetFeedSubmissionListByNextTokenRequest  $request
             */
            $request->setMerchant($config['MERCHANT_ID']);
            $request->setNextToken($nextToken);
        });
        return $response;
    }

    /**
     * 返回过去 90 天内提交的所有上传数据提交列表
     * @param array $config
     * @param array $feedSubmissionIdList
     * @param number $maxCount
     * @param array $feedTypeList
     * @param array $feedProcessingStatusList
     * @param string $submittedFromDate
     * @param string $submittedToDate
     * @return MarketplaceWebService_Model_GetFeedSubmissionListResponse
     */
    public function getFeedSubmissionList($config,
                                          $feedSubmissionIdList,
                                          $maxCount,
                                          $feedTypeList,
                                          $feedProcessingStatusList,
                                          $submittedFromDate,
                                          $submittedToDate){
        $serviceName = 'MarketplaceWebService';
        $method = 'GetFeedSubmissionList';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,
            $feedSubmissionIdList,
            $maxCount,
            $feedTypeList,
            $feedProcessingStatusList,
            $submittedFromDate,
            $submittedToDate){
            /**
             * @var MarketplaceWebService_Model_GetFeedSubmissionListRequest  $request
             */
            $request->setMerchant($config['MERCHANT_ID']);
            $request->setFeedSubmissionIdList($feedSubmissionIdList);
            $request->setMaxCount($maxCount);
            $request->setFeedTypeList($feedTypeList);
            $request->setFeedProcessingStatusList($feedProcessingStatusList);
            $request->setSubmittedFromDate($submittedFromDate);
            $request->setSubmittedToDate($submittedToDate);
        });
        return $response;
    }

    /**
     * @desc 返回上传数据处理报告及 Content-MD5 标头。
     * @param array $config
     * @param string $feedSubmissionId
     * @return MarketplaceWebService_Model_GetFeedSubmissionResultResponse
     */
    public function getFeedSubmissionResult($config,$feedSubmissionId){
        $serviceName = 'MarketplaceWebService';
        $method = 'GetFeedSubmissionResult';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$feedSubmissionId){
            /**
             * @var MarketplaceWebService_Model_GetFeedSubmissionResultRequest $request
             */
            $request->setMerchant($config['MERCHANT_ID']);
            $request->setFeedSubmissionId($feedSubmissionId);
            $request->setFeedSubmissionResult(@fopen('php://memory', 'rw+'));
        });
        return $response;

    }

    /**
     * 返回在过去 90 天内创建、状态为 _DONE_ 且可供下载的报告计数。
     * @param array $config
     * @param array $reportTypeList
     * @param string $acknowledged
     * @param string $availableFromDate
     * @param string $availableToDate
     * @return mixed
     */
    public function getReportCount($config,$reportTypeList,$acknowledged,$availableFromDate,$availableToDate){
        $serviceName = 'MarketplaceWebService';
        $method = 'GetReportCount';
        $service = $this->getService($config,$serviceName);

        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$reportTypeList,$acknowledged,$availableFromDate,$availableToDate){
            /**
             * @var MarketplaceWebService_Model_GetReportCountRequest $request
             */
            $request->setMerchant($config['MERCHANT_ID']);
            $request->getReportTypeList($reportTypeList);
            $request->setAcknowledged($acknowledged);
            $request->setAvailableFromDate($availableFromDate);
            $request->setAvailableToDate($availableToDate);
        });
        return $response;
    }

    /**
     * 可通过之前请求提供给 GetReportListByNextToken 或 GetReportList 的 NextToken 值，返回报告列表，其中前一调用中的 HasNext 值为 true。
     * @param array $config
     * @param string $nextToken
     * @return MarketplaceWebService_Model_GetReportListByNextTokenResponse
     */
    public function getReportListByNextToken($config,$nextToken){
        $serviceName = 'MarketplaceWebService';
        $method = 'GetReportListByNextToken';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$nextToken){
            /**
             * @var MarketplaceWebService_Model_GetReportListByNextTokenRequest  $request
             */
            $request->setMerchant($config['MERCHANT_ID']);
            $request->setNextToken($nextToken);
        });
        return $response;
    }

    /**
     * 返回在过去 90 天内所创建的报告列表。
     * @param array $config
     * @param int $maxCount
     * @param array $reportTypeList
     * @param string $acknowledged
     * @param string $availableFromDate
     * @param string $availableToDate
     * @param array $reportRequestIdList
     * @return MarketplaceWebService_Model_GetReportListResponse
     */
    public function getReportList($config,$maxCount,$reportTypeList,$acknowledged,$availableFromDate,$availableToDate,$reportRequestIdList){
        $serviceName = 'MarketplaceWebService';
        $method = 'GetReportList';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$maxCount,$reportTypeList,$acknowledged,$availableFromDate,$availableToDate,$reportRequestIdList){
            /**
             * @var MarketplaceWebService_Model_GetReportListRequest  $request
             */
            $request->setMerchant($config['MERCHANT_ID']);
            $request->setMaxCount($maxCount);
            $request->setReportTypeList($reportTypeList);
            $request->setAcknowledged($acknowledged);
            $request->setAvailableFromDate($availableFromDate);
            $request->setAvailableToDate($availableToDate);
            $request->setReportRequestIdList($reportRequestIdList);
        });
        return $response;
    }

    /**
     * 返回已提交至亚马逊 MWS 进行处理的报告请求计数。
     * @param array $config
     * @param array $reportTypeList
     * @param array $reportProcessingStatusList
     * @param string $requestedFromDate
     * @param string $requestedToDate
     * @return MarketplaceWebService_Model_GetReportRequestCountResponse
     */
    public function getReportRequestCount($config,$reportTypeList,$reportProcessingStatusList,$requestedFromDate,$requestedToDate){
        $serviceName = 'MarketplaceWebService';
        $method = 'GetReportRequestCount';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$reportTypeList,$reportProcessingStatusList,$requestedFromDate,$requestedToDate){
            /**
             * @var MarketplaceWebService_Model_GetReportRequestCountRequest  $request
             */
            $request->setMerchant($config['MERCHANT_ID']);
            $request->setReportTypeList($reportTypeList);
            $request->setReportProcessingStatusList($reportProcessingStatusList);
            $request->setRequestedFromDate($requestedFromDate);
            $request->setRequestedToDate($requestedToDate);
        });
        return $response;
    }

    /**
     * 取消一个或多个报告请求
     * @param array $config
     * @param string $nextToken
     * @return MarketplaceWebService_Model_GetReportListByNextTokenResponse
     */
    public function getReportRequestListByNextToken($config,$nextToken){
        $serviceName = 'MarketplaceWebService';
        $method = 'GetReportRequestListByNextToken';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$nextToken){
            /**
             * @var MarketplaceWebService_Model_GetReportListByNextTokenRequest  $request
             */
            $request->setMerchant($config['MERCHANT_ID']);
            $request->setNextToken($nextToken);
        });
        return $response;
    }

    /**
     * 返回可用于获取报告的 ReportRequestId 的报告请求列表。
     * @param array $config
     * @param array|string $reportRequestIdList
     * @param array|string $reportTypeList
     * @param array|string $reportProcessingStatusList
     * @param int $maxCount
     * @param string $requestedFromDate
     * @param string $requestedToDate
     * @return MarketplaceWebService_Model_GetReportRequestListResponse
     */
    public function getReportRequestList($config,$reportRequestIdList,$reportTypeList,$reportProcessingStatusList,$maxCount,$requestedFromDate,$requestedToDate){
        $serviceName = 'MarketplaceWebService';
        $method = 'GetReportRequestList';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$reportRequestIdList,$reportTypeList,$reportProcessingStatusList,$maxCount,$requestedFromDate,$requestedToDate){
            /**
             * @var MarketplaceWebService_Model_GetReportRequestListRequest  $request
             */
            $request->setMerchant($config['MERCHANT_ID']);
            $request->setReportRequestIdList($reportRequestIdList);
            $request->setReportTypeList($reportTypeList);
            $request->setReportProcessingStatusList($reportProcessingStatusList);
            $request->setMaxCount($maxCount);
            $request->setRequestedFromDate($requestedFromDate);
            $request->setRequestedToDate($requestedToDate);
        });
        return $response;
    }

    /**
     * 返回报告内容及所返回报告正文的 Content-MD5 标头。
     * @param $config
     * @param $reportId
     * @return MarketplaceWebService_Model_GetReportResponse
     */
    public function getReport($config,$reportId){
        $serviceName = 'MarketplaceWebService';
        $method = 'GetReport';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$reportId){
            /**
             * @var MarketplaceWebService_Model_GetReportRequest  $request
             */
            $request->setMerchant($config['MERCHANT_ID']);
            $request->setReportId($reportId);
        });
        return $response;
    }

    /**
     * 返回计划提交至亚马逊 MWS 的订单报告请求计数。
     * @param $config
     * @param $reportTypeList
     * @return MarketplaceWebService_Model_GetReportScheduleCountResponse
     */
    public function getReportScheduleCount($config,$reportTypeList){
        $serviceName = 'MarketplaceWebService';
        $method = 'GetReportScheduleCount';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$reportTypeList){
            /**
             * @var MarketplaceWebService_Model_GetReportScheduleCountRequest  $request
             */
            $request->setMerchant($config['MERCHANT_ID']);
            $request->setReportTypeList($reportTypeList);
        });
        return $response;
    }

    /**
     * @param array $config
     * @param string $nextToken
     * @return MarketplaceWebService_Model_GetReportScheduleListByNextTokenResponse
     */
    public function getReportScheduleListByNextToken($config,$nextToken){
        $serviceName = 'MarketplaceWebService';
        $method = 'GetReportScheduleListByNextToken';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$nextToken){
            /**
             * @var MarketplaceWebService_Model_GetReportScheduleListByNextTokenRequest  $request
             */
            $request->setMerchant($config['MERCHANT_ID']);
            $request->setNextToken($nextToken);
        });
        return $response;
    }

    /**
     * 返回计划提交至亚马逊 MWS 进行处理的订单报告请求列表。
     * @param array $config
     * @param array $reportTypeList
     * @return MarketplaceWebService_Model_GetReportScheduleListResponse
     */
    public function getReportScheduleList($config,$reportTypeList){
        $serviceName = 'MarketplaceWebService';
        $method = 'GetReportScheduleList';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$reportTypeList){
            /**
             * @var MarketplaceWebService_Model_GetReportScheduleListRequest  $request
             */
            $request->setMerchant($config['MERCHANT_ID']);
            $request->setReportTypeList($reportTypeList);
        });
        return $response;
    }

    /**
     * 创建、更新或删除特定报告类型的报告请求计划。
     * @param $config
     *
     */
    public function manageReportSchedule($config,$reportType,$schedule,$scheduleDate){
        $serviceName = 'MarketplaceWebService';
        $method = 'ManageReportSchedule';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$reportType,$schedule,$scheduleDate){
            /**
             * @var MarketplaceWebService_Model_ManageReportScheduleRequest  $request
             */
            $request->setMerchant($config['MERCHANT_ID']);
            $request->setReportType($reportType);
            $request->setSchedule($schedule);
            $request->setScheduleDate($scheduleDate);
        });
        return $response;
    }

    /**
     * 创建报告请求，并将请求提交至亚马逊 MWS。
     * @param $config
     * @param $reportType
     * @param $startDate
     * @param $endDate
     * @param $reportOptions
     * @param $marketplaceIdList
     * @return MarketplaceWebService_Model_RequestReportResponse
     */
    public function requestReport($config,$reportType,$startDate,$endDate,$reportOptions,$marketplaceIdList){
        $serviceName = 'MarketplaceWebService';
        $method = 'RequestReport';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$reportType,$startDate,$endDate,$reportOptions,$marketplaceIdList){
            /**
             * @var MarketplaceWebService_Model_RequestReportRequest  $request
             */
            $request->setMerchant($config['MERCHANT_ID']);
            $request->setReportType($reportType);
            $request->setStartDate($startDate);
            $request->setEndDate($endDate);
            $request->setReportOptions($reportOptions);
            $request->setMarketplaceIdList($marketplaceIdList);
        });
        return $response;
    }

    /**
     * 上传上传数据以供亚马逊 MWS处理
     * @param $config
     * @param $feed
     * @return MarketplaceWebService_Model_SubmitFeedResponse
     */
    public function submitFeed($config,$feed)
    {
        $serviceName = "MarketplaceWebService";
        $service = $this->getService($config,$serviceName);
        // Constructing the MarketplaceId array which will be passed in as the the MarketplaceIdList
        // parameter to the SubmitFeedRequest object.
//        $marketplaceIdArray = array("Id" => array('<Marketplace_Id_1>', '<Marketplace_Id_2>'));
        $marketplaceIdArray = array("Id" => array($config['MARKETPLACE_ID']));

        $feedHandle = @fopen('php://memory', 'rw+');
        $response = $this->invoke($service, $serviceName, 'submitFeed',function($request)use($config,$marketplaceIdArray,$feed,$feedHandle){
            /**
             * @var MarketplaceWebService_Model_SubmitFeedRequest $request
             */
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

    /**
     * 更新一个或多个报告的确认状态。
     * @param array $config
     * @param array $reportIdList
     * @param boolean $acknowledged
     * @return MarketplaceWebService_Model_UpdateReportAcknowledgementsResponse
     */
    public function updateReportAcknowledgements($config,$reportIdList,$acknowledged){
        $serviceName = 'FBAInboundServiceMWS';
        $methodName = 'ConfirmTransportRequest';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$methodName,function($request)use($config,$reportIdList,$acknowledged){
            /**
             * @var MarketplaceWebService_Model_UpdateReportAcknowledgementsRequest $request
             */
            $request->setSellerId($config);
            $request->setReportIdList($reportIdList);
            $request->setAcknowledged($acknowledged);
        });
        return $response;
    }

    /**
     * 确认您接受亚马逊合作承运人的预计运费，并请求亚马逊合作承运人配送您的入库货件
     * @param array $config
     * @return FBAInboundServiceMWS_Model_ConfirmTransportRequestResponse
     */
    public function confirmTransportRequest($config){
        $serviceName = 'FBAInboundServiceMWS';
        $methodName = 'ConfirmTransportRequest';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$methodName,function($request)use($config){
            /**
             * @var FBAInboundServiceMWS_Model_ConfirmTransportInputRequest $request
             */
            $request->setSellerId($config);
        });
        return $response;
    }

    /**
     * 返回创建 入库货件所需的信息。
     * @param $config
     * @param $shipFromAddress
     * @param $labelPrepPreference
     * @param $inboundShipmentPlanRequestItems
     * @return FBAInboundServiceMWS_Model_CreateInboundShipmentPlanResponse
     */
    public function createInboundShipmentPlan($config,$shipFromAddress,$labelPrepPreference,$inboundShipmentPlanRequestItems){
        $serviceName = 'FBAInboundServiceMWS';
        $methodName = 'CreateInboundShipmentPlan';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$methodName,function($request)use($config,$shipFromAddress,$labelPrepPreference,$inboundShipmentPlanRequestItems){
            /**
             * @var FBAInboundServiceMWS_Model_CreateInboundShipmentPlanRequest $request
             */
            $request->setSellerId($config);
            $request->setShipFromAddress($shipFromAddress);
            $request->setLabelPrepPreference($labelPrepPreference);
            $request->setInboundShipmentPlanRequestItems($inboundShipmentPlanRequestItems);
        });
        return $response;
    }

    /**
     * 创建入库货件。
     * @param $config
     * @param $shipmentId
     * @param $inboundShipmentHeader
     * @param $inboundShipmentItems
     * @return FBAInboundServiceMWS_Model_CreateInboundShipmentResponse
     */
    public function createInboundShipment($config,$shipmentId,$inboundShipmentHeader,$inboundShipmentItems){
        $serviceName = 'FBAInboundServiceMWS';
        $methodName = 'CreateInboundShipment';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$methodName,function($request)use($config,$shipmentId,$inboundShipmentHeader,$inboundShipmentItems){
            /**
             * @var FBAInboundServiceMWS_Model_CreateInboundShipmentRequest $request
             */
            $request->setSellerId($config);
            $request->setShipmentId($shipmentId);
            $request->setInboundShipmentHeader($inboundShipmentHeader);
            $request->setInboundShipmentItems($inboundShipmentItems);
        });
        return $response;
    }

    /**
     * 请求入库货件的预计运费。
     * @param $config
     * @param $shipmentId
     * @return FBAInboundServiceMWS_Model_EstimateTransportInputResponse
     */
    public function estimateTransportRequest($config,$shipmentId){
        $serviceName = 'FBAInboundServiceMWS';
        $methodName = 'EstimateTransportRequest';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$methodName,function($request)use($config,$shipmentId){
            /**
             * @var FBAInboundServiceMWS_Model_EstimateTransportInputRequest $request
             */
            $request->setSellerId($config);
            $request->setShipmentId($shipmentId);
        });
        return $response;
    }

    /**
     * 返回用于打印入库货件提单的 PDF 文档数据。
     * @param $config
     * @param $shipmentId
     * @return FBAInboundServiceMWS_Model_GetBillOfLadingResponse
     */
    public function getBillOfLading($config,$shipmentId){
        $serviceName = 'FBAInboundServiceMWS';
        $methodName = 'GetBillOfLading';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$methodName,function($request)use($config,$shipmentId){
            /**
             * @var FBAInboundServiceMWS_Model_GetBillOfLadingRequest $request
             */
            $request->setSellerId($config);
            $request->setShipmentId($shipmentId);
        });
        return $response;
    }

    /**
     *返回用于打印入库货件包裹标签的 PDF 文档数据。
     * @param array $config
     * @param string $shipmentId
     * @param string $pageType
     * @param $numberOfPackages
     * @return FBAInboundServiceMWS_Model_GetPackageLabelsResponse
     */
    public function getPackageLabels($config,$shipmentId,$pageType,$numberOfPackages){
        $serviceName = 'FBAInboundServiceMWS';
        $methodName = 'GetPackageLabels';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$methodName,function($request)use($config,$shipmentId,$pageType,$numberOfPackages){
            /**
             * @var FBAInboundServiceMWS_Model_GetPackageLabelsRequest $request
             */
            $request->setSellerId($config);
            $request->setShipmentId($shipmentId);
            $request->setPageType($pageType);
            $request->setNumberOfPackages($numberOfPackages);
        });
        return $response;
    }

    /**
     * Returns pallet labels.
     * @param $config
     * @param $shipmentId
     * @param $pageType
     * @param $numberOfPallets
     * @return FBAInboundServiceMWS_Model_GetPalletLabelsResponse
     */
    public function getPalletLabels($config,$shipmentId,$pageType,$numberOfPallets){
        $serviceName = 'FBAInboundServiceMWS';
        $methodName = 'GetPalletLabels';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$methodName,function($request)use($config,$shipmentId,$pageType,$numberOfPallets){
            /**
             * @var FBAInboundServiceMWS_Model_GetPalletLabelsRequest $request
             */
            $request->setSellerId($config);
            $request->setShipmentId($shipmentId);
            $request->setPageType($pageType);
            $request->setNumberOfPallets($numberOfPallets);
        });
        return $response;
    }

    /**
     * Returns item preparation instructions to help with item sourcing decisions.
     * @param $config
     * @param $ASINList
     * @param $shipToCountryCode
     * @return FBAInboundServiceMWS_Model_GetPrepInstructionsForASINResponse
     */
    public function getPrepInstructionsForASIN($config,$ASINList,$shipToCountryCode){
        $serviceName = 'FBAInboundServiceMWS';
        $methodName = 'GetPrepInstructionsForASIN';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$methodName,function($request)use($config,$ASINList,$shipToCountryCode){
            /**
             * @var FBAInboundServiceMWS_Model_GetPrepInstructionsForASINRequest $request
             */
            $request->setSellerId($config);
            $request->setAsinList($ASINList);
            $request->setShipToCountryCode($shipToCountryCode);
        });
        return $response;
    }

    /**
     *  Returns labeling requirements and item preparation instructions to help you prepare items for an inbound shipment.
     * @param $config
     * @param $sellerSKUList
     * @param $shipToCountryCode
     * @return FBAInboundServiceMWS_Model_GetPrepInstructionsForSkURequest
     */
    public function getPrepInstructionsForSkU($config,$sellerSKUList,$shipToCountryCode){
        $serviceName = 'FBAInboundServiceMWS';
        $methodName = 'GetPrepInstructionsForSkU';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$methodName,function($request)use($config,$sellerSKUList,$shipToCountryCode){
            /**
             * @var FBAInboundServiceMWS_Model_GetPrepInstructionsForSkURequest $request
             */
            $request->setSellerId($config);
            $request->setSellerSKUList($sellerSKUList);
            $request->setShipToCountryCode($shipToCountryCode);
        });
        return $response;
    }

    /**
     * 返回入库货件的当前运输信息。
     * @param $config
     * @param $shipmentId
     * @return FBAInboundServiceMWS_Model_GetTransportContentResponse
     */
    public function getTransportContent($config,$shipmentId){
        $serviceName = 'FBAInboundServiceMWS';
        $methodName = 'GetTransportContent';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$methodName,function($request)use($config,$shipmentId){
            /**
             * @var FBAInboundServiceMWS_Model_GetTransportContentRequest $request
             */
            $request->setSellerId($config);
            $request->setShipmentId($shipmentId);
        });
        return $response;
    }

    /**
     * Returns unique package labels for faster and more accurate shipment processing at the Amazon fulfillment center.
     * @param $config
     * @param $shipmentId
     * @param $pageType
     * @param $packageLabelsToPrint
     * @return FBAInboundServiceMWS_Model_GetUniquePackageLabelsResponse
     */
    public function getUniquePackageLabels($config,$shipmentId,$pageType,$packageLabelsToPrint){
        $serviceName = 'FBAInboundServiceMWS';
        $methodName = 'GetUniquePackageLabels';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$methodName,function($request)use($config,$shipmentId,$pageType,$packageLabelsToPrint){
            /**
             * @var FBAInboundServiceMWS_Model_GetUniquePackageLabelsRequest $request
             */
            $request->setSellerId($config);
            $request->setShipmentId($shipmentId);
            $request->setPageType($pageType);
            $request->setPackageLabelsToPrint($packageLabelsToPrint);
        });
        return $response;
    }

    /**
     * @param $config
     * @param $nextToken
     * @return MarketplaceWebService_Model_ListInboundShipmentItemsByNextTokenResponse
     */
    public function listInboundShipmentItemsByNextToken($config,$nextToken){
        $serviceName = 'FBAInboundServiceMWS';
        $method = 'ListInboundShipmentItemsByNextToken';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$nextToken){
            /**
             * @var FBAInboundServiceMWS_Model_ListInboundShipmentItemsByNextTokenRequest  $request
             */
            $request->setSellerId($config['MERCHANT_ID']);
            $request->setNextToken($nextToken);
        });
        return $response;
    }

    /**
     *
     * @param $config
     * @param $shipmentId
     * @param $lastUpdatedAfter
     * @param $lastUpdatedBefore
     * @return FBAInboundServiceMWS_Model_ListInboundShipmentItemsResponse
     */
    public function listInboundShipmentItems($config,$shipmentId,$lastUpdatedAfter,$lastUpdatedBefore){
        $serviceName = 'FBAInboundServiceMWS';
        $method = 'ListInboundShipmentItems';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$shipmentId,$lastUpdatedAfter,$lastUpdatedBefore){
            /**
             * @var FBAInboundServiceMWS_Model_ListInboundShipmentItemsRequest  $request
             */
            $request->setSellerId($config['MERCHANT_ID']);
            $request->setShipmentId($shipmentId);
            $request->setLastUpdatedAfter($lastUpdatedAfter);
            $request->setLastUpdatedBefore($lastUpdatedBefore);
        });
        return $response;
    }

    /**
     *
     * @param $config
     * @param $nextToken
     * @return FBAInboundServiceMWS_Model_ListInboundShipmentsByNextTokenResponse
     */
    public function listInboundShipmentsByNextToken($config,$nextToken){
        $serviceName = 'FBAInboundServiceMWS';
        $method = 'ListInboundShipmentsByNextToken';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$method,function($request)use($config,$nextToken){
            /**
             * @var FBAInboundServiceMWS_Model_ListInboundShipmentsByNextTokenRequest  $request
             */
            $request->setSellerId($config['MERCHANT_ID']);
            $request->setNextToken($nextToken);
        });
        return $response;
    }

    /**
     * 根据您指定的条件返回入库货件列表
     * @param $config
     * @param $shipmentStatusList
     * @param $shipmentIdList
     * @param $lastUpdatedAfter
     * @param $lastUpdatedBefore
     * @return FBAInboundServiceMWS_Model_ListInboundShipmentsResponse
     */
    public function listInboundShipments($config,$shipmentStatusList,$shipmentIdList,$lastUpdatedAfter,$lastUpdatedBefore){
        $serviceName = 'FBAInboundServiceMWS';
        $methodName = 'ListInboundShipments';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$methodName,function($request)use($config,$shipmentStatusList,$shipmentIdList,$lastUpdatedAfter,$lastUpdatedBefore){
            /**
             * @var FBAInboundServiceMWS_Model_ListInboundShipmentsRequest $request
             */
            $request->setSellerId($config);
            $request->setShipmentStatusList($shipmentStatusList);
            $request->setShipmentIdList($shipmentIdList);
            $request->setLastUpdatedAfter($lastUpdatedAfter);
            $request->setLastUpdatedBefore($lastUpdatedBefore);
        });
        return $response;
    }

    /**
     * 向亚马逊发送入库货件的运输信息
     * @param $config
     * @param $shipmentId
     * @param $isPartnered
     * @param $shipmentType
     * @param $transportDetails
     * @return FBAInboundServiceMWS_Model_PutTransportContentResponse
     */
    public function putTransportContent($config,$shipmentId,$isPartnered,$shipmentType,$transportDetails){
        $serviceName = 'FBAInboundServiceMWS';
        $methodName = 'PutTransportContent';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$methodName,function($request)use($config,$shipmentId,$isPartnered,$shipmentType,$transportDetails){
            /**
             * @var FBAInboundServiceMWS_Model_PutTransportContentRequest $request
             */
            $request->setSellerId($config);
            $request->setShipmentId($shipmentId);
            $request->setIsPartnered($isPartnered);
            $request->setShipmentType($shipmentType);
            $request->setTransportDetails($transportDetails);
        });
        return $response;
    }

    /**
     * 更新现有入库货件
     * @param $config
     * @param $shipmentId
     * @param $inboundShipmentHeader
     * @param $inboundShipmentItems
     * @return FBAInboundServiceMWS_Model_UpdateInboundShipmentResponse
     */
    public function updateInboundShipment($config,$shipmentId,$inboundShipmentHeader,$inboundShipmentItems){
        $serviceName = 'FBAInboundServiceMWS';
        $methodName = 'UpdateInboundShipment';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$methodName,function($request)use($config,$shipmentId,$inboundShipmentHeader,$inboundShipmentItems){
            /**
             * @var FBAInboundServiceMWS_Model_UpdateInboundShipmentRequest $request
             */
            $request->setSellerId($config);
            $request->setShipmentId($shipmentId);
        });
        return $response;
    }

    /**
     * 取消之前确认的使用亚马逊合作承运人配送入库货件的请求。
     * @param array $config
     * @param string $shipmentId
     * @return FBAInboundServiceMWS_Model_VoidTransportRequestResponse
     */
    public function voidTransport($config,$shipmentId){
        $serviceName = 'FBAInboundServiceMWS';
        $methodName = 'VoidTransportRequest';
        $service = $this->getService($config,$serviceName);
        $response = $this->invoke($service,$serviceName,$methodName,function($request)use($config,$shipmentId){
            /**
             * @var FBAInboundServiceMWS_Model_VoidTransportInputRequest $request
             */
            $request->setSellerId($config);
            $request->setShipmentId($shipmentId);
        });
        return $response;
    }

    public function cancelFulfillmentOrder($config){

    }
    public function createFulfillmentOrder($config){}
    public function getFulfillmentOrder($config){}
    public function getFulfillmentPreview($config){}
    public function getPackageTrackingDetails($config){}

    /**
     *
     * @param $config
     * @param $nextToken
     * @return FBAOutboundServiceMWS_Model_ListAllFulfillmentOrdersByNextTokenResponse
     */
    public function listAllFulfillmentOrdersByNextToken($config,$nextToken){
        $serviceName = 'FBAOutboundServiceMWS';
        $service = $this->getService($config,$serviceName);
        $method = 'ListAllFulfillmentOrdersByNextToken';
        $response = $this->invoke($service, $serviceName, $method, function ($request) use ($config, $nextToken) {
            /**
             * @var  FBAOutboundServiceMWS_Model_ListAllFulfillmentOrdersByNextTokenRequest $request
             */
            $request->setSellerId($config['MERCHANT_ID']);
            $request->setNextToken($nextToken);
        });
        return $response;
    }
    public function listAllFulfillmentOrders(){}
    public function updateFulfillmentOrder(){}

    public function listMarketplaceParticipationsByNextToken($config,$nextToken){
        $serviceName = 'FBAInventoryServiceMWS';
        $service = $this->getService($config,$serviceName);
        $method = 'ListInventorySupplyByNextToken';
        $response = $this->invoke($service, $serviceName, $method, function ($request) use ($config, $nextToken) {
            /**
             * @var  FBAInventoryServiceMWS_Model_ListInventorySupplyByNextTokenRequest $request
             */
            $request->setSellerId($config['MERCHANT_ID']);
            $request->setNextToken($nextToken);
        });
        return $response;
    }
    public function listMarketplaceParticipations(){}

    public function listFinancialEventGroupsByNextToken($config,$nextToken){
        $serviceName = 'FBAInventoryServiceMWS';
        $service = $this->getService($config,$serviceName);
        $method = 'ListFinancialEventGroupsByNextToken';
        $response = $this->invoke($service, $serviceName, $method, function ($request) use ($config, $nextToken) {
            /**
             * @var  FBAInventoryServiceMWS_Model_ListFinancialEventGroupsByNextTokenRequest $request
             */
            $request->setSellerId($config['MERCHANT_ID']);
            $request->setNextToken($nextToken);
        });
        return $response;
    }
    public function listFinancialEventGroups(){}

    /**
     * @param $config
     * @param $nextToken
     * @return FBAInventoryServiceMWS_Model_ListFinancialEventGroupsByNextTokenResponse
     */
    public function listFinancialEventsByNextToken($config,$nextToken){
        $serviceName = 'FBAInventoryServiceMWS';
        $service = $this->getService($config,$serviceName);
        $method = 'ListFinancialEventGroupsByNextToken';
        $response = $this->invoke($service, $serviceName, $method, function ($request) use ($config, $nextToken) {
            /**
             * @var  FBAInventoryServiceMWS_Model_ListFinancialEventGroupsByNextTokenRequest $request
             */
            $request->setSellerId($config['MERCHANT_ID']);
            $request->setNextToken($nextToken);
        });
        return $response;
    }
    public function listFinancialEvents(){}

    public function getLastUpdatedTimeForRecommendations(){}

    /**
     * @param $config
     * @param $nextToken
     * @return mixed
     */
    public function listRecommendationsByNextToken($config,$nextToken){
        $serviceName = 'FBAInventoryServiceMWS';
        $service = $this->getService($config,$serviceName);
        $method = 'ListInventorySupplyByNextToken';
        $response = $this->invoke($service, $serviceName, $method, function ($request) use ($config, $nextToken) {
            /**
             * @var  FBAInventoryServiceMWS_Model_ListRecommendationsByNextTokenRequest $request
             */
            $request->setSellerId($config['MERCHANT_ID']);
            $request->setNextToken($nextToken);
        });
        return $response;
    }
    public function listRecommendations(){}

    /**
     * @param $config
     * @param string $time
     * @return mixed
     */
    public function listInventorySupply($config, $time = '', $skuList)
    {

        $serviceName = 'FBAInventoryServiceMWS';
        $service = $this->getService($config, $serviceName);
        $method = 'listInventorySupply';
        $response = $this->invoke($service, $serviceName, $method, function ($request) use ($config, $time, $skuList) {
            $request->setSellerId($config['MERCHANT_ID']);
            if ($skuList) {
                require("FBAInventoryServiceMWS/Model/SellerSkuList.php");
                $sellerSkuList = new FBAInventoryServiceMWS_Model_SellerSkuList();
                $sellerSkuList->setmember($skuList);
                $request->setSellerSkus($sellerSkuList);
            } else {
                $request->setQueryStartDateTime($time);
            }
        });

        return $response;
    }


    /**
     * @param $config
     * @param $nextToken
     * @return mixed
     */
    public function ListInventorySupplyByNextToken($config, $nextToken)
    {
        $serviceName = 'FBAInventoryServiceMWS';
        $service = $this->getService($config,$serviceName);
        $method = 'ListInventorySupplyByNextToken';
        $response = $this->invoke($service, $serviceName, $method, function ($request) use ($config, $nextToken) {
            /**
             * @var  FBAInventoryServiceMWS_Model_ListInventorySupplyByNextTokenRequest $request
             */
            $request->setSellerId($config['MERCHANT_ID']);
            $request->setNextToken($nextToken);
        });
        return $response;
    }


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
            case 'FulfillmentOutboundShipment':
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
        } else if ($serviceName == 'FBAInventoryServiceMWS') {
            $serviceName = 'FulfillmentInventory';
        } else if($serviceName == 'FBAOutboundServiceMWS'){
            $serviceName = 'FBAOutboundServiceMWS';
        }

        if(empty($serviceName)){
            return $config['URL'];
        }else{
            return $config['URL']."/".$serviceName.'/'.$clientClass::SERVICE_VERSION;
        }
    }

    /**
     * 发起请求
     * @param object $service
     * @param string $serviceName
     * @param string $methodName
     * @param callable $callback
     * @return mixed
     */
    protected function invoke($service,$serviceName,$methodName,$callback)
    {
        try {
            if(substr($methodName,strlen($methodName)-7) == 'Request'){
                $requestName = substr($methodName,0,strlen($methodName)-7).'InputRequest';
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