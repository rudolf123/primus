-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 27, 2013 at 06:37 PM
-- Server version: 5.1.40
-- PHP Version: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `primus_db_prod`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_userloganswers`
--

CREATE TABLE IF NOT EXISTS `tbl_userloganswers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `userlog_id` int(11) NOT NULL,
  `isright` tinyint(1) DEFAULT NULL,
  `question_text` varchar(255) DEFAULT NULL,
  `answer_text` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tbl_userloganswers`
--

INSERT INTO `tbl_userloganswers` (`id`, `question_id`, `answer_id`, `userlog_id`, `isright`, `question_text`, `answer_text`) VALUES
(1, 1, 6, 12, 0, 'Сколько будет 2+2?', '23'),
(2, 2, 2, 12, 0, 'Основоположник геометрии', 'Архимед'),
(6, 2, 3, 15, 1, 'Основоположник геометрии', 'Евклид'),
(5, 1, 8, 15, 1, 'Сколько будет 2+2?', '4'),
(7, 1, 6, 16, 0, 'Сколько будет 2+2?', '23'),
(8, 2, 3, 16, 1, 'Основоположник геометрии', 'Евклид'),
(9, 1, 6, 17, 0, 'Сколько будет 2+2?', '23'),
(10, 2, 4, 17, 0, 'Основоположник геометрии', 'Геродот');
