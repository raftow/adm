<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{

    
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.institution add   application_simulation_id int(11) NOT NULL  AFTER simulation_applicants_ids;");
    
}catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}