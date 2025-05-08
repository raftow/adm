<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
try
{
  AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.acondition add   when_apply_enum smallint NOT NULL  AFTER show_fe;");
  AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.acondition me SET when_apply_enum = '1' WHERE when_apply_enum = 0 or when_apply_enum is null;");
  AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`applicant_step_request` (
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
    
      
     applicant_id int(11) NOT NULL , 
     application_plan_id int(11) DEFAULT NULL , 
     application_model_id int(11) DEFAULT NULL , 
     step_num smallint DEFAULT NULL , 
     api_endpoint_id int(11) DEFAULT NULL,
     done char(1) NOT NULL , 
     status_date varchar(8) DEFAULT NULL , 
  
    
    PRIMARY KEY (`id`)
  ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
   
    if($mode_is_dev) $migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'applicant_step_request', 198, "+t", "qsearch", null);
    
    AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.sorting_session_stat;");

    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`sorting_session_stat` (
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
        
            
        application_plan_id int(11) NOT NULL , 
        session_num smallint NOT NULL , 
        application_simulation_id int(11) NOT NULL , 
        application_plan_branch_id int(11) NOT NULL , 
        track_num smallint NOT NULL , 
        capacity smallint NOT NULL , 
        nb_accepted smallint NOT NULL , 
        min_app_score1 float DEFAULT NULL , 
        min_app_score2 float DEFAULT NULL , 
        min_app_score3 float DEFAULT NULL , 
        min_acc_score1 float DEFAULT NULL , 
        min_acc_score2 float DEFAULT NULL , 
        min_acc_score3 float DEFAULT NULL , 

        
        PRIMARY KEY (`id`)
        ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

    
    
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant_step_request add   error_message text  DEFAULT NULL  AFTER status_date;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant_step_request add   support_category varchar(16)  DEFAULT NULL  AFTER error_message;");
    AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."ums.`idn_type` (`id`, `id_aut`, `date_aut`, `id_mod`, `date_mod`, `id_valid`, `date_valid`, `avail`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `lookup_code`, `idn_type_name`, `nationalty_id`, `country_id`, `idn_type_name_ar`, `idn_type_name_en`, `idn_validation_function`) VALUES ('4', '1', '2025-05-03 13:09:56.000000', '1', '2025-05-03 13:09:56.000000', NULL, NULL, 'Y', NULL, NULL, NULL, NULL, '1', NULL, 'جواز سفر', '0', '0', 'جواز سفر', 'Passeport', '');");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`applicant` ADD PRIMARY KEY(`id`);");

    // should be unique but unicity with partionning on ID in mysql can not
    // the unique index should be included in partionning key
    // so we will ensure the unicity in application side (by PHP)
    AfwDatabase::db_query("CREATE index uk_applicant on ".$server_db_prefix."adm.applicant(country_id,idn_type_id,idn);");

    /*AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.applicant_step_request;");*/

    
    

    AfwDatabase::db_query("CREATE unique index uk_applicant_step_request on ".$server_db_prefix."adm.applicant_step_request(applicant_id,application_plan_id,step_num);");
    

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.api_endpoint add   priority_num smallint DEFAULT NULL  AFTER application_field_mfk;");
    AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.api_endpoint set priority_num = id - 5");
    AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.api_endpoint set priority_num = priority_num + 13 where priority_num < 0");    
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.api_endpoint add   institution_id int(11) DEFAULT NULL  AFTER priority_num;");
    AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.api_endpoint set institution_id = 1");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model_field add   api_endpoint2_id int(11) NOT NULL  AFTER api_endpoint_id;");    
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_plan_branch add   sorting_group_id int(11) DEFAULT NULL  AFTER direct_adm_capacity;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_session add   started_ind char(1) NOT NULL DEFAULT 'N' AFTER upgraded;");
    AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.sorting_session set started_ind = 'N'");    
    AfwDatabase::db_query("DELETE FROM ".$server_db_prefix."adm.`major_path` WHERE id > 143");
    
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model_branch add   capacity_track1 smallint DEFAULT NULL  AFTER direct_adm_capacity;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model_branch add   capacity_track2 smallint DEFAULT NULL  AFTER capacity_track1;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model_branch add   capacity_track3 smallint DEFAULT NULL  AFTER capacity_track2;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_model_branch add   capacity_track4 smallint DEFAULT NULL  AFTER capacity_track3;");
    
    
    if($server_db_prefix=="uoh_")
    {
        AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant add   attribute_10 char(1) DEFAULT NULL  AFTER attribute_9;");
    }
    
    AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.disability;");
    
    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`disability` (
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
      
        
       name_ar varchar(128)  NOT NULL , 
       desc_ar text  DEFAULT NULL , 
       name_en varchar(128)  NOT NULL , 
       desc_en text  DEFAULT NULL , 
       lookup_code varchar(16)  NOT NULL , 
    
      
      PRIMARY KEY (`id`)
    ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
    
    
    AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.`disability` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `name_ar`, `desc_ar`, `name_en`, `desc_en`, `lookup_code`) VALUES
    (1, 1, '2025-04-29 11:15:58', 1, '2025-04-29 11:15:58', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'المكفوفين', '', 'Blind ', '', '02'),
    (2, 1, '2025-04-29 11:15:58', 1, '2025-04-29 11:15:58', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'الصم والبكم', '', 'Deaf and dumb ', '', '03'),
    (3, 1, '2025-04-29 11:15:58', 1, '2025-04-29 11:15:58', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, ' شلل الأطفال', '', '  Polio ', '', '06'),
    (4, 1, '2025-04-29 11:15:58', 1, '2025-04-29 11:15:58', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, ' شلل سفلي', '', '  Paraplegia ', '', '07'),
    (5, 1, '2025-04-29 11:15:58', 1, '2025-04-29 11:15:58', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, ' صعوبة في النطق', '', '  Difficulty in pronunciation ', '', '08'),
    (6, 1, '2025-04-29 11:15:58', 1, '2025-04-29 11:15:58', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, ' تشوهات خلقية', '', '  Congenital malformations ', '', '09'),
    (7, 1, '2025-04-29 11:15:58', 1, '2025-04-29 11:15:58', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'ضعف السمع', '', 'Hearing impairment ', '', '10'),
    (8, 1, '2025-04-29 11:15:58', 1, '2025-04-29 11:15:58', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, ' أمراض الدم', '', '  Blood Diseases ', '', '11'),
    (9, 1, '2025-04-29 11:15:58', 1, '2025-04-29 11:15:58', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, ' قصر أو بتر بالأطراف السفلية', '', '  Palace parties or amputation of the lower ', '', '12'),
    (10, 1, '2025-04-29 11:15:58', 1, '2025-04-29 11:15:58', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, ' فشل كلوي', '', '  Renal failure', '', '13'),
    (11, 1, '2025-04-29 11:15:58', 1, '2025-04-29 11:15:58', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'شديد الاعاقة', '', 'Severe Disability', '', '14'),
    (12, 1, '2025-04-29 11:15:58', 1, '2025-04-29 11:15:58', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'متوسط الاعاقة', '', 'Moderate Disability', '', '15'),
    (13, 1, '2025-04-29 11:15:58', 1, '2025-04-29 11:15:58', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'مجموعة الإعاقات الجسدية', '', 'Physical Disabilities Group', '', '17'),
    (14, 1, '2025-04-29 11:15:58', 1, '2025-04-29 11:15:58', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'مجموعة الإعاقات الحسية(يرفق تقرير طبي)', '', 'Sensory Disabilities Group (Attach a medical report)', '', '18'),
    (15, 1, '2025-04-29 11:15:58', 1, '2025-04-29 11:15:58', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'مجموعة الإعاقات المركبة', '', 'Complex Disabilities Group', '', '19'),
    (16, 1, '2025-04-29 11:15:58', 1, '2025-04-29 11:15:58', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'مجموعة الإعاقات الذهنية', '', 'Intellectual Disabilities Group', '', '20'),
    (17, 1, '2025-04-29 11:15:58', 1, '2025-04-29 11:15:58', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, 'مجموعة الإعاقات المرضية', '', 'Disease Disabilities Group', '', '21');");
    
    AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.`program_qualification` set `qualification_major_id`=0 where `qualification_major_id` is null;");
    
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant add   disability_ind char(1) NOT NULL  AFTER log;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant add   disability_mfk varchar(255) DEFAULT NULL  AFTER disability_ind;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire add   track_num smallint NOT NULL  AFTER major_category_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_plan_branch add   capacity_track1 smallint DEFAULT NULL  AFTER direct_adm_capacity;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_plan_branch add   capacity_track2 smallint DEFAULT NULL  AFTER capacity_track1;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_plan_branch add   capacity_track3 smallint DEFAULT NULL  AFTER capacity_track2;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_plan_branch add   capacity_track4 smallint DEFAULT NULL  AFTER capacity_track3;");
}
catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}


