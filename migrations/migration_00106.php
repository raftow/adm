<?php
if (!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try {
    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.`application`
            CHANGE `attribute_1` `attribute_1` char(1) NULL AFTER `application_plan_branch_mfk`,
            CHANGE `attribute_2` `attribute_2` int(11) NULL DEFAULT '0' AFTER `attribute_1`;      ");

    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.applicant_scholarship add   add scholarship_type int(11) DEFAULT NULL AFTER scholarship_id;");
} catch (Exception $e) {
    $migration_error .= " " . $e->getMessage();
}
