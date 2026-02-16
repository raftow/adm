<?php
if (!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try {

   
    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.application_desire ADD guid INT(11) DEFAULT NULL AFTER formula_value_3;");
    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.application_desire ADD student_id BIGINT(20) DEFAULT NULL AFTER guid;");
    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.application_desire ADD student_created_ind CHAR(1) DEFAULT NULL AFTER student_id;");
    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.application_desire ADD sis_date DATETIME DEFAULT NULL AFTER student_created_ind;");
    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.application_desire ADD admission_status INT(11) DEFAULT NULL AFTER sis_date;");
    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.application_desire ADD admission_status_date DATETIME DEFAULT NULL AFTER admission_status;");
    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.application_desire ADD payment_created_ind CHAR(1) DEFAULT NULL AFTER admission_status_date;");

} catch (Exception $e) {
    $migration_error .= " " . $e->getMessage();
}
