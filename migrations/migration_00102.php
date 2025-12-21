<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
          

    
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_program add   cv_ind char(1) DEFAULT NULL  AFTER interview_ind;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model_engagement add   degree_id int(11) DEFAULT NULL  AFTER engagement_type_id;");
    
}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}    