<?php
if (!class_exists("AfwSession")) die("Denied access");
/**
 * @var string $migration_error
 */
$server_db_prefix = AfwSession::currentDBPrefix();

AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.`applicant_file` MODIFY COLUMN `id` bigint(20) NOT NULL auto_increment PRIMARY KEY");
