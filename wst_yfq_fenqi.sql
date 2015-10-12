/*
Navicat MySQL Data Transfer

Source Server         : first
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : wstmall

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-09-11 15:18:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wst_yfq_fenqi
-- ----------------------------
DROP TABLE IF EXISTS `wst_yfq_fenqi`;
CREATE TABLE `wst_yfq_fenqi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qishu` varchar(255) DEFAULT NULL,
  `lixi` varchar(255) DEFAULT NULL,
  `yuqi` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
