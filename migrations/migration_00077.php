<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
try
{
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model_financial_transaction add   phase_enum smallint DEFAULT NULL  AFTER process_enabled;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant_payment add   payment_reference  varchar(128)  NOT NULL  AFTER payment_method_enum;");
    //AfwDatabase::db_query("CREATE TABLE ".$server_db_prefix."adm.application_tmp_76 as select * from ".$server_db_prefix."adm.application;");

    

}
catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}