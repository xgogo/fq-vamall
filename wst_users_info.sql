/*
Navicat MySQL Data Transfer

Source Server         : first
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : wstmall

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-09-11 18:04:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wst_users_info
-- ----------------------------
DROP TABLE IF EXISTS `wst_users_info`;
CREATE TABLE `wst_users_info` (
  `info_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL,
  `u_name` varchar(255) NOT NULL,
  `sfzhm` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `sch_name` varchar(255) NOT NULL,
  `sch_address` varchar(255) NOT NULL,
  `profession` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `start_time` date NOT NULL,
  `xuezhi` varchar(255) NOT NULL,
  `dorm_address` varchar(255) NOT NULL,
  `dorm_number` int(11) NOT NULL,
  `student_img` varchar(255) NOT NULL,
  `sfz_img01` varchar(255) NOT NULL,
  `sfz_img02` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `add_time` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `back_info` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
