<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant_qualification add   source_name varchar(48)  DEFAULT NULL  AFTER source;");
    
}catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}