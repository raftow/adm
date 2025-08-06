<?php
$server_db_prefix = AfwSession::currentDBPrefix();;

$default_db = $server_db_prefix."adm";

AfwDatabase::db_query("UPDATE $default_db.`academic_program_offering` po set po.`gender_enum` = (select gender_enum from tvtc_adm.training_unit t where t.id = po.training_unit_id);");
AfwDatabase::db_query("UPDATE $default_db.`academic_program_offering` po set po.`department_id` = (select department_id from tvtc_adm.academic_program ap where ap.id = po.academic_program_id);");
AfwDatabase::db_query("UPDATE $default_db.`academic_program_offering` po set po.`major_id` = (select major_id from tvtc_adm.academic_program ap where ap.id = po.academic_program_id);");
AfwDatabase::db_query("UPDATE $default_db.`academic_program_offering` po set po.`degree_id` = (select degree_id from tvtc_adm.academic_program ap where ap.id = po.academic_program_id);");
AfwDatabase::db_query("UPDATE $default_db.`academic_program_offering` po set po.`academic_level_id` = (select academic_level_id from tvtc_adm.academic_program ap where ap.id = po.academic_program_id);");


AcademicProgramOffering::genereAllNames();
