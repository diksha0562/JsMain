USE jsadmin;

CREATE TABLE `SEM_CUSTOM_REG_PAGE` (
 `PAGE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `TITLE` text,
 `CONTENT` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
 `TIME` datetime NOT NULL,
 PRIMARY KEY (`PAGE_ID`)
); 