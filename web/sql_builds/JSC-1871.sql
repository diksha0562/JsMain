use billing;
CREATE TABLE `CURRENT_GATEWAY` ( `ID` int(11) NOT NULL AUTO_INCREMENT, `GATEWAY` varchar(15) NOT NULL, `CHANGED_BY` varchar(30) NOT NULL, `ENTRY_DT` datetime NOT NULL, PRIMARY KEY (`ID`), KEY `ENTRY_DT` (`ENTRY_DT`)) ENGINE=InnoDB;
INSERT INTO  billing.`CURRENT_GATEWAY` (`GATEWAY` ,  `CHANGED_BY` ,  `ENTRY_DT` )VALUES ('default',  'default', NOW( ));

