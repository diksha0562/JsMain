use jeevansathi_mailer;
UPDATE `MAILER_SUBJECT` SET `SUBJECT_CODE` = 'Member <var>{{USERNAME:profileid=~$otherProfileId`}}</var> has sent you personal messages' WHERE `MAIL_ID` = '1759' AND CONVERT(`SUBJECT_TYPE` USING utf8) = 'D' AND CONVERT(`SUBJECT_CODE` USING utf8) = 'Member <var>{{USERNAME:profileid=~$otherProfileId`}}</var> has sent you a personal message' AND CONVERT(`DESCRIPTION` USING utf8) = 'Subject for mail on receiving a message' LIMIT 1;