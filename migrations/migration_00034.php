<?php
$server_db_prefix = AfwSession::config("db_prefix", "default_db_");

AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."workflow.workflow_file;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."workflow.`workflow_file` (
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
  
    
   original_name varchar(48)  DEFAULT NULL , 
   owner_type varchar(32)  DEFAULT NULL , 
   owner_id smallint DEFAULT NULL , 
   afile_name varchar(48)  DEFAULT NULL , 
   doc_type_id int(11) DEFAULT NULL , 
   afile_ext varchar(32)  DEFAULT NULL , 
   afile_type varchar(32)  DEFAULT NULL , 
   picture char(1) DEFAULT NULL , 
   afile_size smallint DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");