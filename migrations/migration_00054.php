<?php
if(!class_exists("AfwSession")) die("Denied access");
$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.program_track add   sorting_group_id int(11) DEFAULT NULL  AFTER sorting_formula;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model_branch add   sorting_group_id int(11) DEFAULT NULL  AFTER program_offering_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire add   sorting_group_id int(11) DEFAULT NULL  AFTER training_unit_type_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_simulation add   blocked_applicants_mfk varchar(255) DEFAULT NULL  AFTER application_plan_id;");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.prospect_desire add   done char(1) DEFAULT 'N';");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.prospect_desire set done='N' where done is null");
// AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.applicant_simulation;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`applicant_simulation` (
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
  
    
   application_simulation_id int(11) DEFAULT NULL , 
   applicant_id int(11) DEFAULT NULL , 
   done char(1) DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");



// unique index : 
AfwDatabase::db_query("CREATE unique index uk_applicant_simulation on ".$server_db_prefix."adm.applicant_simulation(application_simulation_id,applicant_id);");



AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_step change   step_code step_code varchar(3)  DEFAULT NULL  AFTER step_name_en;");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`screen_model` DROP `screen_title`");