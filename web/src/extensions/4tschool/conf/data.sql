DROP TABLE IF EXISTS pw_4t_tag;
CREATE TABLE `pw_4t_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '动态ID',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '标签名',
  `issystem` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型:1-系统,0-非系统',
  `createdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `lastupdatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT '标签';

DROP TABLE IF EXISTS pw_4t_merchandise;
CREATE TABLE `pw_4t_merchandise` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '动态ID',
  `shopid` int(10) unsigned NOT NULL COMMENT '外键shopid',
  `tagid` int(10) unsigned NOT NULL COMMENT '外键tagid',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品名',
  `price` decimal(10,0) DEFAULT 0 COMMENT '价格',
  `unit` char(10) NOT NULL DEFAULT '' COMMENT '单位',
  `remainder` int NOT NULL DEFAULT 0 COMMENT '剩余数量',
  `ordercount` int NOT NULL DEFAULT 0 COMMENT '已卖出数量',
  `imageurl` varchar(200) NOT NULL DEFAULT '' COMMENT '图片相对路径',
  `description` varchar(2000) NOT NULL DEFAULT '' COMMENT '商品描述',
  `createdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `lastupdatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  KEY `shopid` (`shopid`),
  KEY `tagid` (`tagid`),
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT '商品';

DROP TABLE IF EXISTS pw_4t_shop;
CREATE TABLE `pw_4t_shop`(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '动态ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '商店名',
  `address` varchar(500) NOT NULL DEFAULT '' COMMENT '地址',
  `area` int(10) NOT NULL DEFAULT 0 COMMENT '区域',
  `phonenumber` varchar(15) NOT NULL DEFAULT '' COMMENT '电话号码',
  `contactnumber` varchar(15) NOT NULL DEFAULT '' COMMENT '座机号码',
  `openorder` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开放订餐:1-开放,0-关闭',
  `orderbegin` time NOT NULL DEFAULT '090000' COMMENT '每日订餐开始时间',
  `orderend` time NOT NULL DEFAULT '180000' COMMENT '每日订餐结束时间',
  `createdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `lastupdatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  `description` varchar(2000) NOT NULL DEFAULT '' COMMENT '商店描述',
  `ordercount` int(10) NOT NULL DEFAULT 0 COMMENT '订单总数',
  `isactive` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型:1-活动的,0-非活动的',
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT '商家';

DROP TABLE IF EXISTS pw_4t_image;
CREATE TABLE `pw_4t_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '动态ID',
  `fid` int(10) NOT NULL COMMENT '外键,shop & merchandise',
  `imgurl` varchar(500) NOT NULL DEFAULT '' COMMENT '图片路径',
  `type` char(20) NOT NULL DEFAULT '' COMMENT '类型',
  `standard` char(20) NOT Null DEFAULT '' COMMENT '图片规格(Original,Big,medium,small)',
  `createdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `lastupdatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  `isactive` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型:1-活动的,0-非活动的',
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT '图片';

