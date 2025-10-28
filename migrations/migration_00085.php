<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
    
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_level change   target_audience_ar target_audience_ar varchar(200)  NOT NULL DEFAULT ''  AFTER academic_level_instructions_en;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_level change   target_audience_en target_audience_en varchar(200)  NOT NULL DEFAULT ''  AFTER target_audience_ar;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.degree add   target_audience_ar varchar(200)  NOT NULL DEFAULT ''  AFTER degree_name_en;");

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.degree add   target_audience_en varchar(200)  NOT NULL DEFAULT ''  AFTER target_audience_ar;");

}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}