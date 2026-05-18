<?php
if (!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try {

 
 AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.applicant_account add   fee_description_ar varchar(255)  DEFAULT NULL  AFTER next_transition_id;");
 AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.applicant_account add   fee_description_en varchar(255)  DEFAULT NULL  AFTER fee_description_ar;");

} catch (Exception $e) {
    $migration_error .= " " . $e->getMessage();
}