if($server_db_prefix=="uoh_")
{
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 0, capacity_track2 = 0, capacity_track3 = 0, capacity_track4 = 0 where application_model_id = 11");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 900 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  30");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 750 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  30");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 105 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  31");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 565 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  31");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 255 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  33");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 255 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  33");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 325 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  32");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 325 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  32");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 130 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  3");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 130 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  3");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 125 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  22");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 125 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  36");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 145 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  25");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 145 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  22");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 135 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  36");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 125 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  25");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 135 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  21");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 125 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  21");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 30 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  3");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 18 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  3");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 130 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  29");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 130 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  28");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 130 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  27");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 130 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  26");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 165 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  29");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 165 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  28");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 165 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  27");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 165 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  26");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 125 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  19");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 25 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  19");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 135 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  19");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 50 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  19");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 125 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  18");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 18 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  18");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 130 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  38");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 13 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  38");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 130 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  17");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 13 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  17");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 136 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  2");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 7 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  2");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 165 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  11");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 4 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  11");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 205 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  20");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 5 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  20");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 177 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  16");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 7 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  16");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 144 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  4");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 4 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  4");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 135 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  18");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 18 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  18");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 155 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  17");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 18 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  17");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 135 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  2");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 18 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  2");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 155 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  11");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 18 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  11");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 205 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  20");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 23 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  20");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 175 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  16");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 35 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  16");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 155 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  4");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 38 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  4");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 136 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  12");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 9 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  12");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 125 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  14");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 12 where application_model_id = 11 and training_unit_id = 6 and academic_program_id =  14");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 155 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  5");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 23 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  5");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 165 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  12");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 18 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  12");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 130 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  14");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 18 where application_model_id = 11 and training_unit_id = 2 and academic_program_id =  14");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 165 where application_model_id = 11 and training_unit_id = 1 and academic_program_id =  34");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 205 where application_model_id = 11 and training_unit_id = 3 and academic_program_id =  6");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 18 where application_model_id = 11 and training_unit_id = 3 and academic_program_id =  6");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 150 where application_model_id = 11 and training_unit_id = 4 and academic_program_id =  6");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 18 where application_model_id = 11 and training_unit_id = 4 and academic_program_id =  6");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 150 where application_model_id = 11 and training_unit_id = 4 and academic_program_id =  9");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 18 where application_model_id = 11 and training_unit_id = 4 and academic_program_id =  9");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 150 where application_model_id = 11 and training_unit_id = 4 and academic_program_id =  7");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 165 where application_model_id = 11 and training_unit_id = 4 and academic_program_id =  34");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 190 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  6");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 35 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  6");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 190 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  9");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 35 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  9");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 160 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  39");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 155 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  34");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 155 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  41");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 190 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  7");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 150 where application_model_id = 11 and training_unit_id = 4 and academic_program_id =  8");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 165 where application_model_id = 11 and training_unit_id = 4 and academic_program_id =  37");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 185 where application_model_id = 11 and training_unit_id = 1 and academic_program_id =  6");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 18 where application_model_id = 11 and training_unit_id = 1 and academic_program_id =  6");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 185 where application_model_id = 11 and training_unit_id = 1 and academic_program_id =  37");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 145 where application_model_id = 11 and training_unit_id = 5 and academic_program_id =  15");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 235 where application_model_id = 11 and training_unit_id = 5 and academic_program_id =  37");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 205 where application_model_id = 11 and training_unit_id = 3 and academic_program_id =  34");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 18 where application_model_id = 11 and training_unit_id = 4 and academic_program_id =  8");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 150 where application_model_id = 11 and training_unit_id = 1 and academic_program_id =  1");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 20 where application_model_id = 11 and training_unit_id = 1 and academic_program_id =  1");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 190 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  8");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 20 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  8");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 145 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  37");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 35 where application_model_id = 11 and training_unit_id = 4 and academic_program_id =  24");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 30 where application_model_id = 11 and training_unit_id = 4 and academic_program_id =  23");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 150 where application_model_id = 11 and training_unit_id = 4 and academic_program_id =  10");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 18 where application_model_id = 11 and training_unit_id = 4 and academic_program_id =  10");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 165 where application_model_id = 11 and training_unit_id = 4 and academic_program_id =  35");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 35 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  24");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 190 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  10");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 20 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  10");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 67 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  40");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 15 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  40");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 35 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  23");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 155 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  35");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track2 = 68 where application_model_id = 11 and training_unit_id = 4 and academic_program_id =  40");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 18 where application_model_id = 11 and training_unit_id = 4 and academic_program_id =  40");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 30 where application_model_id = 11 and training_unit_id = 5 and academic_program_id =  15");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 18 where application_model_id = 11 and training_unit_id = 4 and academic_program_id =  7");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set capacity_track1 = 15 where application_model_id = 11 and training_unit_id = 7 and academic_program_id =  7;");
    AfwDatabase::db_query("UPDATE uoh_adm.application_model_branch set seats_capacity = capacity_track1+capacity_track2 where application_model_id = 11");
}