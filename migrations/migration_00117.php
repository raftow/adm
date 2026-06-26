<?php
if (!class_exists("AfwSession")) die("Denied access");
/**
 * @var string $migration_error
 */
$server_db_prefix = AfwSession::currentDBPrefix();
try {

    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.applicant add   disability_desc varchar(250)  DEFAULT NULL  AFTER disability_mfk;");
    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.applicant add   employer_desc varchar(250)  DEFAULT NULL  AFTER employer_approval_afile_id;");
} catch (Exception $e) {
    $migration_error .= " " . $e->getMessage();
}
