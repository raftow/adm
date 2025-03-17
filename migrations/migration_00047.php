<?php

$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'adm_orgunit', 201, "-t", "stats", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'adm_employee', 201, "-t", "stats", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'adm_emp_request', 201, "-t", "stats", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'employee_scope', 201, "-t", "stats", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'institution', 193, "-t", "qedit", null);


$server_db_prefix = AfwSession::config("db_prefix", "default_db_");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`academic_term` CHANGE `aplication_start_date` `application_start_date` DATETIME NULL DEFAULT NULL;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application add application_simulation_id int(11) NOT NULL AFTER application_model_id;");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant add   log char(1) DEFAULT NULL  AFTER applicant_group_id;");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.application_simulation me SET updated_by = 1, updated_at = '2025-03-16 14:47:26', version = 3,  name_ar = _utf8'محاكاة التقديم التجريبية', name_en = 'Application test simulation', application_model_id = '0', applicant_group_id = '0', simul_method_enum = '1', nb_desires = '0' WHERE id = '1';");

AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.applicant_group SET id=2, name_ar = _utf8'مجموعة المتقدمين حقيقة', name_en = 'Real applicants group', desc_ar = _utf8'', desc_en = '', created_by = 1, updated_by = 1, validated_by = 0, active = 'Y', draft = 'Y', sci_id = 0, created_at = '2025-03-13 15:21:04', updated_at = '2025-03-13 15:21:04', `version` = 1");

AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.application_simulation SET id=2, name_ar = _utf8'تقديم حقيقي وليس محاكاة', name_en = 'Real application not a simulation', application_model_id = 0, applicant_group_id = 0, simul_method_enum = '1', settings = '', log = '', created_by = 1, updated_by = 1, validated_by = 0, active = 'Y', draft = 'Y', sci_id = 1, created_at = '2025-03-16 14:52:19', updated_at = '2025-03-16 14:52:19', version = 1");


AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.application_desire;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`application_desire` (
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
  
    
   gender_enum smallint NOT NULL , 
   applicant_id int(11) NOT NULL , 
   idn varchar(32)  NOT NULL , 
   application_plan_id int(11) NOT NULL , 
   application_simulation_id int(11) NOT NULL , 
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


 
AfwDatabase::db_query("CREATE unique index uk_application_desire on ".$server_db_prefix."adm.application_desire(applicant_id,application_plan_id,application_simulation_id,desire_num);");

AfwDatabase::db_query("CREATE unique index uk_big_application_desire on ".$server_db_prefix."adm.application_desire(applicant_id,application_plan_id,application_simulation_id,application_plan_branch_id);");



