<?php

// in applicants - المتقدمون
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'applicant_file', 198, "+t", "qsearch", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'application_desire', 198, "+t", "qsearch", null);

// 201 - الاشراف العام
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'employee_scope', 201, "+t", "qsearch", null);

// 180 - إعدادات القبول
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'sorting_group', 180, "+t", "qsearch", null);



$server_db_prefix = AfwSession::currentDBPrefix();

// par securite

// AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.sorting_branch;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`sorting_branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `created_at`   datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `validated_by` int(11) DEFAULT NULL,
  `validated_at` datetime DEFAULT NULL,
  `active` char(1) NOT NULL,
  `draft` char(1) NOT NULL default  'Y',
  `version` int(4) DEFAULT NULL,
  `update_groups_mfk` varchar(255) DEFAULT NULL,
  `delete_groups_mfk` varchar(255) DEFAULT NULL,
  `display_groups_mfk` varchar(255) DEFAULT NULL,
  `sci_id` int(11) DEFAULT NULL,
  
    
   application_plan_branch_id int(11) NOT NULL , 
   sorting_branch_code varchar(16)  NOT NULL , 
   name_ar varchar(128)  NOT NULL , 
   desc_ar text  DEFAULT NULL , 
   name_en varchar(128)  NOT NULL , 
   desc_en text  DEFAULT NULL , 
   capacity smallint DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("CREATE unique index uk_sorting_branch on ".$server_db_prefix."adm.sorting_branch(application_plan_branch_id,sorting_branch_code);");



/*AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.sorting_group;");*/

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`sorting_group` (
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
   sorting_field_1_id int(11) NOT NULL , 
   sorting_field_2_id int(11) NOT NULL , 
   sorting_field_3_id int(11) NOT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");



// par securite
/* AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.application_desire;");*/

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`application_desire` (
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
  
    
   gender_enum smallint DEFAULT NULL , 
   applicant_id int(11) NOT NULL , 
   idn varchar(32)  NOT NULL , 
   application_plan_id int(11) NOT NULL , 
   application_model_id int(11) NOT NULL , 
   academic_level_id int(11) NOT NULL , 
   desire_num smallint NOT NULL , 
   application_plan_branch_id int(11) NOT NULL , 
   training_unit_id int(11) DEFAULT NULL , 
   training_unit_type_id int(11) DEFAULT NULL , 
   application_id int(11) NOT NULL , 
   applicant_qualification_id int(11) DEFAULT NULL , 
   qualification_id int(11) DEFAULT NULL , 
   major_category_id int(11) DEFAULT NULL , 
   health_ind char(1) DEFAULT NULL , 
   step_num smallint NOT NULL , 
   application_step_id int(11) DEFAULT NULL , 
   desire_status_enum smallint NOT NULL , 
   comments varchar(128)  DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("CREATE unique index uk_application_desire on ".$server_db_prefix."adm.application_desire(applicant_id,application_plan_id,desire_num);");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model add   split_sorting_by_enum smallint DEFAULT NULL  AFTER application_field_mfk;");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.application_model set split_sorting_by_enum = 1 where split_sorting_by_enum=0 or split_sorting_by_enum is null");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.adm_employee add   firstname varchar(32)  NOT NULL  AFTER employee_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.adm_employee add   lastname varchar(32)  NOT NULL  AFTER firstname;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.adm_employee add   lastname_en varchar(32)  NOT NULL  AFTER lastname;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.adm_employee add   firstname_en varchar(32)  NOT NULL  AFTER lastname_en;");


// AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.employee_scope;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`employee_scope` (
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
  
    
   adm_employee_id int(11) DEFAULT NULL , 
   start_date varchar(8) DEFAULT NULL , 
   end_date varchar(8) DEFAULT NULL , 
   academic_level_id int(11) DEFAULT NULL , 
   application_model_id int(11) DEFAULT NULL , 
   gender_enum smallint DEFAULT NULL , 
   training_unit_type_id int(11) DEFAULT NULL , 
   training_unit_id int(11) DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("CREATE unique index uk_employee_scope on ".$server_db_prefix."adm.employee_scope(start_date,end_date);");




AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant_file     add   approved char(1) DEFAULT NULL  AFTER afile_ext;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant_file     add   idn varchar(32) NOT NULL AFTER applicant_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire add   idn varchar(32) NOT NULL AFTER applicant_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application        add   idn varchar(32) NOT NULL AFTER applicant_id;");

AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.`applicant_file` set idn = applicant_id WHERE 1;");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.`application` set idn = applicant_id WHERE 1;");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.`application_desire` set idn = applicant_id WHERE 1;");
