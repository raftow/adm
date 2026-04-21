<?php
if (!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try {
    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.academic_program ADD UNIQUE `program_code` (`program_code`), DROP INDEX `old_name_ar`;");
    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.academic_program ADD sis_level_code VARCHAR(16) NOT NULL DEFAULT '' AFTER sis_program_code;");
    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.academic_program ADD sis_major_code VARCHAR(16) DEFAULT NULL AFTER sis_level_code;");
} catch (Exception $e) {
    $migration_error .= " " . $e->getMessage();
}
