USE incentive;

CREATE TABLE incentive.CRM_AGENT_CHECKIN_CHECKOUT_LOG (
ID INT( 11 ) NOT NULL AUTO_INCREMENT ,
AGENT_NAME VARCHAR( 30 ) ,
LOG_TYPE ENUM( "CHECKIN", "CHECKOUT" ) ,
LATITUDE VARCHAR( 20 ) ,
LONGITUDE VARCHAR( 20 ) ,
DATE_TIME DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL ,
PRIMARY KEY ( ID ) ,
INDEX ( AGENT_NAME , LOG_TYPE , DATE_TIME )
);