use billing;

INSERT IGNORE INTO billing.DISCOUNT_HISTORY_BACKUP SELECT * FROM billing.DISCOUNT_HISTORY WHERE DATE < "2017-04-10";

/* before running this ensure backup done*/
DELETE FROM billing.DISCOUNT_HISTORY WHERE DATE<"2017-04-10";

ALTER TABLE billing.`LIGHTNING_DEAL_DISCOUNT` CHANGE  `ENTRY_DT`  `ENTRY_DT` DATETIME DEFAULT NULL