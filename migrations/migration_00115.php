<?php
if (!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try {

  AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.nominating_candidates add   birth_date varchar(8) DEFAULT NULL  AFTER application_simulation_id;");
  AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.nominating_candidates add   birth_gdate datetime DEFAULT NULL  AFTER birth_date;");

  AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.application_class add   scholarship_ind char(1) DEFAULT NULL  AFTER budgeting_ind;");
  AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.sponsor add   sis_code int(11) NOT NULL DEFAULT 0  AFTER sponsor_adress;");
  } catch (Exception $e) {
    $migration_error .= " " . $e->getMessage();
}
