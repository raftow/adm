<?php
$server_db_prefix = AfwSession::config("db_prefix", "default_db_");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`sponsor_type` (
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
   sponsor_type_name_ar varchar(100)  NOT NULL , 
   sponsor_type_name_en varchar(100)  NOT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

AfwDatabase::db_query("create unique index uk_sponsor_type on ".$server_db_prefix."adm.sponsor_type(sponsor_type_name_ar,sponsor_type_name_en)");



AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`sponsor` (
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
    
      
     sponsor_type_id int(11) NOT NULL , 
     sponsor_name_ar varchar(100)  NOT NULL , 
     sponsor_name_en varchar(100)  NOT NULL , 
     sponsor_email varchar(30)  DEFAULT NULL , 
     sponsor_phone varchar(20)  DEFAULT NULL , 
     sponsor_adress varchar(100)  DEFAULT NULL , 
  
    
    PRIMARY KEY (`id`)
  ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
  
  AfwDatabase::db_query("create unique index uk_sponsor on ".$server_db_prefix."adm.sponsor(sponsor_name_ar,sponsor_name_en);");


  AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`scholarship` (
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
    
      
     scholarship_name_ar varchar(100)  NOT NULL , 
     scholarship_name_en varchar(100)  NOT NULL , 
     scholarship_code varchar(20)  NOT NULL , 
     scholarship_type smallint NOT NULL , 
     percentage float DEFAULT NULL , 
     cap_amount float DEFAULT NULL , 
     sponsor_id int(11) NOT NULL , 
     scholarship_date datetime DEFAULT NULL , 
     adm_file_id int(11) DEFAULT NULL , 
     publish char(1) DEFAULT NULL , 
     application_start_date datetime DEFAULT NULL , 
     application_end_date datetime DEFAULT NULL , 
     academic_year smallint DEFAULT NULL , 
     academic_term smallint DEFAULT NULL , 
  
    
    PRIMARY KEY (`id`)
  ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
  
  
  AfwDatabase::db_query("create unique index uk_scholarship on ".$server_db_prefix."adm.scholarship(scholarship_name_ar,scholarship_name_en,scholarship_code);");


  AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`scholarship_bill` (
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
    
      
     scholarship_id int(11) NOT NULL , 
     financial_transaction_id int(11) NOT NULL , 
     percentage float DEFAULT NULL , 
     amount float DEFAULT NULL , 
     remarks varchar(250)  DEFAULT NULL , 
  
    
    PRIMARY KEY (`id`)
  ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
  
  AfwDatabase::db_query("create unique index uk_scholarship_bill on ".$server_db_prefix."adm.scholarship_bill(scholarship_id,financial_transaction_id);");


  AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`applicant_scholarship_status` (
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
     scholarship_status_ar varchar(100)  NOT NULL , 
     scholarship_status_en varchar(100)  NOT NULL , 
  
    
    PRIMARY KEY (`id`)
  ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
  
  AfwDatabase::db_query("create unique index uk_applicant_scholarship_status on ".$server_db_prefix."adm.applicant_scholarship_status(scholarship_status_ar,scholarship_status_en);");

  AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`applicant_scholarship` (
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
     scholarship_id int(11) NOT NULL , 
     applicant_scholarship_status_id float DEFAULT NULL , 
     application_id float DEFAULT NULL , 
     academic_term_id int(11) DEFAULT NULL , 
     academic_year_id int(11) DEFAULT NULL , 
     academic_program_id int(11) DEFAULT NULL , 
     remarks varchar(250)  DEFAULT NULL , 
  
    
    PRIMARY KEY (`id`)
  ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
  
   AfwDatabase::db_query("create unique index uk_applicant_scholarship on pmu_adm.applicant_scholarship(applicant_id,scholarship_id);");
  
    
  
   AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.`applicant_scholarship_status` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `lookup_code`, `scholarship_status_ar`, `scholarship_status_en`) VALUES
   (1, 1, '2024-12-22 14:48:37', 1, '2024-12-22 14:48:37', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'مصروفة', 'awarded'),
   (2, 1, '2024-12-22 14:50:44', 1, '2024-12-22 14:50:44', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'مقبولة', 'Applied'),
   (3, 1, '2024-12-22 14:50:44', 1, '2024-12-22 14:50:44', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'قيد المعالجة', 'pending'),
   (4, 1, '2024-12-22 14:50:44', 1, '2024-12-22 14:50:44', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'مرفوضة', 'rejected');");
 
   AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.`sponsor_type` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `lookup_code`, `sponsor_type_name_ar`, `sponsor_type_name_en`) VALUES
   (1, 1, '2024-12-22 16:10:38', 1, '2024-12-22 16:10:38', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'الجهات الحكومية', 'Government agencies'),
   (2, 1, '2024-12-22 16:10:38', 1, '2024-12-22 16:10:38', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'الجامعات', 'Universities'),
   (3, 1, '2024-12-22 16:10:38', 1, '2024-12-22 16:10:38', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'المنظمات غير الحكومية والمنظمات غير الربحية', 'Non-Governmental Organizations (NGOs) and Non-Profits'),
   (4, 1, '2024-12-22 16:11:48', 1, '2024-12-22 16:11:48', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'الجمعيات المهنية والتجارية', 'Professional and Trade Associations'),
   (5, 1, '2024-12-22 16:11:48', 1, '2024-12-22 16:11:48', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'الشركات والمؤسسات التجارية', 'Corporations and Businesses'),
   (6, 1, '2024-12-22 16:11:48', 1, '2024-12-22 16:11:48', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'الجماعات المحلية والمدنية', 'Community and Civic Groups'),
   (7, 1, '2024-12-22 16:12:53', 1, '2024-12-22 16:12:53', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'المنظمات الدينية', 'Religious Organizations'),
   (8, 1, '2024-12-22 16:12:53', 1, '2024-12-22 16:12:53', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'المؤسسات والهيئات العامة', 'Public institutions and authorities'),
   (9, 1, '2024-12-22 16:12:53', 1, '2024-12-22 16:12:53', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'المنظمات العسكرية والدفاعية', 'Military and Defense Organizations'),
   (10, 1, '2024-12-22 16:13:55', 1, '2024-12-22 16:13:55', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'الأفراد', 'Individuals'),
   (11, 1, '2024-12-22 16:13:55', 1, '2024-12-22 16:13:55', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'الجماعات الثقافية أو العرقية', 'Cultural or Ethnic Groups'),
   (12, 1, '2024-12-22 16:13:55', 1, '2024-12-22 16:13:55', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'المنظمات الرياضية', 'Sports organizations');");
   