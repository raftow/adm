<?php

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");


AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_program add   program_rank smallint NOT NULL  AFTER program_title;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_program add   program_file_id int(11) DEFAULT NULL  AFTER program_rank;");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_program add   program_instructions text  DEFAULT NULL  AFTER program_file_id;");

