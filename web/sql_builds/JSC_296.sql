use MOBILE_API;

CREATE TABLE `SENT_NOTIFICATIONS_COUNT` (
 `PROFILEID` int(12) NOT NULL,
 `COUNT` int(10) NOT NULL,
  PRIMARY KEY (`PROFILEID`)
)  ENGINE=MyISAM DEFAULT CHARSET=latin1;