DROP TABLE IF EXISTS pw_4t_order;
CREATE TABLE IF NOT EXISTS `pw_4t_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `schoolid` int(11) NOT NULL,
  `ordernumber` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `orderdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL,
  `paymethod` int(11) NOT NULL,
  `delivermethod` int(11) NOT NULL,
  `to` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `deliverby` int(11) NOT NULL,
  `delivercontact` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `savingtotal` decimal(10,0) NOT NULL,
  `ordermoney` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`,`ordernumber`,`orderdate`,`status`,`paymethod`,`deliverby`),
  KEY `schoolid` (`schoolid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(1,1,342221111,80971,1,2,2,'µØÖ·790',21,'µç»°ºÅÂë 23',1,8);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(2,1,342221112,80971,1,4,1,'µØÖ·679',39,'µç»°ºÅÂë 10',4,11);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(3,1,342221113,80971,1,7,2,'µØÖ·831',39,'µç»°ºÅÂë 26',4,8);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(4,1,342221114,80971,1,7,1,'µØÖ·197',48,'µç»°ºÅÂë 11',5,3);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(5,1,342221115,80971,1,8,2,'µØÖ·850',36,'µç»°ºÅÂë 21',5,11);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(6,1,342221116,80971,1,8,2,'µØÖ·134',10,'µç»°ºÅÂë 50',2,11);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(7,1,342221117,80971,1,8,2,'µØÖ·317',42,'µç»°ºÅÂë 13',2,24);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(8,1,342221118,80971,1,3,2,'µØÖ·585',8,'µç»°ºÅÂë 16',2,1);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(9,1,342221119,80971,1,4,2,'µØÖ·288',35,'µç»°ºÅÂë 9',4,2);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(10,1,342221120,80971,1,7,2,'µØÖ·600',12,'µç»°ºÅÂë 27',1,16);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(11,1,342221121,80971,1,4,2,'µØÖ·362',26,'µç»°ºÅÂë 32',1,21);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(12,1,342221122,80971,1,5,1,'µØÖ·279',18,'µç»°ºÅÂë 50',5,1);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(13,1,342221123,80971,1,3,1,'µØÖ·632',15,'µç»°ºÅÂë 42',1,5);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(14,1,342221124,80971,1,3,2,'µØÖ·382',15,'µç»°ºÅÂë 15',2,14);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(15,1,342221125,80971,1,6,2,'µØÖ·586',41,'µç»°ºÅÂë 23',3,19);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(16,1,342221126,80971,1,5,2,'µØÖ·186',10,'µç»°ºÅÂë 35',5,1);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(17,1,342221127,80971,1,2,2,'µØÖ·557',9,'µç»°ºÅÂë 10',1,21);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(18,1,342221128,80971,1,3,1,'µØÖ·196',28,'µç»°ºÅÂë 23',4,22);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(19,1,342221129,80971,1,1,1,'µØÖ·902',35,'µç»°ºÅÂë 6',5,24);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(20,1,342221130,80971,1,8,2,'µØÖ·121',27,'µç»°ºÅÂë 42',4,13);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(21,1,342221131,80971,1,1,2,'µØÖ·896',4,'µç»°ºÅÂë 1',3,7);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(22,1,342221132,80971,1,3,2,'µØÖ·843',11,'µç»°ºÅÂë 46',5,14);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(23,1,342221133,80971,1,5,2,'µØÖ·69',24,'µç»°ºÅÂë 30',5,23);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(24,1,342221134,80971,1,7,1,'µØÖ·417',4,'µç»°ºÅÂë 33',5,4);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(25,1,342221135,80971,1,7,2,'µØÖ·999',11,'µç»°ºÅÂë 42',3,12);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(26,1,342221136,80971,1,1,1,'µØÖ·171',48,'µç»°ºÅÂë 19',2,13);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(27,1,342221137,80971,1,6,2,'µØÖ·350',33,'µç»°ºÅÂë 45',3,1);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(28,1,342221138,80971,1,8,1,'µØÖ·25',25,'µç»°ºÅÂë 40',3,15);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(29,1,342221139,80971,1,2,2,'µØÖ·187',12,'µç»°ºÅÂë 39',1,14);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(30,1,342221140,80971,1,2,2,'µØÖ·574',25,'µç»°ºÅÂë 50',5,6);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(31,1,342221141,80971,1,5,1,'µØÖ·275',14,'µç»°ºÅÂë 50',3,1);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(32,1,342221142,80971,1,6,1,'µØÖ·280',13,'µç»°ºÅÂë 27',2,25);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(33,1,342221143,80971,1,3,2,'µØÖ·984',44,'µç»°ºÅÂë 22',4,13);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(34,1,342221144,80971,1,4,1,'µØÖ·111',47,'µç»°ºÅÂë 40',1,3);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(35,1,342221145,80971,1,6,2,'µØÖ·966',44,'µç»°ºÅÂë 41',4,7);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(36,1,342221146,80971,1,2,1,'µØÖ·892',5,'µç»°ºÅÂë 8',5,10);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(37,1,342221147,80971,1,4,1,'µØÖ·411',33,'µç»°ºÅÂë 18',4,5);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(38,1,342221148,80971,1,3,1,'µØÖ·494',39,'µç»°ºÅÂë 30',5,12);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(39,1,342221149,80971,1,2,2,'µØÖ·733',37,'µç»°ºÅÂë 2',5,6);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(40,1,342221150,80971,1,7,1,'µØÖ·620',36,'µç»°ºÅÂë 38',4,25);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(41,1,342221151,80971,1,4,2,'µØÖ·24',50,'µç»°ºÅÂë 43',4,12);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(42,1,342221152,80971,1,5,2,'µØÖ·638',11,'µç»°ºÅÂë 27',4,19);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(43,1,342221153,80971,1,2,1,'µØÖ·4',10,'µç»°ºÅÂë 47',3,5);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(44,1,342221154,80971,1,4,1,'µØÖ·806',5,'µç»°ºÅÂë 5',2,8);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(45,1,342221155,80971,1,8,2,'µØÖ·17',20,'µç»°ºÅÂë 32',4,16);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(46,1,342221156,80971,1,5,2,'µØÖ·358',4,'µç»°ºÅÂë 25',5,24);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(47,1,342221157,80971,1,3,1,'µØÖ·529',7,'µç»°ºÅÂë 23',5,12);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(48,1,342221158,80971,1,7,2,'µØÖ·870',11,'µç»°ºÅÂë 3',5,15);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(49,1,342221159,80971,1,7,1,'µØÖ·714',50,'µç»°ºÅÂë 31',2,14);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(50,1,342221160,80971,1,7,1,'µØÖ·72',4,'µç»°ºÅÂë 7',2,15);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(51,1,342221161,80971,1,1,1,'µØÖ·861',29,'µç»°ºÅÂë 4',5,16);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(52,1,342221162,80971,1,2,1,'µØÖ·422',12,'µç»°ºÅÂë 42',3,14);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(53,1,342221163,80971,1,6,2,'µØÖ·955',33,'µç»°ºÅÂë 3',3,17);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(54,1,342221164,80971,1,8,1,'µØÖ·491',41,'µç»°ºÅÂë 48',5,8);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(55,1,342221165,80971,1,2,2,'µØÖ·299',42,'µç»°ºÅÂë 23',1,11);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(56,1,342221166,80971,1,8,2,'µØÖ·805',21,'µç»°ºÅÂë 28',4,24);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(57,1,342221167,80971,1,3,1,'µØÖ·614',22,'µç»°ºÅÂë 19',5,2);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(58,1,342221168,80971,1,6,2,'µØÖ·746',4,'µç»°ºÅÂë 16',4,7);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(59,1,342221169,80971,1,1,2,'µØÖ·345',25,'µç»°ºÅÂë 6',5,24);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(60,1,342221170,80971,1,3,1,'µØÖ·652',28,'µç»°ºÅÂë 40',2,21);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(61,1,342221171,80971,1,6,2,'µØÖ·372',2,'µç»°ºÅÂë 16',2,6);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(62,1,342221172,80971,1,2,2,'µØÖ·463',16,'µç»°ºÅÂë 1',4,8);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(63,1,342221173,80971,1,6,1,'µØÖ·765',24,'µç»°ºÅÂë 47',5,12);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(64,1,342221174,80971,1,3,1,'µØÖ·767',44,'µç»°ºÅÂë 6',5,2);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(65,1,342221175,80971,1,3,2,'µØÖ·22',22,'µç»°ºÅÂë 46',5,2);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(66,1,342221176,80971,1,3,1,'µØÖ·504',50,'µç»°ºÅÂë 21',4,18);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(67,1,342221177,80971,1,7,2,'µØÖ·872',44,'µç»°ºÅÂë 36',4,5);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(68,1,342221178,80971,1,8,2,'µØÖ·158',36,'µç»°ºÅÂë 10',4,11);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(69,1,342221179,80971,1,6,1,'µØÖ·367',7,'µç»°ºÅÂë 31',1,23);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(70,1,342221180,80971,1,3,1,'µØÖ·712',14,'µç»°ºÅÂë 42',4,11);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(71,1,342221181,80971,1,2,2,'µØÖ·663',18,'µç»°ºÅÂë 5',5,22);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(72,1,342221182,80971,1,2,1,'µØÖ·840',25,'µç»°ºÅÂë 15',1,4);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(73,1,342221183,80971,1,8,2,'µØÖ·840',7,'µç»°ºÅÂë 8',3,12);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(74,1,342221184,80971,1,4,1,'µØÖ·775',40,'µç»°ºÅÂë 15',4,23);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(75,1,342221185,80971,1,5,2,'µØÖ·370',8,'µç»°ºÅÂë 20',5,13);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(76,1,342221186,80971,1,1,2,'µØÖ·189',28,'µç»°ºÅÂë 37',2,14);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(77,1,342221187,80971,1,7,2,'µØÖ·430',11,'µç»°ºÅÂë 2',1,18);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(78,1,342221188,80971,1,8,2,'µØÖ·851',47,'µç»°ºÅÂë 38',5,6);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(79,1,342221189,80971,1,8,1,'µØÖ·332',25,'µç»°ºÅÂë 5',5,21);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(80,1,342221190,80971,1,6,2,'µØÖ·418',13,'µç»°ºÅÂë 32',3,9);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(81,1,342221191,80971,1,6,1,'µØÖ·406',50,'µç»°ºÅÂë 8',4,15);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(82,1,342221192,80971,1,6,2,'µØÖ·559',31,'µç»°ºÅÂë 45',1,24);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(83,1,342221193,80971,1,4,2,'µØÖ·268',3,'µç»°ºÅÂë 49',4,18);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(84,1,342221194,80971,1,2,1,'µØÖ·922',10,'µç»°ºÅÂë 28',4,13);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(85,1,342221195,80971,1,4,1,'µØÖ·563',11,'µç»°ºÅÂë 26',3,6);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(86,1,342221196,80971,1,7,2,'µØÖ·267',4,'µç»°ºÅÂë 36',5,21);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(87,1,342221197,80971,1,2,2,'µØÖ·279',30,'µç»°ºÅÂë 36',1,12);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(88,1,342221198,80971,1,4,2,'µØÖ·880',13,'µç»°ºÅÂë 8',4,8);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(89,1,342221199,80971,1,2,1,'µØÖ·90',47,'µç»°ºÅÂë 6',5,7);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(90,1,342221200,80971,1,8,2,'µØÖ·844',10,'µç»°ºÅÂë 1',3,9);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(91,1,342221201,80971,1,7,1,'µØÖ·202',50,'µç»°ºÅÂë 15',1,25);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(92,1,342221202,80971,1,4,2,'µØÖ·939',10,'µç»°ºÅÂë 48',2,10);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(93,1,342221203,80971,1,4,1,'µØÖ·450',44,'µç»°ºÅÂë 49',1,19);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(94,1,342221204,80971,1,3,1,'µØÖ·81',48,'µç»°ºÅÂë 45',3,3);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(95,1,342221205,80971,1,7,2,'µØÖ·318',32,'µç»°ºÅÂë 15',5,8);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(96,1,342221206,80971,1,2,1,'µØÖ·609',37,'µç»°ºÅÂë 9',1,7);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(97,1,342221207,80971,1,1,1,'µØÖ·963',41,'µç»°ºÅÂë 44',1,22);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(98,1,342221208,80971,1,5,1,'µØÖ·689',23,'µç»°ºÅÂë 14',1,11);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(99,1,342221209,80971,1,3,1,'µØÖ·183',32,'µç»°ºÅÂë 29',4,18);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(100,1,342221210,80971,1,3,2,'µØÖ·533',31,'µç»°ºÅÂë 4',1,17);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(101,1,342221211,80971,1,3,2,'µØÖ·65',9,'µç»°ºÅÂë 38',4,4);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(102,1,342221212,80971,1,7,2,'µØÖ·753',25,'µç»°ºÅÂë 8',4,13);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(103,1,342221213,80971,1,7,1,'µØÖ·770',48,'µç»°ºÅÂë 35',5,11);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(104,1,342221214,80971,1,5,2,'µØÖ·129',20,'µç»°ºÅÂë 32',4,7);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(105,1,342221215,80971,1,3,1,'µØÖ·285',50,'µç»°ºÅÂë 45',5,1);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(106,1,342221216,80971,1,1,2,'µØÖ·259',10,'µç»°ºÅÂë 32',4,14);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(107,1,342221217,80971,1,6,2,'µØÖ·481',18,'µç»°ºÅÂë 11',1,16);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(108,1,342221218,80971,1,1,1,'µØÖ·555',20,'µç»°ºÅÂë 40',2,13);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(109,1,342221219,80971,1,1,2,'µØÖ·351',17,'µç»°ºÅÂë 28',4,17);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(110,1,342221220,80971,1,5,2,'µØÖ·736',8,'µç»°ºÅÂë 14',4,2);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(111,1,342221221,80971,1,7,1,'µØÖ·198',31,'µç»°ºÅÂë 46',1,1);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(112,1,342221222,80971,1,4,2,'µØÖ·685',44,'µç»°ºÅÂë 23',3,22);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(113,1,342221223,80971,1,6,2,'µØÖ·762',12,'µç»°ºÅÂë 33',5,3);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(114,1,342221224,80971,1,2,2,'µØÖ·970',42,'µç»°ºÅÂë 11',4,25);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(115,1,342221225,80971,1,6,2,'µØÖ·258',15,'µç»°ºÅÂë 28',4,20);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(116,1,342221226,80971,1,3,1,'µØÖ·294',32,'µç»°ºÅÂë 13',1,1);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(117,1,342221227,80971,1,7,2,'µØÖ·749',30,'µç»°ºÅÂë 12',5,11);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(118,1,342221228,80971,1,2,2,'µØÖ·789',5,'µç»°ºÅÂë 16',1,22);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(119,1,342221229,80971,1,5,1,'µØÖ·416',13,'µç»°ºÅÂë 48',5,25);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(120,1,342221230,80971,1,6,1,'µØÖ·1',39,'µç»°ºÅÂë 7',5,24);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(121,1,342221231,80971,1,4,1,'µØÖ·89',33,'µç»°ºÅÂë 14',2,10);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(122,1,342221232,80971,1,2,1,'µØÖ·42',20,'µç»°ºÅÂë 4',2,3);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(123,1,342221233,80971,1,2,1,'µØÖ·703',10,'µç»°ºÅÂë 33',5,25);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(124,1,342221234,80971,1,2,1,'µØÖ·919',46,'µç»°ºÅÂë 17',3,9);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(125,1,342221235,80971,1,6,1,'µØÖ·671',1,'µç»°ºÅÂë 12',2,6);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(126,1,342221236,80971,1,8,1,'µØÖ·271',7,'µç»°ºÅÂë 35',2,16);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(127,1,342221237,80971,1,8,1,'µØÖ·155',33,'µç»°ºÅÂë 24',4,5);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(128,1,342221238,80971,1,8,2,'µØÖ·224',18,'µç»°ºÅÂë 39',1,5);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(129,1,342221239,80971,1,6,2,'µØÖ·206',2,'µç»°ºÅÂë 3',2,24);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(130,1,342221240,80971,1,6,1,'µØÖ·202',13,'µç»°ºÅÂë 10',3,9);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(131,1,342221241,80971,1,6,2,'µØÖ·103',31,'µç»°ºÅÂë 30',4,15);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(132,1,342221242,80971,1,2,1,'µØÖ·436',13,'µç»°ºÅÂë 24',3,10);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(133,1,342221243,80971,1,2,2,'µØÖ·483',4,'µç»°ºÅÂë 43',2,23);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(134,1,342221244,80971,1,8,2,'µØÖ·548',13,'µç»°ºÅÂë 44',2,10);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(135,1,342221245,80971,1,6,1,'µØÖ·869',34,'µç»°ºÅÂë 4',3,14);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(136,1,342221246,80971,1,7,2,'µØÖ·186',40,'µç»°ºÅÂë 6',5,3);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(137,1,342221247,80971,1,4,2,'µØÖ·691',13,'µç»°ºÅÂë 35',4,25);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(138,1,342221248,80971,1,1,1,'µØÖ·340',8,'µç»°ºÅÂë 16',1,12);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(139,1,342221249,80971,1,7,2,'µØÖ·531',7,'µç»°ºÅÂë 5',1,25);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(140,1,342221250,80971,1,4,1,'µØÖ·267',32,'µç»°ºÅÂë 39',4,11);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(141,1,342221251,80971,1,5,2,'µØÖ·923',44,'µç»°ºÅÂë 50',1,8);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(142,1,342221252,80971,1,2,1,'µØÖ·716',22,'µç»°ºÅÂë 40',5,7);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(143,1,342221253,80971,1,2,1,'µØÖ·829',19,'µç»°ºÅÂë 49',1,2);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(144,1,342221254,80971,1,7,2,'µØÖ·338',45,'µç»°ºÅÂë 3',5,13);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(145,1,342221255,80971,1,6,2,'µØÖ·726',18,'µç»°ºÅÂë 39',2,24);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(146,1,342221256,80971,1,8,2,'µØÖ·634',48,'µç»°ºÅÂë 18',2,2);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(147,1,342221257,80971,1,4,2,'µØÖ·934',36,'µç»°ºÅÂë 8',4,7);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(148,1,342221258,80971,1,2,1,'µØÖ·806',11,'µç»°ºÅÂë 18',5,14);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(149,1,342221259,80971,1,4,2,'µØÖ·846',20,'µç»°ºÅÂë 28',2,16);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(150,1,342221260,80971,1,7,1,'µØÖ·486',16,'µç»°ºÅÂë 23',4,22);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(151,1,342221261,80971,1,7,2,'µØÖ·291',8,'µç»°ºÅÂë 39',2,22);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(152,1,342221262,80971,1,8,1,'µØÖ·273',21,'µç»°ºÅÂë 45',5,5);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(153,1,342221263,80971,1,2,1,'µØÖ·320',25,'µç»°ºÅÂë 34',1,24);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(154,1,342221264,80971,1,4,2,'µØÖ·641',16,'µç»°ºÅÂë 25',2,23);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(155,1,342221265,80971,1,3,1,'µØÖ·161',47,'µç»°ºÅÂë 46',2,18);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(156,1,342221266,80971,1,4,2,'µØÖ·363',11,'µç»°ºÅÂë 49',5,15);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(157,1,342221267,80971,1,8,1,'µØÖ·541',8,'µç»°ºÅÂë 50',1,18);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(158,1,342221268,80971,1,6,1,'µØÖ·988',19,'µç»°ºÅÂë 50',4,1);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(159,1,342221269,80971,1,6,2,'µØÖ·95',11,'µç»°ºÅÂë 32',1,10);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(160,1,342221270,80971,1,1,1,'µØÖ·519',10,'µç»°ºÅÂë 7',3,17);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(161,1,342221271,80971,1,5,2,'µØÖ·30',1,'µç»°ºÅÂë 48',1,24);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(162,1,342221272,80971,1,5,2,'µØÖ·720',8,'µç»°ºÅÂë 1',5,6);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(163,1,342221273,80971,1,3,2,'µØÖ·278',33,'µç»°ºÅÂë 32',1,14);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(164,1,342221274,80971,1,7,1,'µØÖ·592',38,'µç»°ºÅÂë 43',5,1);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(165,1,342221275,80971,1,1,1,'µØÖ·889',1,'µç»°ºÅÂë 39',3,22);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(166,1,342221276,80971,1,4,1,'µØÖ·950',7,'µç»°ºÅÂë 15',3,9);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(167,1,342221277,80971,1,4,2,'µØÖ·380',13,'µç»°ºÅÂë 10',4,1);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(168,1,342221278,80971,1,4,2,'µØÖ·80',35,'µç»°ºÅÂë 21',4,10);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(169,1,342221279,80971,1,7,2,'µØÖ·889',41,'µç»°ºÅÂë 31',3,2);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(170,1,342221280,80971,1,2,1,'µØÖ·704',48,'µç»°ºÅÂë 17',3,9);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(171,1,342221281,80971,1,8,1,'µØÖ·767',22,'µç»°ºÅÂë 31',4,9);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(172,1,342221282,80971,1,3,1,'µØÖ·693',32,'µç»°ºÅÂë 30',2,19);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(173,1,342221283,80971,1,4,2,'µØÖ·634',50,'µç»°ºÅÂë 22',5,21);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(174,1,342221284,80971,1,7,1,'µØÖ·457',38,'µç»°ºÅÂë 26',1,24);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(175,1,342221285,80971,1,4,2,'µØÖ·262',32,'µç»°ºÅÂë 21',4,25);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(176,1,342221286,80971,1,6,1,'µØÖ·856',47,'µç»°ºÅÂë 4',3,15);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(177,1,342221287,80971,1,5,2,'µØÖ·22',14,'µç»°ºÅÂë 17',1,14);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(178,1,342221288,80971,1,5,2,'µØÖ·190',37,'µç»°ºÅÂë 12',4,2);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(179,1,342221289,80971,1,2,2,'µØÖ·257',44,'µç»°ºÅÂë 27',3,9);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(180,1,342221290,80971,1,1,1,'µØÖ·833',4,'µç»°ºÅÂë 36',5,25);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(181,1,342221291,80971,1,2,2,'µØÖ·286',47,'µç»°ºÅÂë 34',3,10);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(182,1,342221292,80971,1,1,2,'µØÖ·291',34,'µç»°ºÅÂë 4',3,17);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(183,1,342221293,80971,1,6,1,'µØÖ·188',49,'µç»°ºÅÂë 50',5,21);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(184,1,342221294,80971,1,4,1,'µØÖ·301',27,'µç»°ºÅÂë 34',3,15);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(185,1,342221295,80971,1,2,1,'µØÖ·980',28,'µç»°ºÅÂë 50',5,14);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(186,1,342221296,80971,1,2,1,'µØÖ·354',19,'µç»°ºÅÂë 46',3,11);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(187,1,342221297,80971,1,8,2,'µØÖ·160',4,'µç»°ºÅÂë 21',3,10);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(188,1,342221298,80971,1,3,2,'µØÖ·667',20,'µç»°ºÅÂë 28',5,18);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(189,1,342221299,80971,1,5,2,'µØÖ·332',29,'µç»°ºÅÂë 49',1,17);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(190,1,342221300,80971,1,2,2,'µØÖ·677',19,'µç»°ºÅÂë 12',5,22);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(191,1,342221301,80971,1,3,1,'µØÖ·481',24,'µç»°ºÅÂë 7',2,6);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(192,1,342221302,80971,1,6,1,'µØÖ·475',49,'µç»°ºÅÂë 3',4,25);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(193,1,342221303,80971,1,2,2,'µØÖ·42',45,'µç»°ºÅÂë 18',3,4);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(194,1,342221304,80971,1,4,2,'µØÖ·384',27,'µç»°ºÅÂë 41',2,21);
