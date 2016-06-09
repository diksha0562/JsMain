use MOBILE_API;

CREATE TABLE `DIGEST_NOTIFICATIONS` (
  `ID` int(12) NOT NULL AUTO_INCREMENT,
  `PROFILEID` int(12) NOT NULL,
  `NOTIFICATION_KEY` varchar(20) NOT NULL,
  `SCHEDULED_DATE` date NOT NULL,
  PRIMARY KEY (`ID`),
  KEY SCHEDULED_DATE (`SCHEDULED_DATE`)
);

INSERT INTO MOBILE_API.APP_NOTIFICATIONS VALUES (40, 'EOI_DIGEST', "You received {EOI_COUNT} more interests. Respond to them with an 'Accept' or 'Decline'", 4, 'ALL', 'Y', 'I', 0, 0, 'MULTIPLE', 'Y', 604800, 'A', 'A', 'Interests Received
', 'D');


