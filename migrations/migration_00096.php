<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
           
            AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_program add   interview_ind char(1) NOT NULL DEFAULT 'W'  AFTER 	program_tuition_fees;");
            
}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}    