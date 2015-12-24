CREATE DATABASE amazon;
USE  amazon;

CREATE TABLE IF NOT EXISTS amazon_order(
  AmazonOrderId VARCHAR(100) NOT NULL COMMENT '亚马逊所定义的订单编码，格式为 3-7-7',
  SellerOrderId VARCHAR(10) COMMENT '卖家所定义的订单编码',
  PurchaseDate DATETIME NOT NULL COMMENT '创建订单的日期',
  LastUpdateDate DATETIME NOT NULL COMMENT '订单的最后更新日期',
  OrderStatus VARCHAR(100) NOT NULL COMMENT '当前的订单状态',
  FulfillmentChannel ENUM('AFN','MFM','') COMMENT '订单配送方式：亚马逊配送 (AFN) 或卖家自行配送 (MFN)',
  SalesChannel VARCHAR(100) COMMENT '订单中第一件商品的销售渠道',
  OrderChannel VARCHAR(100) COMMENT '订单中第一件商品的订单渠道',
  ShipServiceLevel VARCHAR(100) COMMENT '货件服务水平',
  ShippingAddress INT UNSIGNED COMMENT '订单的配送地址',
  OrderTotal int UNSIGNED COMMENT '订单的总费用',
  NumberOfItemsShipped VARCHAR(10) COMMENT '已配送的商品数量',
  NumberOfItemsUnshipped VARCHAR(10) COMMENT '未配送的商品数量',
  PaymentExecutionDetail INT UNSIGNED COMMENT '包含一个或多个PaymentExecutionDetailItem响应元素',
  PaymentMethod ENUM('COD','CVS','Other') COMMENT '订单的主要付款方式:COD - 货到付款。仅适用于中国 (CN) 和日本 (JP),便利店。仅适用于日本 (JP),Other - COD 和 CVS 之外的付款方式',
  MarketplaceId VARCHAR(10) NOT NULL COMMENT '订单生成所在商城的匿名编码',
  BuyerEmail VARCHAR(10) COMMENT '买家的匿名电子邮件地址',
  BuyerName VARCHAR(11) COMMENT '买家姓名',
  ShipmentServiceLevelCategory ENUM('Expedited','FreeEconomy','NextDay','SameDay','SecondDay','Scheduled','Standard') COMMENT '订单的配送服务级别分类',
  ShippedByAmazonTFM BOOLEAN COMMENT '指明订单配送方是否是亚马逊配送 (Amazon TFM) 服务,亚马逊 TFM 仅适用于中国 (CN)',
  TFMShipmentStatus ENUM('PendingPickUp','LabelCanceled','PickedUp','AtDestinationFC','Delivered','RejectedByBuyer','Undeliverable','ReturnedToSeller') COMMENT '亚马逊 TFM订单的状态。仅当ShippedByAmazonTFM = True时返回。请注意：即使当 ShippedByAmazonTFM = True 时，如果您还没有创建货件，也不会返回 TFMShipmentStatus,亚马逊 TFM 仅适用于中国 (CN)',
  CbaDisplayableShippingLabel VARCHAR(100) COMMENT '卖家自定义的配送方式，属于Checkout by Amazon (CBA) 所支持的四种标准配送设置中的一种,CBA 仅适用于美国 (US)、英国 (UK) 和德国 (DE) 的卖家',
  OrderType ENUM('StandardOrder','PreOrder') NOT NULL COMMENT '订单类型 :StandardOrder - 包含当前有库存商品的订单,PreOrder -所含预售商品（发布日期晚于当前日期）的订单,Preorder 仅在日本 (JP) 是可行的OrderType 值',
  EarliestShipDate DATETIME COMMENT '您承诺的订单发货时间范围的第一天。日期格式为 ISO 8601,仅对卖家配送网络 (MFN) 订单返回,可能不会对 2013 年 2 月 1 日之前的订单返回 EarliestShipDate',
  LatestShipDate DATETIME COMMENT '您承诺的订单发货时间范围的最后一天。日期格式为 ISO 8601,对卖家配送网络 (MFN)	和亚马逊物流 (AFN) 订单返回,可能不会对 2013 年 2 月 1 日之前的订单返回 LatestShipDate',
  EarliestDeliveryDate DATETIME COMMENT '您承诺的订单送达时间范围的第一天。日期格式为 ISO 8601,仅对没有 PendingAvailability、Pending 或 Canceled状态的 MFN 订单返回',
  LatestDeliveryDate DATETIME COMMENT '您承诺的订单送达时间范围的最后一天。日期格式为 ISO 8601,仅对没有 PendingAvailability、Pending 或 Canceled状态的 MFN 订单返回'
);

CREATE TABLE IF NOT EXISTS Money(
  ID INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '',
  CurrencyCode CHAR(3) NOT NULL COMMENT '三位数的货币代码 格式为 ISO 4217',
  Amount VARCHAR(100) NOT NULL COMMENT '货币金额'
);

CREATE TABLE IF NOT EXISTS Address(
  Name VARCHAR(10) NOT NULL COMMENT '',
  AddressLine1 VARCHAR(100) NOT NULL COMMENT '',
  AddressLine2 VARCHAR(100) COMMENT '',
  AddressLine3 VARCHAR(100) COMMENT '',
  City VARCHAR(100) NOT NULL COMMENT '',
  County VARCHAR(100) NOT NULL COMMENT '',
  District VARCHAR(100) NOT NULL COMMENT ''

);

CREATE TABLE IF NOT EXISTS submission(
  feedSubmissionId VARCHAR(100) NOT NULL PRIMARY KEY COMMENT '',
  feedType VARCHAR(32) NOT NULL COMMENT '',
  submmittedDate DATETIME NOT NULL COMMENT '',
  feedProcessingStatus VARCHAR(100) NOT NULL COMMENT '',
  startedProcessingDate DATETIME COMMENT '',
  completedProcessingDate DATETIME COMMENT ''
);