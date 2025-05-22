<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
try
{
    AfwDatabase::db_query(" ALTER TABLE ".$server_db_prefix."adm.service_item change  service_item_name_en service_item_name_en varchar(100) NOT NULL AFTER service_item_name_ar;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.service_item change   upload_file_ind upload_file_ind char(1) DEFAULT NULL  AFTER service_item_name_en;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.service_item change   document_type_mfk document_type_mfk varchar(255) DEFAULT NULL  AFTER upload_file_ind;");
    
    
}catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}