/*
Navicat MySQL Data Transfer

Source Server         : localhoust
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : d_auth

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2016-11-07 15:37:36
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for t_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `t_auth_group`;
CREATE TABLE `t_auth_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rules` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of t_auth_group
-- ----------------------------
INSERT INTO `t_auth_group` VALUES ('1', 'root', '超级管理员组', '1', '1', '0', '0', '0');
INSERT INTO `t_auth_group` VALUES ('2', 'admin', '管理员组', '2', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for t_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `t_auth_rule`;
CREATE TABLE `t_auth_rule` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `pid` bigint(20) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of t_auth_rule
-- ----------------------------
INSERT INTO `t_auth_rule` VALUES ('1', 'test', '测试', '1', '1', '0', '0', '0', '0');
INSERT INTO `t_auth_rule` VALUES ('2', 'route', '路由', '1', '1', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for t_auth_user_group
-- ----------------------------
DROP TABLE IF EXISTS `t_auth_user_group`;
CREATE TABLE `t_auth_user_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of t_auth_user_group
-- ----------------------------
INSERT INTO `t_auth_user_group` VALUES ('1', '1', '1');
INSERT INTO `t_auth_user_group` VALUES ('2', '1', '2');

-- ----------------------------
-- Table structure for t_user
-- ----------------------------
DROP TABLE IF EXISTS `t_user`;
CREATE TABLE `t_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of t_user
-- ----------------------------
