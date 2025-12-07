<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
           AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`engagement_type` (
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
            
            `lookup_code` varchar(64) DEFAULT NULL,  
            engagement_type varchar(10)  NOT NULL , 
            engagement_type_name_ar varchar(30)  NOT NULL DEFAULT '' , 
            engagement_type_name_en varchar(30)  NOT NULL DEFAULT '' , 
           

            
            PRIMARY KEY (`id`)
            ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
        /*
            AfwDatabase::db_query("create unique index uk_engagement_type on ".$server_db_prefix."adm.engagement_type(engagement_type);");
        
            AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.`engagement_type` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `lookup_code`, `engagement_type`, `engagement_type_name_ar`, `engagement_type_name_en`) VALUES
            (1, 1, '2025-12-07 10:44:06', 1, '2025-12-07 10:44:08', 0, NULL, 'Y', 'Y', 2, '', '', '', NULL, NULL, 'PL', 'تعهّد بصحة البيانات', 'Pledge of data accuracy'),
            (2, 1, '2025-12-07 10:45:19', 1, '2025-12-07 10:45:21', 0, NULL, 'Y', 'Y', 2, '', '', '', NULL, NULL, 'AC', 'عقد اتفاقية قبول', ' admission agreement contract'),
            (3, 1, '2025-12-07 10:46:57', 1, '2025-12-07 10:46:59', 0, NULL, 'Y', 'Y', 2, '', '', '', NULL, NULL, 'MC', 'شرط يدوي', 'Manual requirement');");
*/

            AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`engagement` (
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
            
                
            engagement_type_id int(11) NOT NULL DEFAULT 0 , 
            engagement_name_ar text  NOT NULL , 
            engagement_name_en text   DEFAULT NULL , 
            academic_level_mfk varchar(255) NOT NULL DEFAULT ',' , 

            
            PRIMARY KEY (`id`)
            ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
            
            //AfwDatabase::db_query("create unique index uk_engagement on ".$server_db_prefix."adm.engagement(engagement_type_id,engagement_name_ar);");

            AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.`engagement` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `engagement_type_id`, `engagement_name_ar`, `engagement_name_en`, `academic_level_mfk`) VALUES
            (1, 1, '2025-12-07 10:52:20', 1, '2025-12-07 10:52:23', 0, NULL, 'Y', 'Y', 2, '', '', '', NULL, 1, 'أقرّ بأن جميع البيانات والمعلومات والوثائق التي قدّمتها في طلب الالتحاق ببرامج الدراسات العليا صحيحة وكاملة، وخالية من أي تحريف أو إخفاء لحقائق جوهرية، وأتحمّل كامل المسؤولية عن ذلك.', 'I acknowledge that all data, information, and documents submitted in my application for admission to graduate programs are true, complete, and free from any misrepresentation or concealment of material facts, and I bear full responsibility for this.', ',11,12,13,14,'),
            (2, 1, '2025-12-07 10:53:41', 1, '2025-12-07 10:53:45', 0, NULL, 'Y', 'Y', 2, '', '', '', NULL, 1, 'أوافق على أن للجامعة الحق في إلغاء طلبي أو إنهاء قبولي في أي مرحلة إذا تبيّن أن قبولي بُنِي على بيانات أو وثائق غير صحيحة كليًا أو جزئيًا، وفقًا للائحة الدراسات العليا والقواعد التنفيذية المعمول بها', 'I agree that the university has the right to cancel my application or terminate my admission at any stage if it is found that my admission was based on data or documents that are wholly or partially incorrect, in accordance with the Graduate Studies Regulations and applicable implementing rules.', ''),
            (3, 1, '2025-12-07 10:54:05', 1, '2025-12-07 10:54:08', 0, NULL, 'Y', 'Y', 2, '', '', '', NULL, 1, 'أوافق على أن للجامعة الحق في التحقق من صحة مؤهلاتي ووثائقي لدى الجهات المختصة داخل المملكة أو خارجها، واتخاذ ما تراه مناسبًا من إجراءات إذا ثبت خلاف ذلك.', 'I agree that the university has the right to verify the authenticity of my qualifications and documents with the relevant authorities within or outside the Kingdom and to take any action it deems appropriate if it is found to be false.', ''),
            (4, 1, '2025-12-07 10:55:30', 1, '2025-12-07 10:55:32', 0, NULL, 'Y', 'Y', 2, '', '', '', NULL, 1, 'أقرّ بأنني اطّلعت على شروط وضوابط القبول المعلنة لبرامج الدراسات العليا، بما في ذلك متطلبات التخصّص والمعدل والاختبارات واللغة، وأوافق على التقيد بها دون اعتراض لاحق.​', 'I acknowledge that I have reviewed the published admission requirements and regulations for graduate programs, including the specialization, GPA, tests, and language requirements, and I agree to abide by them without objection.', ''),
            (5, 1, '2025-12-07 10:55:56', 1, '2025-12-07 10:55:58', 0, NULL, 'Y', 'Y', 2, '', '', '', NULL, 1, 'في حال تم قبول طلب التحاقي بالجامعة، أقرّ بالتزامي بسداد الرسوم الدراسية وأي رسوم أخرى مقرّرة في المواعيد المحددة، وبسياسات الجامعة المتعلقة باسترداد الرسوم عند الانسحاب أو التأجيل.​', 'If my application to the university is accepted, I acknowledge my commitment to paying tuition fees and any other applicable fees by the specified deadlines. .', ''),
            (6, 1, '2025-12-07 10:56:22', 1, '2025-12-07 10:56:24', 0, NULL, 'Y', 'Y', 2, '', '', '', NULL, 1, 'أقرّ بأن رقم الجوال والبريد الإلكتروني المسجلين في طلبي يُعدّان وسيلتي الاتصال الرسميتين، وأتحمّل مسؤولية متابعة الرسائل والتحديث الفوري لبيانات التواصل عند تغييرها.​', 'I acknowledge that the mobile phone number and email address provided in my application are my official means of communication, and I am responsible for monitoring messages and promptly updating my contact information if it changes', ''),
            (7, 1, '2025-12-07 10:56:53', 1, '2025-12-07 10:56:54', 0, NULL, 'Y', 'Y', 2, '', '', '', NULL, 1, 'أفهم أن موافقتي على هذه البنود تمثّل إقرارًا قانونيًا ملزمًا، وتشكل جزءًا لا يتجزأ من مستندات قبولي في برنامج الدراسات العليا بالجامعة.', 'I understand that my agreement to these terms constitutes a legally binding acknowledgment and forms an integral part of my admission documents to the university\'s graduate program.', '');");


            AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS nauss_adm.`application_model_engagement` (
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
            
                
            engagement_id int(11) NOT NULL , 
            application_model_id int(11) NOT NULL , 
            engagement_type_id int(11) NOT NULL , 
            

            
            PRIMARY KEY (`id`)
            ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
        
            AfwDatabase::db_query("create unique index uk_application_model_engagement on ".$server_db_prefix."adm.application_model_engagement(engagement_id,application_model_id,engagement_type_id);");
            
}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}    