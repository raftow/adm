<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
try
{
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.institution add   Institution_description_ar text  NOT NULL  AFTER postal_code;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.institution add   Institution_description_en text  NOT NULL  AFTER Institution_description_ar;");
    
    
}catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}