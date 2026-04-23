<?php
if (!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try {

    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.financial_transaction add   add_charge_ind char(1) DEFAULT NULL  AFTER financial_element_unit_enum;");
} catch (Exception $e) {
    $migration_error .= " " . $e->getMessage();
}
