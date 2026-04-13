<?php
if (!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try {

    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.nominating_authority ADD sis_code VARCHAR(32) DEFAULT NULL AFTER country_id;");
} catch (Exception $e) {
    $migration_error .= " " . $e->getMessage();
}
