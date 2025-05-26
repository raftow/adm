<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
try
{
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant_file add   document_type_id int(11) DEFAULT NULL  AFTER doc_type_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.service_request add   application_plan_id int(11) NOT NULL  AFTER applicant_file_id;");

    
}catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}