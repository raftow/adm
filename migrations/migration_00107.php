<?php
if (!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try {

   
    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.applicant_account ADD workflow_request_id INT(11) DEFAULT NULL AFTER payment_deadline;");
    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.applicant_account ADD next_transition_id INT(11) DEFAULT NULL AFTER workflow_request_id;");
} catch (Exception $e) {
    $migration_error .= " " . $e->getMessage();
}
