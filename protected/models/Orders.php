<?php

/**
 * Class Address 订单的配送地址。
 * @attribute string $name	名称。
 * @attribute string $addressLine1	街道地址。
 * @attribute string $addressLine2	其他街道地址信息（如果需要）。
 * @attribute string $addressLine3	其他街道地址信息（如果需要）。
 * @attribute string $city	城市。
 * @attribute string $county	区县。
 * @attribute string $district	区。
 * @attribute string $stateOrRegion	省/自治区/直辖市或地区。
 * @attribute string $postalCode	邮政编码。
 * @attribute string $countryCode	两位数国家/地区代码。格式为 ISO 3166-1-alpha 2 。
 * @attribute string $phone	电话号码。
 */
class Address{
    protected $name;
    protected $addressLine1;
    protected $addressLine2;
    protected $addressLine3;
    protected $city;
    protected $county;
    protected $district;
    protected $stateOrRegion;
    protected $postalCode;
    protected $countryCode;
    protected $phone;
}

/**
 * Class InvoiceData 发票信息（仅适用于中国）。
 * 
 * @attribute string $invoiceRequirement	发票要求信息。
 *
 */
class InvoiceData{
    const InvoiceRequirementIndividual = "Individual"; //买家要求对订单中的每件订单商品单独开具发票。
    const InvoiceRequirementConsolidated = "Consolidated"; //买家要求对订单中的所有订单商品开具一张发票。
    const InvoiceRequirementMustNotSend = "MustNotSend"; // 买家不要求开具发票。

    const NotApplicable = 'NotApplicable';
    const BuyerSelectedInvoiceCategory  = 'NotApplicable';
    const ProductTitle  = 'NotApplicable';

    protected $invoiceRequirement;
    protected $buyerSelectedInvoiceCategory;
    protected $invoiceTitle;
    protected $invoiceInformation;
}

/**
 * Class Money 货币类型和金额。
 * @attribute string $name	名称。
 */
class Money{
    protected $currencyCode;
    protected $amount;
}

/**
 * Class Order 订单详情。
 * @attribute string $name	名称。
 */
class Order{
    const FULFILLMENT_CHANNEL_AFN = 'AFN';
    const FULFILLMENT_CHANNEL_MFN = 'MFN';

    const SHIPMENT_SERVICE_LEVEL_CATEGORY_EXPEDITED = 'Expedited';
    const SHIPMENT_SERVICE_LEVEL_CATEGORY_FREE_ECONOMY = 'FreeEconomy';
    const SHIPMENT_SERVICE_LEVEL_CATEGORY_NEXT_DAY = 'NextDay';
    const SHIPMENT_SERVICE_LEVEL_CATEGORY_SAME_DAY = 'SameDay';
    const SHIPMENT_SERVICE_LEVEL_CATEGORY_SECOND_DAY = 'SecondDay';
    const SHIPMENT_SERVICE_LEVEL_CATEGORY_SCHEDULED = 'Scheduled';
    const SHIPMENT_SERVICE_LEVEL_CATEGORY_STANDARD = 'Standard';

    const TFM_SHIPMENT_STATUS_PENDING_PICK_UP = 'PendingPickUp';
    const TFM_SHIPMENT_STATUS_LABEL_CANCELED = 'LabelCanceled';
    const TFM_SHIPMENT_STATUS_PICKED_UP = 'PickedUp';
    const TFM_SHIPMENT_STATUS_AT_DESTINATION_FC = 'AtDestinationFC';
    const TFM_SHIPMENT_STATUS_DELIVERED = 'Delivered';
    const TFM_SHIPMENT_STATUS_REJECTED_BY_BUYER = 'RejectedByBuyer';
    const TFM_SHIPMENT_STATUS_UNDELIVERABLE = 'Undeliverable';
    const TFM_SHIPMENT_STATUS_RETURNED_TO_SELLER = 'ReturnedToSeller';


    protected $amazonOrderId;
    protected $SellerOrderId;
    protected $purchaseDate;
    protected $lastUpdateDate;
    protected $orderStatus;
    protected $fulfillmentChannel;
    protected $SalesChannel;
    protected $OrderChannel;
    protected $ShipServiceLevel;
    protected $ShippingAddress;
    protected $OrderTotal;
    protected $NumberOfItemsShipped;
    protected $NumberOfItemsUnshipped;
    protected $PaymentExecutionDetail;
    protected $PaymentMethod;
    protected $MarketplaceId;
    protected $BuyerEmail;
    protected $BuyerName;
    protected $ShipmentServiceLevelCategory;
    protected $ShippedByAmazonTFM;
    protected $TFMShipmentStatus;
    protected $CbaDisplayableShippingLabel;
    protected $OrderType;
    protected $EarliestShipDate;
    protected $LatestShipDate;
    protected $EarliestDeliveryDate;
    protected $LatestDeliveryDate;
}

/**
 * Class OrderItem OrderItem 信息。
 *
 * @attribute string $ScheduledDeliveryEndDate	订单预约送货上门的终止日期
 * @attribute string $ScheduledDeliveryEndDate	订单预约送货上门的终止日期
 * @attribute string $ScheduledDeliveryEndDate	订单预约送货上门的终止日期
 * @attribute string $ScheduledDeliveryEndDate	订单预约送货上门的终止日期
 * @attribute string $ScheduledDeliveryEndDate	订单预约送货上门的终止日期
 * @attribute string $ScheduledDeliveryEndDate	订单预约送货上门的终止日期
 * @attribute string $ScheduledDeliveryEndDate	订单预约送货上门的终止日期
 * @attribute string $ScheduledDeliveryEndDate	订单预约送货上门的终止日期
 * @attribute string $ScheduledDeliveryEndDate	订单预约送货上门的终止日期
 * @attribute string $ScheduledDeliveryEndDate	订单预约送货上门的终止日期
 *
 *
 * @attribute string $ScheduledDeliveryEndDate	订单预约送货上门的终止日期（目的地时区）。日期格式为 ISO 8601。
                    注： 预约送货上门仅适用于日本 (JP)。
                    可选。仅当订单为预约送货上门时才返回。
 */
class OrderItem{
    protected $asin;
    protected $SellerSKU;
    protected $OrderItemId;
    protected $Title;
    protected $QuantityOrdered;
    protected $QuantityShipped;
    protected $ItemPrice;
    protected $ShippingPrice;
    protected $GiftWrapPrice;
    protected $ItemTax;
    protected $ShippingTax;
    protected $GiftWrapTax;
    protected $ShippingDiscount;
    protected $PromotionDiscount;
    protected $PromotionIds;
    protected $CODFee;
    protected $CODFeeDiscount;
    protected $GiftMessageText;
    protected $GiftWrapLevel;
    protected $InvoiceData;
    protected $ConditionNote;
    protected $ConditionId;
    protected $ConditionSubtypeId;
    protected $ScheduledDeliveryStartDate;
    protected $ScheduledDeliveryEndDate;

}

/**
 * Class PaymentExecutionDetailItem 用于支付 COD 订单的次级付款方式的相关信息。
 * @attribute string $name	名称。
 */
class PaymentExecutionDetailItem{

    const PAYMENT_METHOD_COD = 'COD';
    const PAYMENT_METHOD_GC = 'GC';
    const PAYMENT_METHOD_POINTS_ACCOUNT = 'PointsAccount ';

    protected $payment;
    protected $paymentMethod;
}

