use MIS;

CREATE TABLE `SEM_PAGE_CUSTOMIZE` (
  `ID` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `SOURCE` varchar(10) NOT NULL,
  `DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `PAGE` varchar(10) NOT NULL,
  `BOX` varchar(10) NOT NULL,
  `CONTENT` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `IMAGE` text NOT NULL,
  `ACTIVE` varchar(1) DEFAULT 'Y',
  PRIMARY KEY (`ID`),
  KEY `SOURCE` (`SOURCE`)
);

        
