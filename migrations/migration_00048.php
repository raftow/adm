<?php
// -- 193    البيانات المرجعية 
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'financial_transaction', 193, "+t", "qsearch", null);

// -- 198  ادارة المتقدمين 
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'applicant_group', 198, "+t", "qsearch", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'application_simulation', 198, "+t", "qsearch", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'applicant_file', 198, "+t", "qsearch", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'application_desire', 198, "+t", "qsearch", null);

// 201 - الاشراف العام
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'employee_scope', 201, "+t", "qsearch", null);

// 180 - إعدادات القبول
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'sorting_group', 180, "+t", "qsearch", null);






// remove bad BFs
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'adm_orgunit', 201, "-t", "stats", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'adm_employee', 201, "-t", "stats", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'adm_emp_request', 201, "-t", "stats", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'employee_scope', 201, "-t", "stats", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'institution', 193, "-t", "qedit", null);


$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.financial_transaction (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `lookup_code`, `fee_code`, `fee_description_ar`, `fee_description_en`, `sis_charge_code`, `sis_payment_code`) VALUES
(1, 1, '2024-11-02 14:51:01', 1, '2024-11-02 14:51:01', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'F001', 'رسوم التقديم', 'Application Fees', NULL, NULL),
(2, 1, '2024-11-02 14:51:01', 1, '2024-11-02 14:51:01', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'F002', 'الرسوم الإدارية', 'inistrative Fees', NULL, NULL),
(3, 1, '2024-11-02 14:51:01', 1, '2024-11-02 14:51:01', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'F003', 'رسوم اختبار الإنجليزية', 'English Test Evaluat', NULL, NULL),
(4, 1, '2024-11-02 14:51:41', 1, '2024-11-02 14:51:41', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'F004', 'رسوم الدراسة', 'Tuition Fees', NULL, NULL);");


AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application add   comments varchar(128)  DEFAULT NULL  AFTER application_status_enum;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_simulation add   application_plan_id int(11) DEFAULT NULL  AFTER log;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_simulation add   progress_value decimal(5,2) DEFAULT NULL  AFTER application_plan_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_simulation add   progress_task varchar(96)  DEFAULT NULL  AFTER progress_value;");
