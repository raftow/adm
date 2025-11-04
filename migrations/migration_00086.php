<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
    
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.tuition_base add   currency_ar varchar(16)  NOT NULL DEFAULT ''  AFTER degree_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.tuition_base add   currency_en varchar(16)  NOT NULL DEFAULT ''  AFTER currency_ar;");


    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_term add   last_date_upload_doc datetime DEFAULT NULL  AFTER maqbool_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_term add   last_date_tuitfee datetime DEFAULT NULL  AFTER last_date_upload_doc;");

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_term add   hijri_last_date_upload_doc varchar(8) DEFAULT NULL  AFTER hijri_sorting_end_date;");

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_term add   hijri_last_date_tuitfee varchar(8) DEFAULT NULL  AFTER hijri_last_date_upload_doc;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_program add   Study_plan int(11) DEFAULT NULL  AFTER program_file_id");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model add   admission_guide int(11) DEFAULT NULL  AFTER training_hours;");
}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}