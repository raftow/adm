<?php

// 198 ادارة المتقدمين 
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'applicant_group', 198, "+t", "qsearch", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'application_simulation', 198, "+t", "qsearch", null);


$server_db_prefix = AfwSession::currentDBPrefix();


/* 
  par securite :
  AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.sorting_path;");
  AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.applicant_group;");
  AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.application_simulation;");
*/

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`sorting_path` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `created_at`   datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `validated_by` int(11) DEFAULT NULL,
  `validated_at` datetime DEFAULT NULL,
  `active` char(1) NOT NULL,
  `draft` char(1) NOT NULL default  'Y' ,
  `version` int(4) DEFAULT NULL,
  `update_groups_mfk` varchar(255) DEFAULT NULL,
  `delete_groups_mfk` varchar(255) DEFAULT NULL,
  `display_groups_mfk` varchar(255) DEFAULT NULL,
  `sci_id` int(11) DEFAULT NULL,
  
    
   application_model_id int(11) NOT NULL , 
   sorting_path_code varchar(16)  NOT NULL , 
   name_ar varchar(128)  NOT NULL , 
   desc_ar text  DEFAULT NULL , 
   name_en varchar(128)  NOT NULL , 
   desc_en text  DEFAULT NULL , 
   capacity_pct decimal(5,2) DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("CREATE unique index uk_sorting_path on ".$server_db_prefix."adm.sorting_path(application_model_id,sorting_path_code);");




AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`applicant_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `created_at`   datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `validated_by` int(11) DEFAULT NULL,
  `validated_at` datetime DEFAULT NULL,
  `active` char(1) NOT NULL,
  `draft` char(1) NOT NULL default  'Y' ,
  `version` int(4) DEFAULT NULL,
  `update_groups_mfk` varchar(255) DEFAULT NULL,
  `delete_groups_mfk` varchar(255) DEFAULT NULL,
  `display_groups_mfk` varchar(255) DEFAULT NULL,
  `sci_id` int(11) DEFAULT NULL,
  
    
   name_ar varchar(128)  NOT NULL , 
   desc_ar text  DEFAULT NULL , 
   name_en varchar(128)  NOT NULL , 
   desc_en text  DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.applicant_group SET id=1, name_ar = _utf8'مجموعة محاكاة التقديم', name_en = 'Application simulation group', desc_ar = _utf8'', desc_en = '', created_by = 1, updated_by = 1, validated_by = 0, active = 'Y', draft = 'Y', sci_id = 0, created_at = '2025-03-13 15:21:04', updated_at = '2025-03-13 15:21:04', `version` = 1");




AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`application_simulation` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `created_at`   datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `validated_by` int(11) DEFAULT NULL,
  `validated_at` datetime DEFAULT NULL,
  `active` char(1) NOT NULL,
  `draft` char(1) NOT NULL default  'Y' ,
  `version` int(4) DEFAULT NULL,
  `update_groups_mfk` varchar(255) DEFAULT NULL,
  `delete_groups_mfk` varchar(255) DEFAULT NULL,
  `display_groups_mfk` varchar(255) DEFAULT NULL,
  `sci_id` int(11) DEFAULT NULL,
  
    
   name_ar varchar(128)  NOT NULL , 
   name_en varchar(128)  NOT NULL , 
   application_model_id int(11) DEFAULT NULL , 
   applicant_group_id int(11) DEFAULT NULL , 
   simul_method_enum smallint NOT NULL , 
   nb_desires smallint DEFAULT NULL , 
   application_model_branch_mfk varchar(255) DEFAULT NULL , 
   settings text  DEFAULT NULL , 
   log text  DEFAULT NULL ,  

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant add   application_model_id int(11) DEFAULT NULL;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant add   applicant_group_id int(11) DEFAULT NULL;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant add   application_model_branch_mfk varchar(128) DEFAULT NULL;");









  
