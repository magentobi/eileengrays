CREATE TABLE IF NOT EXISTS user(
  id BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '',
  first_name VARCHAR(20) NOT NULL COMMENT '',
  last_name VARCHAR(20) NOT NULL COMMENT '',
  email VARCHAR(64) NOT NULL COMMENT '',
  password VARCHAR(32) NOT NULL COMMENT '',
  birth_day DATETIME NOT NULL COMMENT '',
  gender TINYINT UNSIGNED NOT NULL COMMENT '',
  mobile VARCHAR(20) NOT NULL COMMENT '',
  country VARCHAR(20) NOT NULL COMMENT '',
  alternate_email VARCHAR(64) NOT NULL COMMENT ''
);

CREATE TABLE IF NOT EXISTS log();
CREATE TABLE IF NOT EXISTS platform(
  id
);

-- 仓库维护产品
CREATE TABLE IF NOT EXISTS product(
  id int PRIMARY KEY AUTO_INCREMENT ,
  title VARCHAR(10) NOT NULL ,
  sku VARCHAR(10) NOT NULL UNIQUE ,
  format VARCHAR(100) COMMENT ''
);

-- 线上维护产品
CREATE TABLE IF NOT EXISTS item(
  id INT PRIMARY KEY AUTO_INCREMENT,
  sku VARCHAR(32) NOT NULL COMMENT ''
);

-- 线上产品关联仓库产品
CREATE TABLE IF NOT EXISTS item_product(
  item_id INT,
  product_id int,
  num int
);

-- 产品发布平台店铺对应线上产品
CREATE TABLE IF NOT EXISTS item_platform(
  platform_id int,
  store_id int,
  item_id int,
  sku VARCHAR(10)
);
-- 订单表
CREATE TABLE IF NOT EXISTS orders(
  order_id int,
  payment_info VARCHAR(100)
);
-- 订单包含线上产品
CREATE TABLE IF NOT EXISTS order_item(
  order_id int,
  item_id int,
  sku int,
  num int
);

-- 仓库表



























