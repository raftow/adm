<?php
// rafik 06/10/2024
AfwDatabase::db_query("ALTER TABLE c0adm.application add   program_id int(11) NOT NULL  after application_step_id;");

AfwDatabase::db_query("INSERT INTO c0adm.`application_field` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `field_name`, `shortname`, `application_table_id`, `application_field_type_id`, `field_title_ar`, `field_title_en`, `reel`, `additional`, `unit`, `unit_en`, `field_order`, `field_num`, `field_size`, `help_text`, `help_text_en`, `question_text`, `question_text_en`) 
                      VALUES (110809, 1, '2024-10-06 11:25:36', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', 2, NULL, NULL, NULL, NULL, 'program_id', '', 1, 5, 'البرنامج', 'The program', 'Y', 'N', '', '', 60, NULL, 32, NULL, NULL, NULL, NULL);");

// acondition_origin_scope filter defaults       

AfwDatabase::db_query("UPDATE c0adm.`acondition_origin_scope` set training_unit_id = 0 where training_unit_id is null;");
AfwDatabase::db_query("UPDATE c0adm.`acondition_origin_scope` set department_id = 0 where department_id is null;");
AfwDatabase::db_query("UPDATE c0adm.`acondition_origin_scope` set application_model_branch_id = 0 where application_model_branch_id is null;");


// application_model_condition
AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS c0adm.`application_model_condition` (
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
  
    
   application_model_id int(11) NOT NULL , 
   acondition_origin_id int(11) NOT NULL , 
   general char(1) NOT NULL , 
   step_num smallint DEFAULT NULL , 
   acondition_id varchar(64)  NOT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

AfwDatabase::db_query("CREATE unique index uk_application_model_condition on c0adm.application_model_condition(application_model_id,acondition_id);");

// application_model_field
AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS c0adm.`application_model_field` (
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
    
      
     application_model_id int(11) NOT NULL , 
     acondition_id int(11) NOT NULL , 
     application_field_id int(11) NOT NULL , 
     screen_model_id int(11) NOT NULL , 
     step_num smallint NOT NULL , 
  
    
    PRIMARY KEY (`id`)
  ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
  
  
  
  
  // unique index : 
  AfwDatabase::db_query("CREATE unique index uk_application_model_field on c0adm.application_model_field(application_model_id,application_field_id);");
