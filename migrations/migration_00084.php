<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
    
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.program_qualification add   bridging_semester smallint DEFAULT NULL  AFTER bridging;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.program_qualification add   bridging_fees float DEFAULT NULL  AFTER bridging_semester;");

}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}