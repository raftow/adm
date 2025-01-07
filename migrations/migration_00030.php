<?php
$server_db_prefix = AfwSession::config("db_prefix", "default_db_");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`applicant_evaluation` CHANGE `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT;"); 

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`applicant_evaluation` CHANGE `applicant_id` `applicant_id` BIGINT(20) NOT NULL;");