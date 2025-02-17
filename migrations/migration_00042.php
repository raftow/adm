<?php

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");

/**/
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_step add step_code varchar(3)  NOT NULL  AFTER step_name_en;");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_desire add   comments varchar(128)  DEFAULT NULL  AFTER desire_status_enum;");

AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."ums.jobrole SET id=214, jobrole_code = 'roles-prev', titre_short = _utf8'الصلاحيات والإمتيازات', titre_short_en = 'Roles & Privileges', titre = _utf8'الصلاحيات والإمتيازات', titre_en = 'Roles & Privileges', id_sh_org = 0, id_sh_div = 0, avail = 'Y', id_aut = 1, id_mod = 1, id_valid = 0, id_domain = 25, date_aut = '2025-02-16 15:16:35', date_mod = '2025-02-16 15:16:35', version = 1");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`adm_emp_request` (
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
    
      
     orgunit_id int(11) NOT NULL , 
     employee_id int(11) NOT NULL , 
     email varchar(32)  DEFAULT NULL , 
     approved char(1) DEFAULT NULL , 
     reject_reason_ar text  DEFAULT NULL , 
     reject_reason_en text  DEFAULT NULL , 
  
    
    PRIMARY KEY (`id`)
  ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("CREATE unique index uk_adm_emp_request on ".$server_db_prefix."adm.adm_emp_request(orgunit_id,employee_id,email);");  

AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.adm_employee;");  

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`adm_employee` (
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
    orgunit_id int(11) NOT NULL , 
    employee_id int(11) NOT NULL , 
    jobrole_mfk varchar(255) NOT NULL , 
    hierarchy_level_enum smallint NOT NULL , 
    requests_nb smallint NOT NULL , 
    approved char(1) DEFAULT NULL , 
    admin char(1) DEFAULT NULL , 
    super_admin char(1) DEFAULT NULL ,  
  
    
    PRIMARY KEY (`id`)
  ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
  
   
  
  AfwDatabase::db_query("CREATE unique index uk_adm_employee on ".$server_db_prefix."adm.adm_employee(orgunit_id,employee_id);");


  AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`adm_orgunit` (
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
  
    
   orgunit_id int(11) NOT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

  AfwDatabase::db_query("CREATE unique index uk_adm_orgunit on ".$server_db_prefix."adm.adm_orgunit(orgunit_id);");


  AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."hrm.orgunit add   titre_short_en varchar(48)  DEFAULT NULL  AFTER titre;");
  AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."hrm.orgunit add   titre_en varchar(48)  DEFAULT NULL  AFTER titre_short_en;");
  AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.institution add   orgunit_id int(11) NOT NULL  AFTER simulation_applicants_ids;");
  AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.training_unit add orgunit_id int(11) DEFAULT NULL  AFTER `description`;");