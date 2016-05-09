USE billing;

INSERT INTO billing.SERVICES VALUES (NULL, 'X1', 'JS Exclusive - 1 months', '', 1, 10234.95, 11500, 171, 'Y', 'X1', 'PX1', 'N', 158, 'N', 'Y', 'Y', 'N', ' ');
INSERT INTO billing.SERVICES VALUES (NULL, 'X2', 'JS Exclusive - 2 months', '', 2, 15574.93, 17500, 323, 'Y', 'X2', 'PX2', 'N', 159, 'N', 'Y', 'Y', 'N', ' ');
INSERT INTO billing.SERVICES VALUES (NULL, 'X4', 'JS Exclusive - 4 months', '', 4, 19579.92, 22000, 418, 'Y', 'X4', 'PX4', 'N', 161, 'N', 'Y', 'Y', 'N', ' ');
INSERT INTO billing.SERVICES VALUES (NULL, 'X5', 'JS Exclusive - 5 months', '', 5, 20914.91, 23500, 456, 'Y', 'X5', 'PX5', 'N', 162, 'N', 'Y', 'Y', 'N', ' ');
INSERT INTO billing.SERVICES VALUES (NULL, 'X7', 'JS Exclusive - 7 months', '', 7, 24919.90, 28000, 532, 'Y', 'X7', 'PX7', 'N', 164, 'N', 'Y', 'Y', 'N', ' ');
INSERT INTO billing.SERVICES VALUES (NULL, 'X8', 'JS Exclusive - 8 months', '', 8, 29369.88, 33000, 589, 'Y', 'X8', 'PX8', 'N', 165, 'N', 'Y', 'Y', 'N', ' ');
INSERT INTO billing.SERVICES VALUES (NULL, 'X9', 'JS Exclusive - 9 months', '', 9, 31149.87, 35000, 615, 'Y', 'X9', 'PX9', 'N', 166, 'N', 'Y', 'Y', 'N', ' ');
INSERT INTO billing.SERVICES VALUES (NULL, 'X10', 'JS Exclusive - 10 months', '', 10, 32484.87, 36500, 700, 'Y', 'X10', 'PX10', 'N', 167, 'N', 'Y', 'Y', 'N', ' ');
INSERT INTO billing.SERVICES VALUES (NULL, 'X11', 'JS Exclusive - 11 months', '', 11, 33819.86, 38000, 800, 'Y', 'X11', 'PX11', 'N', 168, 'N', 'Y', 'Y', 'N', ' ');

UPDATE billing.SERVICES SET SORTBY=160, PACKAGE='Y', PACKID='PX3', ADDON='N' WHERE SERVICEID='X3';	
UPDATE billing.SERVICES SET SORTBY=163, PACKAGE='Y', PACKID='PX6', ADDON='N' WHERE SERVICEID='X6';
UPDATE billing.SERVICES SET SORTBY=169, PACKAGE='Y', PACKID='PX12', ADDON='N' WHERE SERVICEID='X12';

INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX1', 'F1');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX1', 'X1');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX2', 'F2');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX2', 'X2');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX3', 'F3');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX3', 'X3');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX4', 'F4');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX4', 'X4');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX5', 'F5');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX5', 'X5');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX6', 'F6');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX6', 'X6');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX7', 'F7');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX7', 'X7');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX8', 'F8');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX8', 'X8');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX9', 'F9');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX9', 'X9');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX10', 'F10');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX10', 'X10');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX11', 'F11');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX11', 'X11');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX12', 'F12');
INSERT INTO billing.PACK_COMPONENTS VALUES (NULL, 'PX12', 'X12');

INSERT INTO billing.COMPONENTS VALUES (NULL, 'X1', 'JS Exclusive - 1 months', '', 1, 11500, 171, 'X', 'D', 0);
INSERT INTO billing.COMPONENTS VALUES (NULL, 'X2', 'JS Exclusive - 2 months', '', 2, 17500, 323, 'X', 'D', 0);
INSERT INTO billing.COMPONENTS VALUES (NULL, 'X4', 'JS Exclusive - 4 months', '', 4, 22000, 418, 'X', 'D', 0);
INSERT INTO billing.COMPONENTS VALUES (NULL, 'X5', 'JS Exclusive - 5 months', '', 5, 23500, 456, 'X', 'D', 0);
INSERT INTO billing.COMPONENTS VALUES (NULL, 'X7', 'JS Exclusive - 7 months', '', 7, 28000, 532, 'X', 'D', 0);
INSERT INTO billing.COMPONENTS VALUES (NULL, 'X8', 'JS Exclusive - 8 months', '', 8, 33000, 589, 'X', 'D', 0);
INSERT INTO billing.COMPONENTS VALUES (NULL, 'X9', 'JS Exclusive - 9 months', '', 9, 35000, 615, 'X', 'D', 0);
INSERT INTO billing.COMPONENTS VALUES (NULL, 'X10', 'JS Exclusive - 10 months', '', 10, 36500, 700, 'X', 'D', 0);
INSERT INTO billing.COMPONENTS VALUES (NULL, 'X11', 'JS Exclusive - 11 months', '', 11, 38000, 800, 'X', 'D', 0);

INSERT INTO billing.DIRECT_CALL_COUNT VALUES ('X1', 10);
INSERT INTO billing.DIRECT_CALL_COUNT VALUES ('X2', 25);
INSERT INTO billing.DIRECT_CALL_COUNT VALUES ('X3', 75);
INSERT INTO billing.DIRECT_CALL_COUNT VALUES ('X4', 75);
INSERT INTO billing.DIRECT_CALL_COUNT VALUES ('X5', 100);
INSERT INTO billing.DIRECT_CALL_COUNT VALUES ('X6', 125);
INSERT INTO billing.DIRECT_CALL_COUNT VALUES ('X7', 140);
INSERT INTO billing.DIRECT_CALL_COUNT VALUES ('X8', 155);
INSERT INTO billing.DIRECT_CALL_COUNT VALUES ('X9', 175);
INSERT INTO billing.DIRECT_CALL_COUNT VALUES ('X10', 180);
INSERT INTO billing.DIRECT_CALL_COUNT VALUES ('X11', 190);
INSERT INTO billing.DIRECT_CALL_COUNT VALUES ('X12', 225);