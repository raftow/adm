<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
           AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   gender_enum smallint NOT NULL DEFAULT 0  AFTER last_name_en;");



            $migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'service_request', 198, "-t", "qsearch", null);
        
    
}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}    