DROP TABLE IF EXISTS `#__gasmanagement`;
DROP TABLE IF EXISTS `#__weldingmanagement`;
CREATE TABLE `#__gasmanagement`(
  `id`       INT(11)     NOT NULL AUTO_INCREMENT,
  `number`  VARCHAR(30) DEFAULT '****-****-****-****' NOT NULL COMMENT '气体编号',
  `name` VARCHAR(30) NOT NULL,
  `brand` VARCHAR(30) COMMENT '气体牌号',
  `standard` VARCHAR(30) COMMENT '气体规格',
  PRIMARY KEY (`id`)
)ENGINE =MyISAM AUTO_INCREMENT =1 DEFAULT CHARSET =utf8;

CREATE TABLE `#__weldingmanagement`(
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(30) NOT NULL ,
  `brand` VARCHAR(30) COMMENT '牌号',
  `diameter` VARCHAR(20) COMMENT '焊丝直径',
  `density` VARCHAR(10) COMMENT '焊丝密度',
  `number` VARCHAR(20) COMMENT '焊丝编号',
  `desc`  TEXT COMMENT '说明 描述',
  PRIMARY KEY (`id`)
)ENGINE MyISAM AUTO_INCREMENT = 1 DEFAULT CHARSET =utf8;