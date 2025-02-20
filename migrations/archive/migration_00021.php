<?php
$server_db_prefix = AfwSession::config("db_prefix", "default_db_");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`applicant_api_request` CHANGE `applicant_id` `applicant_id` BIGINT(20) NOT NULL");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`applicant` CHANGE `idn` `idn` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL");