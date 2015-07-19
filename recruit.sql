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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- 正在导出表  recruit.association_departments 的数据：~3 rows (大约)
DELETE FROM `association_departments`;
/*!40000 ALTER TABLE `association_departments` DISABLE KEYS */;
INSERT INTO `association_departments` (`id`, `departmentName`, `username`, `password`, `association`) VALUES
	(1, '网络部', 'wlb', '0cf282ab36ee1936701bb2f177a75e93', '校科协'),
	(2, '计算机部', 'jsj', '12619d9358f501617b5a4d9c3e07f2bf', '校科协'),
	(3, '文化部', 'whb', 'f65fb21e12cc89944e07a9a5eb70a4d3', '学生会'),
	(4, '学习部', 'xxb', 'f0ce78c4e8283cc56e4283053658aaf7', '学生会');
/*!40000 ALTER TABLE `association_departments` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- 正在导出表  recruit.association_list 的数据：~2 rows (大约)
DELETE FROM `association_list`;
/*!40000 ALTER TABLE `association_list` DISABLE KEYS */;
INSERT INTO `association_list` (`id`, `associationName`, `quest1`, `quest2`, `quest3`, `username`, `password`) VALUES
	(1, '校科协', '你喜欢吃芥末吗', '你是二次元还是三次元', '你的性取向是什么', 'sast', 'c35bf0d93d1c02b152d1e49a30460047'),
	(2, '学生会', '你的星座是什么', '你怎么看待董嘉睿', '你喜欢什么运动', 'stu', 'ebece9185bc89be8c96782d4db4323fe');
/*!40000 ALTER TABLE `association_list` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- 正在导出表  recruit.student_basic_info 的数据：~2 rows (大约)
DELETE FROM `student_basic_info`;
/*!40000 ALTER TABLE `student_basic_info` DISABLE KEYS */;
INSERT INTO `student_basic_info` (`id`, `xh`, `name`, `birthday`, `year`, `password`, `qq`, `mail`, `phone`, `sex`, `dorm`, `college`, `major`, `gaozhong`) VALUES
	(1, 'B11111111', '我', '1993-11-05', 1993, 'ef16dc54dc337985f09629c0f850c70a', 213123, '12312@121', 2132132, 2, '21321', '321312', 'aaaa', 'sss'),
	(4, 'B13011226', '诸鑫强', '1994-11-08', 1994, 'e9e03d9a6ee5df50a1761719740d119a', 123123, '123@qq.com', 12345678901, 1, '1232', 'ed', 'dd', 'dd');
/*!40000 ALTER TABLE `student_basic_info` ENABLE KEYS */;


-- 导出  表 recruit.student_recruit_info 结构
DROP TABLE IF EXISTS `student_recruit_info`;
CREATE TABLE IF NOT EXISTS `student_recruit_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xh` varchar(20) NOT NULL,
  `department1` int(11) NOT NULL COMMENT '所报部门id',
  `department2` int(11) NOT NULL COMMENT '所报第二部门id',
  `association` text NOT NULL COMMENT '所报社团名称',
  `quest1` text,
  `quest2` text,
  `quest3` text,
  `acceptState` varchar(50) DEFAULT '0' COMMENT '0表示暂无结果，-1表示被第一部门拒绝，-2表示被第二部门拒绝，其他正数表示录取部门id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- 正在导出表  recruit.student_recruit_info 的数据：~2 rows (大约)
DELETE FROM `student_recruit_info`;
/*!40000 ALTER TABLE `student_recruit_info` DISABLE KEYS */;
INSERT INTO `student_recruit_info` (`id`, `xh`, `department1`, `department2`, `association`, `quest1`, `quest2`, `quest3`, `acceptState`) VALUES
	(1, 'B13011226', 1, 2, '校科协', '你猜', '你再猜', '就不告诉你', '2'),
	(2, 'B13011226', 3, 4, '学生会', '不', '不是的', '不是这样的', '0');
/*!40000 ALTER TABLE `student_recruit_info` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
