use newjs;
ALTER TABLE `JPROFILE` ADD `ID_PROOF_TYP` CHAR(1),
			   ADD  `ID_PROOF_NO` VARCHAR(30);
ALTER TABLE `EDIT_LOG` ADD `ID_PROOF_TYP` CHAR(1),
               ADD  `ID_PROOF_NO` VARCHAR(30);
