<?php

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_step change   step_code step_code varchar(3)  DEFAULT NULL  AFTER step_name_en;");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`screen_model` DROP `screen_title`");