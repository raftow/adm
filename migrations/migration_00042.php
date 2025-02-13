<?php
$server_db_prefix = AfwSession::config("db_prefix", "default_db_");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_step add step_code varchar(3)  NOT NULL  AFTER step_name_en;");