INSERT INTO `pw_4t_order`(`id`, `userid`, `ordernumber`,`schoolid`, `status`, `paymethod`, `delivermethod`, `to`, `deliverby`, `delivercontact`, `savingtotal`, `ordermoney`) VALUES(195,1,342221305,80971,1,4,1,'µØÖ·810',17,'µç»°ºÅÂë 47',2,7);

DROP TABLE IF EXISTS `pw_4t_order_item`;
CREATE TABLE IF NOT EXISTS `pw_4t_order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL,
  `merchandiseid` int(11) NOT NULL,
  `schoolareaid` int(11) NOT NULL,
  `quatity` int(11) NOT NULL,
  `priceoriginal` decimal(10,0) NOT NULL,
  `priceofferdescription` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `saving` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orderid` (`orderid`),
  KEY `merchandiseid` (`merchandiseid`),
  KEY `schoolareaid` (`schoolareaid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

TRUNCATE TABLE pw_4t_order_item;#SQL for table data(pw_4t_order_item)
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(1,54,43,14,5,7,'ÕÛ¿Û6',5,-2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(2,60,388,14,1,12,'ÕÛ¿Û6',11,-1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(3,37,459,14,1,19,'ÕÛ¿Û8',9,-10);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(4,54,218,14,5,4,'ÕÛ¿Û9',11,7);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(5,2,340,14,1,4,'ÕÛ¿Û8',9,5);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(6,27,405,14,5,20,'ÕÛ¿Û7',3,-17);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(7,36,51,14,1,17,'ÕÛ¿Û6',6,-11);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(8,49,300,14,4,11,'ÕÛ¿Û7',9,-2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(9,18,151,14,2,16,'ÕÛ¿Û6',13,-3);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(10,46,237,14,2,8,'ÕÛ¿Û7',9,1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(11,43,242,14,3,5,'ÕÛ¿Û6',3,-2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(12,22,58,14,3,3,'ÕÛ¿Û9',11,8);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(13,36,259,14,2,15,'ÕÛ¿Û9',11,-4);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(14,15,248,14,5,17,'ÕÛ¿Û8',7,-10);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(15,16,214,14,5,5,'ÕÛ¿Û8',7,2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(16,56,287,14,4,15,'ÕÛ¿Û8',6,-9);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(17,40,181,14,1,12,'ÕÛ¿Û6',8,-4);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(18,27,147,14,1,13,'ÕÛ¿Û9',13,0);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(19,49,367,14,2,3,'ÕÛ¿Û7',12,9);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(20,11,314,14,2,19,'ÕÛ¿Û7',6,-13);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(21,49,5,14,4,16,'ÕÛ¿Û9',3,-13);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(22,23,141,14,3,5,'ÕÛ¿Û7',13,8);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(23,7,450,14,1,18,'ÕÛ¿Û7',11,-7);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(24,14,341,14,3,14,'ÕÛ¿Û9',6,-8);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(25,9,22,14,3,11,'ÕÛ¿Û7',8,-3);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(26,39,278,14,3,6,'ÕÛ¿Û7',7,1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(27,1,92,14,5,7,'ÕÛ¿Û6',7,0);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(28,25,376,14,1,20,'ÕÛ¿Û9',3,-17);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(29,38,53,14,2,8,'ÕÛ¿Û6',10,2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(30,18,37,14,2,13,'ÕÛ¿Û9',10,-3);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(31,41,145,14,5,14,'ÕÛ¿Û8',13,-1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(32,11,232,14,1,3,'ÕÛ¿Û8',6,3);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(33,18,33,14,2,5,'ÕÛ¿Û9',9,4);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(34,22,472,14,1,9,'ÕÛ¿Û8',9,0);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(35,17,412,14,4,6,'ÕÛ¿Û9',10,4);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(36,25,222,14,1,8,'ÕÛ¿Û6',13,5);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(37,25,179,14,5,5,'ÕÛ¿Û8',13,8);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(38,30,233,14,5,11,'ÕÛ¿Û7',4,-7);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(39,55,289,14,1,9,'ÕÛ¿Û6',12,3);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(40,15,367,14,3,14,'ÕÛ¿Û8',6,-8);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(41,20,243,14,4,4,'ÕÛ¿Û7',7,3);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(42,3,297,14,2,8,'ÕÛ¿Û6',8,0);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(43,50,158,14,4,19,'ÕÛ¿Û7',8,-11);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(44,5,203,14,3,16,'ÕÛ¿Û9',8,-8);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(45,33,178,14,1,6,'ÕÛ¿Û7',2,-4);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(46,11,26,14,2,17,'ÕÛ¿Û8',2,-15);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(47,57,353,14,5,11,'ÕÛ¿Û6',10,-1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(48,35,242,14,4,16,'ÕÛ¿Û9',11,-5);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(49,33,465,14,3,20,'ÕÛ¿Û6',13,-7);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(50,21,479,14,5,9,'ÕÛ¿Û6',7,-2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(51,11,484,14,2,10,'ÕÛ¿Û9',3,-7);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(52,5,302,14,1,4,'ÕÛ¿Û9',2,-2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(53,15,291,18,5,4,'ÕÛ¿Û8',10,6);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(54,24,158,18,2,5,'ÕÛ¿Û7',10,5);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(55,28,357,18,1,16,'ÕÛ¿Û6',2,-14);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(56,44,124,18,4,18,'ÕÛ¿Û8',6,-12);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(57,17,19,18,4,10,'ÕÛ¿Û6',8,-2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(58,51,208,18,5,6,'ÕÛ¿Û9',11,5);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(59,60,214,18,5,11,'ÕÛ¿Û7',5,-6);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(60,17,42,18,1,15,'ÕÛ¿Û9',4,-11);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(61,42,185,18,5,19,'ÕÛ¿Û6',3,-16);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(62,20,465,18,3,19,'ÕÛ¿Û7',9,-10);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(63,11,477,18,2,4,'ÕÛ¿Û8',9,5);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(64,57,143,18,4,10,'ÕÛ¿Û7',12,2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(65,49,238,18,5,4,'ÕÛ¿Û6',12,8);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(66,37,337,18,2,16,'ÕÛ¿Û7',2,-14);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(67,27,67,18,1,3,'ÕÛ¿Û8',8,5);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(68,14,19,18,5,18,'ÕÛ¿Û9',8,-10);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(69,27,311,18,5,3,'ÕÛ¿Û8',6,3);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(70,21,118,18,5,13,'ÕÛ¿Û6',8,-5);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(71,5,494,18,2,18,'ÕÛ¿Û8',6,-12);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(72,60,83,18,2,13,'ÕÛ¿Û6',2,-11);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(73,44,303,18,3,8,'ÕÛ¿Û6',7,-1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(74,29,258,18,5,12,'ÕÛ¿Û9',9,-3);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(75,9,105,18,5,11,'ÕÛ¿Û9',2,-9);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(76,55,305,18,4,9,'ÕÛ¿Û9',7,-2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(77,4,75,18,1,5,'ÕÛ¿Û6',9,4);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(78,12,369,18,1,18,'ÕÛ¿Û6',8,-10);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(79,27,404,18,2,10,'ÕÛ¿Û7',5,-5);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(80,19,3,18,4,9,'ÕÛ¿Û8',10,1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(81,55,358,18,4,13,'ÕÛ¿Û6',11,-2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(82,2,387,18,4,17,'ÕÛ¿Û8',2,-15);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(83,52,25,18,4,17,'ÕÛ¿Û9',7,-10);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(84,16,411,18,2,14,'ÕÛ¿Û9',12,-2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(85,39,353,18,4,4,'ÕÛ¿Û6',12,8);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(86,43,418,18,2,11,'ÕÛ¿Û9',11,0);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(87,31,8,18,3,20,'ÕÛ¿Û9',4,-16);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(88,19,344,18,3,12,'ÕÛ¿Û7',13,1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(89,50,151,18,1,9,'ÕÛ¿Û7',6,-3);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(90,6,485,18,1,5,'ÕÛ¿Û7',8,3);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(91,58,441,18,3,19,'ÕÛ¿Û9',12,-7);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(92,16,244,18,2,12,'ÕÛ¿Û8',3,-9);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(93,32,290,18,5,12,'ÕÛ¿Û6',5,-7);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(94,29,21,18,1,3,'ÕÛ¿Û6',10,7);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(95,45,224,18,3,9,'ÕÛ¿Û9',10,1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(96,51,444,18,4,11,'ÕÛ¿Û9',3,-8);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(97,20,276,18,5,5,'ÕÛ¿Û7',5,0);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(98,45,50,18,5,19,'ÕÛ¿Û7',7,-12);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(99,51,410,18,3,3,'ÕÛ¿Û7',11,8);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(100,39,206,18,5,5,'ÕÛ¿Û8',7,2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(101,14,54,18,3,12,'ÕÛ¿Û7',4,-8);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(102,33,8,18,5,14,'ÕÛ¿Û9',5,-9);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(103,14,140,18,4,7,'ÕÛ¿Û8',11,4);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(104,6,155,18,3,13,'ÕÛ¿Û8',3,-10);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(105,43,258,18,5,7,'ÕÛ¿Û8',2,-5);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(106,2,124,18,1,3,'ÕÛ¿Û7',12,9);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(107,12,165,18,4,9,'ÕÛ¿Û7',12,3);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(108,9,237,18,2,7,'ÕÛ¿Û9',7,0);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(109,43,67,18,5,16,'ÕÛ¿Û7',4,-12);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(110,39,15,18,2,9,'ÕÛ¿Û7',8,-1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(111,43,495,18,5,9,'ÕÛ¿Û8',7,-2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(112,28,27,18,2,17,'ÕÛ¿Û7',6,-11);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(113,16,456,18,1,4,'ÕÛ¿Û7',9,5);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(114,8,338,18,3,5,'ÕÛ¿Û6',13,8);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(115,49,138,18,4,19,'ÕÛ¿Û6',11,-8);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(116,15,336,18,1,18,'ÕÛ¿Û7',12,-6);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(117,28,365,18,3,16,'ÕÛ¿Û9',6,-10);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(118,28,295,18,2,4,'ÕÛ¿Û6',6,2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(119,34,233,18,4,19,'ÕÛ¿Û8',4,-15);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(120,49,198,18,2,4,'ÕÛ¿Û9',7,3);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(121,57,148,18,2,18,'ÕÛ¿Û6',4,-14);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(122,27,128,18,3,3,'ÕÛ¿Û7',10,7);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(123,35,132,18,5,3,'ÕÛ¿Û6',2,-1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(124,53,300,18,2,7,'ÕÛ¿Û7',9,2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(125,35,367,18,5,5,'ÕÛ¿Û9',8,3);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(126,50,250,18,4,15,'ÕÛ¿Û6',4,-11);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(127,32,199,18,4,11,'ÕÛ¿Û6',12,1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(128,22,130,18,3,18,'ÕÛ¿Û8',13,-5);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(129,51,476,18,3,11,'ÕÛ¿Û6',4,-7);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(130,40,396,18,1,3,'ÕÛ¿Û6',11,8);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(131,36,201,18,2,17,'ÕÛ¿Û6',12,-5);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(132,47,388,18,5,5,'ÕÛ¿Û8',7,2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(133,34,9,18,3,16,'ÕÛ¿Û9',3,-13);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(134,52,447,18,2,14,'ÕÛ¿Û9',13,-1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(135,40,181,18,1,7,'ÕÛ¿Û6',5,-2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(136,48,265,18,4,11,'ÕÛ¿Û6',12,1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(137,40,144,18,3,3,'ÕÛ¿Û9',9,6);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(138,44,118,18,2,7,'ÕÛ¿Û8',13,6);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(139,52,36,18,4,9,'ÕÛ¿Û8',2,-7);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(140,55,331,18,5,8,'ÕÛ¿Û8',4,-4);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(141,16,307,18,5,6,'ÕÛ¿Û8',3,-3);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(142,46,303,18,3,20,'ÕÛ¿Û6',9,-11);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(143,21,40,18,4,11,'ÕÛ¿Û7',8,-3);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(144,44,328,18,3,13,'ÕÛ¿Û8',12,-1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(145,2,21,18,5,11,'ÕÛ¿Û9',4,-7);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(146,30,163,18,3,10,'ÕÛ¿Û6',9,-1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(147,30,189,18,5,16,'ÕÛ¿Û9',11,-5);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(148,39,313,18,4,18,'ÕÛ¿Û7',7,-11);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(149,43,275,18,3,16,'ÕÛ¿Û8',7,-9);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(150,22,247,18,4,9,'ÕÛ¿Û7',7,-2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(151,14,389,18,5,5,'ÕÛ¿Û7',7,2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(152,60,250,18,2,20,'ÕÛ¿Û8',7,-13);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(153,21,58,18,2,19,'ÕÛ¿Û9',2,-17);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(154,20,465,18,4,17,'ÕÛ¿Û8',4,-13);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(155,38,161,18,5,17,'ÕÛ¿Û8',4,-13);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(156,12,230,18,2,9,'ÕÛ¿Û7',7,-2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(157,1,309,18,1,16,'ÕÛ¿Û9',10,-6);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(158,8,154,18,3,15,'ÕÛ¿Û9',4,-11);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(159,48,286,18,3,10,'ÕÛ¿Û8',4,-6);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(160,38,89,18,2,17,'ÕÛ¿Û9',10,-7);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(161,46,325,18,1,20,'ÕÛ¿Û9',9,-11);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(162,40,76,18,3,10,'ÕÛ¿Û6',8,-2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(163,44,366,18,5,9,'ÕÛ¿Û6',13,4);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(164,53,215,18,5,5,'ÕÛ¿Û6',4,-1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(165,10,392,18,2,6,'ÕÛ¿Û8',11,5);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(166,56,1,18,2,18,'ÕÛ¿Û6',3,-15);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(167,1,141,18,2,4,'ÕÛ¿Û8',11,7);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(168,56,113,18,2,10,'ÕÛ¿Û8',6,-4);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(169,32,17,18,5,20,'ÕÛ¿Û9',11,-9);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(170,43,409,18,2,8,'ÕÛ¿Û7',9,1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(171,46,186,18,4,18,'ÕÛ¿Û8',5,-13);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(172,1,316,18,3,4,'ÕÛ¿Û8',7,3);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(173,18,146,18,5,8,'ÕÛ¿Û6',2,-6);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(174,48,5,18,4,9,'ÕÛ¿Û7',9,0);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(175,6,63,18,5,8,'ÕÛ¿Û8',12,4);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(176,39,200,18,5,12,'ÕÛ¿Û6',7,-5);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(177,40,159,18,5,10,'ÕÛ¿Û8',8,-2);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(178,26,266,18,1,12,'ÕÛ¿Û6',4,-8);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(179,13,144,18,3,6,'ÕÛ¿Û6',7,1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(180,59,351,18,5,17,'ÕÛ¿Û9',10,-7);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(181,49,442,18,2,9,'ÕÛ¿Û8',4,-5);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(182,17,232,18,4,20,'ÕÛ¿Û8',6,-14);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(183,33,206,18,4,16,'ÕÛ¿Û8',12,-4);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(184,18,228,18,5,13,'ÕÛ¿Û9',2,-11);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(185,28,466,18,2,11,'ÕÛ¿Û7',12,1);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(186,59,291,18,2,3,'ÕÛ¿Û9',3,0);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(187,35,391,18,2,20,'ÕÛ¿Û9',9,-11);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(188,55,99,18,4,3,'ÕÛ¿Û6',7,4);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(189,29,436,18,1,9,'ÕÛ¿Û9',3,-6);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(190,56,223,18,2,16,'ÕÛ¿Û9',13,-3);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(191,10,92,18,4,14,'ÕÛ¿Û6',5,-9);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(192,39,157,18,2,18,'ÕÛ¿Û7',5,-13);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(193,4,1,18,5,16,'ÕÛ¿Û9',11,-5);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(194,42,468,18,4,10,'ÕÛ¿Û9',7,-3);
INSERT INTO `pw_4t_order_item`(`id`, `orderid`, `merchandiseid`,`schoolareaid`, `quatity`, `priceoriginal`, `priceofferdescription`, `price`, `saving`) VALUES(195,22,266,18,1,5,'ÕÛ¿Û8',11,6);


DROP TABLE IF EXISTS `pw_4t_school_opened`;
CREATE TABLE  `pw_4t_school_opened` (
  `schoolid` INT NOT NULL ,
  `opened` INT( 1 ) NOT NULL ,
  PRIMARY KEY (  `schoolid` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_bin;
INSERT INTO  `pw_4t_school_opened` (
  `schoolid` ,
  `opened`
)
  VALUES (
    '11016', '1'
  ), (
    '11017', '1'
  );

DROP TABLE IF EXISTS `pw_4t_school_area`;
CREATE TABLE IF NOT EXISTS `pw_4t_school_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schoolid` int(11) NOT NULL,
  `areaname` varchar(200) NOT NULL,
  `createdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `schoolid` (`schoolid`),
  KEY `areaname` (`areaname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

DROP TABLE IF EXISTS `pw_4t_school_people`;
CREATE TABLE IF NOT EXISTS `pw_4t_school_people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schoolid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `type` char(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `schoolid` (`schoolid`,`userid`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `pw_4t_my_favorite`;
CREATE TABLE  `pw_4t_my_favorite` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `userid` INT NOT NULL ,
  `shopid` INT NOT NULL ,
  `merchandiseid` INT NOT NULL ,
  `createdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  INDEX (  `userid` ,  `shopid` ,  `merchandiseid` )
) ENGINE = INNODB;

DROP TABLE IF EXISTS `pw_4t_order_action_log`;
CREATE TABLE IF NOT EXISTS `pw_4t_order_action_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL,
  `by` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `action` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `actiondate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `orderid` (`orderid`,`by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE  `pw_4t_order` ADD  `shopid` INT NOT NULL AFTER  `schoolid` ,
ADD INDEX (  `shopid` );

UPDATE  `pw_4t_order` SET shopid =1;

update `pw_4t_order_item` set merchandiseid = orderid%3 + 1;

ALTER TABLE  `pw_4t_school_opened` ADD  `complaintsline` VARCHAR( 50 ) NULL COMMENT  '投诉热线';

UPDATE  `pw_4t_school_opened` SET  `opened` = b '1',
`complaintsline` =  '0791-88888888' WHERE  `pw_4t_school_opened`.`schoolid` =80971;

ALTER TABLE  `pw_4t_order_item` ADD  `integral` INT NOT NULL COMMENT  '积分' AFTER  `saving`;

ALTER TABLE  `pw_4t_shop` CHANGE  `area`  `areaid` INT( 10 ) NOT NULL DEFAULT  '0' COMMENT  '区域';

DROP TABLE IF EXISTS `pw_4t_order_address`;
CREATE TABLE  `pw_4t_order_address` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `userid` INT NOT NULL ,
  `rname` VARCHAR( 50 ) NOT NULL ,
  `raddress` VARCHAR( 200 ) NOT NULL ,
  `rphone` VARCHAR( 20 ) NOT NULL ,
  `createdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  INDEX (  `userid` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_bin;

INSERT INTO `pw_4t_order_address` (`id`, `userid`, `rname`, `raddress`, `rphone`, `createdate`) VALUES
(1, 1, '杨炀', '#14栋603室', '15270011972', '2013-04-08 16:57:44'),
(2, 1, '赵老师', '紫金园里面的某一栋', '13334567890', '2013-04-08 16:58:21');

DROP TABLE IF EXISTS `pw_4t_my_money`;
CREATE TABLE  `pw4t`.`pw_4t_my_money` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `userid` INT NOT NULL ,
  `money` INT NOT NULL ,
  `credit` INT NOT NULL ,
  INDEX (  `userid` )
) ENGINE = INNODB;
ALTER TABLE  `pw_4t_my_money` CHANGE  `money`  `money` FLOAT( 11 ) NOT NULL;

DROP TABLE IF EXISTS `pw_4t_my_money_history`;
CREATE TABLE  `pw4t`.`pw_4t_my_money_history` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `userid` INT NOT NULL ,
  `moneyoriginal` FLOAT NOT NULL ,
  `moneyincome` FLOAT NOT NULL ,
  `moneyleft` FLOAT NOT NULL ,
  `description` VARCHAR( 500 ) NULL ,
  `createdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (  `id`),
  INDEX (  `userid` )
) ENGINE = INNODB;

DROP TABLE IF EXISTS `pw_4t_my_credit_history`;
CREATE TABLE  `pw4t`.`pw_4t_my_credit_history` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `userid` INT NOT NULL ,
  `creditoriginal` FLOAT NOT NULL ,
  `creditincome` FLOAT NOT NULL ,
  `creditleft` FLOAT NOT NULL ,
  `description` VARCHAR( 500 ) NULL ,
  `createdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (  `id`),
  INDEX (  `userid` )
) ENGINE = INNODB;

ALTER TABLE  `pw_4t_order` CHANGE  `ordernumber`  `ordernumber` VARCHAR( 17 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL;
ALTER TABLE  `pw_4t_order` ADD  `towho` VARCHAR( 50 ) NOT NULL AFTER  `to` ,
ADD  `tomobile` VARCHAR( 20 ) NOT NULL AFTER  `towho` ,
ADD  `preorder` BOOL NOT NULL AFTER  `tomobile` ,
ADD  `preorderat` TIME NOT NULL AFTER  `preorder`;

DROP TABLE IF EXISTS pw_4t_shop_promo;
CREATE TABLE `pw_4t_shop_promo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '动态ID',
  `shopid` int(10) unsigned NOT NULL COMMENT '外键shopid',
  `templateid` int(10) unsigned NOT NULL COMMENT '外键templateid',
  `isactive` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型:1-活动的,0-非活动的',
  `createdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `lastupdatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT '商家活动';

DROP TABLE IF EXISTS pw_4t_merchandise_promo;
CREATE TABLE `pw_4t_merchandise_promo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '动态ID',
  `merchandiseid` int(10) unsigned NOT NULL COMMENT '外键merchandiseid',
  `shoppromoid` varchar(36) NOT NULL COMMENT '外键shoppromoid',
  `element` varchar(20) NOT NULL DEFAULT '' COMMENT '活动元素',
  `value` varchar(50) NOT Null DEFAULT '' COMMENT '活动元素值',
  `createdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `lastupdatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT '商品活动';

DROP TABLE IF EXISTS pw_4t_promo_template;
CREATE TABLE `pw_4t_promo_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '动态ID',
  `templateid` int(10) unsigned NOT NULL COMMENT '外键templateid',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '活动名',
  `element` varchar(20) NOT NULL DEFAULT '' COMMENT '活动元素',
  `createdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `lastupdatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT '活动模板';

ALTER TABLE  `pw_4t_shop_promo` ADD `description` varchar(2000) NOT NULL DEFAULT '' COMMENT '活动描述' AFTER `isactive`;
ALTER TABLE  `pw_4t_merchandise` ADD  `currentprice` decimal(10,0) DEFAULT 0 COMMENT  '当前价格' AFTER  `price`;


ALTER TABLE  `pw_4t_school_people` ADD  `areaid` INT NOT NULL ,
ADD INDEX (  `areaid` );

delete from pw_hook_inject
where class="EXT:4tschool.service.security.App_Security" and method="afterMobileVerified";

INSERT INTO  `pw_hook_inject` (
  `id` ,
  `app_id` ,
  `app_name` ,
  `hook_name` ,
  `alias` ,
  `class` ,
  `method` ,
  `loadway` ,
  `expression` ,
  `created_time` ,
  `modified_time` ,
  `description`
)
  VALUES (
    NULL ,  '4tschool',  '4tschool',  's_PwMobileService_checkVerify',  'afteremobileverify',  'EXT:4tschool.service.security.App_Security_Injector',  'afterMobileVerified',  'load',  '',  '0',  '0', 'after mobile verified, record verify status'
  );


DROP TABLE IF EXISTS `pw_4t_user_messageboard`;
CREATE TABLE  `pw_4t_user_messageboard` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `userid` INT NULL ,
  `cookie` VARCHAR( 36 ) NULL ,
  `question` VARCHAR( 500 ) NOT NULL ,
  `approved` BOOL NULL ,
  `replyby` INT  NULL ,
  `reply` VARCHAR( 500 ) NULL ,
  `deleted` BOOL NOT NULL ,
  `deletedby` INT NULL ,
  `deletedat` DATETIME NULL ,
  `createdat` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `repliedat` DATETIME NULL ,
  INDEX (  `userid` ,  `cookie` ,  `approved` ,  `replyby` ,  `deleted` ,  `deletedby` )
) ENGINE = INNODB;

ALTER TABLE  `pw_4t_user_messageboard` ADD  `schoolid` INT NOT NULL AFTER  `id` ,
ADD INDEX (  `schoolid` );
ALTER TABLE  `pw_4t_user_messageboard` CHANGE  `approved`  `approved` TINYINT( 1 ) NULL DEFAULT  '0';
ALTER TABLE  `pw_4t_user_messageboard` CHANGE  `deleted`  `deleted` TINYINT( 1 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `pw_4t_user_messageboard` CHANGE  `replyby`  `replyby` INT( 11 ) NULL DEFAULT  '0';

ALTER TABLE  `pw_4t_order_address` ADD  `isdefault` BIT( 1 ) NOT NULL AFTER  `rphone`;

ALTER TABLE  `pw_4t_shop` ADD  `imageurl` varchar(200) AFTER  `ordercount` COMMENT '图片相对路径';


DROP TABLE IF EXISTS `pw_4t_order_status_history`;
CREATE TABLE IF NOT EXISTS `pw_4t_order_status_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) NOT NULL,
  `changedby` int(11) NOT NULL,
  `statusfrom` int(11) NOT NULL,
  `statusto` int(11) NOT NULL,
  `changedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `orderid` (`orderid`,`changedby`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO pw_windid_area VALUES('99','Virtual','Virtual',0,1);
INSERT INTO pw_windid_area VALUES('9901','Incidentally','Virtual|Incidentally',99,1);
INSERT INTO pw_windid_school VALUES('10000','VirtualSchool',99,3,'V');
ALTER TABLE  `pw_4t_school_opened` ADD `type` char(1) AFTER  `opened`;
INSERT INTO pw_4t_school_opened VALUES('10000',1,'V');
UPDATE pw_4t_school_opened SET type='P' WHERE type is NULL;

DROP TABLE IF EXISTS `pw_4t_order_sequence`;
CREATE TABLE  `pw_4t_order_sequence` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `orderid` INT NOT NULL ,
  `createdat` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  UNIQUE (
    `orderid`
  )
) ENGINE = INNODB;

ALTER TABLE  `pw_4t_order` ADD  `sequence` INT NOT NULL ,
ADD INDEX (  `sequence` )

ALTER TABLE  `pw_4t_order_item` ADD  `status` INT(11) AFTER `integral`;
ALTER TABLE  `pw_4t_shop` ADD  `packingprice` decimal(10,0) DEFAULT 0 COMMENT  '打包价' AFTER  `currentprice`;
ALTER TABLE  `pw_4t_shop`  MODIFY COLUMN `packingprice` decimal(10,1);


ALTER TABLE  `pw_4t_order_item` ADD  `sequence` VARCHAR( 10 ) NOT NULL AFTER  `status` ,
ADD INDEX (  `sequence` );

ALTER TABLE  `pw_4t_order_item` ADD  `packingprice` DECIMAL( 2, 1 ) NOT NULL;
ALTER TABLE  `pw_4t_order_item` CHANGE  `price`  `price` DECIMAL( 10, 1 ) NOT NULL ;
ALTER TABLE  `pw_4t_order_item` CHANGE  `priceoriginal`  `priceoriginal` DECIMAL( 10, 1 ) NOT NULL ;
ALTER TABLE  `pw_4t_order_item` CHANGE  `saving`  `saving` DECIMAL( 10, 1 ) NOT NULL ;
ALTER TABLE  `pw_4t_order` CHANGE  `savingtotal`  `savingtotal` DECIMAL( 10, 1 ) NOT NULL ;
ALTER TABLE  `pw_4t_order` CHANGE  `ordermoney`  `ordermoney` DECIMAL( 10, 1 ) NOT NULL ;

ALTER TABLE  `pw_4t_order` ADD  `note` VARCHAR( 100 ) NULL COMMENT  '用户下单时候的备注信息, 例如不要辣椒' AFTER  `ordermoney`;

ALTER TABLE  `pw_4t_order_item` ADD  `changeFromItemId` INT NOT NULL AFTER  `id` ,
ADD INDEX (  `changeFromItemId` );

ALTER TABLE  `pw_4t_order_item` ADD  `valid` INT NOT NULL DEFAULT  '1' AFTER  `id`;
ALTER TABLE  `pw_4t_order_item` ADD  `lastUpdated` DATETIME NOT NULL;

ALTER TABLE  `pw_4t_order` ADD  `lastUpdated` DATETIME NOT NULL AFTER  `sequence`;

CREATE TABLE  `pw4t`.`pw_4t_people_schedule` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`type` INT NOT NULL ,
`datetimeBegin` DATETIME NOT NULL ,
`datetimeEnd` DATETIME NOT NULL ,
`userid` INT NOT NULL ,
`actionby` INT NOT NULL ,
`createdat` TIMESTAMP NOT NULL ,
`lastupdatedat` DATETIME NOT NULL ,
`description` VARCHAR( 200 ) NOT NULL ,
INDEX (  `type` ,  `datetimeBegin` ,  `datetimeEnd` ,  `userid` ,  `actionby` )
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_bin;

ALTER TABLE  `pw_4t_people_schedule` ADD  `schoolid` INT NOT NULL AFTER  `id` ,
ADD INDEX (  `schoolid` );

ALTER TABLE  `pw_4t_people_schedule` ADD  `shopid` INT NOT NULL ,
ADD INDEX (  `shopid` );

INSERT INTO `pw_4t_promo_template` (`id`, `templateid`, `name`, `element`, `createdate`, `lastupdatetime`) VALUES
(2, 2, 'MeetDeduct', 'M', 1373777355, 1373777355),
(3, 2, 'MeetDeduct', 'C', 1373777355, 1373777355),
(4, 2, 'MeetDeduct', 'A', 1373777355, 1373777355);

ALTER TABLE  `pw_4t_order_item` ADD  `promoUsed` VARCHAR( 200 ) NULL DEFAULT NULL AFTER  `packingprice`;

ALTER TABLE  `pw_4t_order_item` ADD  `totalMoney` DECIMAL( 10, 1 ) NOT NULL DEFAULT  '0' AFTER  `promoUsed`;

ALTER TABLE  `pw_4t_order_item` CHANGE  `promoUsed`  `promoUsed` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL;

update `pw_4t_order_item` set totalMoney = (price * quatity);

ALTER TABLE  `pw_4t_merchandise` ADD INDEX (  `remainder` );

ALTER TABLE  `pw_4t_merchandise` ADD  `needPackingPrice` BOOL NOT NULL DEFAULT  '1' AFTER  `name`;

ALTER TABLE  `pw_announce` ADD  `schoolid` INT NOT NULL DEFAULT  '0' AFTER  `aid` ,
ADD INDEX (  `schoolid` );

ALTER TABLE  `pw_4t_order` CHANGE  `ordernumber`  `ordernumber` VARCHAR( 17 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;

ALTER TABLE  `pw_4t_shop` ADD  `averagemakeorder` FLOAT( 3, 1 ) NOT NULL AFTER  `isactive` ,
ADD  `averagebakeout` FLOAT( 3, 1 ) NOT NULL AFTER  `averagemakeorder` ,
ADD  `averagetocenter` FLOAT( 3, 1 ) NOT NULL AFTER  `averagebakeout` ,
ADD  `actualmakeorder` FLOAT( 3, 1 ) NOT NULL AFTER  `averagetocenter` ,
ADD  `actualbakeout` FLOAT( 3, 1 ) NOT NULL AFTER  `actualmakeorder` ,
ADD  `actualtocenter` FLOAT( 3, 1 ) NOT NULL AFTER  `actualbakeout`;

ALTER TABLE  `pw_4t_shop` ADD  `averagedelivery` FLOAT( 3, 1 ) NOT NULL AFTER  `averagetocenter`;

ALTER TABLE  `pw_4t_shop` ADD  `actualdelivery` FLOAT( 3, 1 ) NOT NULL AFTER  `actualtocenter`;

ALTER TABLE  `pw_4t_order` ADD  `estimatedeliveryat` DATETIME NULL AFTER  `sequence`;

ALTER TABLE  `pw_4t_order` ADD  `estimatetime` FLOAT( 3, 1 ) NOT NULL AFTER  `estimatedeliveryat`;

DROP TABLE IF EXISTS `pw_4t_people_order_statistic`;
CREATE TABLE  `pw_4t_people_order_statistic` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`uid` INT NOT NULL ,
`schoolid` INT NOT NULL ,
`counttotal` FLOAT( 3, 1 ) NOT NULL ,
`typefor` INT NOT NULL
) ENGINE = INNODB;

ALTER TABLE  `pw_4t_people_order_statistic` CHANGE  `counttotal`  `counttotal` FLOAT( 10, 1 ) NOT NULL;

truncate pw_4t_people_order_statistic;
INSERT INTO pw_4t_people_order_statistic(uid,schoolid,counttotal,typefor)
SELECT userid AS uid, schoolid, SUM( ordermoney ) AS  `counttotal` , 1 AS  `typefor` 
FROM pw_4t_order
WHERE STATUS =5
GROUP BY schoolid,userid;

ALTER TABLE  `pw_4t_order_status_history` ADD  `changedatefrom` DATETIME NOT NULL AFTER  `statusto`;

ALTER TABLE  `pw_4t_shop` ADD  `deliveryprice` DECIMAL( 10, 1 ) NOT NULL DEFAULT  '0' AFTER  `packingprice`;

ALTER TABLE  `pw_4t_merchandise` ADD  `recommend` INT( 1 ) NOT NULL DEFAULT '0' AFTER  `remainder` ,
ADD  `active` INT( 1 ) NOT NULL DEFAULT '1' AFTER  `recommend` ,
ADD INDEX (  `recommend` ,  `active` );

ALTER TABLE  `pw_user_mobile_verify` CHANGE  `code`  `code` INT( 6 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '验证码';

ALTER TABLE `pw_4t_shop` ADD `ispartner` tinyint(1) NOT NULL DEFAULT '1' AFTER `isactive`;

ALTER TABLE `pw_4t_shop` ADD `hasterminal` tinyint(1) NOT Null DEFAULT '1' AFTER `ispartner`;

ALTER TABLE  `pw_4t_school_people` ADD  `isleader` INT( 1 ) NOT NULL DEFAULT  '0' AFTER  `areaid`;

ALTER TABLE `pw_4t_merchandise` ADD `isstar` tinyint(1) NOT NULL DEFAULT '0' AFTER `active`;

DROP TABLE IF EXISTS pw_4t_search_record;
CREATE TABLE  `pw_4t_search_record` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`uid` INT NOT NULL,
`schoolid` INT NOT NULL,
`keyword` VARCHAR(200) NOT NULL,
`searchtype` CHAR(1)  NOT NULL,
`createdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = INNODB;

DROP TABLE IF EXISTS pw_4t_merchandise_tag;
CREATE TABLE `pw_4t_merchandise_tag`(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `mid` INT NOT NULL,
  `tid` INT NOT NULL,
  `createdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = INNODB;


CREATE TABLE IF NOT EXISTS `pw_4t_school_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schoolid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `type` char(20) NOT NULL,
  `areaid` int(11) NOT NULL,
  `leaderid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `schoolid` (`schoolid`,`userid`,`type`),
  KEY `areaid` (`areaid`)
) ENGINE=INNODB  AUTO_INCREMENT=1;
ALTER TABLE  `pw_4t_school_group` ADD  `name` VARCHAR( 100 ) NOT NULL;

DROP TABLE IF EXISTS pw_4t_systag_tree;
CREATE TABLE `pw_4t_systag_tree`(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `json` text NOT NULL,
  `description` VARCHAR(2000) NOT NULL,
  `type` VARCHAR(50) NOT NULL,
  `createdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = INNODB;

CREATE TABLE  `pw_4t_school_peopleingroup` (
`groupid` INT( 11 ) NOT NULL ,
`peopleid` INT( 11 ) NOT NULL ,
INDEX (  `groupid` ,  `peopleid` )
) ENGINE = INNODB;

DROP TABLE IF EXISTS pw_4t_boutique;
CREATE TABLE `pw_4t_boutique`(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `schoolid` INT NOT NULL,
  `type` VARCHAR(50) NOT NULL,  
  `imgurl` varchar(500) NOT NULL,
  `link` varchar(500) NOT NULL,
  `description` VARCHAR(2000) NOT NULL,
  `startdate` DATETIME NOT NULL,
  `enddate` DATETIME NOT NULL,
  `createdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = INNODB;
ALTER TABLE  `pw_4t_boutique` ADD  `lastupdatetime` TIMESTAMP AFTER  `createdate`;
ALTER TABLE `pw_4t_boutique` ADD `isrelease` tinyint(1) NOT NULL DEFAULT '0' AFTER `description`;

ALTER TABLE  `pw_4t_order_item` ADD  `commented` INT( 1 ) NOT NULL DEFAULT  '0' AFTER  `totalMoney` ,
ADD INDEX (  `commented` );

CREATE TABLE IF NOT EXISTS `pw_4t_m_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `environmentscore` int(4) DEFAULT NULL,
  `servicescore` int(4) DEFAULT NULL,
  `tastescore` int(4) DEFAULT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`,`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE  `pw_4t_s_overallcomment` (
`id` INT NOT NULL ,
`shopid` INT NOT NULL ,
`environmentscore` FLOAT( 2, 1 ) NOT NULL ,
`servicescore` FLOAT( 2, 1 ) NOT NULL ,
`tastescore` FLOAT( 2, 1 ) NOT NULL ,
`updatedon` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (  `id` ) ,
INDEX (  `shopid` )
) ENGINE = INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE  `pw_4t_m_comment` ADD  `orderid` INT( 11 ) NOT NULL AFTER  `userid` ,
ADD INDEX (  `orderid` );

ALTER TABLE  `pw_4t_merchandise` ADD  `commentcount` INT( 11 ) NOT NULL DEFAULT  '0' AFTER  `description`;
ALTER TABLE  `pw_4t_shop` ADD  `commentcount` INT( 11 ) NOT NULL DEFAULT  '0' AFTER  `actualdelivery`;

CREATE TABLE IF NOT EXISTS `pw_4t_m_overallcomment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL,
  `environmentscore` float(2,1) NOT NULL,
  `servicescore` float(2,1) NOT NULL,
  `tastescore` float(2,1) NOT NULL,
  `updatedon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE  `pw_4t_m_overallcomment` ADD  `totalcomment` INT( 11 ) NOT NULL DEFAULT  '0' AFTER  `mid`;

ALTER TABLE `pw_4t_shop` ADD `latitude` DECIMAL(11,8) NOT NULL DEFAULT 0 AFTER `address`;
ALTER TABLE `pw_4t_shop` ADD `longitude` DECIMAL(11,8) NOT NULL DEFAULT 0 AFTER `latitude`;
ALTER TABLE `pw_4t_shop` ADD `startingprice` DECIMAL(10,0) NOT NULL DEFAULT 0 AFTER `deliveryprice`;

CREATE TABLE IF NOT EXISTS `pw_4t_shop_deliverytime` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `shopid` INT(11) NOT NULL,
  `begintime` TIME NOT NULL DEFAULT '000000',
  `endtime` TIME NOT NULL DEFAULT '000000',
  `weights` INT NOT NULL,
  `isactive` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `createdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE  `pw_4t_search_record` CHANGE  `keyword`  `keyword` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;
ALTER TABLE  `pw_4t_school_opened` ADD  `shundaiid` INT( 11 ) NOT NULL AFTER  `type` ,
ADD  `openWallet` INT( 1 ) NOT NULL DEFAULT  '0' AFTER  `shundaiid`;
ALTER TABLE  `pw_4t_school_opened` CHANGE  `openWallet`  `openwallet` INT( 1 ) NOT NULL DEFAULT  '0';

ALTER TABLE  `pw_4t_school_opened` ADD  `openorder` INT( 1 ) NOT NULL DEFAULT  '1' AFTER  `openwallet`;
ALTER TABLE  `pw_4t_school_opened` ADD  `openshundai` INT( 1 ) NOT NULL DEFAULT  '1' AFTER  `openorder`;
ALTER TABLE  `pw_4t_school_opened` ADD UNIQUE (
`schoolid`
);
ALTER TABLE  `pw_4t_school_opened` ADD  `openliuyanban` INT( 1 ) NOT NULL DEFAULT  '1' AFTER  `openshundai`;

CREATE TABLE  `pw_4t_shop_phonechecked` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`shopid` INT( 11 ) NOT NULL ,
`uid` INT( 11 ) NOT NULL DEFAULT  '0',
`clientip` VARCHAR( 20 ) NOT NULL ,
`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
INDEX (  `shopid` )
) ENGINE = INNODB;

CREATE TABLE `pw_4t_cate_week_report` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `schoolid` INT(11) DEFAULT NULL,
  `type` INT(10) DEFAULT NULL,
  `title` VARCHAR(300) DEFAULT NULL,
  `content` BLOB,
  `breviaryphoto` VARCHAR(90) DEFAULT NULL,
  `creator` VARCHAR(60) DEFAULT NULL,
  `contactinfo` VARCHAR(60) DEFAULT NULL,
  `audited` INT(1) DEFAULT NULL,
  `released` INT(1) DEFAULT NULL,
  `auditdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `releasedate` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `createdate` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`),
  KEY `schoolid` (`schoolid`),
  KEY `type` (`type`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

ALTER TABLE  `pw_4t_merchandise`  MODIFY COLUMN `currentprice` DECIMAL(10,1);
ALTER TABLE  `pw_4t_merchandise`  MODIFY COLUMN `price` DECIMAL(10,1);


ALTER TABLE `pw_4t_merchandise` ADD collectCount INT(11);
UPDATE `pw_4t_merchandise` SET collectCount = 0;
ALTER TABLE `pw_4t_shop` ADD collectCount INT(11);
UPDATE `pw_4t_shop` SET collectCount = 0;

ALTER TABLE  `pw_4t_merchandise_tag` ADD INDEX (  `mid` );
ALTER TABLE  `pw_4t_merchandise_tag` ADD INDEX (  `tid` );

ALTER TABLE  `pw_4t_cate_week_report` ADD  `link` VARCHAR( 300 ) NULL;

CREATE TABLE `pw_4t_promotional_manage`(
  `id` INT(10) DEFAULT NULL,
  `` 
)ENGINE=INNODB DEFAULT CHARSET=utf8;

ALTER TABLE  `pw_4t_merchandise` ADD  `descriptionurl` VARCHAR( 150 ) NULL AFTER `description`;

CREATE TABLE IF NOT EXISTS `pw_4t_promotional_manage` (
  `id` INT(10) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `schoolid` INT(10) NOT NULL COMMENT '外键学校ID',
  `shopid` INT(10) DEFAULT NULL COMMENT '外键商店ID',
  `promotionalstatus` TINYINT(1) DEFAULT NULL COMMENT '推广时间',
  `promotionalstartime` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '推广开始日期',
  `promotionalendtime` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '推广截止日期',
  `promotionalcreatedate` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '推广创建日期',
  `promotionalupdate` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '推广更新日期',
  PRIMARY KEY (`id`),
  KEY `schoolid` (`schoolid`),
  KEY `shopid` (`shopid`),
  KEY `promotionalstatus` (`promotionalstatus`)
) ENGINE=INNODB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

ALTER TABLE  `pw_4t_shop` ADD  `isaudit` TINYINT( 1 ) DEFAULT '1' AFTER `hasterminal`;
ALTER TABLE  `pw_4t_merchandise` ADD  `merchandisedescription` BLOB;
ALTER TABLE `pw_4t_shop` CHANGE `isaudit` `isaudit` TINYINT( 1 ) NULL DEFAULT NULL ;

CREATE TABLE `pw_4t_push` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '推送ID号',
  `schoolid` INT(11) NOT NULL COMMENT '学校ID号',
  `type` INT(2) DEFAULT NULL COMMENT '推送类型',
  `title` VARCHAR(300) DEFAULT NULL COMMENT '推送标题',
  `content` BLOB COMMENT '推送内容',
  `status` TINYINT(1) DEFAULT NULL COMMENT '推送状态',
  `creator` VARCHAR(50) DEFAULT NULL COMMENT '推送的创建者',
  `createdate` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '推送的创建日期',
  `updatedate` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '推送的更新日期',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `schoolid` (`schoolid`),
  KEY `status` (`status`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

ALTER TABLE pw_4t_school_group CHARACTER SET utf8;

ALTER TABLE `pw_4t_school_group` CHANGE `type` `type` CHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
ALTER TABLE `pw_4t_school_group` CHANGE `name` `name` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;

CREATE TABLE `pw_4t_baidu_push` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `baiduuserid` varchar(30) DEFAULT NULL,
  `baiduchannelid` varchar(30) DEFAULT NULL,
  `tagid` int(11) DEFAULT NULL,
  `schoolid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `baiduuserid` (`baiduuserid`),
  KEY `baiduchannelid` (`baiduchannelid`),
  KEY `tagid` (`tagid`),
  KEY `schoolid` (`schoolid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE  `pw_4t_shop` ADD  `isopen` TINYINT( 1 ) DEFAULT NULL AFTER `isaudit`;
ALTER TABLE  `pw_4t_shop` ADD  `hasprint` TINYINT( 1 ) DEFAULT NULL AFTER `hasterminal`;
ALTER TABLE `pw_4t_shop` CHANGE `hasprint` `hasprint` TINYINT( 1 ) NULL DEFAULT '0';
ALTER TABLE `pw_4t_shop` CHANGE `isopen` `isopen` TINYINT( 1 ) NULL DEFAULT '0';
ALTER TABLE `pw_4t_shop` CHANGE `isopen` `isshopopen` TINYINT(1) DEFAULT 0;

ALTER TABLE  `pw_4t_school_opened` ADD  `openmap` TINYINT( 1 ) DEFAULT NULL;

INSERT INTO `pw_4t_school_opened`(`schoolid`, `opened`, `type`, `shundaiid`, `openwallet`, `openorder`, `openshundai`, `openliuyanban`) 
VALUES(1001292, 1, 'P', 28, 0, 1, 0, 1);

INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('qq', 'qusite_1001292', '客服咨询:Aaron-251643819|合作咨询:Peter-215169718,Aaron-504662465', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('tel', 'qusite_1001292', '13617910719,251643819', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('style', 'qusite_1001292', '3', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('isopen', 'qusite_1001292', '0', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('qq', 'qusite_11045', '客服咨询:Wade-11111111|合作咨询:York-222222,Aaron-504662465', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('tel', 'qusite_11045', '1507777711,1507777711', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('style', 'qusite_11045', '3', 'string');
 
 INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('isopen', 'qusite_11045', '0', 'string');

 ALTER TABLE  `pw_4t_school_opened` ADD  `openwebsite` TINYINT( 1 ) DEFAULT NULL;

ALTER TABLE  `pw_4t_school_opened` ADD  `opencombo` TINYINT( 1 ) NOT NULL DEFAULT 0 AFTER `openwebsite`;
ALTER TABLE  `pw_4t_school_opened` ADD  `schlatitude` DECIMAL(11,8) NOT NULL DEFAULT '0.00000000';
ALTER TABLE  `pw_4t_school_opened` ADD  `schlongitude` DECIMAL(11,8) NOT NULL DEFAULT '0.00000000';


CREATE TABLE `pw_4t_shop_status_record` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `shopId` INT(11) DEFAULT NULL,
  `userId` INT(11) DEFAULT NULL,
  `actiontime` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `actionstatus` INT(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
 KEY `userId` (`userId`),
 KEY `shopId` (`shopId`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

ALTER TABLE  `pw_4t_school_opened` ADD  `openclassannounce` TINYINT( 1 ) DEFAULT 0;

ALTER TABLE  `pw_4t_school_opened` ADD  `abbreviation` varchar( 20 ) DEFAULT '点餐, 外卖, 点餐哟';

CREATE TABLE IF NOT EXISTS `pw_4t_tmpuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE  `pw_4t_order` ADD  `firstorder` INT( 1 ) NOT NULL DEFAULT  '0' AFTER  `sequence` ,
ADD INDEX (  `firstorder` ) ;

ALTER TABLE  `pw_4t_shop` ADD  `openordertouser` TINYINT( 1 ) DEFAULT 0 AFTER isshopopen;

UPDATE pw_4t_merchandise SET collectCount=0 WHERE collectCount IS NULL;
ALTER TABLE `pw_4t_merchandise` CHANGE `collectCount` `collectCount` INT( 11 ) NULL DEFAULT '0';

ALTER TABLE `pw_4t_school_opened` CHANGE `abbreviation` `abbreviation` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL ;

ALTER TABLE  `pw_4t_order` ADD  `source` VARCHAR( 4 ) NULL;


ALTER TABLE  `pw_4t_tmpuser` ADD  `from` INT( 11 ) NOT NULL AFTER  `userid` ,
ADD  `key` VARCHAR( 50 ) NOT NULL AFTER  `from` ,
ADD INDEX (  `from` ,  `key` ) ;

ALTER TABLE  `pw_4t_tmpuser` ADD  `createdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER  `key` ;

ALTER TABLE `pw_4t_m_comment` ADD INDEX (`userid`);
ALTER TABLE `pw_4t_boutique` ADD INDEX (`type`);
ALTER TABLE `pw_4t_boutique` ADD INDEX (`isrelease`);

ALTER TABLE `pw_4t_order_address` CHANGE `isdefault` `isdefault` INT( 1 ) NOT NULL ;

ALTER TABLE  `pw_4t_order` ADD  `isordertouser` TINYINT( 1 ) DEFAULT 0;

CREATE TABLE `pw_4t_shop_school` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `shopId` INT(11) DEFAULT NULL,
  `schoolId` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
 KEY `shopId` (`shopId`),
 KEY `schoolId` (`schoolId`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

INSERT INTO `pw_4t_shop_school` (`shopId`, `schoolId`) (SELECT sh.id AS shopId, sa.schoolid AS schoolId FROM pw_4t_shop AS sh 
LEFT JOIN pw_4t_school_area AS sa ON sh.areaid = sa.id);

ALTER TABLE `pw_4t_tag` ADD `shopid` INT( 11 ) NOT NULL DEFAULT 0 AFTER `id`,
ADD `isactive` tinyint(1) NOT NULL DEFAULT 1 AFTER `issystem`,
ADD INDEX(`shopid`,`isactive`);

INSERT INTO `pw_4t_school_opened`(`schoolid`, `opened`, `type`, `shundaiid`, `openwallet`, `openorder`, `openshundai`, `openliuyanban`) 
VALUES(1001293, 1, 'P', 28, 0, 1, 0, 1);

INSERT INTO `pw_4t_school_opened`(`schoolid`, `opened`, `type`, `shundaiid`, `openwallet`, `openorder`, `openshundai`, `openliuyanban`) 
VALUES(1001294, 1, 'P', 28, 0, 1, 0, 1);

INSERT INTO `pw_4t_school_opened`(`schoolid`, `opened`, `type`, `shundaiid`, `openwallet`, `openorder`, `openshundai`, `openliuyanban`) 
VALUES(1001295, 1, 'P', 28, 0, 1, 0, 1);

INSERT INTO `pw_4t_school_opened`(`schoolid`, `opened`, `type`, `shundaiid`, `openwallet`, `openorder`, `openshundai`, `openliuyanban`) 
VALUES(11033, 1, 'P', 28, 0, 1, 0, 1);

INSERT INTO `pw_4t_school_opened`(`schoolid`, `opened`, `type`, `shundaiid`, `openwallet`, `openorder`, `openshundai`, `openliuyanban`) 
VALUES(11016, 1, 'P', 28, 0, 1, 0, 1);

INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('qq', 'qusite_1001293', '客服咨询:Peter-215169718|合作咨询:Yang-81552433', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('tel', 'qusite_1001293', '88556454', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('style', 'qusite_1001293', '3', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('isopen', 'qusite_1001293', '0', 'string');
 
 INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('qq', 'qusite_1001294', '客服咨询:Peter-215169718|合作咨询:Yang-81552433', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('tel', 'qusite_1001294', '88556454', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('style', 'qusite_1001294', '3', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('isopen', 'qusite_1001294', '0', 'string');
 
 INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('qq', 'qusite_1001295', '客服咨询:Peter-215169718|合作咨询:Yang-81552433', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('tel', 'qusite_1001295', '88556454', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('style', 'qusite_1001295', '3', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('isopen', 'qusite_1001295', '0', 'string');

 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('qq', 'qusite_11033', '客服咨询:Peter-215169718|合作咨询:Yang-81552433', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('tel', 'qusite_11033', '88556454', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('style', 'qusite_11033', '3', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('isopen', 'qusite_11033', '0', 'string');

INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('qq', 'qusite_11016', '客服咨询:Peter-215169718|合作咨询:Yang-81552433', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('tel', 'qusite_11016', '88556454', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('style', 'qusite_11016', '3', 'string');
 
INSERT INTO `pw_common_config`(`name`, `namespace`, `value`, `vtype`) 
 VALUE('isopen', 'qusite_11016', '0', 'string');

ALTER TABLE `pw_4t_shop` ADD `ifrebate` TINYINT(1) NOT NULL DEFAULT 0 AFTER `isshopopen`;
ALTER TABLE `pw_4t_shop` ADD `rebatefromshop` DECIMAL(6, 2) NOT NULL DEFAULT 0 AFTER `ifrebate`;
ALTER TABLE `pw_4t_shop` ADD `rebatetouser` DECIMAL(6, 2) NOT NULL DEFAULT 0 AFTER `rebatefromshop`;
ALTER TABLE `pw_4t_shop` ADD `masterid` INT(10) UNSIGNED NOT NULL AFTER `userid`;
ALTER TABLE  `pw_4t_shop` ADD INDEX (  `ifrebate` );
ALTER TABLE  `pw_4t_shop` ADD INDEX (  `masterid` );

UPDATE `pw_4t_shop` AS s SET s.masterid = (SELECT sp.userid 
FROM `pw_4t_school_area` AS sa 
LEFT JOIN `pw_4t_school_people` AS sp ON sa.schoolid = sp.schoolid AND sp.TYPE = 'master' WHERE s.areaid= sa.id LIMIT 1);

CREATE TABLE IF NOT EXISTS `pw_4t_shopdailysale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopid` int(11) NOT NULL,
  `datefor` date NOT NULL,
  `totalorders` int(11) NOT NULL,
  `validorders` int(11) NOT NULL,
  `totalmoney` int(11) NOT NULL,
  `validmoney` int(11) NOT NULL,
  `calon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `shopid` (`shopid`,`datefor`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `pw_4t_shop_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `shopid` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `speed` int(11) NOT NULL,
  `comment` varchar(200) NULL,
  `createdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`,`shopid`,`orderid`,`speed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `pw_4t_shopspeed_overall` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopid` int(11) NOT NULL,
  `overallspeed` int(11) NOT NULL,
  `overallcount` int(11) NOT NULL,
  `averagespeed` int(11) NOT NULL,
  `updateon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `shopid` (`shopid`,`overallcount`,`averagespeed`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `pw_4t_my_money_history` ADD `orderid` INT(11) NOT NULL DEFAULT 0 AFTER `userid`;
ALTER TABLE `pw_4t_order` ADD `deservedpointcoin` INT(11) NOT NULL DEFAULT 0 AFTER `ordernumber`;
ALTER TABLE `pw_4t_order` ADD `ifusersigninorder` TINYINT(1) NOT NULL DEFAULT 0 AFTER `deservedpointcoin`;

CREATE TABLE IF NOT EXISTS `pw_4t_weixin_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(200) NOT NULL,
  `expireat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

ALTER TABLE `pw_4t_order` CHANGE `ifusersigninorder` `ifrejectapproved` TINYINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE  `pw_4t_order` ADD  `rebatefromshop` DECIMAL( 6, 2 ) NOT NULL DEFAULT  '0.0' AFTER  `ordermoney` ,
ADD  `shopreturn` DECIMAL( 6, 2 ) NOT NULL DEFAULT  '0.0' AFTER  `rebatefromshop` ;

ALTER TABLE  `pw_4t_shopdailysale` ADD  `totalshopreturn` DECIMAL( 10, 2 ) NOT NULL DEFAULT  '0.0' AFTER  `validmoney` ,
ADD  `validshopreturn` DECIMAL( 10, 2 ) NOT NULL DEFAULT  '0.0' AFTER  `totalshopreturn` ;

CREATE TABLE `pw_4t_gift_exchange` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '活动兑换表主id',
  `userid` INT(11) NOT NULL COMMENT '用户id',
  `contact` VARCHAR(10) NOT NULL COMMENT '联系人姓名',
  `phonenumber` VARCHAR(15) NOT NULL COMMENT '联系电话 ',
  `qq` VARCHAR(15) DEFAULT NULL COMMENT 'QQ',
  `address` VARCHAR(500) DEFAULT NULL COMMENT '联系人地址',
  `productid` INT(3) NOT NULL COMMENT '兑换奖品id',
  `exchangesuccess` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '是否兑换成功',
  `createtime` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `updatetime` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '记录最后一次讲更新时间',
  `exceptionexchange` TINYINT(1) DEFAULT NULL COMMENT '异常兑换',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`,`productid`,`exchangesuccess`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;


CREATE TABLE `pw_4t_baiduuser_channel` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `shopid` INT(11) DEFAULT NULL,
  `baiduuserid` VARCHAR(50) DEFAULT NULL,
  `channelid` VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shopid` (`shopid`,`baiduuserid`,`channelid`)
) ENGINE=INNODB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


ALTER TABLE  `pw_4t_order` ADD  `firstordersince0331` INT( 1 ) NOT NULL DEFAULT  '0' AFTER  `firstorder` ,
ADD INDEX (  `firstordersince0331` ) ;