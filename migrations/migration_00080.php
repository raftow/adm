<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
    AfwDatabase::db_query("create unique index uk_financial_transaction on ".$server_db_prefix."adm.financial_transaction(fee_code);");
    

}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}