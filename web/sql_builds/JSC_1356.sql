USE billing;

UPDATE billing.SERVICES SET SHOW_ONLINE='N' WHERE SERVICEID LIKE 'M%';
UPDATE billing.SERVICES SET SHOW_ONLINE='N' WHERE SERVICEID LIKE 'B%';