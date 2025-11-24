<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
           AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nomination_letter add   letter_code varchar(20)  NOT NULL  AFTER application_plan_id;");



        //create unique index uk_nomination_letter on nauss_adm.nomination_letter(application_plan_id,letter_code,nominating_authority_id);
           AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nomination_letter 
                            DROP INDEX uk_nomination_letter, 
                            ADD UNIQUE KEY `uk_nomination_letter` (application_plan_id,letter_code,nominating_authority_id)");
    
}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}    