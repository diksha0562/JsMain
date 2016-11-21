USE billing;

CREATE TABLE billing.GATEWAY_RESPONSE_LOG (
  ID int(11) NOT NULL AUTO_INCREMENT,
  PROFILEID int(11) DEFAULT NULL,
  ORDER_ID int(11) DEFAULT NULL,
  ORDER_STR varchar(50) DEFAULT NULL,
  GATEWAY varchar(15) DEFAULT NULL,
  RESPONSE_MSG text,
  ENTRY_DT datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  DUP varchar(10) DEFAULT NULL,
  RET varchar(10) DEFAULT NULL,
  PRIMARY KEY (ID),
  KEY PROFILEID (PROFILEID),
  KEY ORDER_ID (ORDER_ID)
) ENGINE=InnoDB;