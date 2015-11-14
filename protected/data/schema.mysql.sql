use test;
CREATE TABLE goods(
  goods_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '商品编号',
  goods_name VARCHAR(64) NOT NULL COMMENT '商品标题',
  sold_num INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '销售数量',
  availability TINYINT UNSIGNED NOT NULL NOT NULL DEFAULT 1 COMMENT '1:销售中，0:已下架',
  stock_num INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '库存数量'
)ENGINE = InnoDb CHAR SET utf8 COMMENT '商品表';

CREATE TABLE goods_category(
  cate_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '分类标识',
  cate_name VARCHAR(64) NOT NULL COMMENT '分类名称',
  parent_id INT UNSIGNED COMMENT '上级分类',
  level INT UNSIGNED NOT NULL COMMENT '分类级别',
  FOREIGN KEY ('parent_id') REFERENCES  goods_category ('cate_id')
)ENGINE = InnoDb CHAR SET utf8 COMMENT '商品分类表';

CREATE TABLE goods_image(
  img_id BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '图片编号',
  goods_id INT UNSIGNED NOT NULL COMMENT '商品分类编号',
  img_name VARCHAR(32) NOT NULL COMMENT '图片名称'
)ENGINE = InnoDb CHAR SET utf8 COMMENT '商品图片';

CREATE TABLE goods_attributes(
  attr_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '商品属性标识',
  attr_name VARCHAR(32) NOT NULL COMMENT '商品属性名称'
)ENGINE = InnoDb CHAR SET utf8 COMMENT '商品属性表';

CREATE TABLE goods_attr_value(
  goods_id INT UNSIGNED NOT NULL COMMENT '商品标识',
  attr_id INT UNSIGNED NOT NULL COMMENT '商品附加属性标识',
  attr_name VARCHAR(32) NOT NULL COMMENT '商品属性名称(冗余数据)',
  attr_value VARCHAR(32) NOT NULL COMMENT '商品附加属性值',
  PRIMARY KEY (goods_id,attr_id)
)ENGINE = InnoDb CHAR SET utf8 COMMENT '商品附加属性表';
















create TABLE goods_local(
  goods_id INT UNSIGNED NOT NULL COMMENT '商品编号',
  lang TINYINT UNSIGNED NOT NULL COMMENT '语言/地区',
  goods_name VARCHAR(64) NOT NULL COMMENT '商品标题',
  sold_num INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '销售数量',
  availability TINYINT UNSIGNED NOT NULL NOT NULL DEFAULT 1 COMMENT '1:销售中，0:已下架',
  stock_num INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '本地库存数量',
  PRIMARY KEY (goods_id,lang)
)ENGINE = InnoDb CHAR SET utf8 COMMENT '商品国际化表';

create TABLE goods_category_local(
  cate_id INT UNSIGNED NOT NULL COMMENT '分类标识',
  lang TINYINT UNSIGNED NOT NULL COMMENT '语言/地区',
  cate_name VARCHAR(64) NOT NULL COMMENT '分类名称',
  PRIMARY KEY (cate_id,lang)
)ENGINE = InnoDb CHAR SET utf8 COMMENT '商品分类国际化表';

create TABLE goods_attributes_local(
  attr_id INT UNSIGNED NOT NULL COMMENT '商品属性标识',
  lang TINYINT UNSIGNED NOT NULL COMMENT '语言/地区',
  attr_name VARCHAR(32) NOT NULL COMMENT '商品属性名称',
  PRIMARY KEY (attr_id,lang)
)ENGINE = InnoDb CHAR SET utf8 COMMENT '商品属性国际化表';

CREATE TABLE goods_attr_value_local(
  goods_id INT UNSIGNED NOT NULL COMMENT '商品标识',
  attr_id INT UNSIGNED NOT NULL COMMENT '商品附加属性标识',
  attr_value VARCHAR(32) NOT NULL COMMENT '商品附加属性值',
  lang TINYINT UNSIGNED NOT NULL COMMENT '语言/地区',
  PRIMARY KEY (goods_id,attr_id,lang)
)ENGINE = InnoDb CHAR SET utf8 COMMENT '商品附加属性国际化表';








insert into goods  (goods_name,sold_num,availability,stock_num)VALUE ('测试',11,1,999);


insert into goods_attributes (attr_name) VALUES ('重量'),('质材');
insert into goods_attr_value VALUES (1,1,'重量','0.1kg'),(2,2,'质材','金属');
insert into goods_local VALUES (1,1,'test',12,1,999);








CREATE TABLE IF NOT EXISTS user(
  id BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '',
  first_name VARCHAR(20) NOT NULL COMMENT '',
  last_name VARCHAR(20) NOT NULL COMMENT '',
  email VARCHAR(64) NOT NULL COMMENT '',
  password VARCHAR(32) NOT NULL COMMENT '',
  birth_day DATETIME NOT NULL COMMENT '',
  gender TINYINT UNSIGNED NOT NULL COMMENT '',
  mobile VARCHAR(20) NOT NULL COMMENT '',
  local VARCHAR(20) NOT NULL COMMENT '',
  alternate_email VARCHAR(64) NOT NULL COMMENT '',
  create_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  last_log_time TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT ''
);


























