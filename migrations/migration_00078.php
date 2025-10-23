<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model_branch
        CHANGE `branch_name_ar` `branch_name_ar` varchar(256) COLLATE 'utf8mb3_unicode_ci' NOT NULL DEFAULT '' AFTER `branch_order`,
        CHANGE `branch_name_en` `branch_name_en` varchar(256) COLLATE 'utf8mb3_unicode_ci' NULL AFTER `is_open`;");

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_plan_branch add   gender_enum smallint NOT NULL DEFAULT 0  AFTER application_plan_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_plan_branch add   training_period_enum smallint NOT NULL DEFAULT 0  AFTER gender_enum;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_program_offering add   training_period_enum smallint NOT NULL DEFAULT 0  AFTER sorting_group_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model_branch add   training_period_enum smallint NOT NULL DEFAULT 0  AFTER gender_enum;");
    AfwDatabase::db_query("CREATE UNIQUE INDEX uk_application_plan_branch on ".$server_db_prefix."adm.application_plan_branch(application_plan_id,gender_enum,training_period_enum,program_offering_id);");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model_branch drop index uk_application_model_branch;");
    AfwDatabase::db_query("CREATE UNIQUE INDEX uk_application_model_branch on ".$server_db_prefix."adm.application_model_branch(application_model_id,program_offering_id,gender_enum,training_period_enum);");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.program_track add   doc_type_mfk varchar(255) NOT NULL DEFAULT ','  AFTER sorting_formula;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model add   doc_type_mfk varchar(255) NOT NULL DEFAULT ','  AFTER eval_type_mfk;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model_branch change   gender_enum gender_enum smallint NOT NULL DEFAULT 0  AFTER academic_program_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model_branch change   branch_order branch_order smallint NOT NULL DEFAULT 0  AFTER application_model_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model_branch change   branch_name_ar branch_name_ar varchar(128)  NOT NULL DEFAULT ''  AFTER branch_order;");
    

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.qualification change   gpa_from gpa_from smallint NOT NULL DEFAULT 0  AFTER maqbool_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.qualification change   qualifcation_name_ar qualifcation_name_ar varchar(64)  NOT NULL DEFAULT ''  AFTER id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.qualification change   qualifcation_name_en qualifcation_name_en varchar(64)  NOT NULL DEFAULT ''  AFTER qualifcation_name_ar;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.qualification change   level_enum level_enum smallint NULL AFTER qualifcation_name_en;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.qualification change   maqbool_id maqbool_id varchar(10)  NOT NULL DEFAULT ''  AFTER level_enum;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.qualification change   gpa_from gpa_from smallint NOT NULL DEFAULT 0  AFTER maqbool_id;");
    AfwDatabase::db_query("CREATE unique index uk_qualification on ".$server_db_prefix."adm.qualification(sis_code);");

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   qsearch char(1) DEFAULT NULL  AFTER formula_field_3_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   retrieve char(1) DEFAULT NULL  AFTER qsearch;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   edit char(1) DEFAULT NULL  AFTER retrieve;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   qedit char(1) DEFAULT NULL  AFTER edit;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   readonly char(1) DEFAULT NULL  AFTER qedit;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   mandatory char(1) DEFAULT NULL  AFTER readonly;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   step smallint DEFAULT NULL  AFTER mandatory;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   width_pct smallint DEFAULT NULL  AFTER step;");
    
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."pag.atable modify column atable_name varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."pag.atable CHANGE `key_field` `key_field` varchar(128) COLLATE 'latin1_swedish_ci' NULL AFTER `titre_u_en`;");

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."hrm.orgunit
                        CHANGE `titre_short_en` `titre_short_en` varchar(96) COLLATE 'utf8mb3_general_ci' NULL AFTER `titre`,
                        CHANGE `titre_en` `titre_en` varchar(255) COLLATE 'utf8mb3_general_ci' NULL AFTER `titre_short_en`;");
}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}    