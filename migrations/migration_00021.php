<?php
$server_db_prefix = AfwSession::config("db_prefix", "default_db_");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`applicant_api_request` CHANGE `applicant_id` `applicant_id` BIGINT(20) NOT NULL");