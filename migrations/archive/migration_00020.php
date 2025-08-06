<?php
$server_db_prefix = AfwSession::currentDBPrefix();

// medali transaction fees moodule

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant_qualification add   adm_file_id int(11) DEFAULT NULL  AFTER import_utility_id;");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant_evaluation add   adm_file_id int(11) DEFAULT NULL  AFTER imported;");
