<?php
$server_db_prefix = AfwSession::config("db_prefix", "default_db_");


AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant change   mother_saudi_ind mother_saudi_ind char(1)  DEFAULT 0 ;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant change   password password varchar(100)  DEFAULT NULL  AFTER username;");
