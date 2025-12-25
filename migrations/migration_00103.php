<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
          

    
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant_file add   reupload_enum smallint DEFAULT NULL  AFTER approved;");
    
}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}    