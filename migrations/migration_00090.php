<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
    // 194 - المؤهلات - 
    $migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'major_path', 194, "+t", "qsearch", null);

    // remove bad BFs
    // $migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'adm_orgunit', 201, "-t", "stats", null);

    
}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}    