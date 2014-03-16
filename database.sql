-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 17, 2014 at 02:49 AM
-- Server version: 5.5.36-cll
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `fripig_weather`
--

-- --------------------------------------------------------

--
-- Table structure for table `36hr`
--

CREATE TABLE IF NOT EXISTS `36hr` (
  `sn` int(11) NOT NULL AUTO_INCREMENT,
  `city` char(10) NOT NULL,
  `class` char(10) NOT NULL,
  `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` char(20) DEFAULT NULL,
  `value` float NOT NULL,
  PRIMARY KEY (`sn`),
  KEY `city` (`city`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=85801 ;

-- --------------------------------------------------------

--
-- Table structure for table `cityweek`
--

CREATE TABLE IF NOT EXISTS `cityweek` (
  `sn` int(11) NOT NULL AUTO_INCREMENT,
  `city` char(12) NOT NULL,
  `class` char(10) NOT NULL,
  `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` char(20) DEFAULT NULL,
  `value` float NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=238393 ;

-- --------------------------------------------------------

--
-- Table structure for table `data_state`
--

CREATE TABLE IF NOT EXISTS `data_state` (
  `sn` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(250) NOT NULL,
  `updatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`sn`)
) ENGINE=MEMORY  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `sn` int(4) NOT NULL AUTO_INCREMENT,
  `c_order` int(3) NOT NULL,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `c_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sid` int(10) NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `obs`
--

CREATE TABLE IF NOT EXISTS `obs` (
  `sn` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(20) NOT NULL,
  `msgtype` char(10) NOT NULL,
  `dataid` char(10) NOT NULL,
  `scope` char(10) NOT NULL,
  `location` point NOT NULL,
  `locationName` char(20) NOT NULL,
  `stationId` char(10) NOT NULL,
  `obsTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `TIME` int(11) NOT NULL,
  `ELEV` int(11) NOT NULL,
  `WDIR` float NOT NULL,
  `WDSD` float NOT NULL,
  `TEMP` float NOT NULL,
  `HUMD` float NOT NULL,
  `PRES` float NOT NULL,
  `24R` float DEFAULT NULL,
  `SUN` float DEFAULT NULL,
  `H_24R` float DEFAULT NULL,
  `WS15M` float DEFAULT NULL,
  `WD15M` float DEFAULT NULL,
  `WS15T` char(4) DEFAULT NULL,
  `H_FX` float DEFAULT NULL,
  `H_XD` float DEFAULT NULL,
  `H_FXT` char(10) DEFAULT NULL,
  `H_F10` float DEFAULT NULL,
  `H_10D` float DEFAULT NULL,
  `H_F10T` char(10) DEFAULT NULL,
  `CITY` char(20) NOT NULL,
  `CITY_SN` char(5) NOT NULL,
  `TOWN` char(20) NOT NULL,
  `TOWN_SN` char(5) NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=318301 ;

-- --------------------------------------------------------

--
-- Table structure for table `obs_A0001_001`
--

CREATE TABLE IF NOT EXISTS `obs_A0001_001` (
  `sn` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(20) NOT NULL,
  `msgtype` char(10) NOT NULL,
  `dataid` char(10) NOT NULL,
  `scope` char(10) NOT NULL,
  `location` point NOT NULL,
  `locationName` char(20) NOT NULL,
  `stationId` char(10) NOT NULL,
  `obsTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ELEV` int(11) NOT NULL,
  `WDIR` float NOT NULL,
  `WDSD` float NOT NULL,
  `TEMP` float NOT NULL,
  `HUMD` float NOT NULL,
  `PRES` float NOT NULL,
  `SUN` float NOT NULL,
  `H_24R` float NOT NULL,
  `WS15M` float NOT NULL,
  `WD15M` float NOT NULL,
  `WS15T` char(4) NOT NULL,
  `CITY` char(20) NOT NULL,
  `CITY_SN` char(5) NOT NULL,
  `TOWN` char(20) NOT NULL,
  `TOWN_SN` char(5) NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8055 ;

-- --------------------------------------------------------

--
-- Table structure for table `WeatherAssistant`
--

CREATE TABLE IF NOT EXISTS `WeatherAssistant` (
  `sn` int(11) NOT NULL AUTO_INCREMENT,
  `cityid` char(6) NOT NULL,
  `name` char(10) NOT NULL,
  `stno` char(10) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text NOT NULL,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5475 ;

-- --------------------------------------------------------

--
-- Table structure for table `week`
--

CREATE TABLE IF NOT EXISTS `week` (
  `sn` int(11) NOT NULL AUTO_INCREMENT,
  `city` char(10) NOT NULL,
  `class` char(10) NOT NULL,
  `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` char(20) DEFAULT NULL,
  `value` float NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=133351 ;
