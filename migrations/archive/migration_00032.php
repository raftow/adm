<?php
$server_db_prefix = AfwSession::currentDBPrefix();
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`training_unit_type` add program_track_id int(11) DEFAULT NULL  AFTER training_unit_type_code;"); 

// some previleges


