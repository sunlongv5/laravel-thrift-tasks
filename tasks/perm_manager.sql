/*
 Navicat Premium Data Transfer

 Source Server         : dev-192.168.202.90
 Source Server Type    : MySQL
 Source Server Version : 50536
 Source Host           : 192.168.202.90
 Source Database       : perm_manager

 Target Server Type    : MySQL
 Target Server Version : 50536
 File Encoding         : utf-8

 Date: 07/04/2017 16:52:37 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `t_business_config`
-- ----------------------------
DROP TABLE IF EXISTS `t_business_config`;
CREATE TABLE `t_business_config` (
  `bid` int(11) NOT NULL AUTO_INCREMENT COMMENT '业务id',
  `url` varchar(128) NOT NULL DEFAULT '' COMMENT '业务url',
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(1024) NOT NULL DEFAULT '' COMMENT '描述',
  `mtime` datetime NOT NULL COMMENT '创建时间',
  `ctime` datetime NOT NULL COMMENT '创建时间',
  `admin` varchar(1024) NOT NULL DEFAULT '' COMMENT '管理员, 可以是多个',
  `auditerType` tinyint(4) NOT NULL DEFAULT '0' COMMENT '审核人类型: 1 管理员; 2 直接上级;',
  `creater` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人',
  `lastEditor` varchar(64) NOT NULL DEFAULT '' COMMENT '最后一次修改人',
  `configs` mediumblob NOT NULL COMMENT '权限配置, Json格式',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态: 0 正常状态; 1 审核中; 2 驳回; 3 已修改; 4 删除; ',
  PRIMARY KEY (`bid`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `t_perm_audit`
-- ----------------------------
DROP TABLE IF EXISTS `t_perm_audit`;
CREATE TABLE `t_perm_audit` (
  `auditId` int(11) NOT NULL AUTO_INCREMENT COMMENT '审核id',
  `userId` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` varchar(64) NOT NULL DEFAULT '' COMMENT '冗余用户名',
  `bid` int(11) NOT NULL DEFAULT '0' COMMENT '业务id',
  `begDate` date NOT NULL COMMENT '开始日期',
  `endDate` date NOT NULL COMMENT '结束日期',
  `description` varchar(1024) NOT NULL DEFAULT '' COMMENT '申请说明',
  `roles` varchar(256) NOT NULL DEFAULT '' COMMENT '用户所在的角色列表, 以,分隔',
  `perms` mediumblob NOT NULL COMMENT '权限列表, 以,分隔',
  `mtime` datetime NOT NULL COMMENT '修改时间',
  `ctime` datetime NOT NULL COMMENT '创建时间',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态: 1 审核中; 2 驳回; 3 已修改;',
  PRIMARY KEY (`auditId`),
  UNIQUE KEY `userId` (`userId`,`bid`),
  KEY `bid` (`bid`)
) ENGINE=InnoDB AUTO_INCREMENT=1000389 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `t_role_perm`
-- ----------------------------
DROP TABLE IF EXISTS `t_role_perm`;
CREATE TABLE `t_role_perm` (
  `roleId` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `bid` int(11) NOT NULL DEFAULT '0' COMMENT '业务id',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '角色名',
  `description` varchar(1024) NOT NULL DEFAULT '' COMMENT '详细描述信息',
  `perms` mediumblob NOT NULL COMMENT '权限列表, 以,分隔',
  `creater` varchar(64) NOT NULL DEFAULT '' COMMENT '创建人',
  `lastEditor` varchar(64) NOT NULL DEFAULT '' COMMENT '最后一次修改人',
  `mtime` datetime NOT NULL COMMENT '修改时间',
  `ctime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`roleId`),
  KEY `bid` (`bid`,`roleId`)
) ENGINE=InnoDB AUTO_INCREMENT=10071 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `t_user_perm`
-- ----------------------------
DROP TABLE IF EXISTS `t_user_perm`;
CREATE TABLE `t_user_perm` (
  `userId` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` varchar(64) NOT NULL DEFAULT '' COMMENT '冗余用户名',
  `bid` int(11) NOT NULL DEFAULT '0' COMMENT '业务id',
  `begDate` date NOT NULL COMMENT '开始日期',
  `endDate` date NOT NULL COMMENT '结束日期',
  `roles` varchar(256) NOT NULL DEFAULT '' COMMENT '用户所在的角色列表, 以,分隔',
  `perms` mediumblob NOT NULL COMMENT '权限列表, 以,分隔',
  `mtime` datetime NOT NULL COMMENT '修改时间',
  `ctime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`bid`,`userId`),
  KEY `username` (`username`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
