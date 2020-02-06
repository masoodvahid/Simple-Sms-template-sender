-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 28, 2020 at 10:43 PM
-- Server version: 5.7.23
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sendsms`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` bigint(20) DEFAULT NULL,
  `content` text,
  `receipte` int(11) DEFAULT NULL,
  `status` varchar(126) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code1` int(11) DEFAULT NULL,
  `code2` int(11) DEFAULT NULL,
  `panel_username` varchar(63) NOT NULL,
  `panel_password` varchar(63) NOT NULL,
  `panel_line_number` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `code1`, `code2`, `panel_username`, `panel_password`, `panel_line_number`) VALUES
(1, 801, 901, '-', '-', '');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

DROP TABLE IF EXISTS `templates`;
CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) DEFAULT NULL,
  `title` varchar(63) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `code`, `title`, `content`) VALUES
(1, 801, 'کارت بانکی شماره 1', 'متن کارت شماره 1\r\n نیست'),
(2, 802, 'کارت بانکی شماره 2', 'متن کارت شماره 2 که جهت تست وارد شده است.'),
(3, 803, 'کارت بانکی شماره 3', 'این تست نیست '),
(4, 804, 'کارت بانکی 4', 'تست کارت شماره 4'),
(5, 901, 'اخطار عدم پرداخت', 'اخطار عدم پرداخت '),
(6, 902, 'دومین اخطار', 'دومین اخطار جهت پرداخت قبوض');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
