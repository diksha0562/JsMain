use MOBILE_API;
ALTER TABLE  MOBILE_API.`DIGEST_NOTIFICATIONS` CHANGE  `SCHEDULED_DATE`  `SCHEDULED_DATE` DATETIME DEFAULT NULL;
ALTER TABLE  MOBILE_API.`DIGEST_NOTIFICATIONS` DROP INDEX  `PROFILEID`;
ALTER TABLE  MOBILE_API.`DIGEST_NOTIFICATIONS` ADD UNIQUE  `PROFILEID` (  `PROFILEID` ,  `NOTIFICATION_KEY` )