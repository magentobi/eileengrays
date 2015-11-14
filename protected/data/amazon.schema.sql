CREATE DATABASE amazon;
USE  amazon;

CREATE TABLE IF NOT EXISTS amazon_order(
  AmazonOrderId VARCHAR(100) NOT NULL COMMENT '����ѷ������Ķ������룬��ʽΪ 3-7-7',
  SellerOrderId VARCHAR(10) COMMENT '����������Ķ�������',
  PurchaseDate DATETIME NOT NULL COMMENT '��������������',
  LastUpdateDate DATETIME NOT NULL COMMENT '����������������',
  OrderStatus VARCHAR(100) NOT NULL COMMENT '��ǰ�Ķ���״̬',
  FulfillmentChannel ENUM('AFN','MFM','') COMMENT '�������ͷ�ʽ������ѷ���� (AFN) �������������� (MFN)',
  SalesChannel VARCHAR(100) COMMENT '�����е�һ����Ʒ����������',
  OrderChannel VARCHAR(100) COMMENT '�����е�һ����Ʒ�Ķ�������',
  ShipServiceLevel VARCHAR(100) COMMENT '��������ˮƽ',
  ShippingAddress INT UNSIGNED COMMENT '���������͵�ַ',
  OrderTotal int UNSIGNED COMMENT '�������ܷ���',
  NumberOfItemsShipped VARCHAR(10) COMMENT '�����͵���Ʒ����',
  NumberOfItemsUnshipped VARCHAR(10) COMMENT 'δ���͵���Ʒ����',
  PaymentExecutionDetail INT UNSIGNED COMMENT '����һ������PaymentExecutionDetailItem��ӦԪ��',
  PaymentMethod ENUM('COD','CVS','Other') COMMENT '��������Ҫ���ʽ:COD - ����������������й� (CN) ���ձ� (JP),�����ꡣ���������ձ� (JP),Other - COD �� CVS ֮��ĸ��ʽ',
  MarketplaceId VARCHAR(10) NOT NULL COMMENT '�������������̳ǵ���������',
  BuyerEmail VARCHAR(10) COMMENT '��ҵ����������ʼ���ַ',
  BuyerName VARCHAR(11) COMMENT '�������',
  ShipmentServiceLevelCategory ENUM('Expedited','FreeEconomy','NextDay','SameDay','SecondDay','Scheduled','Standard') COMMENT '���������ͷ��񼶱����',
  ShippedByAmazonTFM BOOLEAN COMMENT 'ָ���������ͷ��Ƿ�������ѷ���� (Amazon TFM) ����,����ѷ TFM ���������й� (CN)',
  TFMShipmentStatus ENUM('PendingPickUp','LabelCanceled','PickedUp','AtDestinationFC','Delivered','RejectedByBuyer','Undeliverable','ReturnedToSeller') COMMENT '����ѷ TFM������״̬������ShippedByAmazonTFM = Trueʱ���ء���ע�⣺��ʹ�� ShippedByAmazonTFM = True ʱ���������û�д���������Ҳ���᷵�� TFMShipmentStatus,����ѷ TFM ���������й� (CN)',
  CbaDisplayableShippingLabel VARCHAR(100) COMMENT '�����Զ�������ͷ�ʽ������Checkout by Amazon (CBA) ��֧�ֵ����ֱ�׼���������е�һ��,CBA ������������ (US)��Ӣ�� (UK) �͵¹� (DE) ������',
  OrderType ENUM('StandardOrder','Preorder') NOT NULL COMMENT '�������� :StandardOrder - ������ǰ�п����Ʒ�Ķ���,Preorder -����Ԥ����Ʒ�������������ڵ�ǰ���ڣ��Ķ���,Preorder �����ձ� (JP) �ǿ��е�OrderType ֵ',
  EarliestShipDate DATETIME COMMENT '����ŵ�Ķ�������ʱ�䷶Χ�ĵ�һ�졣���ڸ�ʽΪ ISO 8601,���������������� (MFN) ��������,���ܲ���� 2013 �� 2 �� 1 ��֮ǰ�Ķ������� EarliestShipDate',
  LatestShipDate DATETIME COMMENT '����ŵ�Ķ�������ʱ�䷶Χ�����һ�졣���ڸ�ʽΪ ISO 8601,�������������� (MFN)	������ѷ���� (AFN) ��������,���ܲ���� 2013 �� 2 �� 1 ��֮ǰ�Ķ������� LatestShipDate',
  EarliestDeliveryDate DATETIME COMMENT '����ŵ�Ķ����ʹ�ʱ�䷶Χ�ĵ�һ�졣���ڸ�ʽΪ ISO 8601,����û�� PendingAvailability��Pending �� Canceled״̬�� MFN ��������',
  LatestDeliveryDate DATETIME COMMENT '����ŵ�Ķ����ʹ�ʱ�䷶Χ�����һ�졣���ڸ�ʽΪ ISO 8601,����û�� PendingAvailability��Pending �� Canceled״̬�� MFN ��������'
);

CREATE TABLE IF NOT EXISTS Money(
  ID INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '',
  CurrencyCode CHAR(3) NOT NULL COMMENT '��λ���Ļ��Ҵ��� ��ʽΪ ISO 4217',
  Amount VARCHAR(100) NOT NULL COMMENT '���ҽ��'
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