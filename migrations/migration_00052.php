<?php

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
// added by rafik : start
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_program add   program_title_ar varchar(64)  NOT NULL  AFTER program_title;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_program add   program_title_en varchar(64)  NOT NULL  AFTER program_title_ar;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_program add   program_duration_ar varchar(32)  NOT NULL  AFTER program_title_en;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_program add   program_duration_en varchar(32)  NOT NULL  AFTER program_duration_ar;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_program add   program_instructions_ar text  NOT NULL  AFTER program_duration_en;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.academic_program add   program_instructions_en text  NOT NULL  AFTER program_instructions_ar;");
