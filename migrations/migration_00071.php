<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
try
{

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.service_request add   request_status_id int(11) NOT NULL  AFTER application_plan_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.service_request add   request_type_id int(11) NOT NULL  AFTER request_status_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.service_request add   status_comment text  NOT NULL  AFTER request_type_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.service_request add   status_date datetime DEFAULT NULL  AFTER status_comment;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.service_request add   applicant_id int(11) NOT NULL  AFTER status_date;");
    
}catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}