/*
Navicat MySQL Data Transfer

Source Server         : first
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : wstmall

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-09-11 15:18:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wst_yfq_role
-- ----------------------------
DROP TABLE IF EXISTS `wst_yfq_role`;
CREATE TABLE `wst_yfq_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `r_name` varchar(255) NOT NULL,
  `r_qishu` varchar(255) NOT NULL,
  `r_ed` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
