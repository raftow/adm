<?php

// in applicants - المتقدمون
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'applicant_file', 198, "+t", "qsearch", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'application_desire', 198, "+t", "qsearch", null);

$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'employee_scope', 201, "+t", "qsearch", null);

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");


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
