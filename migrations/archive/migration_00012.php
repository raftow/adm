<?php
// rafik applicant fields ++
AfwDatabase::db_query("INSERT INTO c0adm.`application_field` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `field_name`, `shortname`, `application_table_id`, `application_field_type_id`, `field_title_ar`, `field_title_en`, `reel`, `additional`, `unit`, `unit_en`, `field_order`, `field_num`, `field_size`, `help_text`, `help_text_en`, `question_text`, `question_text_en`) VALUES
(110845, 1, '2024-10-17 13:35:19', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', 2, NULL, NULL, NULL, NULL, 'attribute_3', '', 3, 13, 'مستوى المؤهل', 'qualification level', 'N', 'N', '', '', 130, NULL, 32, NULL, NULL, NULL, NULL)");


AfwDatabase::db_query("update c0adm.`applicant` set active='Y';");

AfwDatabase::db_query("update c0adm.`applicant` set attribute_1='Y' where attribute_1='1';");
AfwDatabase::db_query("update c0adm.`applicant` set attribute_1='N' where attribute_1='0';");

AfwDatabase::db_query("update c0adm.`applicant` set attribute_4='Y' where attribute_4='1';");
AfwDatabase::db_query("update c0adm.`applicant` set attribute_4='N' where attribute_4='0';");

AfwDatabase::db_query("update c0adm.`applicant` set attribute_5='Y' where attribute_5='1';");
AfwDatabase::db_query("update c0adm.`applicant` set attribute_5='N' where attribute_5='0';");

AfwDatabase::db_query("update c0adm.`applicant` set attribute_7='Y' where attribute_7='1';");
AfwDatabase::db_query("update c0adm.`applicant` set attribute_7='N' where attribute_7='0';");

AfwDatabase::db_query("update c0adm.`applicant` set attribute_8='Y' where attribute_8='1';");
AfwDatabase::db_query("update c0adm.`applicant` set attribute_8='N' where attribute_8='0';");

AfwDatabase::db_query("ALTER TABLE c0adm.api_endpoint add   application_field_mfk varchar(255) NOT NULL  AFTER api_url");
AfwDatabase::db_query("ALTER TABLE c0adm.app_model_api add   application_field_mfk varchar(255) NOT NULL  AFTER published");
AfwDatabase::db_query("ALTER TABLE c0adm.application_model_field add   api_endpoint_id int(11) NOT NULL  AFTER screen_model_id;");
AfwDatabase::db_query("ALTER TABLE c0adm.app_model_api change   duration_expiry duration_expiry smallint DEFAULT NULL  AFTER can_refresh;");
AfwDatabase::db_query("ALTER TABLE c0adm.app_model_api add   step_num smallint DEFAULT NULL  AFTER api_endpoint_id;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS c0adm.`applicant_api_request` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `created_by` int(11) NOT NULL,
    `created_at`   datetime NOT NULL,
    `updated_by` int(11) NOT NULL,
    `updated_at` datetime NOT NULL,
    `validated_by` int(11) DEFAULT NULL,
    `validated_at` datetime DEFAULT NULL,
    `active` char(1) NOT NULL,
    `draft` char(1) NOT NULL default 'Y',
    `version` int(4) DEFAULT NULL,
    `update_groups_mfk` varchar(255) DEFAULT NULL,
    `delete_groups_mfk` varchar(255) DEFAULT NULL,
    `display_groups_mfk` varchar(255) DEFAULT NULL,
    `sci_id` int(11) DEFAULT NULL,
    
      
     applicant_id int(11) NOT NULL , 
     api_endpoint_id int(11) NOT NULL , 
     run_date datetime DEFAULT NULL , 
     need_refresh char(1) NOT NULL , 
  
    
    PRIMARY KEY (`id`)
  ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
  
  
  // unique index : 
  AfwDatabase::db_query("CREATE unique index uk_applicant_api_request on c0adm.applicant_api_request(applicant_id,api_endpoint_id);");

  AfwDatabase::db_query("ALTER table c0adm.api_endpoint DROP key uk_api_endpoint;");

  AfwDatabase::db_query("INSERT INTO c0adm.`api_endpoint` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `api_endpoint_code`, `name_ar`, `api_endpoint_title`, `desc_ar`, `api_endpoint_name_ar`, `name_en`, `api_endpoint_name_en`, `desc_en`, `adm_file_id`, `failure_text`, `api_url`, `application_field_mfk`) VALUES
(1, 1, '2024-10-18 15:05:57', 1, '2024-10-19 08:43:30', 0, NULL, 'Y', 'Y', 3, NULL, NULL, NULL, 0, 'mlsd_disability', '', 'MLSD-DisabilityReportService ', NULL, 'الاستعلام عن بيانات ذوي الإعاقة', '', 'MLSD-DisabilityReportService', NULL, NULL, NULL, 'xxxxxx', ',110378,'),
(2, 1, '2024-10-18 16:07:28', 1, '2024-10-19 08:43:30', 0, NULL, 'Y', 'Y', 2, NULL, NULL, NULL, 0, 'moe_qualifications', '', 'خدمة مؤهل', NULL, 'خدمة مؤهل', '', 'MOE – Qualifications Service', NULL, NULL, NULL, 'xxxxxx/yyyyy', ',110694,110735,110845,'),
(3, 1, '2024-10-18 16:10:55', 1, '2024-10-19 08:43:30', 0, NULL, 'Y', 'Y', 3, NULL, NULL, NULL, 0, 'moi_person_info', '', 'البيانات الشخصية - وزارة الداخلية', NULL, 'البيانات الشخصية - وزارة الداخلية', '', 'MOI – Personal', NULL, NULL, NULL, 'xxxxxx/yyyyy/zzzz', ',110395,110484,110299,110323,110324,110325,110401,110734,'),
(4, 1, '2024-10-18 16:16:22', 1, '2024-10-19 08:43:30', 0, NULL, 'Y', 'Y', 2, NULL, NULL, NULL, 0, 'moe_academic_infos', '', 'البيانات الأكاديمية - وزارة التعليم', NULL, 'البيانات الأكاديمية - وزارة التعليم', '', 'MOE – ACADEMIC-INFOS Service', NULL, NULL, NULL, 'xxxxxx/yyyyy/aaaaa', ',110359,110362,110363,110365,110732,110380,110382,110383,110384,'),
(5, 1, '2024-10-18 16:19:02', 1, '2024-10-19 08:43:30', 0, NULL, 'Y', 'Y', 2, NULL, NULL, NULL, 0, 'ttc_academic_infos', '', 'البيانات الأكاديمية-المؤسسة العامة للتدريب التقني', NULL, 'البيانات الأكاديمية-المؤسسة العامة للتدريب التقني', '', 'TTC – ACADEMIC-INFOS Service', NULL, NULL, NULL, 'xxxxxx/yyyyy/BBBB', ',110732,110367,110735,110845,'),
(6, 1, '2024-10-19 08:46:16', 1, '2024-10-19 08:46:16', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, 'offline_data', '', 'البيانات الأكاديمية الجاهزة', NULL, 'البيانات الأكاديمية الجاهزة', '', 'offline_data', NULL, NULL, NULL, 'xooooo/yyyyy', ',110395,110484,110299,110323,110324,110325,110401,');");


  AfwDatabase::db_query("CREATE unique index uk_api_endpoint on c0adm.api_endpoint(api_endpoint_code);");

  AfwDatabase::db_query("ALTER TABLE c0adm.api_endpoint add   published char(1) DEFAULT NULL  AFTER api_endpoint_code;");
  AfwDatabase::db_query("ALTER TABLE c0adm.api_endpoint add   can_refresh char(1) NOT NULL  AFTER api_endpoint_name_en;");
  AfwDatabase::db_query("ALTER TABLE c0adm.api_endpoint add   duration_expiry smallint DEFAULT NULL  AFTER can_refresh;");

  
  