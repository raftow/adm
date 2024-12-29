<?php
$server_db_prefix = AfwSession::config("db_prefix", "default_db_");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`applicant_evaluation` CHANGE `adm_file_id` `workflow_file_id` INT(11) NULL DEFAULT NULL;");

AfwDatabase::db_query("CREATE TABLE ".$server_db_prefix."adm.`applicant_file` (
    `id` bigint(20) NOT NULL,
    `created_by` int(11) NOT NULL,
    `created_at` datetime NOT NULL,
    `updated_by` int(11) NOT NULL,
    `updated_at` datetime NOT NULL,
    `validated_by` int(11) DEFAULT NULL,
    `validated_at` datetime DEFAULT NULL,
    `active` char(1) NOT NULL,
    `draft` char(1) NOT NULL DEFAULT 'Y',
    `version` int(4) DEFAULT NULL,
    `update_groups_mfk` varchar(255) DEFAULT NULL,
    `delete_groups_mfk` varchar(255) DEFAULT NULL,
    `display_groups_mfk` varchar(255) DEFAULT NULL,
    `sci_id` int(11) DEFAULT NULL,
    `name_ar` varchar(128) NOT NULL,
    `desc_ar` text DEFAULT NULL,
    `name_en` varchar(128) NOT NULL,
    `desc_en` text DEFAULT NULL,
    `applicant_id` bigint(20) DEFAULT NULL,
    `workflow_file_id` int(11) DEFAULT NULL,
    `doc_type_id` int(11) DEFAULT NULL,
    `afile_ext` varchar(32) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

AfwDatabase::db_query("DELETE from ".$server_db_prefix."ums.`doc_type` where id in (6,7,18,20,27,28,29);");
AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."ums.`doc_type` (`id`, `id_aut`, `date_aut`, `id_mod`, `date_mod`, `id_valid`, `date_valid`, `avail`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `lookup_code`, `titre`, `titre_short`, `valid_ext`) VALUES
(6, 1, '2016-04-22 16:24:02', 1, '2024-12-27 16:26:09', 0, NULL, 'Y', 6, NULL, NULL, NULL, 0, 'diploma', 'صورة المؤهل العلمي النسخة الأصلية', 'مؤهل علمي', 'png,jpg,jpeg,pdf,doc,docx'),
(7, 1, '2016-04-22 16:24:02', 1, '2024-12-27 16:28:29', 0, NULL, 'Y', 10, NULL, NULL, NULL, 0, 'attachement', 'مرفقات أخرى توضيحية (غالبا pdf)', 'مرفق آخر', 'png,jpg,jpeg,pdf,doc,docx'),
(18, 1, '2020-04-04 02:49:23', 1, '2021-08-29 11:21:38', 0, NULL, 'Y', 2, NULL, NULL, NULL, 0, 'idn_photo', 'صورة لبطاقة الهوية', 'صورة الهوية', 'png,jpg,jpeg,pdf'),
(20, 1, '2021-08-29 11:10:09', 1, '2022-03-29 18:57:04', 0, NULL, 'Y', 3, NULL, NULL, NULL, 0, 'cv', 'سيرة ذاتية موجزة', 'سيرة ذاتية', 'png,jpg,jpeg,pdf,doc,docx'),
(27, 1, '2022-03-29 18:57:04', 1, '2024-12-12 18:05:55', 0, NULL, 'Y', 2, NULL, NULL, NULL, 0, 'photo', 'صورة فوتوغرافية', 'صورة فوتو', 'png,jpg,jpeg,'),
(28, 1, '2022-03-29 18:57:04', 1, '2024-12-27 16:26:09', 0, NULL, 'Y', 2, NULL, NULL, NULL, 0, 'exam', 'صورة شهادة اجتياز اختبار', 'شهادة اجتياز اختبار', 'png,jpg,jpeg,pdf,doc'),
(29, 1, '2022-03-29 18:57:04', 1, '2024-12-27 16:26:09', 0, NULL, 'Y', 2, NULL, NULL, NULL, 0, 'tazkia', 'صورة تزكية معتمدة', 'تزكية', 'png,jpg,jpeg,pdf,doc');");
