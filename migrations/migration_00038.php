<?php
$server_db_prefix = AfwSession::config("db_prefix", "default_db_");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.acondition_origin add   program_track_mfk varchar(255) DEFAULT NULL  AFTER academic_program_mfk;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.acondition_origin_scope add   program_track_id int(11) NOT NULL  AFTER application_model_branch_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.aparameter_value add major_path_id int(11) DEFAULT NULL  AFTER application_model_branch_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.aparameter_value add program_track_id int(11) DEFAULT NULL  AFTER major_path_id;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.aparameter_value drop key uk_aparameter_value;"); 
AfwDatabase::db_query("CREATE unique index uk_aparameter_value on ".$server_db_prefix."adm.aparameter_value(aparameter_id,application_model_id,application_plan_id,training_unit_id,department_id,application_model_branch_id,major_path_id,program_track_id);");

AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.`applicant_qualification` set imported='N' where imported is null;");

AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.aparameter 
                    SET id=19, aparameter_name_ar = _utf8'ضارب النسبة التراكمية في النسبة الموزونة', 
                        aparameter_name_en = 'coef of cumulative percentage in the weighted percentage', 
                        customizable = 'Y', measurement_unit_ar = _utf8'', measurement_unit_en = '', 
                        aparam_use_scope_id = '5', afield_type_id = '7',                         
                        active = 'Y', created_by = 1, updated_by = 1, validated_by = 0, sci_id = 379, 
                        created_at = '2025-01-29 17:06:34', updated_at = '2025-01-29 17:06:34', `version` = 0;");

AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.aparameter 
                        SET id=20, aparameter_name_ar = _utf8'ضارب درجة اختبار القدرات في النسبة الموزونة', 
                            aparameter_name_en = 'coef of aptitude test score in the weighted percentage', 
                            customizable = 'Y', measurement_unit_ar = _utf8'', measurement_unit_en = '', 
                            aparam_use_scope_id = '5', afield_type_id = '7',                         
                            active = 'Y', created_by = 1, updated_by = 1, validated_by = 0, sci_id = 379, 
                            created_at = '2025-01-29 17:06:34', updated_at = '2025-01-29 17:06:34', `version` = 0;");
    
AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.aparameter 
                            SET id=21, aparameter_name_ar = _utf8'ضارب درجة اختبار التحصيلي في النسبة الموزونة', 
                                aparameter_name_en = 'coef of achievement test score in the weighted percentage', 
                                customizable = 'Y', measurement_unit_ar = _utf8'', measurement_unit_en = '', 
                                aparam_use_scope_id = '5', afield_type_id = '7',                         
                                active = 'Y', created_by = 1, updated_by = 1, validated_by = 0, sci_id = 379, 
                                created_at = '2025-01-29 17:06:34', updated_at = '2025-01-29 17:06:34', `version` = 0;");

AfwDatabase::db_query("DELETE FROM ".$server_db_prefix."adm.`evaluation`");

AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.`evaluation` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `evaluation_name_ar`, `evaluation_name_en`, `eval_type_id`, `maxexamresult`, `examresulttype`, `validity_days`, `validity_months`, `validity_years`, `examspecialtycode`, `examspecialtyname`, `instructions`) VALUES
                                (1, 1, '2025-01-30 10:37:25', 1, '2025-01-30 11:14:09', 0, NULL, 'Y', 'Y', 2, NULL, NULL, NULL, 0, 'اختبار القدرات العامة  للتخصصات العلمية', 'General Aptitude Test for Science Track', 1, 100, 'Percentage', NULL, NULL, 5, '01', 'التخصصات العلمية', 'اختبار يقيس القدرات المتعلقة بعمليات التعلم -كالقدرة التحليلية والاستدلالية- لدى خريجي الثانوية العامة، والراغبين بالالتحاق بمؤسسات التعليم العالي.'),
                                (2, 1, '2025-01-30 11:18:51', 1, '2025-01-30 11:18:51', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, 'اختبار القدرات العامة للتخصصات النظرية', 'General Aptitude Test for Humanities Track', 1, 100, 'Percentage', NULL, NULL, 5, '02', 'التخصصات النظرية', 'اختبار يقيس القدرات المتعلقة بعمليات التعلم -كالقدرة التحليلية والاستدلالية- لدى خريجي الثانوية العامة، والراغبين بالالتحاق بمؤسسات التعليم العالي.'),
                                (3, 1, '2025-01-30 11:18:51', 1, '2025-01-30 11:18:51', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, 'اختبار التحصيل الدراسي للتخصصات العلمية', 'Academic Achievement Test for the Science Track', 2, 100, 'Percentage', NULL, NULL, 5, '01', 'التخصصات العلمية', 'اختبار موحد يقيس مدى تحصيل المختبرين في عدد من المواد الدراسية خلال دراستهم في  المسار العام ومسار علوم الصحة والحياة ومسار علوم الحاسب والهندسة من المرحلة الثانوية.​'),
                                (4, 1, '2025-01-30 11:18:51', 1, '2025-01-30 11:18:51', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, 'اختبار التحصيل الدراسي للتخصصات النظرية', 'Academic Achievement Test for the Humanities Track', 2, 100, 'Percentage', NULL, NULL, 5, '02', 'التخصصات النظرية', 'اختبار موحد يقيس مدى تحصيل المختبرين في عدد من المواد الدراسية خلال دراستهم في مساري الشرعي وإدارة الأعمال من المرحلة الثانوية.​'),
                                (5, 1, '2025-01-30 11:21:24', 1, '2025-01-30 11:21:24', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, 'اختبار كفايات اللغة الإنجليزية STEP', 'Standardized Test of English Proficiency (STEP)', 3, 100, 'Percentage', NULL, NULL, 3, '01', 'عام', 'يغطي المهارات الأساسية التي يمكن قياسها بموضوعية وثبات لكفايات اللغة الإنجليزية وهو اختبار قريب من الاختبارات العالمية المعروفة (TOEFL and ILETS)، '),
                                (6, 1, '2025-01-30 11:21:24', 1, '2025-01-30 11:21:24', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, 'اختبار برنامج اللغة الانجليزية المكثف للمؤسسة', 'TVTC Intensive English program test', 4, 100, 'Percentage', NULL, NULL, 5, '01', 'عام', 'يعتبر البرنامج من أهم البرامج التطويرية التي تقدمها المؤسسة العامة للتدريب التقني والمهني  لخريجيها، ويهدف لتمكينهم من اكتساب المهارات في اللغة الانجليزية وفق احتياجات ومتطلبات سوق العمل.');");

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant add   preferred_program_track_id int(11) DEFAULT NULL  AFTER email; "); 

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`aparameter_value` CHANGE major_path_id major_path_id INT(11) NOT NULL DEFAULT 0; "); 
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.`aparameter_value` set `major_path_id` = 0 where `major_path_id` is null; "); 
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`aparameter_value` CHANGE program_track_id program_track_id INT(11) NOT NULL DEFAULT 0; "); 
AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.`aparameter_value` set `program_track_id` = 0 where `program_track_id` is null; "); 
        
AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.`application_field` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, 
                        `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, 
                        `field_name`, `shortname`, `application_table_id`, `application_field_type_id`, `field_title_ar`, `field_title_en`, 
                        `usable_in_conditions`, `reel`, `additional`, `unit`, `unit_en`, `field_order`, `field_num`, `field_size`, 
                        `help_text`, `help_text_en`, `question_text`, `question_text_en`) VALUES
(110953, 1, '2025-01-31 21:59:42', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', 2, 
                        NULL, NULL, NULL, NULL, 
                        'weighted_percentage', '', 3, 16, 'النسبة الموزونة', 'weighted percentage', 
                        'Y', 'N', 'N', '', '', 50, NULL, 32, NULL, NULL, NULL, NULL); ");  

AfwDatabase::db_query("update ".$server_db_prefix."adm.applicant set employer_approval = 'N' where employer_approval is null or employer_approval != 'N';");  

/**
 * INSERT INTO uoh_adm.`aparameter` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `aparameter_name_ar`, `aparameter_name_en`, `customizable`, `afield_type_id`, `answer_table_id`, `measurement_unit_ar`, `measurement_unit_en`, `tprogram_mfk`, `aparam_use_scope_id`, `readonly`) VALUES
 * (22, 1, '2025-02-01 13:41:03', 1, '2025-02-01 13:41:13', 0, NULL, 'Y', 'Y', 2, NULL, NULL, NULL, 380, 'النسبة الموزونة الأدنى المشروطة', 'Conditional minimum weighted ratio', 'Y', 7, NULL, '%', '%', NULL, 1, NULL);
 * 
 */
