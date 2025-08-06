<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
    AfwDatabase::db_query(" ALTER TABLE ".$server_db_prefix."adm.applicant_evaluation add   need_evaluation_enum smallint DEFAULT NULL  AFTER eval_level;");
    
    
}catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}