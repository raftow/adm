<?php
$server_db_prefix = AfwSession::config("db_prefix", "default_db_");

// some previleges
// faq

$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'scholarship', 183, "+t", "qsearch", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'program_track', 189, "+t", "qsearch", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'academic_program', 189, "+t", "qsearch", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'academic_level', 189, "+t", "qsearch", null);

