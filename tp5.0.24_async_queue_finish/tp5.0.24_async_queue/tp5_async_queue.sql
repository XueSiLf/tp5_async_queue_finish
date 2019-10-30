/*
Navicat MySQL Data Transfer

Source Server         : 本地wamp数据库
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : tp5_async_queue

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2019-10-30 19:01:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `member`
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `email` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of member
-- ----------------------------
INSERT INTO `member` VALUES ('1', '1592328848@qq.com', '1592328848@qq.com', '1572255313', '0');
