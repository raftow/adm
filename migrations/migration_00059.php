<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
try
{
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant add   Profile_populated char(1) DEFAULT NULL  AFTER application_model_branch_mfk;");
    
}catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}