<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_step add   FrontEnd_instructions_ar text  NOT NULL  AFTER step_code;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_step add   FrontEnd_instructions_en text  NOT NULL  AFTER FrontEnd_instructions_ar;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_step add   show_in_FrondEnd char(1) NOT NULL  AFTER FrontEnd_instructions_en;");

