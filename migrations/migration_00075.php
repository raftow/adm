<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
try
{

    
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant_qualification add   country_id int(11) NOT NULL  AFTER adm_file_id;");
    
}catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}