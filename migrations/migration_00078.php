<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
try
{
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."pag.atable modify column atable_name varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;");
}
catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}    