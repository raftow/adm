<?php

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");

// par securite d'executer ce script par erreur je desactive le drop
AfwDatabase::db_query("DROP TABLE ".$server_db_prefix."adm.`application_desire`;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`application_desire` (
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
  `gender_enum` smallint(6) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `idn` varchar(32) NOT NULL,
  `application_plan_id` int(11) NOT NULL,
  `application_simulation_id` int(11) NOT NULL,
  `application_model_id` int(11) NOT NULL,
  `academic_level_id` int(11) NOT NULL,
  `desire_num` smallint(6) NOT NULL,
  `application_plan_branch_id` int(11) NOT NULL,
  `training_unit_id` int(11) DEFAULT NULL,
  `training_unit_type_id` int(11) DEFAULT NULL,
  `application_id` int(11) NOT NULL,
  `applicant_qualification_id` int(11) DEFAULT NULL,
  `qualification_id` int(11) DEFAULT NULL,
  `major_category_id` int(11) DEFAULT NULL,
  `health_ind` char(1) DEFAULT NULL,
  `step_num` smallint(6) NOT NULL,
  `application_step_id` int(11) DEFAULT NULL,
  `desire_status_enum` smallint(6) NOT NULL,
  `comments` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
PARTITION BY HASH (`applicant_id`)
PARTITIONS 200;");


AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`application_desire`
  ADD PRIMARY KEY (`applicant_id`,`application_plan_id`,`application_simulation_id`,`desire_num`),
  ADD UNIQUE KEY `uk_big_application_desire` (`applicant_id`,`application_plan_id`,`application_simulation_id`,`application_plan_branch_id`);");

AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.applicant set created_at='2020-01-01' where 1");   
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.applicant set updated_at='2020-01-01' where 1");   
// AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.applicant set validated_at='2020-01-01' where 1");   

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant change   attribute_29 qiyas_achievement_th float DEFAULT NULL  AFTER `log`;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant change   attribute_30 qiyas_achievement_th_date datetime DEFAULT NULL  AFTER qiyas_achievement_th;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant change   attribute_31 qiyas_aptitude_sc float DEFAULT NULL  AFTER qiyas_achievement_th_date;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant change   attribute_32 qiyas_aptitude_sc_date datetime DEFAULT NULL  AFTER qiyas_aptitude_sc;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant change   attribute_33 qiyas_aptitude_th float DEFAULT NULL  AFTER qiyas_aptitude_sc_date;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant change   attribute_34 qiyas_aptitude_th_date datetime DEFAULT NULL  AFTER qiyas_aptitude_th;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant change   attribute_35 qiyas_achievement_sc float DEFAULT NULL  AFTER qiyas_aptitude_th_date;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant change   attribute_36 qiyas_achievement_sc_date datetime DEFAULT NULL  AFTER qiyas_achievement_sc;");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant add   attribute_29 smallint DEFAULT NULL  AFTER attribute_28;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant add   attribute_30 smallint DEFAULT NULL  AFTER attribute_29;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant add   attribute_31 smallint DEFAULT NULL  AFTER attribute_30;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant add   attribute_32 smallint DEFAULT NULL  AFTER attribute_31;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant add   attribute_33 smallint DEFAULT NULL  AFTER attribute_32;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant add   attribute_34 smallint DEFAULT NULL  AFTER attribute_33;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant add   attribute_35 smallint DEFAULT NULL  AFTER attribute_34;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant add   attribute_36 smallint DEFAULT NULL  AFTER attribute_35;");


AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.application_field set field_name = 'qiyas_achievement_th' where application_table_id=1 and field_name = 'attribute_29'");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.application_field set field_name = 'qiyas_achievement_th_date' where application_table_id=1 and field_name = 'attribute_30'");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.application_field set field_name = 'qiyas_aptitude_sc' where application_table_id=1 and field_name = 'attribute_31'");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.application_field set field_name = 'qiyas_aptitude_sc_date' where application_table_id=1 and field_name = 'attribute_32'");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.application_field set field_name = 'qiyas_aptitude_th' where application_table_id=1 and field_name = 'attribute_33'");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.application_field set field_name = 'qiyas_aptitude_th_date' where application_table_id=1 and field_name = 'attribute_34'");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.application_field set field_name = 'qiyas_achievement_sc' where application_table_id=1 and field_name = 'attribute_35'");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.application_field set field_name = 'qiyas_achievement_sc_date' where application_table_id=1 and field_name = 'attribute_36'");





