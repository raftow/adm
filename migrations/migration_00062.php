<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");


AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`application_desire`
CHANGE `gender_enum` `gender_enum` smallint NULL AFTER `sci_id`,
CHANGE `idn` `idn` varchar(32) COLLATE 'utf8mb3_unicode_ci' NULL AFTER `applicant_id`,
CHANGE `application_model_id` `application_model_id` int NULL AFTER `application_simulation_id`,
CHANGE `academic_level_id` `academic_level_id` int NULL AFTER `application_model_id`,
CHANGE `application_model_branch_id` `application_model_branch_id` int NULL AFTER `application_plan_branch_id`,
CHANGE `step_num` `step_num` smallint NULL AFTER `health_ind`;");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.api_endpoint add   import char(1) DEFAULT NULL  AFTER published;");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.api_endpoint set import = 'N' where import  is null;");

/* AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.sorting_session;"); */

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
  started_ind char(1) NOT NULL DEFAULT 'N',
  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

// AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_session DROP index uk_sorting_session");

AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.sorting_session set started_ind = 'N'");  
AfwDatabase::db_query("CREATE unique index uk_sorting_session on ".$server_db_prefix."adm.sorting_session(application_plan_id,session_num);");

AfwDatabase::db_query("CREATE unique index uk_application on ".$server_db_prefix."adm.application(applicant_id,application_plan_id,application_simulation_id);");
AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.`sorting_group` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `name_ar`, `desc_ar`, `name_en`, `desc_en`, `sorting_field_1_id`, `sorting_field_2_id`, `sorting_field_3_id`, `field1_sorting_sens_enum`, `field2_sorting_sens_enum`, `field3_sorting_sens_enum`, `formula_field_1_id`, `formula_field_2_id`, `formula_field_3_id`, `formula_field_4_id`, `formula_field_5_id`, `formula_field_6_id`, `formula_field_7_id`, `formula_field_8_id`, `formula_field_9_id`) VALUES
(1, 1, '2025-04-14 17:18:25', 1, '2025-04-22 14:43:34', 0, NULL, 'Y', 'Y', 4, '', '', '', 1, 'الفرز عبر النسبة الموزونة', '', 'Sorting via weighted ratio', '', 110953, 0, 0, 1, NULL, NULL, 111235, 111233, 111234, 0, NULL, NULL, 0, NULL, NULL);");



AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire CHANGE `track_num` `track_num` smallint NULL AFTER `major_category_id`;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire CHANGE `desire_status_enum` `desire_status_enum` smallint NULL AFTER `application_step_id`;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model_field add   answer char(1) DEFAULT NULL  AFTER duration_expiry;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model_field add   is_mandatory char(1) NOT NULL  AFTER answer;");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.application_model_field set is_mandatory = 'Y' where mandatory is null;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application add   weighted_pctg float DEFAULT NULL  AFTER applicant_qualification_id;");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.application set weighted_pctg = 1.1 where weighted_pctg is null");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`application_field` CHANGE `formula_field_1_id` `formula_field_1_id` int NULL AFTER `field_size`;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."pag.`afield_option_value` CHANGE `id_mod` `id_mod` int NULL AFTER `date_aut`, CHANGE `option_value_comments` `option_value_comments` text COLLATE 'utf8mb3_unicode_ci' NULL AFTER `option_value`;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."pag.`foption`
                            CHANGE `foption_desc_en` `foption_desc_en` text COLLATE 'utf8mb3_unicode_ci' NULL AFTER `foption_desc_ar`,
                            CHANGE `id_mod` `id_mod` int NULL AFTER `date_aut`,
                            CHANGE `afield_type_mfk` `afield_type_mfk` varchar(255) COLLATE 'utf8mb3_unicode_ci' NULL AFTER `foption_name_en`,
                            CHANGE `foption_type` `foption_type` smallint NULL AFTER `afield_type_mfk`;");

