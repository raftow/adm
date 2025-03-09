<?php

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");




AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`educational_zone` (
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
     educational_zone_ar varchar(100)  NOT NULL , 
     educational_zone_en varchar(100)  NOT NULL , 
  
    
    PRIMARY KEY (`id`)
  ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
  
   AfwDatabase::db_query("create unique index uk_educational_zone on ".$server_db_prefix."adm.educational_zone(educational_zone_ar,educational_zone_en);");

   AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant_qualification add   educational_zone_id int(11) NOT NULL  AFTER gpa;");