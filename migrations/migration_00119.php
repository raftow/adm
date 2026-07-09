<?php
if (!class_exists("AfwSession")) die("Denied access");
/**
 * @var string $migration_error
 */
$server_db_prefix = AfwSession::currentDBPrefix();
try {

    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.applicant_account add   send_to_sis_ind char(1) DEFAULT NULL  AFTER fee_description_en;");
    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.applicant_account add   send_to_sis_date datetime DEFAULT NULL  AFTER send_to_sis_ind;");
    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.nomination_letter change   nomination_letter_date nomination_letter_date datetime DEFAULT NULL  AFTER letter_code;");
} catch (Exception $e) {
    $migration_error .= " " . $e->getMessage();
}
