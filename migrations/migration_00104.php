<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
          
    AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.action_type;");

    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`action_type` (
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
    
        
    action_type_code varchar(16)  NOT NULL , 
    action_type_name_ar varchar(48)  NOT NULL DEFAULT '' , 
    action_type_name_en varchar(48)  NOT NULL DEFAULT '' , 
    new_record_ind char(1) NOT NULL DEFAULT 'W' ,  

    
    PRIMARY KEY (`id`)
    ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

    AfwDatabase::db_query("create unique index uk_action_type on ".$server_db_prefix."adm.action_type(action_type_code);");


    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.nominating_candidates add   action_type_id int(11) NOT NULL DEFAULT 0  AFTER idn;");
    AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.application_exception;");

    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`application_exception` (
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
    application_plan_id int(11) NOT NULL , 
    application_simulation_id int(11) NOT NULL , 
    expiry_date varchar(8) NOT NULL , 

    
    PRIMARY KEY (`id`)
    ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");



AfwDatabase::db_query("create unique index uk_application_exception on ".$server_db_prefix."adm.application_exception(applicant_id,application_plan_id,application_simulation_id,expiry_date);");
}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}    