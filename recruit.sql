-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2015 at 03:00 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `association_departments`
--

CREATE TABLE IF NOT EXISTS `association_departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `departmentId` int(11) NOT NULL,
  `departmentName` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `association` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部门账户列表,若部门id为0但社团id不为0则为该社团管理员账户,若全部为0则是root用户' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `association_list`
--

CREATE TABLE IF NOT EXISTS `association_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `associationName` varchar(40) NOT NULL,
  `quest1` longtext,
  `quest2` longtext,
  `quest3` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `association_list`
--

INSERT INTO `association_list` (`id`, `associationName`, `quest1`, `quest2`, `quest3`) VALUES
(1, 'Test1', 'foo', 'bar', NULL),
(2, 'Test2', NULL, 'foo2', 'bar2');

-- --------------------------------------------------------

--
-- Table structure for table `student_basic_info`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='记录基本信息如学号,姓名等' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `student_basic_info`
--

INSERT INTO `student_basic_info` (`id`, `xh`, `name`, `birthday`, `year`, `password`, `qq`, `mail`, `phone`, `sex`, `dorm`, `college`, `major`, `gaozhong`) VALUES
(1, 'B11111111', '我', '1993-11-05', 1993, 'qweqwe', 213123, '12312@121', 2132132, 22, '21321', '321312', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `student_recruit_info`
--

CREATE TABLE IF NOT EXISTS `student_recruit_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xh` varchar(20) NOT NULL,
  `department1` int(11) NOT NULL,
  `department2` int(11) NOT NULL,
  `association` int(11) NOT NULL,
  `quest1` longtext,
  `quest2` longtext,
  `quest3` longtext,
  `acceptState` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `student_recruit_info`
--

INSERT INTO `student_recruit_info` (`id`, `xh`, `department1`, `department2`, `association`, `quest1`, `quest2`, `quest3`, `acceptState`) VALUES
(1, 'B11111111', 2, 3, 1, 'hehe', 'qwqw', 'edf', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
