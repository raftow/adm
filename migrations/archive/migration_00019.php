<?php
$server_db_prefix = AfwSession::currentDBPrefix();

// medali transaction fees moodule
AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.`financial_transaction`");
AfwDatabase::db_query("CREATE TABLE ".$server_db_prefix."adm.`financial_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `created_at`   datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `validated_by` int(11) DEFAULT NULL,
  `validated_at` datetime DEFAULT NULL,
  `active` char(1) NOT NULL,
  `draft` char(1) NOT NULL default 'Y',
  `version` int(4) DEFAULT NULL,
  `update_groups_mfk` varchar(255) DEFAULT NULL,
  `delete_groups_mfk` varchar(255) DEFAULT NULL,
  `display_groups_mfk` varchar(255) DEFAULT NULL,
  `sci_id` int(11) DEFAULT NULL,
  
  `lookup_code` varchar(64) DEFAULT NULL,  
   fee_code varchar(6)  NOT NULL , 
   fee_description_ar varchar(30)  NOT NULL , 
   fee_description_en varchar(20)  DEFAULT NULL , 
   sis_charge_code varchar(20)  DEFAULT NULL , 
   sis_payment_code varchar(20)  DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
  
//  AfwDatabase::db_query("create unique index uk_financial_transaction on ".$server_db_prefix."adm.financial_transaction(fee_code)");

  AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.financial_transaction (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `lookup_code`, `fee_code`, `fee_description_ar`, `fee_description_en`, `sis_charge_code`, `sis_payment_code`) VALUES
(1, 1, '2024-11-02 14:51:01', 1, '2024-11-02 14:51:01', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'F001', 'رسوم التقديم', 'Application Fees', NULL, NULL),
(2, 1, '2024-11-02 14:51:01', 1, '2024-11-02 14:51:01', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'F002', 'الرسوم الإدارية', 'inistrative Fees', NULL, NULL),
(3, 1, '2024-11-02 14:51:01', 1, '2024-11-02 14:51:01', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'F003', 'رسوم اختبار الإنجليزية', 'English Test Evaluat', NULL, NULL),
(4, 1, '2024-11-02 14:51:41', 1, '2024-11-02 14:51:41', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'F004', 'رسوم الدراسة', 'Tuition Fees', NULL, NULL);");

AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.`application_model_financial_transaction`");

  AfwDatabase::db_query("CREATE TABLE ".$server_db_prefix."adm.`application_model_financial_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `created_at`   datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `validated_by` int(11) DEFAULT NULL,
  `validated_at` datetime DEFAULT NULL,
  `active` char(1) NOT NULL,
  `draft` char(1) NOT NULL default 'Y',
  `version` int(4) DEFAULT NULL,
  `update_groups_mfk` varchar(255) DEFAULT NULL,
  `delete_groups_mfk` varchar(255) DEFAULT NULL,
  `display_groups_mfk` varchar(255) DEFAULT NULL,
  `sci_id` int(11) DEFAULT NULL,
  
    
   financial_transaction_id int(11) NOT NULL , 
   application_model_id int(11) NOT NULL , 
   amount float NOT NULL , 
   process_enabled char(1) DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("create unique index uk_application_model_financial_transaction on ".$server_db_prefix."adm.application_model_financial_transaction(financial_transaction_id,application_model_id,amount);");

AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.`applicant_account`");


AfwDatabase::db_query("CREATE TABLE ".$server_db_prefix."adm.`applicant_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `created_at`   datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `validated_by` int(11) DEFAULT NULL,
  `validated_at` datetime DEFAULT NULL,
  `active` char(1) NOT NULL,
  `draft` char(1) NOT NULL default 'Y',
  `version` int(4) DEFAULT NULL,
  `update_groups_mfk` varchar(255) DEFAULT NULL,
  `delete_groups_mfk` varchar(255) DEFAULT NULL,
  `display_groups_mfk` varchar(255) DEFAULT NULL,
  `sci_id` int(11) DEFAULT NULL,
  
    
   applicant_id int(11) NOT NULL , 
   application_id int(11) NOT NULL , 
   application_model_financial_transaction_id int(11) NOT NULL , 
   total_amount   float NOT NULL , 
   payment_status_enum smallint NOT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

AfwDatabase::db_query("create unique index uk_applicant_account on ".$server_db_prefix."adm.applicant_account(applicant_id,application_id,application_model_financial_transaction_id);");


AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.`applicant_payment`");

AfwDatabase::db_query("CREATE TABLE ".$server_db_prefix."adm.`applicant_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `created_at`   datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `validated_by` int(11) DEFAULT NULL,
  `validated_at` datetime DEFAULT NULL,
  `active` char(1) NOT NULL,
  `draft` char(1) NOT NULL default 'Y',
  `version` int(4) DEFAULT NULL,
  `update_groups_mfk` varchar(255) DEFAULT NULL,
  `delete_groups_mfk` varchar(255) DEFAULT NULL,
  `display_groups_mfk` varchar(255) DEFAULT NULL,
  `sci_id` int(11) DEFAULT NULL,
  
    
   applicant_account_id int(11) NOT NULL , 
   amount   float NOT NULL , 
   payment_status_enum smallint NOT NULL , 
   payment_method_enum smallint NOT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

AfwDatabase::db_query("create unique index uk_applicant_payment on ".$server_db_prefix."adm.applicant_payment(applicant_account_id,amount);");





