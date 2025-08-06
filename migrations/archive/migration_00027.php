<?php
if(!class_exists("AfwSession")) die("Denied access");
$server_db_prefix = AfwSession::currentDBPrefix();

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`applicant_file` MODIFY COLUMN `id` bigint(20) NOT NULL auto_increment PRIMARY KEY");
