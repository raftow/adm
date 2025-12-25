<?php
// medali 03/10/2024
AfwDatabase::db_query("alter table c0adm.applicant_qualification change   source source int(11) DEFAULT NULL  after date");
AfwDatabase::db_query("alter table c0adm.qualification add   gpa_from smallint NOT NULL  after maqbool_id");
AfwDatabase::db_query("update c0adm.qualification set gpa_from=100 where id=49");
AfwDatabase::db_query("update c0adm.qualification set gpa_from=5 where id=54");
AfwDatabase::db_query("update c0adm.qualification set gpa_from=100 where id!=54 and level_enum=20");

AfwDatabase::db_query("alter table c0adm.evaluation change   instructions instructions text  DEFAULT NULL  after examspecialtyname");

AfwDatabase::db_query("INSERT INTO `evaluation` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `evaluation_name_ar`, `evaluation_name_en`, `eval_type_id`, `maxexamresult`, `examresulttype`, `validity_days`, `validity_months`, `validity_years`, `examspecialtycode`, `examspecialtyname`, `instructions`) VALUES
(1, 1, '2024-10-02 14:38:24', 1, '2024-10-02 14:38:24', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, 'اختبار القدرات العامة  للتخصصات العلمية', 'General Aptitude Test for Science Track', 2, 100, 'percentage', NULL, NULL, 5, '01', 'التخصصات العلمية', 'اختبار يقيس القدرات المتعلقة بعمليات التعلم -كالقدرة التحليلية والاستدلالية- لدى خريجي الثانوية العامة، والراغبين بالالتحاق بمؤسسات التعليم العالي.'),
(2, 1, '2024-10-02 14:38:25', 1, '2024-10-02 14:38:25', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, 'اختبار القدرات العامة للتخصصات النظرية', 'General Aptitude Test for Humanities Track', 2, 100, 'percentage', NULL, NULL, 5, '02', 'التخصصات النظرية', 'اختبار يقيس القدرات المتعلقة بعمليات التعلم -كالقدرة التحليلية والاستدلالية- لدى خريجي الثانوية العامة، والراغبين بالالتحاق بمؤسسات التعليم العالي.'),
(3, 1, '2024-10-02 14:38:25', 1, '2024-10-02 14:38:25', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, 'اختبار التحصيل الدراسي للتخصصات العلمية', 'Academic Achievement Test for the Science Track', 1, 100, 'percentage', NULL, NULL, 5, '01', 'التخصصات العلمية', 'اختبار موحد يقيس مدى تحصيل المختبرين في عدد من المواد الدراسية خلال دراستهم في  المسار العام ومسار علوم الصحة والحياة ومسار علوم الحاسب والهندسة من المرحلة الثانوية.​'),
(4, 1, '2024-10-02 14:42:52', 1, '2024-10-02 14:42:52', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, 'اختبار التحصيل الدراسي للتخصصات النظرية', 'Academic Achievement Test for the Humanities Track', 1, 100, 'Percentage', NULL, NULL, 5, '02', 'التخصصات النظرية', 'اختبار موحد يقيس مدى تحصيل المختبرين في عدد من المواد الدراسية خلال دراستهم في مساري الشرعي وإدارة الأعمال من المرحلة الثانوية.​'),
(5, 1, '2024-10-02 14:42:52', 1, '2024-10-02 14:42:52', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, 'اختبار كفايات اللغة الإنجليزية STEP', 'Standardized Test of English Proficiency (STEP)', 4, 100, 'Percentage', NULL, NULL, 3, '01', 'عام', 'يغطي المهارات الأساسية التي يمكن قياسها بموضوعية وثبات لكفايات اللغة الإنجليزية وهو اختبار قريب من الاختبارات العالمية المعروفة (TOEFL and ILETS)، '),
(6, 1, '2024-10-02 14:42:52', 1, '2024-10-02 14:42:52', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, 'اختبار برنامج اللغة الانجليزية المكثف للمؤسسة', 'TTC Intensive English program test', 3, 100, 'Percentage', NULL, NULL, 5, NULL, 'عام', 'يعتبر البرنامج من أهم البرامج التطويرية التي تقدمها المؤسسة العامة للتدريب التقني والمهني  لخريجيها، ويهدف لتمكينهم من اكتساب المهارات في اللغة الانجليزية وفق احتياجات ومتطلبات سوق العمل.')");


AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS c0adm.`admission_agreement_plan_person` (
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
    
      
     identity_type_id int(11) NOT NULL , 
     idn varchar(40)  NOT NULL , 
     applicant_id int(11) NOT NULL , 
     applicant_name varchar(128)  NOT NULL , 
     admission_agreement_plan_id int(11) NOT NULL , 
     applicant_informed char(1) DEFAULT NULL , 
  
    
    PRIMARY KEY (`id`)
  ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1");
  
  AfwDatabase::db_query("create unique index uk_admission_agreement_plan_person on c0adm.admission_agreement_plan_person(applicant_id,admission_agreement_plan_id)");


  AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS c0adm.`admission_agreement_exception` (
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
    
      
     admission_agreement_plan_id int(11) NOT NULL , 
     acondition_id int(11) NOT NULL , 
  
    
    PRIMARY KEY (`id`)
  ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1");
  AfwDatabase::db_query("create unique index uk_admission_agreement_exception on c0adm.admission_agreement_exception(admission_agreement_plan_id,acondition_id)");
  
  AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS c0adm.`admission_agreement` (
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
    
      
     admfile_id int(11) DEFAULT NULL , 
     admission_agreement_name_ar varchar(128)  NOT NULL , 
     admission_agreement_name_en varchar(128)  NOT NULL , 
     third_party_id int(11) NOT NULL , 
     agreement_start_date datetime DEFAULT NULL , 
     agreement_expiry_date datetime DEFAULT NULL , 
     hijri_agreement_start_date varchar(8) NOT NULL , 
     hijri_agreement_expiry_date varchar(8) NOT NULL , 
  
    
    PRIMARY KEY (`id`)
  ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1");
  
  AfwDatabase::db_query("create unique index uk_admission_agreement on c0adm.admission_agreement(admission_agreement_name_ar)");
  

//        