<?php
if (!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try {

    AfwDatabase::db_query("DROP TABLE IF EXISTS " . $server_db_prefix . "adm.sis_level_code;");

    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS " . $server_db_prefix . "adm.`sis_level_code` (
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


AfwDatabase::db_query("CREATE UNIQUE INDEX uk_sis_level_code ON " . $server_db_prefix . "adm.sis_level_code(lookup_code);");

AfwDatabase::db_query("DROP TABLE IF EXISTS " . $server_db_prefix . "adm.sis_program_code;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS " . $server_db_prefix . "adm.`sis_program_code` (
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
   sis_level_code int(11) DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("CREATE UNIQUE INDEX uk_sis_program_code ON " . $server_db_prefix . "adm.sis_program_code(lookup_code,sis_level_code);");

    AfwDatabase::db_query("DROP TABLE IF EXISTS " . $server_db_prefix . "adm.sis_major_code;");

    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS " . $server_db_prefix . "adm.`sis_major_code` (
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
   sis_program_code_id int(11) NOT NULL , 
   
  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

  
AfwDatabase::db_query("CREATE UNIQUE INDEX uk_sis_major_code ON " . $server_db_prefix . "adm.sis_major_code(lookup_code,sis_program_code_id);");


AfwDatabase::db_query("alter table " . $server_db_prefix . "adm.applicant add sis_continuous_ind char(1) NOT NULL default 'N' after passeport_expiry_gdate;");
AfwDatabase::db_query("alter table " . $server_db_prefix . "adm.applicant add sis_graduate_ind char(1) NOT NULL default 'N' after sis_continuous_ind;");
AfwDatabase::db_query("alter table " . $server_db_prefix . "adm.applicant add sis_withdrawn_ind char(1) NOT NULL default 'N' after sis_graduate_ind;");
AfwDatabase::db_query("alter table " . $server_db_prefix . "adm.applicant add sis_dismissed_ind char(1) NOT NULL default 'N' after sis_withdrawn_ind;");
AfwDatabase::db_query("alter table " . $server_db_prefix . "adm.applicant add sis_closed_ind char(1) NOT NULL default 'N' after sis_dismissed_ind;");
AfwDatabase::db_query("alter table " . $server_db_prefix . "adm.applicant add sis_visitor_ind char(1) NOT NULL default 'N' after sis_closed_ind;");


AfwDatabase::db_query("DROP TABLE IF EXISTS nauss_adm.sis_sponsor_code;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS nauss_adm.`sis_sponsor_code` (
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
  
  `lookup_code` varchar(64) DEFAULT NULL,  
   lookup_code varchar(16)  DEFAULT NULL , 
   name_ar varchar(128)  NOT NULL DEFAULT '' , 
   name_en varchar(128)  NOT NULL DEFAULT '' , 
   desc_ar text  DEFAULT NULL , 
   desc_en text  DEFAULT NULL , 
   validated_by int(11) DEFAULT NULL , 
   validated_at datetime DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

 
AfwDatabase::db_query("CREATE UNIQUE INDEX uk_sis_sponsor_code ON " . $server_db_prefix . "adm.sis_sponsor_code(lookup_code);");

AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.nominating_authority change   sis_code sis_code int(11) DEFAULT NULL  AFTER country_id;");

} catch (Exception $e) {
    $migration_error .= " " . $e->getMessage();
}
