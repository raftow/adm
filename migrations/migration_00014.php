<?php


AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS c0adm.`recommendation_letter` (
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
   recommender_name varchar(30)  NOT NULL , 
   mobile varchar(30)  NOT NULL , 
   email varchar(30)  NOT NULL , 
   occupation varchar(30)  NOT NULL , 
   organization_name varchar(30)  NOT NULL , 
   lor_type char(1) DEFAULT NULL , 
   adm_file_id int(11) DEFAULT NULL , 
   status char(1) DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

// unique index : 
AfwDatabase::db_query("create unique index uk_recommendation_letter on c0adm.recommendation_letter(applicant_id,recommender_name,mobile,email,occupation,organization_name,lor_type,adm_file_id,status);");



AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS c0adm.`application_recommendation` (
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
  
    
   recommendation_letter_id int(11) NOT NULL , 
   application_id smallint NOT NULL , 
   lor_status_enum char(1) NOT NULL , 
   notification_sent char(1) DEFAULT NULL , 
   notification_date datetime DEFAULT NULL , 
   notification_type_enum varchar(30)  DEFAULT NULL , 
   approval_user_id int(11) DEFAULT NULL , 
   comments text  DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("create unique index uk_application_recommendation on c0adm.application_recommendation(recommendation_letter_id,application_id);");

