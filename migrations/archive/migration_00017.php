<?php
// because this migration is only for PMU
$server_db_prefix = AfwSession::currentDBPrefix();

if($server_db_prefix=="pmu_")
{
    $default_db = $server_db_prefix."adm";

    // @todo dump of pmu_adm.`academic_level_offering` and pmu_adm.`academic_program_offering`
}