<?php
$server_db_prefix = AfwSession::config("db_prefix", "default_db_");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.financial_transaction add financial_element_unit_enum smallint DEFAULT NULL AFTER sis_payment_code;");