<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
try
{
    AfwDatabase::db_query(" ALTER TABLE ".$server_db_prefix."adm.service_item modify column service_item_name_en varchar(100) NOT NULL ;");
    
    
}catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}