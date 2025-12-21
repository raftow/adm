<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
          

    
    AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.study_type;");

    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`study_type` (
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
    
    lookup_code varchar(16)  DEFAULT NULL , 
    name_ar varchar(128)  NOT NULL DEFAULT '' , 
    name_en varchar(128)  NOT NULL DEFAULT '' , 
    desc_ar text  DEFAULT NULL , 
    desc_en text  DEFAULT NULL , 
    
    PRIMARY KEY (`id`)
  ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

  AfwDatabase::db_query("create unique index uk_study_type on ".$server_db_prefix."adm.study_type(lookup_code);");
  AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant_qualification add   study_type_id int(11) NOT NULL DEFAULT 0  AFTER grading_scale_id;");

}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}    