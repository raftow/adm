<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{

        AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.program_qualification add   bridging_fees_comment varchar(255)  DEFAULT NULL  AFTER bridging_fees;");

}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}