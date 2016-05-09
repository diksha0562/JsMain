USE reg;

INSERT INTO `REG_EDIT_PAGE_FIELDS` ( `PAGE` , `FIELD_ID` , `GROUP` , `TABLE_NAME` , `LABEL` , `BLANK_VALUE` , `BLANK_LABEL` )
VALUES (
'DP1', '7', 'b', 'JPROFILE:PINCODE', 'Pincode<u>*</u> :', '', ''
);

INSERT INTO `PROFILE_FIELDS` ( `ID` , `FIELD_NAME` , `TYPE` , `CONSTRAINT_CLASS` , `JAVASCRIPT_VALIDATION` , `DEPENDENT_FIELD` , `LABEL` )
VALUES (
'7', 'PINCODE', 'text', 'pin', 'validate_pin', '10', 'Pincode'
);