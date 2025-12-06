<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{

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