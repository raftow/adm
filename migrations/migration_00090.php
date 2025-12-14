<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application add signup_acknowldgment char(1) DEFAULT NULL;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   training_period_enum smallint NOT NULL DEFAULT 0  AFTER academic_program_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   application_plan_branch_mfk varchar(255) DEFAULT NULL  AFTER study_funding_status_id;");

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   qual_country_id int(11) NOT NULL DEFAULT 0  AFTER adm_file_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   grading_scale_id int(11) DEFAULT NULL  AFTER country_id;");


    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   qualification_id int(11) NOT NULL DEFAULT 0  AFTER gender_enum;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   major_category_id int(11) NOT NULL DEFAULT 0  AFTER qualification_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   major_path_id int(11) NOT NULL DEFAULT 0  AFTER major_category_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   qualification_major_id int(11) DEFAULT NULL  AFTER major_path_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   gpa float NOT NULL DEFAULT 0.0  AFTER qualification_major_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   gpa_from smallint DEFAULT NULL  AFTER gpa;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   date datetime NOT NULL DEFAULT '19800101'  AFTER gpa_from;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   adm_file_id int(11) DEFAULT NULL  AFTER date;");
    


    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   rating_overpass_gdate datetime DEFAULT NULL  AFTER track_overpass_user_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   rating_overpass char(1) DEFAULT NULL  AFTER study_funding_status_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   rating_overpass_user_id int(11) DEFAULT NULL  AFTER track_overpass;");

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   track_overpass_gdate datetime DEFAULT NULL  AFTER track_overpass_user_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nomination_letter add   application_simulation_id int(11) NOT NULL DEFAULT 1  AFTER application_plan_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   application_plan_id int(11) DEFAULT NULL  AFTER nomination_letter_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   application_simulation_id int(11) NOT NULL DEFAULT 1  AFTER application_plan_id;");

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   track_overpass char(1) DEFAULT NULL  AFTER study_funding_status_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   track_overpass_user_id int(11) DEFAULT NULL  AFTER track_overpass;");


    // 194 - المؤهلات - 
    $migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'major_path', 194, "+t", "qsearch", null);

    // remove bad BFs
    // $migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'adm_orgunit', 201, "-t", "stats", null);

    
}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}    