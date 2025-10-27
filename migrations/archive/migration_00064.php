<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_level add   target_audience_ar varchar(32)  NOT NULL  AFTER academic_level_instructions_en;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_level add   target_audience_en varchar(32)  NOT NULL  AFTER target_audience_ar;");
    
    
}catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}