<?php
$server_db_prefix = AfwSession::config("db_prefix", "default_db_");

// more previleges (see list all goals command-line)

// 198 ادارة المتقدمين 
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'application', 198, "+t", "qsearch", null);
