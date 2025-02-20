<?php
// rafik applicant tables partionned
AfwDatabase::db_query("RENAME TABLE `c0adm`.`applicant` TO `c0adm`.`applicant_before`;");

AfwDatabase::db_query("CREATE TABLE `c0adm`.`applicant` (
    `id` bigint(20) NOT NULL,
    `created_by` int(11) NOT NULL,
    `created_at` datetime NOT NULL,
    `updated_by` int(11) NOT NULL,
    `updated_at` datetime NOT NULL,
    `validated_by` int(11) DEFAULT NULL,
    `validated_at` datetime DEFAULT NULL,
    `active` char(1) NOT NULL,
    `draft` char(1) NOT NULL DEFAULT 'Y',
    `version` int(4) DEFAULT NULL,
    `update_groups_mfk` varchar(255) DEFAULT NULL,
    `delete_groups_mfk` varchar(255) DEFAULT NULL,
    `display_groups_mfk` varchar(255) DEFAULT NULL,
    `sci_id` int(11) DEFAULT NULL,
    `email` varchar(25) DEFAULT NULL,
    `mobile` varchar(25) DEFAULT NULL,
    `country_id` int(11) DEFAULT NULL,
    `idn_type_id` smallint(6) DEFAULT NULL,
    `idn` varchar(16) DEFAULT NULL,
    `id_issue_place` varchar(30) DEFAULT NULL,
    `id_issue_date` datetime DEFAULT NULL,
    `id_expiry_date` datetime DEFAULT NULL,
    `religion_enum` smallint(6) DEFAULT NULL,
    `gender_enum` smallint(6) DEFAULT NULL,
    `mother_saudi_ind` char(1) NOT NULL,
    `mother_idn` varchar(30) DEFAULT NULL,
    `mother_birth_date` varchar(8) DEFAULT NULL,
    `passeport_num` varchar(32) DEFAULT NULL,
    `passeport_expiry_gdate` datetime DEFAULT NULL,
    `first_name_ar` varchar(32) DEFAULT NULL,
    `father_name_ar` varchar(32) DEFAULT NULL,
    `middle_name_ar` varchar(32) DEFAULT NULL,
    `last_name_ar` varchar(32) DEFAULT NULL,
    `first_name_en` varchar(32) DEFAULT NULL,
    `father_name_en` varchar(32) DEFAULT NULL,
    `middle_name_en` varchar(32) DEFAULT NULL,
    `last_name_en` varchar(32) DEFAULT NULL,
    `birth_date` varchar(8) DEFAULT NULL,
    `birth_gdate` datetime DEFAULT NULL,
    `place_of_birth` varchar(32) DEFAULT NULL,
    `marital_status_enum` smallint(6) DEFAULT NULL,
    `profile_approved` char(1) DEFAULT NULL,
    `address_type_enum` smallint(6) DEFAULT NULL,
    `address` varchar(200) DEFAULT NULL,
    `city_id` int(11) DEFAULT NULL,
    `postal_code` varchar(10) DEFAULT NULL,
    `country_code` varchar(10) DEFAULT NULL,
    `username` varchar(16) DEFAULT NULL,
    `password` varchar(16) DEFAULT NULL,
    `signup_acknowldgment` char(1) DEFAULT NULL,
    `has_iban` char(1) DEFAULT NULL,
    `iban` varchar(25) DEFAULT NULL,
    `bank_account_pledge` char(1) DEFAULT NULL,
    `job_status_enum` smallint(6) DEFAULT NULL,
    `employer_approval` char(1) DEFAULT NULL,
    `employer_enum` smallint(6) DEFAULT NULL,
    `employer_approval_afile_id` int(11) DEFAULT NULL,
    `guardian_name` varchar(25) DEFAULT NULL,
    `guardian_phone` varchar(25) DEFAULT NULL,
    `guardian_idn` varchar(16) DEFAULT NULL,
    `guardian_id_date` datetime DEFAULT NULL,
    `guardian_id_place` varchar(25) DEFAULT NULL,
    `relationship_enum` smallint(6) DEFAULT NULL,
    `attribute_1` char(1) DEFAULT NULL,
    `attribute_2` varchar(64) DEFAULT NULL,
    `attribute_3` datetime DEFAULT NULL,
    `attribute_4` char(1) DEFAULT NULL,
    `attribute_5` char(1) DEFAULT NULL,
    `attribute_6` varchar(64) DEFAULT NULL,
    `attribute_7` char(1) DEFAULT NULL,
    `attribute_8` char(1) DEFAULT NULL,
    `attribute_9` varchar(64) DEFAULT NULL,
    `attribute_11` char(1) DEFAULT NULL,
    `attribute_12` char(1) DEFAULT NULL,
    `attribute_13` char(1) DEFAULT NULL,
    `attribute_14` char(1) DEFAULT NULL,
    `attribute_15` char(1) DEFAULT NULL,
    `attribute_16` char(1) DEFAULT NULL,
    `attribute_17` datetime DEFAULT NULL,
    `attribute_18` char(1) DEFAULT NULL,
    `attribute_19` int(11) DEFAULT NULL,
    `attribute_20` varchar(64) DEFAULT NULL,
    `attribute_21` char(1) DEFAULT NULL,
    `attribute_22` char(1) DEFAULT NULL,
    `attribute_23` char(1) DEFAULT NULL,
    `attribute_24` char(1) DEFAULT NULL,
    `attribute_25` char(1) DEFAULT NULL,
    `attribute_26` char(1) DEFAULT NULL,
    `attribute_27` char(1) DEFAULT NULL,
    `attribute_28` char(1) DEFAULT NULL,
    `attribute_29` smallint(6) DEFAULT NULL,
    `attribute_30` datetime DEFAULT NULL,
    `attribute_31` smallint(6) DEFAULT NULL,
    `attribute_32` datetime DEFAULT NULL,
    `attribute_33` smallint(6) DEFAULT NULL,
    `attribute_34` datetime DEFAULT NULL,
    `attribute_35` smallint(6) DEFAULT NULL,
    `attribute_36` datetime DEFAULT NULL,
    `attribute_37` datetime DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
  PARTITION BY HASH (`id`)
  PARTITIONS 100;");

AfwDatabase::db_query("INSERT into `c0adm`.`applicant` select * from `c0adm`.`applicant_before`;"); 

AfwDatabase::db_query("ALTER TABLE `applicant` ADD PRIMARY KEY (`id`);"); 

AfwDatabase::db_query("CREATE INDEX applicant_mobile on `applicant`(mobile);"); 

AfwDatabase::db_query("CREATE INDEX applicant_email on `applicant`(email);"); 

/*
ALTER TABLE `applicant` DROP PRIMARY KEY;

ALTER TABLE `applicant` DROP INDEX applicant_mobile; 

ALTER TABLE `applicant` DROP INDEX applicant_email;

-- ALTER TABLE `applicant` ADD PRIMARY KEY (`id`);
-- CREATE INDEX applicant_mobile on `applicant`(mobile); 
-- CREATE INDEX applicant_email on `applicant`(email);
*/
