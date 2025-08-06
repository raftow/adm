<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire drop application_id;");
    AfwDatabase::db_query("CREATE TABLE ".$server_db_prefix."adm.application_tmp_76 as select * from ".$server_db_prefix."adm.application;");

    AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.`application`;");
    AfwDatabase::db_query("CREATE TABLE ".$server_db_prefix."adm.`application` (
        `created_by` int NOT NULL,
        `created_at` datetime NOT NULL,
        `updated_by` int NOT NULL,
        `updated_at` datetime NOT NULL,
        `validated_by` int DEFAULT NULL,
        `validated_at` datetime DEFAULT NULL,
        `active` char(1) COLLATE utf8mb3_unicode_ci NOT NULL,
        `draft` char(1) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'Y',
        `version` int DEFAULT NULL,
        `update_groups_mfk` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
        `delete_groups_mfk` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
        `display_groups_mfk` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
        `sci_id` int DEFAULT NULL,
        `applicant_id` bigint NOT NULL,
        `idn` varchar(32) COLLATE utf8mb3_unicode_ci NOT NULL,
        `application_plan_id` int NOT NULL,
        `application_model_id` int NOT NULL,
        `application_simulation_id` int NOT NULL,
        `step_num` smallint DEFAULT NULL,
        `application_step_id` int DEFAULT NULL,
        `program_id` int DEFAULT NULL,
        `application_status_enum` smallint DEFAULT NULL,
        `applicant_decision_enum` smallint NOT NULL DEFAULT '0',
        `comments` varchar(256) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
        `applicant_qualification_id` int DEFAULT NULL,
        `weighted_pctg` float DEFAULT NULL,
        `qualification_id` int DEFAULT NULL,
        `major_category_id` int DEFAULT NULL,
        `application_plan_branch_mfk` text COLLATE utf8mb3_unicode_ci,
        `attribute_1` smallint DEFAULT NULL,
        `attribute_2` smallint DEFAULT NULL,
        PRIMARY KEY (`applicant_id`,`application_plan_id`,`application_simulation_id`),
        KEY `application_plan_id` (`application_plan_id`,`application_simulation_id`,`active`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
    PARTITION BY HASH (`applicant_id`)
    PARTITIONS 200;");

    AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.`application` (`created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `applicant_id`, `idn`, `application_plan_id`, `application_model_id`, `application_simulation_id`, `step_num`, `application_step_id`, `program_id`, `application_status_enum`, `applicant_decision_enum`, `comments`, `applicant_qualification_id`, `weighted_pctg`, `qualification_id`, `major_category_id`, `application_plan_branch_mfk`, `attribute_1`, `attribute_2`) ".
    "SELECT `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `applicant_id`, `idn`, `application_plan_id`, `application_model_id`, `application_simulation_id`, `step_num`, `application_step_id`, `program_id`, `application_status_enum`, `applicant_decision_enum`, `comments`, `applicant_qualification_id`, `weighted_pctg`, `qualification_id`, `major_category_id`, `application_plan_branch_mfk`, `attribute_1`, `attribute_2` 
     FROM ".$server_db_prefix."adm.application_tmp_76;");

AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.`applicant_fintrans`");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`applicant_fintrans` (
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
   application_plan_id int(11) NOT NULL , 
   application_simulation_id int(11) NOT NULL , 
   appmodel_fintran_id int(11) NOT NULL , 
   total_amount   float NOT NULL , 
   payment_status_enum smallint NOT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

AfwDatabase::db_query("create unique index uk_applicant_fintrans on ".$server_db_prefix."adm.applicant_fintrans(applicant_id,application_plan_id, application_simulation_id,appmodel_fintran_id);");    

AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.`applicant_account`");

AfwDatabase::db_query("CREATE TABLE ".$server_db_prefix."adm.`applicant_account` (
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
   application_plan_id int(11) NOT NULL , 
   application_simulation_id int(11) NOT NULL ,  
   application_model_financial_transaction_id int(11) NOT NULL , 
   total_amount   float NOT NULL , 
   payment_status_enum smallint NOT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

AfwDatabase::db_query("create unique index uk_applicant_account on ".$server_db_prefix."adm.applicant_account(applicant_id,application_plan_id,application_simulation_id,application_model_financial_transaction_id);");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`applicant_scholarship` (
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
     scholarship_id int(11) NOT NULL , 
     applicant_scholarship_status_id int(11) DEFAULT NULL , 
     application_plan_id int(11) DEFAULT NULL , 
     application_simulation_id int(11) NOT NULL ,
     academic_term_id int(11) DEFAULT NULL , 
     academic_year_id int(11) DEFAULT NULL , 
     academic_program_id int(11) DEFAULT NULL , 
     remarks varchar(250)  DEFAULT NULL , 
  
    
    PRIMARY KEY (`id`)
  ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
  
   AfwDatabase::db_query("create unique index uk_applicant_scholarship on ".$server_db_prefix."adm.applicant_scholarship(applicant_id,scholarship_id);");
  

}
catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}