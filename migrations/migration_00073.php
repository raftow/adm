<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{

    AfwDatabase::db_query("CREATE TABLE ".$server_db_prefix."adm.`request_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `validated_by` int DEFAULT NULL,
  `validated_at` datetime DEFAULT NULL,
  `active` char(1) COLLATE utf8mb3_unicode_ci NOT NULL,
  `version` int DEFAULT NULL,
  `update_groups_mfk` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `delete_groups_mfk` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `display_groups_mfk` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `sci_id` int DEFAULT NULL,
  `lookup_code` varchar(128) COLLATE utf8mb3_unicode_ci NOT NULL,
  `request_status_name_ar` varchar(128) COLLATE utf8mb3_unicode_ci NOT NULL,
  `request_status_name_en` varchar(128) COLLATE utf8mb3_unicode_ci NOT NULL,
  `response_type_mfk` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `customer_status_name_ar` varchar(128) COLLATE utf8mb3_unicode_ci NOT NULL,
  `customer_status_name_en` varchar(128) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_request_status` (`lookup_code`)
) ENGINE=InnoDB AUTO_INCREMENT=302 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;");
    AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.`request_status` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `lookup_code`, `request_status_name_ar`, `request_status_name_en`, `response_type_mfk`, `customer_status_name_ar`, `customer_status_name_en`) VALUES
    (1,	0,	'2021-06-03 14:47:56',	1,	'2021-06-03 14:47:56',	NULL,	NULL,	'Y',	3,	NULL,	NULL,	NULL,	NULL,	'customer_draft',	'مسودة',	'draft',	NULL,	'مسودة',	'draft'),
    (2,	0,	'2022-03-13 17:09:34',	1,	'2022-03-13 17:09:34',	NULL,	NULL,	'Y',	5,	NULL,	NULL,	NULL,	NULL,	'customer_sent',	'طلب مرسل',	'sent for check',	NULL,	'طلب مرسل',	'sent for check'),
    (3,	0,	'2022-04-11 15:21:09',	1,	'2022-04-11 15:21:09',	NULL,	NULL,	'Y',	3,	NULL,	NULL,	NULL,	NULL,	'invest_redirect',	'يحول إلى الجهة المختصة',	'redirect',	',2,1,',	'يحول إلى الجهة المختصة',	'redirect'),
    (4,	0,	'2022-04-14 11:48:39',	1,	'2022-04-14 11:48:39',	NULL,	NULL,	'Y',	5,	NULL,	NULL,	NULL,	NULL,	'ongoing',	'جاري العمل',	'ongoing',	',7,',	'جاري العمل',	'ongoing'),
    (5,	0,	'2022-04-14 11:48:39',	1,	'2022-04-14 11:48:39',	NULL,	NULL,	'Y',	5,	NULL,	NULL,	NULL,	NULL,	'superv_done',	'تمت الإجابة',	'response given',	',7,1,',	'تمت الإجابة',	'response given'),
    (6,	0,	'2022-04-07 16:51:06',	1,	'2022-04-07 16:51:06',	NULL,	NULL,	'Y',	5,	NULL,	NULL,	NULL,	NULL,	'invest_customer_cancel',	'العميل ألغى الطلب',	'canceled',	NULL,	'العميل ألغى الطلب',	'canceled'),
    (7,	0,	'2022-05-16 14:33:48',	1,	'2022-05-16 14:33:48',	NULL,	NULL,	'Y',	3,	NULL,	NULL,	NULL,	NULL,	'closed',	'طلب مغلق',	'closed',	',1,',	'طلب مغلق',	'closed'),
    (8,	0,	'2022-04-11 15:21:09',	1,	'2022-04-11 15:21:09',	NULL,	NULL,	'Y',	4,	NULL,	NULL,	NULL,	NULL,	'superv_invest_rejected',	'طلب مستبعد',	'rejected',	',2,1,',	'طلب مستبعد',	'rejected'),
    (9,	0,	'2022-04-07 17:28:32',	1,	'2022-04-07 17:28:32',	NULL,	NULL,	'Y',	4,	NULL,	NULL,	NULL,	NULL,	'ignored',	'طلب تم تجاهله',	'ignored',	NULL,	'طلب تم تجاهله',	'ignored'),
    (16,	1,	'2022-03-13 17:09:34',	1,	'2022-04-07 16:51:06',	0,	NULL,	'N',	2,	NULL,	NULL,	NULL,	0,	'',	'',	'',	NULL,	'',	''),
    (101,	1,	'2021-11-24 18:36:37',	1,	'2022-04-11 15:21:09',	0,	NULL,	'Y',	4,	NULL,	NULL,	NULL,	0,	'superv_invest_missed_info',	'لاستكمال البيانات',	'MISSED_INFO',	',2,5,',	'لاستكمال البيانات',	'MISSED_INFO'),
    (102,	1,	'2021-11-24 18:36:37',	1,	'2022-04-11 15:21:09',	0,	NULL,	'Y',	4,	NULL,	NULL,	NULL,	0,	'superv_invest_missed_files',	'لاستكمال المرفقات',	'MISSED_FILES',	',2,5,',	'لاستكمال المرفقات',	'MISSED_FILES'),
    (201,	1,	'2022-04-10 17:06:38',	1,	'2022-04-10 17:06:38',	0,	NULL,	'Y',	1,	NULL,	NULL,	NULL,	0,	'assigned',	'عند الموظف',	'Assigned to employee',	NULL,	'عند الموظف',	'Assigned to employee'),
    (301,	1,	'2022-04-07 15:11:50',	1,	'2022-04-11 15:21:09',	0,	NULL,	'Y',	3,	NULL,	NULL,	NULL,	0,	'invest_under_revision',	'تدقيق الاجابة',	'RESPONSE UNDER REVISION',	',1,',	'تدقيق الاجابة',	'RESPONSE UNDER REVISION');");
    
}catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}