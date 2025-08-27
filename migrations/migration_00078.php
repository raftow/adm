<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.qualification change   gpa_from gpa_from smallint NOT NULL DEFAULT 0  AFTER maqbool_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   qsearch char(1) DEFAULT NULL  AFTER formula_field_3_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   retrieve char(1) DEFAULT NULL  AFTER qsearch;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   edit char(1) DEFAULT NULL  AFTER retrieve;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   qedit char(1) DEFAULT NULL  AFTER edit;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   readonly char(1) DEFAULT NULL  AFTER qedit;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   mandatory char(1) DEFAULT NULL  AFTER readonly;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   step smallint DEFAULT NULL  AFTER mandatory;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_field add   width_pct smallint DEFAULT NULL  AFTER step;");
    
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."pag.atable modify column atable_name varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;");

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."hrm.orgunit
                        CHANGE `titre_short_en` `titre_short_en` varchar(96) COLLATE 'utf8mb3_general_ci' NULL AFTER `titre`,
                        CHANGE `titre_en` `titre_en` varchar(255) COLLATE 'utf8mb3_general_ci' NULL AFTER `titre_short_en`;");
}
catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}    