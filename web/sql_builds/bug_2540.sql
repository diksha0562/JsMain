use billing;

UPDATE billing.COMPONENTS SET TYPE='C',DURATION='12' WHERE COMPID LIKE 'I%';
update billing.SERVICES SET DURATION='12' WHERE SERVICEID LIKE 'I%';