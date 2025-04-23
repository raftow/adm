<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");


AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   formula_field_1_id int(11) NOT NULL  AFTER field_size;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   formula_field_2_id int(11) DEFAULT NULL  AFTER formula_field_1_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   formula_field_3_id int(11) DEFAULT NULL  AFTER formula_field_2_id;");

AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.`application_field` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `field_name`, `shortname`, `application_table_id`, `application_field_type_id`, `field_title_ar`, `field_title_en`, `usable_in_conditions`, `reel`, `additional`, `unit`, `unit_en`, `field_order`, `field_num`, `field_size`, `formula_field_1_id`, `formula_field_2_id`, `formula_field_3_id`, `help_text`, `help_text_en`, `question_text`, `question_text_en`) VALUES
(111233, 1, '2025-04-22 14:14:18', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', 4, NULL, NULL, NULL, NULL, 'aptitude_score', '', 1, 16, 'درجة القدرات العامة', 'aptitude_score', 'Y', 'N', 'N', '', '', 580, NULL, 32, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(111234, 1, '2025-04-22 14:14:18', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', 4, NULL, NULL, NULL, NULL, 'achievement_score', '', 1, 16, 'درجة التحصيلي', 'achievement_score', 'Y', 'N', 'N', '', '', 630, NULL, 32, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(111235, 1, '2025-04-22 14:14:18', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', 2, NULL, NULL, NULL, NULL, 'secondary_cumulative_pct', '', 1, 16, 'درجة الثانوية التراكمية', 'secondary_cumulative_pct', 'Y', 'N', 'N', '', '', 680, NULL, 32, 0, NULL, NULL, NULL, NULL, NULL, NULL);");


AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_group add   field1_sorting_sens_enum smallint DEFAULT NULL  AFTER sorting_field_3_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_group add   field2_sorting_sens_enum smallint DEFAULT NULL  AFTER field1_sorting_sens_enum;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_group add   field3_sorting_sens_enum smallint DEFAULT NULL  AFTER field2_sorting_sens_enum;");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_group add   formula_field_1_id int(11) NOT NULL  AFTER field3_sorting_sens_enum;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_group add   formula_field_2_id int(11) DEFAULT NULL  AFTER formula_field_1_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_group add   formula_field_3_id int(11) DEFAULT NULL  AFTER formula_field_2_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_group add   formula_field_4_id int(11) NOT NULL  AFTER formula_field_3_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_group add   formula_field_5_id int(11) DEFAULT NULL  AFTER formula_field_4_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_group add   formula_field_6_id int(11) DEFAULT NULL  AFTER formula_field_5_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_group add   formula_field_7_id int(11) NOT NULL  AFTER formula_field_6_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_group add   formula_field_8_id int(11) DEFAULT NULL  AFTER formula_field_7_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_group add   formula_field_9_id int(11) DEFAULT NULL  AFTER formula_field_8_id;");


AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire add   sorting_value_1 float DEFAULT NULL  AFTER comments;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire add   sorting_value_2 float DEFAULT NULL  AFTER sorting_value_1;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire add   sorting_value_3 float DEFAULT NULL  AFTER sorting_value_2;");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire add   formula_value_1 float DEFAULT NULL  AFTER sorting_value_3;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire add   formula_value_2 float DEFAULT NULL  AFTER formula_value_1;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire add   formula_value_3 float DEFAULT NULL  AFTER formula_value_2;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire add   formula_value_4 float DEFAULT NULL  AFTER formula_value_3;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire add   formula_value_5 float DEFAULT NULL  AFTER formula_value_4;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire add   formula_value_6 float DEFAULT NULL  AFTER formula_value_5;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire add   formula_value_7 float DEFAULT NULL  AFTER formula_value_6;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire add   formula_value_8 float DEFAULT NULL  AFTER formula_value_7;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire add   formula_value_9 float DEFAULT NULL  AFTER formula_value_8;");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model_branch add   sorting_group_id int(11) DEFAULT NULL  AFTER program_offering_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire add   sorting_group_id int(11) DEFAULT NULL  AFTER training_unit_type_id;");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_program_offering add   sorting_group_id int(11) DEFAULT NULL  AFTER degree_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire add   application_model_branch_id int(11) NOT NULL  AFTER application_plan_branch_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.program_track add   sorting_group_id int(11) DEFAULT NULL  AFTER sorting_formula;");

AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.academic_program_offering po set po.program_track_id=(select p.program_track_id from ".$server_db_prefix."adm.academic_program p where p.id = po.academic_program_id);");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.academic_program_offering po set po.academic_level_id=(select p.academic_level_id from ".$server_db_prefix."adm.academic_program p where p.id = po.academic_program_id);");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.academic_program_offering po set po.degree_id=(select p.degree_id from ".$server_db_prefix."adm.academic_program p where p.id = po.academic_program_id);");


AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.academic_program_offering po set po.sorting_group_id=(select pt.sorting_group_id from ".$server_db_prefix."adm.program_track pt where pt.id = po.program_track_id);");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.application_model_branch amb set amb.sorting_group_id=(select po.sorting_group_id from ".$server_db_prefix."adm.academic_program_offering po where po.id = amb.program_offering_id);");

AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.application_desire ad set ad.application_model_branch_id=(select apb.application_model_branch_id from ".$server_db_prefix."adm.application_plan_branch apb where apb.id = ad.application_plan_branch_id) where  ad.application_model_branch_id is null or  ad.application_model_branch_id = 0;");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.application_desire ad set ad.sorting_group_id=(select amb.sorting_group_id from ".$server_db_prefix."adm.application_model_branch amb where amb.id = ad.application_model_branch_id) where  ad.sorting_group_id is null or  ad.sorting_group_id = 0;");



AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_simulation add   blocked_applicants_mfk varchar(255) DEFAULT NULL  AFTER application_plan_id;");

/* AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.sorting_session;");*/

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`sorting_session` (
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
  
  application_plan_id int(11) DEFAULT NULL , 
  session_num smallint DEFAULT NULL , 

  application_simulation_id int(11) NOT NULL DEFAULT 2,

    
  name_ar varchar(128)  NOT NULL , 
  name_en varchar(128)  NOT NULL , 
   
  start_date datetime DEFAULT NULL , 
  end_date datetime DEFAULT NULL , 
  validated char(1) DEFAULT NULL , 
  validate_date datetime DEFAULT NULL , 
  published char(1) NOT NULL DEFAULT 'N', 
  publish_date datetime DEFAULT NULL , 
  last_approve_date datetime DEFAULT NULL , 
  upgraded char(1) NOT NULL DEFAULT 'N', 
  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

// AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_session DROP index uk_sorting_session");

AfwDatabase::db_query("CREATE unique index uk_sorting_session on ".$server_db_prefix."adm.sorting_session(application_plan_id,session_num);");



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