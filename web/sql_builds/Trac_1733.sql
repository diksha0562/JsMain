UPDATE `SERVICES` SET `SHOW_ONLINE` = 'Y' WHERE `SERVICEID` = 'P2' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'Y' WHERE `SERVICEID` = 'B2' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'Y' WHERE `SERVICEID` = 'D2' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'Y' WHERE `SERVICEID` = 'C2' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'Y' WHERE `SERVICEID` = 'A2' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'Y' WHERE `SERVICEID` = 'T2' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'Y' WHERE `SERVICEID` = 'M2' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'Y' WHERE `SERVICEID` = 'L2' LIMIT 1 ;

UPDATE `SERVICES` SET `SHOW_ONLINE` = 'N' WHERE `SERVICEID` = 'P3' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'N' WHERE `SERVICEID` = 'B3' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'N' WHERE `SERVICEID` = 'D3' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'N' WHERE `SERVICEID` = 'C3' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'N' WHERE `SERVICEID` = 'A3' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'N' WHERE `SERVICEID` = 'T3' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'N' WHERE `SERVICEID` = 'M3' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'N' WHERE `SERVICEID` = 'L3' LIMIT 1 ;

UPDATE `SERVICES` SET `SHOW_ONLINE` = 'Y' WHERE `SERVICEID` = 'P4' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'Y' WHERE `SERVICEID` = 'B4' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'Y' WHERE `SERVICEID` = 'D4' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'Y' WHERE `SERVICEID` = 'C4' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'Y' WHERE `SERVICEID` = 'A4' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'Y' WHERE `SERVICEID` = 'T4' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'Y' WHERE `SERVICEID` = 'M4' LIMIT 1 ;
UPDATE `SERVICES` SET `SHOW_ONLINE` = 'Y' WHERE `SERVICEID` = 'L4' LIMIT 1 ;

UPDATE `SERVICES` as a,`SERVICES` as b SET a.PRICE_RS_TAX=b.PRICE_RS_TAX,a.PRICE_DOL=b.PRICE_DOL,a.PRICE_RS=b.PRICE_RS WHERE a.SERVICEID='P2' and b.SERVICEID='P3';
UPDATE `SERVICES` as a,`SERVICES` as b SET a.PRICE_RS_TAX=b.PRICE_RS_TAX,a.PRICE_DOL=b.PRICE_DOL,a.PRICE_RS=b.PRICE_RS WHERE a.SERVICEID='B2' and b.SERVICEID='B3';
UPDATE `SERVICES` as a,`SERVICES` as b SET a.PRICE_RS_TAX=b.PRICE_RS_TAX,a.PRICE_DOL=b.PRICE_DOL,a.PRICE_RS=b.PRICE_RS WHERE a.SERVICEID='D2' and b.SERVICEID='D3';
UPDATE `SERVICES` as a,`SERVICES` as b SET a.PRICE_RS_TAX=b.PRICE_RS_TAX,a.PRICE_DOL=b.PRICE_DOL,a.PRICE_RS=b.PRICE_RS WHERE a.SERVICEID='C2' and b.SERVICEID='C3';
UPDATE `SERVICES` as a,`SERVICES` as b SET a.PRICE_RS_TAX=b.PRICE_RS_TAX,a.PRICE_DOL=b.PRICE_DOL,a.PRICE_RS=b.PRICE_RS WHERE a.SERVICEID='A2' and b.SERVICEID='A3';
UPDATE `SERVICES` as a,`SERVICES` as b SET a.PRICE_RS_TAX=b.PRICE_RS_TAX,a.PRICE_DOL=b.PRICE_DOL,a.PRICE_RS=b.PRICE_RS WHERE a.SERVICEID='T2' and b.SERVICEID='T3';
UPDATE `SERVICES` as a,`SERVICES` as b SET a.PRICE_RS_TAX=b.PRICE_RS_TAX,a.PRICE_DOL=b.PRICE_DOL,a.PRICE_RS=b.PRICE_RS WHERE a.SERVICEID='M2' and b.SERVICEID='M3';
UPDATE `SERVICES` as a,`SERVICES` as b SET a.PRICE_RS_TAX=b.PRICE_RS_TAX,a.PRICE_DOL=b.PRICE_DOL,a.PRICE_RS=b.PRICE_RS WHERE a.SERVICEID='L2' and b.SERVICEID='L3';

