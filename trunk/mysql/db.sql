-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 18, 2010 at 03:33 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6-1+lenny8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pardus_info_center`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `id` bigint(20) NOT NULL auto_increment,
  `universe` varchar(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(32) default NULL,
  `permissions` int(11) default '0',
  `level` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `universe`, `name`, `password`, `permissions`, `level`) VALUES
(1, 'Orion', 'root', '986d76480b0b202c14f23ffd3b977f68', 0, 'Admin'),
(2, 'Artemis', 'Public', '4c9184f37cff01bcdc32dc486ec36961', 715827882, 'Open'),
(3, 'Orion', 'Orion-Send', '986d76480b0b202c14f23ffd3b977f68', 0, 'Confidential'),
(4, 'Artemis', 'Artemis-Send', '986d76480b0b202c14f23ffd3b977f68', 0, 'Confidential'),
(5, 'Pegasus', 'Pegasus-Send', '986d76480b0b202c14f23ffd3b977f68', 0, 'Confidential'),
(6, 'Orion', 'Orion-View', '986d76480b0b202c14f23ffd3b977f68', 715827882, 'Confidential'),
(7, 'Artemis', 'Artemis-View', '986d76480b0b202c14f23ffd3b977f68', 715827882, 'Confidential'),
(8, 'Pegasus', 'Pegasus-View', '986d76480b0b202c14f23ffd3b977f68', 715827882, 'Confidential');

-- --------------------------------------------------------

--
-- Table structure for table `combat`
--

CREATE TABLE IF NOT EXISTS `combat` (
  `id` bigint(20) NOT NULL auto_increment,
  `pid` bigint(20) NOT NULL,
  `universe` varchar(10) NOT NULL,
  `type` varchar(20) NOT NULL,
  `when` datetime NOT NULL,
  `sector` varchar(20) NOT NULL,
  `coords` varchar(10) NOT NULL,
  `attacker` varchar(60) NOT NULL,
  `defender` varchar(60) NOT NULL,
  `outcome` varchar(20) NOT NULL,
  `additional` varchar(40) default NULL,
  `data` text NOT NULL,
  `level` varchar(20) default 'Confidential',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6146 ;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` bigint(20) NOT NULL auto_increment,
  `universe` varchar(10) NOT NULL,
  `table` varchar(20) NOT NULL,
  `table_id` bigint(20) NOT NULL,
  `name` varchar(20) default NULL,
  `when` datetime NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Table structure for table `hack`
--

CREATE TABLE IF NOT EXISTS `hack` (
  `id` bigint(20) NOT NULL auto_increment,
  `universe` varchar(10) NOT NULL,
  `date` datetime NOT NULL,
  `method` varchar(10) NOT NULL,
  `location` varchar(30) default NULL,
  `pilotId` bigint(20) default NULL,
  `pilot` varchar(30) NOT NULL,
  `credits` bigint(20) NOT NULL,
  `reputation` bigint(20) NOT NULL,
  `buildingAmount` bigint(20) NOT NULL,
  `experience` bigint(20) default NULL,
  `cluster` varchar(50) default NULL,
  `sector` varchar(20) default NULL,
  `coords` varchar(10) default NULL,
  `shipStatus` text,
  `buildingPositions` text,
  `buildings` text,
  `foes` text,
  `friends` text,
  `foeAlliances` text,
  `friendAlliances` text,
  `level` varchar(20) default 'Confidential',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE IF NOT EXISTS `level` (
  `id` smallint(2) unsigned NOT NULL,
  `level` smallint(2) unsigned NOT NULL,
  `name` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `level`, `name`) VALUES
(1, 1, 'Open'),
(2, 2, 'Confidential'),
(3, 3, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `mission`
--

CREATE TABLE IF NOT EXISTS `mission` (
  `id` bigint(20) NOT NULL auto_increment,
  `pid` bigint(20) NOT NULL,
  `universe` varchar(10) NOT NULL,
  `source` varchar(30) NOT NULL,
  `when` datetime NOT NULL,
  `faction` varchar(9) default NULL,
  `type` varchar(30) NOT NULL,
  `timelimit` bigint(20) NOT NULL,
  `amount` bigint(20) default NULL,
  `opponent` varchar(20) default NULL,
  `destination` varchar(30) default NULL,
  `sector` varchar(20) default NULL,
  `coords` varchar(10) default NULL,
  `reward` bigint(20) NOT NULL,
  `deposit` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_pid_universe` (`pid`,`universe`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=144717 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` bigint(20) NOT NULL auto_increment,
  `universe` varchar(10) default NULL,
  `when` datetime default NULL,
  `type` varchar(50) default NULL,
  `location` varchar(50) default NULL,
  `payer` varchar(60) default NULL,
  `receiver` varchar(60) default NULL,
  `credits` int(12) default NULL,
  `level` varchar(20) default 'Confidential',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=85 ;

