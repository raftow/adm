<?php
$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.training_unit_type change   training_unit_type_code training_unit_type_code varchar(30)  NOT NULL  AFTER id;");

// more previleges (see list all goals command-line)

// in academic structure menu 189
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'training_unit_type', 189, "+t", "qsearch", null);

// in programs menu 183
// $migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'scholarship', 183, "+t", "qsearch", null);

// in qualifications menu 194
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'qualification', 194, "+t", "qsearch", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'evaluation', 194, "+t", "qsearch", null);
