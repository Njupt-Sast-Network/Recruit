-- phpMyAdmin SQL Dump
-- version 4.4.8
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-09-09 19:06:20
-- 服务器版本： 5.6.20
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `recruit`
--
CREATE DATABASE IF NOT EXISTS `recruit` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `recruit`;

-- --------------------------------------------------------

--
-- 表的结构 `association_departments`
--

CREATE TABLE IF NOT EXISTS `association_departments` (
  `id` int(11) NOT NULL,
  `association` varchar(50) NOT NULL COMMENT '所属社团名称',
  `departmentName` text NOT NULL COMMENT '部门名称',
  `username` text NOT NULL COMMENT '部门管理员用户名',
  `password` char(255) NOT NULL COMMENT '部门管理员密码'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `association_list`
--

CREATE TABLE IF NOT EXISTS `association_list` (
  `id` int(11) NOT NULL,
  `associationName` varchar(40) NOT NULL,
  `quest1` text NOT NULL,
  `quest2` text NOT NULL,
  `quest3` text NOT NULL,
  `username` text NOT NULL COMMENT '社团管理员用户名',
  `password` text NOT NULL COMMENT '社团管理员密码'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `student_basic_info`
--

CREATE TABLE IF NOT EXISTS `student_basic_info` (
  `id` int(11) NOT NULL,
  `xh` varchar(20) NOT NULL,
  `name` varchar(40) NOT NULL,
  `birthday` date NOT NULL,
  `year` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `qq` bigint(20) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `sex` int(11) NOT NULL,
  `dorm` text NOT NULL,
  `college` text NOT NULL,
  `major` text NOT NULL,
  `gaozhong` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 替换视图以便查看 `student_download`
--
CREATE TABLE IF NOT EXISTS `student_download` (
`id` int(11)
,`xh` varchar(20)
,`department1` int(11)
,`department2` int(11)
,`association` text
,`quest1` text
,`quest2` text
,`quest3` text
,`acceptState` varchar(50)
,`name` varchar(40)
,`mail` varchar(40)
,`dorm` text
,`birthday` date
,`sex` int(11)
,`college` text
,`major` text
,`gaozhong` text
,`phone` bigint(20)
,`qq` bigint(20)
);

-- --------------------------------------------------------

--
-- 表的结构 `student_recruit_info`
--

CREATE TABLE IF NOT EXISTS `student_recruit_info` (
  `id` int(11) NOT NULL,
  `xh` varchar(20) NOT NULL,
  `department1` int(11) NOT NULL COMMENT '所报部门id',
  `department2` int(11) NOT NULL COMMENT '所报第二部门id',
  `association` text NOT NULL COMMENT '所报社团名称',
  `quest1` text,
  `quest2` text,
  `quest3` text,
  `acceptState` varchar(50) DEFAULT '0' COMMENT '0表示暂无结果，-1表示被第一部门拒绝，-2表示被第二部门拒绝，其他正数表示录取部门id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 视图结构 `student_download`
--
DROP TABLE IF EXISTS `student_download`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `student_download` AS select `student_recruit_info`.`id` AS `id`,`student_recruit_info`.`xh` AS `xh`,`student_recruit_info`.`department1` AS `department1`,`student_recruit_info`.`department2` AS `department2`,`student_recruit_info`.`association` AS `association`,`student_recruit_info`.`quest1` AS `quest1`,`student_recruit_info`.`quest2` AS `quest2`,`student_recruit_info`.`quest3` AS `quest3`,`student_recruit_info`.`acceptState` AS `acceptState`,`student_basic_info`.`name` AS `name`,`student_basic_info`.`mail` AS `mail`,`student_basic_info`.`dorm` AS `dorm`,`student_basic_info`.`birthday` AS `birthday`,`student_basic_info`.`sex` AS `sex`,`student_basic_info`.`college` AS `college`,`student_basic_info`.`major` AS `major`,`student_basic_info`.`gaozhong` AS `gaozhong`,`student_basic_info`.`phone` AS `phone`,`student_basic_info`.`qq` AS `qq` from (`student_recruit_info` join `student_basic_info`) where (`student_recruit_info`.`xh` = `student_basic_info`.`xh`);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `association_departments`
--
ALTER TABLE `association_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `association_list`
--
ALTER TABLE `association_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_basic_info`
--
ALTER TABLE `student_basic_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_recruit_info`
--
ALTER TABLE `student_recruit_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `association_departments`
--
ALTER TABLE `association_departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `association_list`
--
ALTER TABLE `association_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_basic_info`
--
ALTER TABLE `student_basic_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_recruit_info`
--
ALTER TABLE `student_recruit_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
