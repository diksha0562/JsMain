use incentive;
CREATE TABLE incentive.`SALES_PROCESS_WISE_TRACKING_HEAD_COUNT` ( `MONTH_YR` varchar(10) NOT NULL, `INBOUND_TELE` int(11) NOT NULL, `CENTER_SALES` int(11) NOT NULL, `FP_TELE` int(11) NOT NULL, `CENTRAL_RENEW_TELE` int(11) NOT NULL, `FIELD_SALES` int(11) NOT NULL, `FRANCHISEE_SALES` int(11) NOT NULL, `OUTBOUND_TELE` int(11) NOT NULL, `RCB_TELE` int(11) NOT NULL, `UNASSISTED_SALES` int(11) NOT NULL, PRIMARY KEY (`MONTH_YR`))  COMMENT =  'Table linked to SALES_PROCESS_WISE_TRACKING';