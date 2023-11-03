
CREATE DATABASE systemeio CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `systemeio`;

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `currencies`
-- ----------------------------
DROP TABLE IF EXISTS `currencies`;
CREATE TABLE `currencies` (
                              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                              `code` text ,
                              PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;;

-- ----------------------------
-- Records of currencies
-- ----------------------------
INSERT INTO `currencies` VALUES ('1', 'USD');
INSERT INTO `currencies` VALUES ('2', 'EUR');

-- ----------------------------
-- Table structure for `goods`
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
                         `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                         `product` text ,
                         `price` float unsigned DEFAULT '0',
                         `currency` int(10) unsigned DEFAULT '0',
                         PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;;

-- ----------------------------
-- Records of goods
-- ----------------------------
INSERT INTO `goods` VALUES ('1', 'Iphone', '100', '2');
INSERT INTO `goods` VALUES ('2', 'Наушники', '20', '2');
INSERT INTO `goods` VALUES ('3', 'Чехол', '10', '2');

-- ----------------------------
-- Table structure for `tax`
-- ----------------------------
DROP TABLE IF EXISTS `tax`;
CREATE TABLE `tax` (
                       `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                       `Country` text,
                       `Code` char(2) DEFAULT NULL,
                       `Tax` int(11) DEFAULT NULL,
                       `digitsLength` int(10) unsigned DEFAULT NULL,
                       `taxNumberLength` int(11) DEFAULT NULL,
                       PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tax
-- ----------------------------
INSERT INTO `tax` VALUES ('1', 'Germany', 'DE', '19', '9', '11');
INSERT INTO `tax` VALUES ('2', 'Italy', 'IT', '22', '11', '13');
INSERT INTO `tax` VALUES ('3', 'Greece', 'GR', '24', '9', '11');
INSERT INTO `tax` VALUES ('4', 'France', 'FR', '20', '9', '13');

