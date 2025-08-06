<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.qualification_major change   qualification_major_name_ar qualification_major_name_ar varchar(100)  NOT NULL  AFTER display_groups_mfk;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.qualification_major change   qualification_major_name_en qualification_major_name_en varchar(100)  NOT NULL  AFTER qualification_major_name_ar;");
    
}catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}