<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
          
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant_scholarship add   grant_committee_interview_score smallint DEFAULT NULL  AFTER remarks;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant_scholarship add   grant_committee_letter int(11) DEFAULT NULL  AFTER grant_committee_interview_score;");
}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}    