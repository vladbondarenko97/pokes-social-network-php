-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 29, 2013 at 04:12 PM
-- Server version: 5.1.66-cll
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vladbond_pokes`
--

-- --------------------------------------------------------

--
-- Table structure for table `pokes`
--

CREATE TABLE IF NOT EXISTS `pokes` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `pokes` varchar(32) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `pokes`
--

INSERT INTO `pokes` (`id`, `pokes`) VALUES
(7, '0'),
(6, '2'),
(5, '2');

-- --------------------------------------------------------

--
-- Table structure for table `pokes_cooldown`
--

CREATE TABLE IF NOT EXISTS `pokes_cooldown` (
  `id` varchar(16) NOT NULL,
  `time` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pokes_cooldown`
--

INSERT INTO `pokes_cooldown` (`id`, `time`) VALUES
('5', '1377812661'),
('6', '0'),
('7', '0');

-- --------------------------------------------------------

--
-- Table structure for table `poke_history`
--

CREATE TABLE IF NOT EXISTS `poke_history` (
  `id` varchar(16) NOT NULL,
  `from` varchar(16) NOT NULL,
  `time` varchar(16) NOT NULL,
  `reason` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `poke_history`
--

INSERT INTO `poke_history` (`id`, `from`, `time`, `reason`) VALUES
('5', '5', '1377797628', 'Testing reasons 2'),
('5', '5', '1377536042', 'TESTING REASONS'),
('6', '5', '1377812346', 'You are a good friend. I trust you with everything. Hopefully it will stay that way.'),
('6', '5', '1377812661', 'Another one. :D');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `fname` varchar(15) NOT NULL,
  `lname` varchar(15) NOT NULL,
  `username` varchar(15) DEFAULT NULL,
  `password` varchar(15) DEFAULT NULL,
  `regdate` varchar(20) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `ip` varchar(35) DEFAULT NULL,
  `lastip` varchar(16) NOT NULL,
  `rank` varchar(1) DEFAULT NULL,
  `sex` varchar(1) NOT NULL DEFAULT 'U',
  `banned` varchar(1) DEFAULT NULL,
  `approved` varchar(1) NOT NULL DEFAULT '0',
  `description` varchar(256) NOT NULL DEFAULT 'I am a new Pokes user. =)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `username`, `password`, `regdate`, `email`, `ip`, `lastip`, `rank`, `sex`, `banned`, `approved`, `description`) VALUES
(5, 'Vlad', 'Bondarenko', 'Vlad1k', 'maxim123', '08/18/2013', 'vlad1k@vlad1k.net', '76.236.244.31', '76.236.244.31', '3', 'm', '0', '1', '<span style="color:blue">Pokes Admin</span>'),
(6, 'Kamil', 'Jarosz', 'kamil09875', 'kamil09875...', '08/19/2013', 'kamil09875@gmail.com', '94.40.103.77', '94.40.103.77', '3', 'm', '0', '1', '<span style="color:blue">Pokes Admin</span>'),
(7, 'Pokes', 'Dummy', 'test', 'POKES</3', '08/19/2013', 'admin@vlad1k.net', '76.236.245.113', '76.236.245.113', '1', 'm', '0', '1', 'WWwwwdaubisubIUWBUYBWKUABVFUSHBFAJHGBAJEHGBWEIBGIELUWGNILWEUGBLWIUBNJSLKHDBFLIWEUBGIUWEBGIUWYEBGIWUEGBIWBG');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
