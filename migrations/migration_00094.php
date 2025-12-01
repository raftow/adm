<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
           AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add  country_id int(11) DEFAULT NULL  AFTER Mobile;");
        
    
}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}    