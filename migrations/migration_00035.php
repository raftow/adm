<?php
$server_db_prefix = AfwSession::config("db_prefix", "default_db_");

AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.program_track;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`program_track` (
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
  
  `lookup_code` varchar(64) DEFAULT NULL,  
   track_code varchar(50)  NOT NULL , 
   application_model_id int(11) DEFAULT NULL , 
   track_name_ar varchar(50)  NOT NULL , 
   track_name_en varchar(50)  NOT NULL , 
   sorting_instructions text  DEFAULT NULL , 
   sorting_formula varchar(200)  DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");