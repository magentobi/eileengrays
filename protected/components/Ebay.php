<?php

/**
 *
 * @desc       Ebay.php file.
 *
 * @author     Qiu Xincai <qiuxc@eileengrays.com>
 * @link       http://www.eileengrays.com/
 * @copyright  EileenGrays.Com 2013-2015
 * @license    http://www.eileengrays.com/
 */
class Ebay extends CApplicationComponent
{
    protected function getOrders($config,$timeStart,$timeEnd,$page,$pateSize)
    {
        $CreateTimeFrom = gmdate("Y-m-d\TH:i:s", strtotime($timeStart)); //current time minus 30 minutes
        $CreateTimeTo = gmdate("Y-m-d\TH:i:s", strtotime($timeEnd));
        ///Build the request Xml string
        $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
        $requestXmlBody .= '<GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
        $requestXmlBody .= '<DetailLevel>ReturnAll</DetailLevel>';
        //$requestXmlBody .= "<CreateTimeFrom>$CreateTimeFrom</CreateTimeFrom><CreateTimeTo>$CreateTimeTo</CreateTimeTo>";
        $requestXmlBody .= "<ModTimeFrom>$CreateTimeFrom</ModTimeFrom><ModTimeTo>$CreateTimeTo</ModTimeTo>";
        if ($order_id) {
            $requestXmlBody .= '<OrderIDArray><OrderID>' . $order_id . '</OrderID></OrderIDArray>';
        }
        $requestXmlBody .= '<OrderRole>Seller</OrderRole><OrderStatus>Completed</OrderStatus>'; //Completed, Shipped
        $requestXmlBody .= '<Pagination><EntriesPerPage>100</EntriesPerPage><PageNumber>' . $page . '</PageNumber></Pagination>';
        $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>" . Yii::app()->params->ebay['production']['userToken'][$store_id] . "</eBayAuthToken></RequesterCredentials>";
        $requestXmlBody .= '</GetOrdersRequest>';

        //Create a new eBay session with all details pulled in from included keys.php
        $session = new EBaySession(Yii::app()->params->ebay['production']['userToken'][$store_id], Yii::app()->params->ebay['production']['devID'][$store_id], Yii::app()->params->ebay['production']['appID'][$store_id], Yii::app()->params->ebay['production']['certID'][$store_id], Yii::app()->params->ebay['production']['serverUrl'], Yii::app()->params->ebay['compatabilityLevel'], $siteID, $verb);

        //send the request and get response
        $responseXml = $session->sendHttpRequest($requestXmlBody);

    }
}