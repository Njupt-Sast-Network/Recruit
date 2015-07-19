-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.6.16 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win32
-- HeidiSQL 版本:                  8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 导出 recruit 的数据库结构
DROP DATABASE IF EXISTS `recruit`;
CREATE DATABASE IF NOT EXISTS `recruit` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `recruit`;


-- 导出  表 recruit.association_departments 结构
DROP TABLE IF EXISTS `association_departments`;
CREATE TABLE IF NOT EXISTS `association_departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `departmentName` text NOT NULL COMMENT '部门名称',
  `username` text NOT NULL COMMENT '部门管理员用户名',
  `password` text NOT NULL COMMENT '部门管理员密码',
  `association` varchar(50) NOT NULL COMMENT '所属社团名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 数据导出被取消选择。


-- 导出  表 recruit.association_list 结构
DROP TABLE IF EXISTS `association_list`;
CREATE TABLE IF NOT EXISTS `association_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `associationName` varchar(40) NOT NULL,
  `quest1` text NOT NULL,
  `quest2` text NOT NULL,
  `quest3` text NOT NULL,
  `username` text NOT NULL COMMENT '社团管理员用户名',
  `password` text NOT NULL COMMENT '社团管理员密码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 数据导出被取消选择。


-- 导出  表 recruit.student_basic_info 结构
DROP TABLE IF EXISTS `student_basic_info`;
CREATE TABLE IF NOT EXISTS `student_basic_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xh` varchar(20) NOT NULL,
  `name` varchar(40) NOT NULL,
  `birthday` date NOT NULL,
  `year` int(11) NOT NULL,
  `password` varchar(40) NOT NULL,
  `qq` bigint(20) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `sex` int(11) NOT NULL,
  `dorm` text NOT NULL,
  `college` text NOT NULL,
  `major` text NOT NULL,
  `gaozhong` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 数据导出被取消选择。


-- 导出  表 recruit.student_recruit_info 结构
DROP TABLE IF EXISTS `student_recruit_info`;
CREATE TABLE IF NOT EXISTS `student_recruit_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xh` varchar(20) NOT NULL,
  `department1` int(11) NOT NULL,
  `department2` int(11) NOT NULL,
  `association` int(11) NOT NULL,
  `quest1` text NOT NULL,
  `quest2` text NOT NULL,
  `quest3` text NOT NULL,
  `acceptState` text COMMENT '0表示暂无结果，-1表示被第一部门拒绝，-2表示被第二部门拒绝，其他字符串表示录取部门名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 数据导出被取消选择。
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
