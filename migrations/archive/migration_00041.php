<?php
$server_db_prefix = AfwSession::currentDBPrefix();

// more previleges (see list all goals command-line)

// 198 ادارة المتقدمين 
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'application', 198, "+t", "qsearch", null);

$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'application', 198, "+t", "qsearch", null);
