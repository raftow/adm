<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{

        AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_program add  supp_program_mfk varchar(255) DEFAULT NULL  AFTER program_instructions_en;");
        AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_term add   current_period_id int(11) DEFAULT NULL  AFTER term_name_en;");

}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}