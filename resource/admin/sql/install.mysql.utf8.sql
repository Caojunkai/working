
CREATE TABLE IF NOT EXISTS `#__resource_welder` (
  `id`INT(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL COMMENT 'The name',
  `groups`varchar(150) NOT NULL ,
  `certificate` varchar(128) DEFAULT '' COMMENT '资格证',
  `certificate_end`  datetime DEFAULT NULL COMMENT '资格证到期时间',
  `work_start`  datetime DEFAULT NULL COMMENT '上岗时间',
  `site` varchar(100) DEFAULT '' COMMENT '焊接位置',
  PRIMARY KEY (`id`),
  INDEX `name`(`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

CREATE TABLE IF NOT EXISTS `#__resource_gas`(
  `id`       INT(11)     NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(30) NOT NULL,
  `brand` VARCHAR(30) COMMENT '气体牌号',
  `standard` VARCHAR(30) COMMENT '气体规格',
  `num`  VARCHAR(30) DEFAULT '****-****-****-****' NOT NULL COMMENT '气体编号',
  PRIMARY KEY (`id`)
)ENGINE =MyISAM AUTO_INCREMENT =1 DEFAULT CHARSET =utf8;

CREATE TABLE IF NOT EXISTS `#__resource_welding`(
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(30) NOT NULL ,
  `brand` VARCHAR(30) COMMENT '牌号',
  `diameter` VARCHAR(20) COMMENT '焊丝直径',
  `density` VARCHAR(10) COMMENT '焊丝密度',
  `num` VARCHAR(20) COMMENT '焊丝编号',
  `desc`  TEXT COMMENT '说明 描述',
  PRIMARY KEY (`id`)
)ENGINE MyISAM AUTO_INCREMENT = 1 DEFAULT CHARSET =utf8;


CREATE TABLE IF NOT EXISTS `#__resource_tech` (
  `id`INT(11) NOT NULL AUTO_INCREMENT,
  `num`varchar(150) NOT NULL COMMENT '文件编号',
  `name` varchar(150) NOT NULL COMMENT 'The name',
  `site` varchar(256) NOT NULL COMMENT '焊接位置',
  `weld_arg` varchar(256) NOT NULL COMMENT '焊接参数',
  `board_arg` varchar(256) NOT NULL COMMENT '板材参数',
  `speed` varchar(256) NOT NULL COMMENT '送丝速度',
  `welding` varchar(256) NOT NULL COMMENT '所用的焊丝',
  `gas_arg` varchar(256) NOT NULL COMMENT '气体参数设置',
  `weld_site` varchar(256) NOT NULL COMMENT '焊接位置图',
  `voltage` varchar(256) NOT NULL COMMENT '电压范围',
  `weld_speed` varchar(256) NOT NULL COMMENT '焊接速度',
  `weld_tech` varchar(256) NOT NULL COMMENT '焊接工艺图资料',
  `number` varchar(256) NOT NULL COMMENT '编号',
  `i` varchar(256) NOT NULL COMMENT '电流',
  `v` varchar(256) NOT NULL COMMENT '电压',
  `consumable` varchar(256) NOT NULL COMMENT '耗材',
  `gas_name` varchar(256) NOT NULL COMMENT '气体名称',
  `gas_flow` varchar(256) NOT NULL COMMENT '气体流量',
  PRIMARY KEY (`id`),
  INDEX `name`(`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

CREATE TABLE IF NOT EXISTS `#__resource_workshop` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `coding` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `remark` text CHARACTER SET utf8 COLLATE utf8_bin,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__resource_machine` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sequence` varchar(20) DEFAULT NULL,
  `coding` varchar(20) DEFAULT NULL,
  `model` varchar(20) DEFAULT NULL,
  `position` varchar(30) DEFAULT NULL,
  `pic` varchar(20) DEFAULT NULL,
  `usetime` datetime DEFAULT NULL,
  `hanjietime` varchar(20) DEFAULT NULL,
  `baoyantime` varchar(10) DEFAULT NULL,
  `records` varchar(100) DEFAULT NULL,
  `times` varchar(10) DEFAULT NULL,
  `workshopid` int(10) DEFAULT NULL,
  `guzhang` tinyint(2) NOT NULL DEFAULT '0',
  `created_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__resource_maintain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `welder_id` int(11) DEFAULT NULL,
  `machine_id` int(11) DEFAULT NULL,
  `oper_time` varchar(20) DEFAULT NULL,
  `limit_time` varchar(20) DEFAULT NULL,
  `oper_name` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
