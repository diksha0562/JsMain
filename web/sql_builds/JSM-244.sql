use search;
CREATE TABLE `LATEST_SEARCHQUERY` (
  `ID` int(11) unsigned NOT NULL,
  `GENDER` char(1) NOT NULL DEFAULT '',
  `CASTE` text NOT NULL,
  `MTONGUE` text NOT NULL,
  `LAGE` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `HAGE` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `HAVEPHOTO` char(1) DEFAULT NULL,
  `MANGLIK` varchar(10) DEFAULT NULL,
  `MSTATUS` varchar(20) DEFAULT NULL,
  `HAVECHILD` varchar(20) DEFAULT NULL,
  `LHEIGHT` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `HHEIGHT` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `BTYPE` varchar(20) DEFAULT NULL,
  `COMPLEXION` varchar(20) DEFAULT NULL,
  `DIET` varchar(20) DEFAULT NULL,
  `SMOKE` varchar(20) DEFAULT NULL,
  `DRINK` varchar(20) DEFAULT NULL,
  `HANDICAPPED` varchar(20) DEFAULT NULL,
  `OCCUPATION` text NOT NULL,
  `COUNTRY_RES` text NOT NULL,
  `CITY_RES` text NOT NULL,
  `EDU_LEVEL` varchar(20) DEFAULT NULL,
  `KEYWORD` text NOT NULL,
  `DATE` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ONLINE` char(1) NOT NULL DEFAULT '',
  `SORT_LOGIC` char(1) DEFAULT NULL,
  `INCOME` text,
  `ROW_COUNT` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `RANK_ID` int(4) unsigned NOT NULL DEFAULT '0',
  `PROFILEID` int(11) unsigned NOT NULL DEFAULT '0',
  `SEARCH_TYPE` char(2) DEFAULT NULL,
  `SUBSCRIPTION` char(1) NOT NULL DEFAULT '',
  `RECORDCOUNT` mediumint(9) NOT NULL DEFAULT '0',
  `PAGECOUNT` mediumint(9) NOT NULL DEFAULT '0',
  `EDU_LEVEL_NEW` text,
  `KEYWORD_TYPE` varchar(5) NOT NULL,
  `CASTE_DISPLAY` text NOT NULL,
  `RELATION` varchar(20) DEFAULT NULL,
  `NEWSEARCH_CLUSTERING` text NOT NULL,
  `OCCUPATION_GROUPING` text,
  `EDUCATION_GROUPING` text,
  `RELIGION` varchar(30) DEFAULT NULL,
  `ORIGINAL_SID` int(11) NOT NULL,
  `CASTE_MAPPING` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `HOROSCOPE` char(1) DEFAULT NULL,
  `SPEAK_URDU` char(1) NOT NULL,
  `HIJAB_MARRIAGE` char(1) NOT NULL,
  `SAMPRADAY` varchar(10) NOT NULL DEFAULT '',
  `ZARATHUSHTRI` char(1) DEFAULT NULL,
  `AMRITDHARI` char(1) DEFAULT NULL,
  `CUT_HAIR` char(1) DEFAULT NULL,
  `MATHTHAB` varchar(30) DEFAULT NULL,
  `WORK_STATUS` varchar(30) DEFAULT NULL,
  `HIV` varchar(10) DEFAULT NULL,
  `NATURE_HANDICAP` varchar(30) DEFAULT NULL,
  `LIVE_PARENTS` char(1) NOT NULL,
  `SUBCASTE` text,
  `WEAR_TURBAN` varchar(10) NOT NULL DEFAULT '',
  `LINCOME` char(2) NOT NULL,
  `HINCOME` char(2) NOT NULL,
  `LINCOME_DOL` char(2) NOT NULL,
  `HINCOME_DOL` char(2) NOT NULL,
  `LAST_ACTIVITY` varchar(30) DEFAULT NULL,
  `CASTE_GROUP` varchar(200) DEFAULT NULL,
  `INDIA_NRI` varchar(10) DEFAULT NULL,
  `STATE` text,
  `CITY_INDIA` text NOT NULL,
  `MARRIED_WORKING` varchar(10) NOT NULL,
  `GOING_ABROAD` varchar(10) NOT NULL,
  `VIEWED` varchar(10) DEFAULT NULL,
  `NoRelaxParams` text,
  `WIFE_WORKING` char(1) DEFAULT NULL,
  `PROFILE_ADDED` varchar(20) NOT NULL,
  `LAST_LOGIN_DT` date NOT NULL,
  `ISEARCH_PROFILEID` int(11) unsigned DEFAULT NULL,
  `TRACKING_COOKIE_ID` varchar(20) NOT NULL,
  `MANGLIK_IGNORE` varchar(10) NOT NULL,
  `MSTATUS_IGNORE` varchar(20) NOT NULL,
  `HIV_IGNORE` varchar(10) NOT NULL,
  `HANDICAPPED_IGNORE` varchar(20) NOT NULL,
  `LVERIFY_ACTIVATED_DT` datetime NOT NULL,
  `HVERIFY_ACTIVATED_DT` datetime NOT NULL,
  `MATCHALERTS_DATE_CLUSTER` varchar(20) NOT NULL,
  `KUNDLI_DATE_CLUSTER` varchar(20) NOT NULL,
  `SEARCH_CHANNEL` enum('Desktop','MS','NewMS','Android','Ios') DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ProfileAndChannel` (`PROFILEID`,`SEARCH_CHANNEL`)
) ENGINE=MyISAM;