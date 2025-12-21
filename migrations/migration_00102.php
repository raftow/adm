<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
          

    
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_program add   cv_ind char(1) DEFAULT NULL  AFTER interview_ind;");

    
}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}    