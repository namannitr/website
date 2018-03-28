-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 05, 2018 at 10:34 AM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `paylen`
--
CREATE DATABASE IF NOT EXISTS `paylen` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `paylen`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`admin_id`),
  KEY `id` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `default_settings`
--

CREATE TABLE IF NOT EXISTS `default_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zero_ftd` int(11) NOT NULL,
  `firstmonths_one_ftd` int(11) NOT NULL,
  `one_ftd` int(11) NOT NULL,
  `two_ftd` int(11) NOT NULL,
  `one_ftd_eu` int(11) NOT NULL,
  `two_ftd_eu` int(11) NOT NULL,
  `three_ftd_eu` int(11) NOT NULL,
  `500bonus` int(11) NOT NULL,
  `1000bonus` int(11) NOT NULL,
  `getbonusonload` int(11) NOT NULL,
  `load_level1` float NOT NULL,
  `load_level2` float NOT NULL,
  `load_level3` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ftd`
--

CREATE TABLE IF NOT EXISTS `ftd` (
  `ftd_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `retention_id` int(11) DEFAULT NULL,
  `ftd_date` datetime NOT NULL,
  `client_name` varchar(30) NOT NULL,
  `note` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `client_email` varchar(40) NOT NULL,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ftd_id`),
  UNIQUE KEY `ftd_id_2` (`ftd_id`),
  KEY `ftd_id` (`ftd_id`),
  KEY `ftd_id_3` (`ftd_id`),
  KEY `ftd_id_4` (`ftd_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txt` text NOT NULL,
  `user` text NOT NULL,
  `query` text NOT NULL,
  `ip` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;

-- --------------------------------------------------------

--
-- Table structure for table `retentions`
--

CREATE TABLE IF NOT EXISTS `retentions` (
  `retention_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `r_group_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` text NOT NULL,
  `active` enum('True','False') NOT NULL DEFAULT 'True',
  PRIMARY KEY (`retention_id`),
  KEY `retention_id` (`retention_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;

-- --------------------------------------------------------

--
-- Table structure for table `retention_load`
--

CREATE TABLE IF NOT EXISTS `retention_load` (
  `retention_load_id` int(11) NOT NULL AUTO_INCREMENT,
  `ftd_id` int(11) NOT NULL,
  `load_amount` float NOT NULL,
  `load_date` datetime NOT NULL,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `retention_id` int(11) NOT NULL,
  PRIMARY KEY (`retention_load_id`),
  UNIQUE KEY `retention_load_id_3` (`retention_load_id`),
  KEY `retention_load_id` (`retention_load_id`),
  KEY `retention_load_id_2` (`retention_load_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_groups`
--

CREATE TABLE IF NOT EXISTS `r_groups` (
  `r_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `r_supervisor_id` int(11) NOT NULL,
  PRIMARY KEY (`r_group_id`),
  KEY `group_id` (`r_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_supervisors`
--

CREATE TABLE IF NOT EXISTS `r_supervisors` (
  `r_supervisor_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`r_supervisor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `supervisors`
--

CREATE TABLE IF NOT EXISTS `supervisors` (
  `supervisor_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` text NOT NULL,
  `active` enum('True','False') NOT NULL DEFAULT 'True',
  PRIMARY KEY (`supervisor_id`),
  KEY `supervisor_id` (`supervisor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) NOT NULL,
  `middle_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `account_type` varchar(20) NOT NULL,
  `group_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` text NOT NULL,
  `active` enum('True','False') NOT NULL DEFAULT 'True',
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;

-- --------------------------------------------------------

--
-- Table structure for table `workhours`
--

CREATE TABLE IF NOT EXISTS `workhours` (
  `workhours_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `hours` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`workhours_id`),
  KEY `workhours_id` (`workhours_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;

-- --------------------------------------------------------

--
-- Table structure for table `workhours_retention`
--

CREATE TABLE IF NOT EXISTS `workhours_retention` (
  `workhours_id` int(11) NOT NULL AUTO_INCREMENT,
  `retention_id` int(11) NOT NULL,
  `hours` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`workhours_id`),
  KEY `workhours_id` (`workhours_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `workhours_supervisor`
--

CREATE TABLE IF NOT EXISTS `workhours_supervisor` (
  `workhours_id` int(11) NOT NULL AUTO_INCREMENT,
  `supervisor_id` int(11) NOT NULL,
  `hours` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`workhours_id`),
  KEY `workhours_id` (`workhours_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
