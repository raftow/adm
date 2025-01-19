<?php
$server_db_prefix = AfwSession::config("db_prefix", "default_db_");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`scholarship` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `created_by` int(11) NOT NULL,
    `created_at`   datetime NOT NULL,
    `updated_by` int(11) NOT NULL,
    `updated_at` datetime NOT NULL,
    `validated_by` int(11) DEFAULT NULL,
    `validated_at` datetime DEFAULT NULL,
    `active` char(1) NOT NULL,
    `draft` char(1) NOT NULL default  Y ,
    `version` int(4) DEFAULT NULL,
    `update_groups_mfk` varchar(255) DEFAULT NULL,
    `delete_groups_mfk` varchar(255) DEFAULT NULL,
    `display_groups_mfk` varchar(255) DEFAULT NULL,
    `sci_id` int(11) DEFAULT NULL,
    
      
     scholarship_name_ar varchar(100)  NOT NULL , 
     scholarship_name_en varchar(100)  NOT NULL , 
     scholarship_code varchar(20)  NOT NULL , 
     scholarship_type int(11) NOT NULL , 
     percentage float DEFAULT NULL , 
     cap_amount float DEFAULT NULL , 
     sponsor_id int(11) NOT NULL , 
     scholarship_date datetime DEFAULT NULL , 
     adm_file_id int(11) DEFAULT NULL , 
     publish char(1) DEFAULT NULL , 
     application_start_date datetime DEFAULT NULL , 
     application_end_date datetime DEFAULT NULL , 
     academic_year_id int(11) DEFAULT NULL , 
     academic_term_id int(11) DEFAULT NULL , 
     academic_program_id int(11) DEFAULT NULL , 
  
    
    PRIMARY KEY (`id`)
  ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

// some previleges
// faq

$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'scholarship', 183, "+t", "qsearch", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'program_track', 189, "+t", "qsearch", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'academic_program', 189, "+t", "qsearch", null);
$migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'academic_level', 189, "+t", "qsearch", null);

