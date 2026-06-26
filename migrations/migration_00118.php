<?php
if (!class_exists("AfwSession")) die("Denied access");
/**
 * @var string $migration_error
 */
$server_db_prefix = AfwSession::currentDBPrefix();
try {

    AfwDatabase::db_query("INSERT INTO  " . $server_db_prefix . "pag.afield_type me 
        SET id = '18',
            id_aut = 1, 
            date_aut = '2026-06-26 13:17:05', 
            `version` = 1,  
            titre = _utf8'مصفوفة', 
            titre_short = _utf8'مصفوفة', 
            is_numeric='N', 
            sql_field_type='text', 
            oracle_field_type='varchar2(5000)';");
} catch (Exception $e) {
    $migration_error .= " " . $e->getMessage();
}
