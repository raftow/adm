<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
          
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant_scholarship add   add scholarship_type int(11) DEFAULT NULL AFTER scholarship_id;");
}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}    