-- phpMyAdmin SQL Dump
-- version 2.6.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost:3306
-- Generation Time: Mar 06, 2012 at 06:39 PM
-- Server version: 5.1.37
-- PHP Version: 5.3.8
-- 
-- Database: `kundli_alert`
-- 
CREATE DATABASE `kundli_alert` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE kundli_alert;

-- --------------------------------------------------------
DROP TABLE IF EXISTS API_OUTPUT;
-- 
-- Table structure for table `API_OUTPUT`
-- 

CREATE TABLE `API_OUTPUT` (
  `PROFILEID` int(11) unsigned NOT NULL,
  `MATCHID` int(11) unsigned NOT NULL,
  `GUNA` float NOT NULL,
  `LAGNA` tinyint(2) NOT NULL,
  `SUN` tinyint(2) NOT NULL,
  `MERCURY` tinyint(2) NOT NULL,
  `JUPITER` tinyint(2) NOT NULL,
  `SATURN` tinyint(2) NOT NULL,
  `MARS` tinyint(2) NOT NULL,
  `VENUS` tinyint(2) NOT NULL,
  `STATUS` char(1) NOT NULL,
  `ENTRY_DT` datetime NOT NULL,
  PRIMARY KEY (`PROFILEID`,`MATCHID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `API_OUTPUT`
-- 


-- --------------------------------------------------------
DROP TABLE IF EXISTS KUNDLI_CONTACT_CENTER;
-- 
-- Table structure for table `KUNDLI_CONTACT_CENTER`
-- 

CREATE TABLE `KUNDLI_CONTACT_CENTER` (
  `PROFILEID` int(11) unsigned NOT NULL,
  `MATCHID` int(11) unsigned NOT NULL,
  `GUNA` float NOT NULL,
  `LAGNA` tinyint(2) NOT NULL,
  `SUN` tinyint(2) NOT NULL,
  `MERCURY` tinyint(2) NOT NULL,
  `JUPITER` tinyint(2) NOT NULL,
  `SATURN` tinyint(2) NOT NULL,
  `MARS` tinyint(2) NOT NULL,
  `VENUS` tinyint(2) NOT NULL,
  `ENTRY_DT` datetime DEFAULT NULL,
  `MAIL_DT` date NOT NULL,
  PRIMARY KEY (`PROFILEID`,`MATCHID`)
) ENGINE=MRG_MyISAM DEFAULT CHARSET=latin1 INSERT_METHOD=LAST UNION=(`LOG1`);

-- 
-- Dumping data for table `KUNDLI_CONTACT_CENTER`
-- 


-- --------------------------------------------------------
DROP TABLE IF EXISTS KUNDLI_RECEIVER_PAID;
-- 
-- Table structure for table `KUNDLI_RECEIVER_PAID`
-- 

CREATE TABLE `KUNDLI_RECEIVER_PAID` (
  `PROFILEID` int(11) unsigned NOT NULL,
  `GENDER` char(1) NOT NULL,
  `START_DT` datetime DEFAULT NULL,
  `END_DT` datetime DEFAULT NULL,
  PRIMARY KEY (`PROFILEID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `KUNDLI_RECEIVER_PAID`
-- 


-- --------------------------------------------------------
DROP TABLE IF EXISTS KUNDLI_RECEIVER_UNPAID;
-- 
-- Table structure for table `KUNDLI_RECEIVER_UNPAID`
-- 

CREATE TABLE `KUNDLI_RECEIVER_UNPAID` (
  `PROFILEID` int(11) unsigned NOT NULL,
  `GENDER` char(1) NOT NULL,
  `START_DT` datetime DEFAULT NULL,
  `END_DT` datetime DEFAULT NULL,
  PRIMARY KEY (`PROFILEID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `KUNDLI_RECEIVER_UNPAID`
-- 


-- --------------------------------------------------------
DROP TABLE IF EXISTS LAST_ACTIVE_LOG;
-- 
-- Table structure for table `LAST_ACTIVE_LOG`
-- 

CREATE TABLE `LAST_ACTIVE_LOG` (
  `NO` smallint(1) NOT NULL,
  `DATE` date NOT NULL,
  `TYPE` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `LAST_ACTIVE_LOG`
-- 


-- --------------------------------------------------------
DROP TABLE IF EXISTS LOG1;
-- 
-- Table structure for table `LOG1`
-- 

CREATE TABLE `LOG1` (
  `PROFILEID` int(11) unsigned NOT NULL,
  `MATCHID` int(11) unsigned NOT NULL,
  `GUNA` float NOT NULL,
  `LAGNA` tinyint(2) NOT NULL,
  `SUN` tinyint(2) NOT NULL,
  `MERCURY` tinyint(2) NOT NULL,
  `JUPITER` tinyint(2) NOT NULL,
  `SATURN` tinyint(2) NOT NULL,
  `MARS` tinyint(2) NOT NULL,
  `VENUS` tinyint(2) NOT NULL,
  `ENTRY_DT` datetime DEFAULT NULL,
  `MAIL_DT` date NOT NULL,
  PRIMARY KEY (`PROFILEID`,`MATCHID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `LOG1`
-- 


-- --------------------------------------------------------
DROP TABLE IF EXISTS MAILER_PAID;
-- 
-- Table structure for table `MAILER_PAID`
-- 

CREATE TABLE `MAILER_PAID` (
  `PROFILEID` int(11) unsigned NOT NULL,
  `MATCHID` int(11) unsigned NOT NULL,
  `GUNA` float NOT NULL,
  `LAGNA` tinyint(2) NOT NULL,
  `SUN` tinyint(2) NOT NULL,
  `MERCURY` tinyint(2) NOT NULL,
  `JUPITER` tinyint(2) NOT NULL,
  `SATURN` tinyint(2) NOT NULL,
  `MARS` tinyint(2) NOT NULL,
  `VENUS` tinyint(2) NOT NULL,
  `ENTRY_DT` datetime NOT NULL,
  PRIMARY KEY (`PROFILEID`,`MATCHID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `MAILER_PAID`
-- 


-- --------------------------------------------------------
DROP TABLE IF EXISTS MAILER_UNPAID;
-- 
-- Table structure for table `MAILER_UNPAID`
-- 

CREATE TABLE `MAILER_UNPAID` (
  `PROFILEID` int(11) unsigned NOT NULL,
  `MATCHID` int(11) unsigned NOT NULL,
  `GUNA` float NOT NULL,
  `LAGNA` tinyint(2) NOT NULL,
  `SUN` tinyint(2) NOT NULL,
  `MERCURY` tinyint(2) NOT NULL,
  `JUPITER` tinyint(2) NOT NULL,
  `SATURN` tinyint(2) NOT NULL,
  `MARS` tinyint(2) NOT NULL,
  `VENUS` tinyint(2) NOT NULL,
  `ENTRY_DT` datetime NOT NULL,
  PRIMARY KEY (`PROFILEID`,`MATCHID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `MAILER_UNPAID`
-- 

DROP TABLE IF EXISTS PROFILE_LOGS_PAID;
-- --------------------------------------------------------

-- 
-- Table structure for table `PROFILE_LOGS_PAID`
-- 

CREATE TABLE `PROFILE_LOGS_PAID` (
  `PROFILEID` int(11) NOT NULL,
  PRIMARY KEY (`PROFILEID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `PROFILE_LOGS_PAID`
-- 


-- --------------------------------------------------------
DROP TABLE IF EXISTS PROFILE_LOGS_UNPAID;
-- 
-- Table structure for table `PROFILE_LOGS_UNPAID`
-- 

CREATE TABLE `PROFILE_LOGS_UNPAID` (
  `PROFILEID` int(11) NOT NULL,
  PRIMARY KEY (`PROFILEID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `PROFILE_LOGS_UNPAID`
-- 


-- --------------------------------------------------------
DROP TABLE IF EXISTS SEARCH_FEMALE_PAID;
-- 
-- Table structure for table `SEARCH_FEMALE_PAID`
-- 

CREATE TABLE `SEARCH_FEMALE_PAID` (
  `PROFILEID` mediumint(11) unsigned NOT NULL DEFAULT '0',
  `CASTE` smallint(8) unsigned DEFAULT '0',
  `RELIGION` tinyint(3) NOT NULL,
  `MANGLIK` char(1) NOT NULL DEFAULT '',
  `MTONGUE` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `MSTATUS` char(1) NOT NULL DEFAULT '',
  `OCCUPATION` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `COUNTRY_RES` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `COUNTRY_BIRTH` tinyint(3) NOT NULL DEFAULT '0',
  `CITY_RES` char(4) NOT NULL DEFAULT '',
  `HEIGHT` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `EDU_LEVEL` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `EDU_LEVEL_NEW` tinyint(4) NOT NULL DEFAULT '0',
  `MOD_DT` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DRINK` char(1) NOT NULL DEFAULT '',
  `SMOKE` char(1) NOT NULL DEFAULT '',
  `HAVECHILD` char(2) NOT NULL DEFAULT '',
  `RES_STATUS` char(1) NOT NULL DEFAULT '',
  `BTYPE` char(1) NOT NULL DEFAULT '',
  `COMPLEXION` char(1) NOT NULL DEFAULT '',
  `DIET` char(1) NOT NULL DEFAULT '',
  `HANDICAPPED` char(1) NOT NULL DEFAULT '',
  `AGE` tinyint(4) NOT NULL DEFAULT '0',
  `INCOME` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `RELATION` char(1) NOT NULL,
  `SORT_DT` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `PROFILE_SCORE` smallint(6) DEFAULT '0',
  `TOTAL_POINTS` mediumint(6) NOT NULL DEFAULT '0',
  `ENTRY_DT` date NOT NULL DEFAULT '0000-00-00',
  `BAND` tinyint(2) NOT NULL DEFAULT '0',
  `NUM` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `LAGE` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `HAGE` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `AGE_FILTER` char(1) NOT NULL DEFAULT 'N',
  `RELIGION_FILTER` char(1) NOT NULL DEFAULT 'N',
  `CASTE_FILTER` char(1) NOT NULL DEFAULT 'N',
  `MTONGUE_FILTER` char(1) NOT NULL DEFAULT 'N',
  `COUNTRY_RES_FILTER` char(1) NOT NULL DEFAULT 'N',
  `MSTATUS_FILTER` char(1) NOT NULL DEFAULT 'N',
  `INCOME_FILTER` char(1) NOT NULL DEFAULT 'N',
  `CITY_RES_FILTER` char(1) NOT NULL DEFAULT 'N',
  `DTOFBIRTH` date NOT NULL DEFAULT '0000-00-00',
  `INCOME_SORTBY` tinyint(4) NOT NULL,
  `PARTNER_CHILD` char(2) NOT NULL,
  `PARTNER_LAGE` tinyint(4) NOT NULL,
  `PARTNER_HAGE` tinyint(4) NOT NULL,
  `PARTNER_LHEIGHT` tinyint(3) NOT NULL,
  `PARTNER_HHEIGHT` tinyint(3) NOT NULL,
  `PARTNER_HANDICAPPED` char(1) NOT NULL,
  `PARTNER_BTYPE` text NOT NULL,
  `PARTNER_CASTE` text NOT NULL,
  `PARTNER_CITYRES` text NOT NULL,
  `PARTNER_COMP` text NOT NULL,
  `PARTNER_COUNTRYRES` text NOT NULL,
  `PARTNER_DIET` text NOT NULL,
  `PARTNER_DRINK` text NOT NULL,
  `PARTNER_ELEVEL` text NOT NULL,
  `PARTNER_ELEVEL_NEW` text NOT NULL,
  `PARTNER_INCOME` text NOT NULL,
  `PARTNER_MANGLIK` text NOT NULL,
  `PARTNER_MSTATUS` text NOT NULL,
  `PARTNER_MTONGUE` text NOT NULL,
  `PARTNER_OCC` text NOT NULL,
  `PARTNER_SMOKE` text NOT NULL,
  `PARTNER_RELATION` text NOT NULL,
  `PARTNER_RELIGION` text NOT NULL,
  `HAVEPHOTO` char(1) DEFAULT 'N',
  `LAST_LOGIN_DT` date NOT NULL,
  `HIV` char(1) NOT NULL,
  `ASTRO_ENTRY_DT` datetime DEFAULT NULL,
  UNIQUE KEY `PROFILEID` (`PROFILEID`),
  KEY `SEARCH1` (`AGE`),
  KEY `MTONGUE` (`MTONGUE`),
  KEY `CASTE` (`CASTE`),
  KEY `OCCUPATION` (`OCCUPATION`),
  KEY `HEIGHT` (`HEIGHT`),
  KEY `COUNTRY_RES` (`COUNTRY_RES`),
  KEY `srcind` (`MSTATUS`,`HEIGHT`,`AGE`,`CASTE`),
  KEY `ENTRY_DT` (`ENTRY_DT`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 MAX_ROWS=500000 AVG_ROW_LENGTH=400;

-- 
-- Dumping data for table `SEARCH_FEMALE_PAID`
-- 


-- --------------------------------------------------------
DROP TABLE IF EXISTS SEARCH_FEMALE_UNPAID;
-- 
-- Table structure for table `SEARCH_FEMALE_UNPAID`
-- 

CREATE TABLE `SEARCH_FEMALE_UNPAID` (
  `PROFILEID` mediumint(11) unsigned NOT NULL DEFAULT '0',
  `CASTE` smallint(8) unsigned DEFAULT '0',
  `RELIGION` tinyint(3) NOT NULL,
  `MANGLIK` char(1) NOT NULL DEFAULT '',
  `MTONGUE` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `MSTATUS` char(1) NOT NULL DEFAULT '',
  `OCCUPATION` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `COUNTRY_RES` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `COUNTRY_BIRTH` tinyint(3) NOT NULL DEFAULT '0',
  `CITY_RES` char(4) NOT NULL DEFAULT '',
  `HEIGHT` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `EDU_LEVEL` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `EDU_LEVEL_NEW` tinyint(4) NOT NULL DEFAULT '0',
  `MOD_DT` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DRINK` char(1) NOT NULL DEFAULT '',
  `SMOKE` char(1) NOT NULL DEFAULT '',
  `HAVECHILD` char(2) NOT NULL DEFAULT '',
  `RES_STATUS` char(1) NOT NULL DEFAULT '',
  `BTYPE` char(1) NOT NULL DEFAULT '',
  `COMPLEXION` char(1) NOT NULL DEFAULT '',
  `DIET` char(1) NOT NULL DEFAULT '',
  `HANDICAPPED` char(1) NOT NULL DEFAULT '',
  `AGE` tinyint(4) NOT NULL DEFAULT '0',
  `INCOME` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `RELATION` char(1) NOT NULL,
  `SORT_DT` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `PROFILE_SCORE` smallint(6) DEFAULT '0',
  `TOTAL_POINTS` mediumint(6) NOT NULL DEFAULT '0',
  `ENTRY_DT` date NOT NULL DEFAULT '0000-00-00',
  `BAND` tinyint(2) NOT NULL DEFAULT '0',
  `NUM` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `LAGE` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `HAGE` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `AGE_FILTER` char(1) NOT NULL DEFAULT 'N',
  `RELIGION_FILTER` char(1) NOT NULL DEFAULT 'N',
  `CASTE_FILTER` char(1) NOT NULL DEFAULT 'N',
  `MTONGUE_FILTER` char(1) NOT NULL DEFAULT 'N',
  `COUNTRY_RES_FILTER` char(1) NOT NULL DEFAULT 'N',
  `MSTATUS_FILTER` char(1) NOT NULL DEFAULT 'N',
  `INCOME_FILTER` char(1) NOT NULL DEFAULT 'N',
  `CITY_RES_FILTER` char(1) NOT NULL DEFAULT 'N',
  `DTOFBIRTH` date NOT NULL DEFAULT '0000-00-00',
  `INCOME_SORTBY` tinyint(4) NOT NULL,
  `PARTNER_CHILD` char(2) NOT NULL,
  `PARTNER_LAGE` tinyint(4) NOT NULL,
  `PARTNER_HAGE` tinyint(4) NOT NULL,
  `PARTNER_LHEIGHT` tinyint(3) NOT NULL,
  `PARTNER_HHEIGHT` tinyint(3) NOT NULL,
  `PARTNER_HANDICAPPED` char(1) NOT NULL,
  `PARTNER_BTYPE` text NOT NULL,
  `PARTNER_CASTE` text NOT NULL,
  `PARTNER_CITYRES` text NOT NULL,
  `PARTNER_COMP` text NOT NULL,
  `PARTNER_COUNTRYRES` text NOT NULL,
  `PARTNER_DIET` text NOT NULL,
  `PARTNER_DRINK` text NOT NULL,
  `PARTNER_ELEVEL` text NOT NULL,
  `PARTNER_ELEVEL_NEW` text NOT NULL,
  `PARTNER_INCOME` text NOT NULL,
  `PARTNER_MANGLIK` text NOT NULL,
  `PARTNER_MSTATUS` text NOT NULL,
  `PARTNER_MTONGUE` text NOT NULL,
  `PARTNER_OCC` text NOT NULL,
  `PARTNER_SMOKE` text NOT NULL,
  `PARTNER_RELATION` text NOT NULL,
  `PARTNER_RELIGION` text NOT NULL,
  `HAVEPHOTO` char(1) DEFAULT 'N',
  `LAST_LOGIN_DT` date NOT NULL,
  `HIV` char(1) NOT NULL,
  `ASTRO_ENTRY_DT` datetime DEFAULT NULL,
  UNIQUE KEY `PROFILEID` (`PROFILEID`),
  KEY `SEARCH1` (`AGE`),
  KEY `MTONGUE` (`MTONGUE`),
  KEY `CASTE` (`CASTE`),
  KEY `OCCUPATION` (`OCCUPATION`),
  KEY `HEIGHT` (`HEIGHT`),
  KEY `COUNTRY_RES` (`COUNTRY_RES`),
  KEY `srcind` (`MSTATUS`,`HEIGHT`,`AGE`,`CASTE`),
  KEY `ENTRY_DT` (`ENTRY_DT`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 MAX_ROWS=500000 AVG_ROW_LENGTH=400;

-- 
-- Dumping data for table `SEARCH_FEMALE_UNPAID`
-- 


-- --------------------------------------------------------
DROP TABLE IF EXISTS SEARCH_MALE_PAID;
-- 
-- Table structure for table `SEARCH_MALE_PAID`
-- 

CREATE TABLE `SEARCH_MALE_PAID` (
  `PROFILEID` mediumint(11) unsigned NOT NULL DEFAULT '0',
  `CASTE` smallint(8) unsigned DEFAULT '0',
  `RELIGION` tinyint(3) NOT NULL,
  `MANGLIK` char(1) NOT NULL DEFAULT '',
  `MTONGUE` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `MSTATUS` char(1) NOT NULL DEFAULT '',
  `OCCUPATION` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `COUNTRY_RES` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `COUNTRY_BIRTH` tinyint(3) NOT NULL DEFAULT '0',
  `CITY_RES` char(4) NOT NULL DEFAULT '',
  `HEIGHT` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `EDU_LEVEL` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `EDU_LEVEL_NEW` tinyint(4) NOT NULL DEFAULT '0',
  `MOD_DT` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DRINK` char(1) NOT NULL DEFAULT '',
  `SMOKE` char(1) NOT NULL DEFAULT '',
  `HAVECHILD` char(2) NOT NULL DEFAULT '',
  `RES_STATUS` char(1) NOT NULL DEFAULT '',
  `BTYPE` char(1) NOT NULL DEFAULT '',
  `COMPLEXION` char(1) NOT NULL DEFAULT '',
  `DIET` char(1) NOT NULL DEFAULT '',
  `HANDICAPPED` char(1) NOT NULL DEFAULT '',
  `AGE` tinyint(4) NOT NULL DEFAULT '0',
  `INCOME` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `RELATION` char(1) NOT NULL,
  `SORT_DT` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `PROFILE_SCORE` smallint(6) DEFAULT '0',
  `TOTAL_POINTS` mediumint(6) NOT NULL DEFAULT '0',
  `ENTRY_DT` date NOT NULL DEFAULT '0000-00-00',
  `BAND` tinyint(2) NOT NULL DEFAULT '0',
  `NUM` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `LAGE` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `HAGE` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `AGE_FILTER` char(1) NOT NULL DEFAULT 'N',
  `RELIGION_FILTER` char(1) NOT NULL DEFAULT 'N',
  `CASTE_FILTER` char(1) NOT NULL DEFAULT 'N',
  `MTONGUE_FILTER` char(1) NOT NULL DEFAULT 'N',
  `COUNTRY_RES_FILTER` char(1) NOT NULL DEFAULT 'N',
  `MSTATUS_FILTER` char(1) NOT NULL DEFAULT 'N',
  `INCOME_FILTER` char(1) NOT NULL DEFAULT 'N',
  `CITY_RES_FILTER` char(1) NOT NULL DEFAULT 'N',
  `DTOFBIRTH` date NOT NULL DEFAULT '0000-00-00',
  `INCOME_SORTBY` tinyint(4) NOT NULL,
  `PARTNER_CHILD` char(2) NOT NULL,
  `PARTNER_LAGE` tinyint(4) NOT NULL,
  `PARTNER_HAGE` tinyint(4) NOT NULL,
  `PARTNER_LHEIGHT` tinyint(3) NOT NULL,
  `PARTNER_HHEIGHT` tinyint(3) NOT NULL,
  `PARTNER_HANDICAPPED` char(1) NOT NULL,
  `PARTNER_BTYPE` text NOT NULL,
  `PARTNER_CASTE` text NOT NULL,
  `PARTNER_CITYRES` text NOT NULL,
  `PARTNER_COMP` text NOT NULL,
  `PARTNER_COUNTRYRES` text NOT NULL,
  `PARTNER_DIET` text NOT NULL,
  `PARTNER_DRINK` text NOT NULL,
  `PARTNER_ELEVEL` text NOT NULL,
  `PARTNER_ELEVEL_NEW` text NOT NULL,
  `PARTNER_INCOME` text NOT NULL,
  `PARTNER_MANGLIK` text NOT NULL,
  `PARTNER_MSTATUS` text NOT NULL,
  `PARTNER_MTONGUE` text NOT NULL,
  `PARTNER_OCC` text NOT NULL,
  `PARTNER_SMOKE` text NOT NULL,
  `PARTNER_RELATION` text NOT NULL,
  `PARTNER_RELIGION` text NOT NULL,
  `HAVEPHOTO` char(1) DEFAULT 'N',
  `LAST_LOGIN_DT` date NOT NULL,
  `HIV` char(1) NOT NULL,
  `ASTRO_ENTRY_DT` datetime DEFAULT NULL,
  UNIQUE KEY `PROFILEID` (`PROFILEID`),
  KEY `SEARCH1` (`AGE`),
  KEY `MTONGUE` (`MTONGUE`),
  KEY `CASTE` (`CASTE`),
  KEY `OCCUPATION` (`OCCUPATION`),
  KEY `HEIGHT` (`HEIGHT`),
  KEY `COUNTRY_RES` (`COUNTRY_RES`),
  KEY `srcind` (`MSTATUS`,`HEIGHT`,`AGE`,`CASTE`),
  KEY `ENTRY_DT` (`ENTRY_DT`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 MAX_ROWS=500000 AVG_ROW_LENGTH=400;

-- 
-- Dumping data for table `SEARCH_MALE_PAID`
-- 


-- --------------------------------------------------------
DROP TABLE IF EXISTS SEARCH_MALE_UNPAID;
-- 
-- Table structure for table `SEARCH_MALE_UNPAID`
-- 

CREATE TABLE `SEARCH_MALE_UNPAID` (
  `PROFILEID` mediumint(11) unsigned NOT NULL DEFAULT '0',
  `CASTE` smallint(8) unsigned DEFAULT '0',
  `RELIGION` tinyint(3) NOT NULL,
  `MANGLIK` char(1) NOT NULL DEFAULT '',
  `MTONGUE` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `MSTATUS` char(1) NOT NULL DEFAULT '',
  `OCCUPATION` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `COUNTRY_RES` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `COUNTRY_BIRTH` tinyint(3) NOT NULL DEFAULT '0',
  `CITY_RES` char(4) NOT NULL DEFAULT '',
  `HEIGHT` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `EDU_LEVEL` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `EDU_LEVEL_NEW` tinyint(4) NOT NULL DEFAULT '0',
  `MOD_DT` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DRINK` char(1) NOT NULL DEFAULT '',
  `SMOKE` char(1) NOT NULL DEFAULT '',
  `HAVECHILD` char(2) NOT NULL DEFAULT '',
  `RES_STATUS` char(1) NOT NULL DEFAULT '',
  `BTYPE` char(1) NOT NULL DEFAULT '',
  `COMPLEXION` char(1) NOT NULL DEFAULT '',
  `DIET` char(1) NOT NULL DEFAULT '',
  `HANDICAPPED` char(1) NOT NULL DEFAULT '',
  `AGE` tinyint(4) NOT NULL DEFAULT '0',
  `INCOME` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `RELATION` char(1) NOT NULL,
  `SORT_DT` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `PROFILE_SCORE` smallint(6) DEFAULT '0',
  `TOTAL_POINTS` mediumint(6) NOT NULL DEFAULT '0',
  `ENTRY_DT` date NOT NULL DEFAULT '0000-00-00',
  `BAND` tinyint(2) NOT NULL DEFAULT '0',
  `NUM` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `LAGE` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `HAGE` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `AGE_FILTER` char(1) NOT NULL DEFAULT 'N',
  `RELIGION_FILTER` char(1) NOT NULL DEFAULT 'N',
  `CASTE_FILTER` char(1) NOT NULL DEFAULT 'N',
  `MTONGUE_FILTER` char(1) NOT NULL DEFAULT 'N',
  `COUNTRY_RES_FILTER` char(1) NOT NULL DEFAULT 'N',
  `MSTATUS_FILTER` char(1) NOT NULL DEFAULT 'N',
  `INCOME_FILTER` char(1) NOT NULL DEFAULT 'N',
  `CITY_RES_FILTER` char(1) NOT NULL DEFAULT 'N',
  `DTOFBIRTH` date NOT NULL DEFAULT '0000-00-00',
  `INCOME_SORTBY` tinyint(4) NOT NULL,
  `PARTNER_CHILD` char(2) NOT NULL,
  `PARTNER_LAGE` tinyint(4) NOT NULL,
  `PARTNER_HAGE` tinyint(4) NOT NULL,
  `PARTNER_LHEIGHT` tinyint(3) NOT NULL,
  `PARTNER_HHEIGHT` tinyint(3) NOT NULL,
  `PARTNER_HANDICAPPED` char(1) NOT NULL,
  `PARTNER_BTYPE` text NOT NULL,
  `PARTNER_CASTE` text NOT NULL,
  `PARTNER_CITYRES` text NOT NULL,
  `PARTNER_COMP` text NOT NULL,
  `PARTNER_COUNTRYRES` text NOT NULL,
  `PARTNER_DIET` text NOT NULL,
  `PARTNER_DRINK` text NOT NULL,
  `PARTNER_ELEVEL` text NOT NULL,
  `PARTNER_ELEVEL_NEW` text NOT NULL,
  `PARTNER_INCOME` text NOT NULL,
  `PARTNER_MANGLIK` text NOT NULL,
  `PARTNER_MSTATUS` text NOT NULL,
  `PARTNER_MTONGUE` text NOT NULL,
  `PARTNER_OCC` text NOT NULL,
  `PARTNER_SMOKE` text NOT NULL,
  `PARTNER_RELATION` text NOT NULL,
  `PARTNER_RELIGION` text NOT NULL,
  `HAVEPHOTO` char(1) DEFAULT 'N',
  `LAST_LOGIN_DT` date NOT NULL,
  `HIV` char(1) NOT NULL,
  `ASTRO_ENTRY_DT` datetime DEFAULT NULL,
  UNIQUE KEY `PROFILEID` (`PROFILEID`),
  KEY `SEARCH1` (`AGE`),
  KEY `MTONGUE` (`MTONGUE`),
  KEY `CASTE` (`CASTE`),
  KEY `OCCUPATION` (`OCCUPATION`),
  KEY `HEIGHT` (`HEIGHT`),
  KEY `COUNTRY_RES` (`COUNTRY_RES`),
  KEY `srcind` (`MSTATUS`,`HEIGHT`,`AGE`,`CASTE`),
  KEY `ENTRY_DT` (`ENTRY_DT`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 MAX_ROWS=500000 AVG_ROW_LENGTH=400;

-- 
-- Dumping data for table `SEARCH_MALE_UNPAID`
-- 


-- --------------------------------------------------------
DROP TABLE IF EXISTS ZERO_KUNDLI;
-- 
-- Table structure for table `ZERO_KUNDLI`
-- 

CREATE TABLE `ZERO_KUNDLI` (
  `RECEIVER` int(2) unsigned NOT NULL,
  `DATE` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `ZERO_KUNDLI`
-- 

use MIS;

DROP TABLE IF EXISTS KUNDLI_MAILER_TRACKING;
-- 
-- Table structure for table `KUNDLI_MAILER_TRACKING`
-- 

CREATE TABLE `KUNDLI_MAILER_TRACKING` (
  `DATE` date NOT NULL,
  `PROFILES_CONSIDERED` mediumint(8) NOT NULL,
  `PROFILES_MAIL_SENT` mediumint(8) NOT NULL,
  `MAIL_OPEN` mediumint(8) NOT NULL,
  `UNSUBSCRIPTION` mediumint(8) NOT NULL,
  PRIMARY KEY (`DATE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

use newjs;

DROP TABLE IF EXISTS SUNSIGN_MATCHASTRO;
-- 
-- Table structure for table `SUNSIGN_MATCHASTRO`
-- 

CREATE TABLE `SUNSIGN_MATCHASTRO` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(50) DEFAULT NULL,
  `VALUE` int(3) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- 
-- Dumping data for table `SUNSIGN_MATCHASTRO`
-- 

INSERT INTO `SUNSIGN_MATCHASTRO` VALUES (1, 'Don''t Know', 1);
INSERT INTO `SUNSIGN_MATCHASTRO` VALUES (2, 'Aries', 2);
INSERT INTO `SUNSIGN_MATCHASTRO` VALUES (3, 'Taurus', 3);
INSERT INTO `SUNSIGN_MATCHASTRO` VALUES (4, 'Gemini', 4);
INSERT INTO `SUNSIGN_MATCHASTRO` VALUES (5, 'Cancer', 5);
INSERT INTO `SUNSIGN_MATCHASTRO` VALUES (6, 'Leo', 6);
INSERT INTO `SUNSIGN_MATCHASTRO` VALUES (7, 'Virgo', 7);
INSERT INTO `SUNSIGN_MATCHASTRO` VALUES (8, 'Libra', 8);
INSERT INTO `SUNSIGN_MATCHASTRO` VALUES (9, 'Scorpio', 9);
INSERT INTO `SUNSIGN_MATCHASTRO` VALUES (10, 'Sagittarius', 10);
INSERT INTO `SUNSIGN_MATCHASTRO` VALUES (11, 'Capricorn', 11);
INSERT INTO `SUNSIGN_MATCHASTRO` VALUES (12, 'Aquarius', 12);
INSERT INTO `SUNSIGN_MATCHASTRO` VALUES (13, 'Pisces', 13);
        

DROP TABLE IF EXISTS UNMATCHED_SUNSIGN_MATCHASTRO;
-- 
-- Table structure for table `UNMATCHED_SUNSIGN_MATCHASTRO`
-- 

CREATE TABLE `UNMATCHED_SUNSIGN_MATCHASTRO` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(50) DEFAULT NULL,
  `PROFILEID` mediumint(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `JPROFILE_ALERTS` ADD `KUNDLI_ALERT_MAILS` CHAR( 1 ) NOT NULL AFTER `CONTACT_ALERT_MAILS`;
