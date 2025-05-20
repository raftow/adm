<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
try
{
    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`document_category` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `created_by` int(11) NOT NULL,
    `created_at`   datetime NOT NULL,
    `updated_by` int(11) NOT NULL,
    `updated_at` datetime NOT NULL,
    `validated_by` int(11) DEFAULT NULL,
    `validated_at` datetime DEFAULT NULL,
    `active` char(1) NOT NULL,
    `draft` char(1) NOT NULL default  'Y' ,
    `version` int(4) DEFAULT NULL,
    `update_groups_mfk` varchar(255) DEFAULT NULL,
    `delete_groups_mfk` varchar(255) DEFAULT NULL,
    `display_groups_mfk` varchar(255) DEFAULT NULL,
    `sci_id` int(11) DEFAULT NULL,
    
        
    document_category_name_ar varchar(100)  NOT NULL , 
    document_category_name_en varchar(100)  NOT NULL , 

    
    PRIMARY KEY (`id`)
    ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
        
    AfwDatabase::db_query("create unique index uk_document_category on ".$server_db_prefix."adm.document_category(document_category_name_ar,document_category_name_en);");
    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`document_type` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `created_by` int(11) NOT NULL,
        `created_at`   datetime NOT NULL,
        `updated_by` int(11) NOT NULL,
        `updated_at` datetime NOT NULL,
        `validated_by` int(11) DEFAULT NULL,
        `validated_at` datetime DEFAULT NULL,
        `active` char(1) NOT NULL,
        `draft` char(1) NOT NULL default  'Y' ,
        `version` int(4) DEFAULT NULL,
        `update_groups_mfk` varchar(255) DEFAULT NULL,
        `delete_groups_mfk` varchar(255) DEFAULT NULL,
        `display_groups_mfk` varchar(255) DEFAULT NULL,
        `sci_id` int(11) DEFAULT NULL,
        
        
        document_type_name_ar varchar(100)  NOT NULL , 
        document_type_name_en varchar(100)  NOT NULL , 
        document_category_id int(11) NOT NULL , 
    
        
        PRIMARY KEY (`id`)
    ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");   
    AfwDatabase::db_query("create unique index uk_document_type on ".$server_db_prefix."adm.document_type(document_type_name_ar,document_type_name_en,document_category_id);");


    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`service_category` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `created_by` int(11) NOT NULL,
    `created_at`   datetime NOT NULL,
    `updated_by` int(11) NOT NULL,
    `updated_at` datetime NOT NULL,
    `validated_by` int(11) DEFAULT NULL,
    `validated_at` datetime DEFAULT NULL,
    `active` char(1) NOT NULL,
    `draft` char(1) NOT NULL default  'Y' ,
    `version` int(4) DEFAULT NULL,
    `update_groups_mfk` varchar(255) DEFAULT NULL,
    `delete_groups_mfk` varchar(255) DEFAULT NULL,
    `display_groups_mfk` varchar(255) DEFAULT NULL,
    `sci_id` int(11) DEFAULT NULL,
    
        
    service_category_name_ar varchar(100)  NOT NULL , 
    service_category_name_en varchar(100)  NOT NULL , 

    
    PRIMARY KEY (`id`)
    ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

    AfwDatabase::db_query("create unique index uk_service_category on ".$server_db_prefix."adm.service_category(service_category_name_ar,service_category_name_en);");
    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`service_item` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `created_by` int(11) NOT NULL,
        `created_at`   datetime NOT NULL,
        `updated_by` int(11) NOT NULL,
        `updated_at` datetime NOT NULL,
        `validated_by` int(11) DEFAULT NULL,
        `validated_at` datetime DEFAULT NULL,
        `active` char(1) NOT NULL,
        `draft` char(1) NOT NULL default  'Y' ,
        `version` int(4) DEFAULT NULL,
        `update_groups_mfk` varchar(255) DEFAULT NULL,
        `delete_groups_mfk` varchar(255) DEFAULT NULL,
        `display_groups_mfk` varchar(255) DEFAULT NULL,
        `sci_id` int(11) DEFAULT NULL,
        
          
         service_category_id varchar(100)  NOT NULL , 
         service_item_name_ar varchar(100)  NOT NULL , 
         service_item_name_en smallint NOT NULL , 
         upload_file_ind smallint DEFAULT NULL , 
         document_type_mfk smallint DEFAULT NULL , 
      
        
        PRIMARY KEY (`id`)
      ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

      AfwDatabase::db_query("create unique index uk_service_item on ".$server_db_prefix."adm.service_item(service_category_id,service_item_name_ar,service_item_name_en,upload_file_ind,document_type_mfk);");



      AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`service_request` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `created_by` int(11) NOT NULL,
        `created_at`   datetime NOT NULL,
        `updated_by` int(11) NOT NULL,
        `updated_at` datetime NOT NULL,
        `validated_by` int(11) DEFAULT NULL,
        `validated_at` datetime DEFAULT NULL,
        `active` char(1) NOT NULL,
        `draft` char(1) NOT NULL default  'Y' ,
        `version` int(4) DEFAULT NULL,
        `update_groups_mfk` varchar(255) DEFAULT NULL,
        `delete_groups_mfk` varchar(255) DEFAULT NULL,
        `display_groups_mfk` varchar(255) DEFAULT NULL,
        `sci_id` int(11) DEFAULT NULL,
        
            
        idn varchar(15)  NOT NULL , 
        first_name varchar(100)  DEFAULT NULL , 
        last_name varchar(100)  DEFAULT NULL , 
        mobile varchar(15)  DEFAULT NULL , 
        email varchar(30)  DEFAULT NULL , 
        service_category_id int(11) DEFAULT NULL , 
        service_item_id int(11) DEFAULT NULL , 
        subject varchar(100)  DEFAULT NULL , 
        description text  DEFAULT NULL , 
        applicant_file_id int(11) DEFAULT NULL , 

        
        PRIMARY KEY (`id`)
        ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
        AfwDatabase::db_query("create unique index uk_service_request on ".$server_db_prefix."adm.service_request(idn,first_name,last_name,mobile,email,service_category_id,service_item_id,subject,description,applicant_file_id);");


        AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."document_category (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `document_category_name_ar`, `document_category_name_en`) VALUES
        (1, 1, '2025-05-19 12:55:39', 1, '2025-05-19 12:55:39', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'وثائق التعريف وإثبات الهوية', ' Personal Identification and Proof of Identity'),
        (2, 1, '2025-05-19 12:56:13', 1, '2025-05-19 12:56:13', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'المؤهلات العلمية و السجلات الأكاديمية', 'Academic Records'),
        (3, 1, '2025-05-19 12:56:31', 1, '2025-05-19 12:56:31', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'الاختبارات', 'Standardized Test Scores'),
        (4, 1, '2025-05-19 12:57:11', 1, '2025-05-19 12:57:11', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'الرسوم  وإثبات الدفع', 'Application Fees and Payment Proof'),
        (5, 1, '2025-05-19 12:57:42', 1, '2025-05-19 12:57:42', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'وثائق الإقامة والوضع القانوني', 'Residency and Legal Status Documents'),
        (6, 1, '2025-05-19 12:58:06', 1, '2025-05-19 12:58:06', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'الوثائق الطبية والصحية', 'Medical and Health Documents'),
        (7, 1, '2025-05-19 12:58:44', 1, '2025-05-19 12:58:44', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'الوثائق المالية', 'Financial Documents'),
        (8, 1, '2025-05-19 12:59:29', 1, '2025-05-19 12:59:29', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'الوثائق المهنية', 'Professional and Extracurricular Documents'),
        (9, 1, '2025-05-19 13:00:06', 1, '2025-05-19 13:00:06', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'شهادات الخلو من السوابق', 'Background Checks and Clearance Certificates');");

        AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."document_type (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `document_type_name_ar`, `document_type_name_en`, `document_category_id`) VALUES
        (1, 1, '2025-05-20 08:11:25', 1, '2025-05-20 08:11:25', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'صورة لجواز السفر', 'Passport copy', 1),
        (2, 1, '2025-05-20 08:12:22', 1, '2025-05-20 08:12:22', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'بطاقة الهوية الوطنية', 'National ID', 1),
        (3, 1, '2025-05-20 08:12:22', 1, '2025-05-20 08:12:22', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'بطاقة الإقامة', 'Resident Permit', 1),
        (4, 1, '2025-05-20 08:12:22', 1, '2025-05-20 08:12:22', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'شهادة الميلاد', 'Birth certificate', 1),
        (5, 1, '2025-05-20 08:13:41', 1, '2025-05-20 08:13:41', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'صورة مقدم الطلب', 'Applicant Photo', 1),
        (6, 1, '2025-05-20 08:13:41', 1, '2025-05-20 08:13:41', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'شهادة الثانوية العامة او مايعادلها', 'High school transcripts', 2),
        (7, 1, '2025-05-20 08:13:41', 1, '2025-05-20 08:13:41', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'ترجمات السجلات الاكاديمية', 'Translations of transcripts ', 2),
        (8, 1, '2025-05-20 08:14:51', 1, '2025-05-20 08:14:51', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'سجلات الكلية أو الجامعة', 'College or university transcripts', 2),
        (9, 1, '2025-05-20 08:14:51', 1, '2025-05-20 08:14:51', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'الدبلومات أو الشهادات', 'Diplomas or certificates', 2),
        (10, 1, '2025-05-20 08:14:51', 1, '2025-05-20 08:14:51', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'اختبار القدرات العامة  للتخصصات العلمية', 'General Aptitude Test for Science Track', 3),
        (11, 1, '2025-05-20 08:15:52', 1, '2025-05-20 08:15:52', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'اختبار القدرات العامة للتخصصات النظرية', 'General Aptitude Test for Humanities Track', 3),
        (12, 1, '2025-05-20 08:15:52', 1, '2025-05-20 08:15:52', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'اختبار كفايات اللغة الإنجليزية STEP', 'Standardized Test of English Proficiency (STEP)', 3),
        (13, 1, '2025-05-20 08:15:52', 1, '2025-05-20 08:15:52', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'اختبار التحصيل الدراسي للتخصصات العلمية', 'Academic Achievement Test for the Science Track', 3),
        (14, 1, '2025-05-20 08:17:08', 1, '2025-05-20 08:17:08', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'اختبار التحصيل الدراسي للتخصصات النظرية', 'Academic Achievement Test for the Humanities Track', 3),
        (15, 1, '2025-05-20 08:17:08', 1, '2025-05-20 08:17:08', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'اختبار الإنجليزية كلغة أجنبية - TOFEL', 'Test of English as a Foreign Language', 3),
        (16, 1, '2025-05-20 08:17:08', 1, '2025-05-20 08:17:08', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'نِظَامُ اخْتِبَارِ اللُّغَةِ الْإِنْجِلِيزِيَّةِ الدَّوْلِيُّ  -IELTS', 'International English Language Testing System', 3),
        (17, 1, '2025-05-20 08:17:53', 1, '2025-05-20 08:17:53', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'إيصال الدفع', 'Visa', 5),
        (18, 1, '2025-05-20 08:17:53', 1, '2025-05-20 08:17:53', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'البريد الإلكتروني لتأكيد المعاملة', 'residency permit', 5),
        (19, 1, '2025-05-20 08:17:53', 1, '2025-05-20 08:17:53', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'تأشيرة', 'Work permit ', 5),
        (20, 1, '2025-05-20 08:20:53', 1, '2025-05-20 08:20:53', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'إثبات حالة الإقامة', 'Proof of residency status ', 5),
        (21, 1, '2025-05-20 08:20:53', 1, '2025-05-20 08:20:53', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'كشف طبي', 'Medical Report', 6),
        (22, 1, '2025-05-20 08:20:53', 1, '2025-05-20 08:20:53', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'تقرير فحص الصحة العامة', 'General health check-up report', 6),
        (23, 1, '2025-05-20 08:34:42', 1, '2025-05-20 08:34:42', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'شهادة اثبات الإعاقة', 'Certificate of Proof of Disability', 6),
        (24, 1, '2025-05-20 08:34:42', 1, '2025-05-20 08:34:42', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'وثائق التأمين الصحي', 'Health insurance documentation', 6),
        (25, 1, '2025-05-20 08:34:42', 1, '2025-05-20 08:34:42', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'كشف حساب بنكي يوضح وجود أموال كافية', 'Bank statements showing sufficient funds', 7),
        (26, 1, '2025-05-20 08:37:35', 1, '2025-05-20 08:37:35', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'إقرار بالدعم (ضمان مالي من كفيل)', 'Affidavit of support (financial guarantee from a sponsor)', 7),
        (27, 1, '2025-05-20 08:37:35', 1, '2025-05-20 08:37:35', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'خطابات منح المنح الدراسية أو المساعدات المالية', 'Scholarship or financial aid award letters', 7),
        (28, 1, '2025-05-20 08:37:35', 1, '2025-05-20 08:37:35', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'بيان شخصي (لبرامج البكالوريوس)', 'Personal statement (for undergraduate programs)', 8),
        (29, 1, '2025-05-20 08:38:21', 1, '2025-05-20 08:38:21', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'بيان الغرض (SOP) لبرامج الدراسات العليا', 'Statement of Purpose (SOP) for graduate programs', 8),
        (30, 1, '2025-05-20 08:38:21', 1, '2025-05-20 08:38:21', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'السيرة الذاتية (CV)', 'Resume or Curriculum Vitae (CV)', 8),
        (31, 1, '2025-05-20 08:38:21', 1, '2025-05-20 08:38:21', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'تصريح من صاحب العمل', 'Statement from the employer', 8),
        (32, 1, '2025-05-20 08:39:06', 1, '2025-05-20 08:39:06', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'توصية اكاديمية', 'letter of academic recommendations', 8),
        (33, 1, '2025-05-20 08:39:06', 1, '2025-05-20 08:39:06', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'توصية مهنية', 'letter of professional recommendations', 8),
        (34, 1, '2025-05-20 08:39:06', 1, '2025-05-20 08:39:06', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'تقرير شهادة خلو سوابق', 'Police clearance certificate', 9);");

        AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."service_category (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `service_category_name_ar`, `service_category_name_en`) VALUES
        (1, 1, '2025-05-19 13:00:57', 1, '2025-05-19 13:00:57', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'استفسار عام', 'General Inquiry'),
        (2, 1, '2025-05-19 13:01:11', 1, '2025-05-19 13:01:11', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'القبول الجامعي', 'University Admission'),
        (3, 1, '2025-05-19 13:01:30', 1, '2025-05-19 13:01:30', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'القبول الاستثنائي', 'Exceptional Admission'),
        (4, 1, '2025-05-19 13:01:40', 1, '2025-05-19 13:01:40', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'حساب المتقدم', 'Applicant Account');");
            
        AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."service_item (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `service_category_id`, `service_item_name_ar`, `service_item_name_en`, `upload_file_ind`, `document_type_mfk`) VALUES
        (1, 1, '2025-05-19 13:06:06', 1, '2025-05-19 13:06:06', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, '1', 'استفسار القبول الثانوي', 0, 0, NULL),
        (2, 1, '2025-05-19 13:06:30', 1, '2025-05-19 13:07:19', 0, NULL, 'Y', 'Y', 2, ',', ',', ',', 0, '2', 'المتقدم المعفي من اختبار القدرات والتحصيلي', 0, 0, NULL),
        (3, 1, '2025-05-19 13:07:11', 1, '2025-05-19 13:07:11', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, '2', 'بيانات المتقدم لم ترد من الوزارة', 0, 0, NULL),
        (4, 1, '2025-05-19 13:07:41', 1, '2025-05-19 13:07:41', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, '2', 'تعديل درجة القدرات أوالتحصيلي', 0, 0, NULL),
        (5, 1, '2025-05-19 13:08:13', 1, '2025-05-19 13:08:13', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, '2', 'معادلة الشهادة الثانوية الخارجية', 0, 0, NULL),
        (6, 1, '2025-05-19 13:08:35', 1, '2025-05-19 13:08:35', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, '2', 'طالب لديه رقم جامعي سابق', 0, 0, NULL),
        (7, 1, '2025-05-19 13:09:02', 1, '2025-05-19 13:09:02', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, '3', 'قبول ذوي االاحتياجات الخاصة', 0, 0, NULL),
        (8, 1, '2025-05-19 13:09:23', 1, '2025-05-19 13:09:23', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, '2', 'متقدم من أم سعودية', 0, 0, NULL),
        (9, 1, '2025-05-19 13:09:46', 1, '2025-05-19 13:09:46', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, '3', 'قبول أبناء مستفيدي الضمان الاجتماعي', 0, 0, NULL),
        (10, 1, '2025-05-19 13:10:18', 1, '2025-05-19 13:10:18', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, '4', 'تعديل رقم الجوال', 0, 0, NULL),
        (11, 1, '2025-05-19 13:10:38', 1, '2025-05-19 13:10:38', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, '4', 'لا يمكن الدخول لحسابي', 0, 0, NULL);");

}catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}