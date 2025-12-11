<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
          
AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.cv_rubric;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`cv_rubric` (
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
  
   cv_rubric_ar varchar(32)  NOT NULL , 
   cv_rubric_en varchar(32)  NOT NULL DEFAULT '' , 
   weight float NOT NULL DEFAULT 0.0 , 
   percentage float NOT NULL DEFAULT 0.0 , 
   module_name varchar(48)  NOT NULL DEFAULT '' , 
  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


 
AfwDatabase::db_query("create unique index uk_cv_rubric on ".$server_db_prefix."adm.cv_rubric(cv_rubric_ar);");




AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.conference_role;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`conference_role` (
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
   scoring_multiplier float NOT NULL DEFAULT 0.0 , 
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

 
AfwDatabase::db_query("create unique index uk_conference_role on ".$server_db_prefix."adm.conference_role(lookup_code);");

AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.applicant_scientific_conference;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`applicant_scientific_conference` (
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
  
    
   applicant_id bigint(20) NOT NULL , 
   event_name_ar varchar(32)  NOT NULL , 
   event_name_en varchar(48)  NOT NULL DEFAULT '' , 
   conference_role_id int(11) NOT NULL DEFAULT 0 , 
   event_topic varchar(255)  NOT NULL DEFAULT '' , 
   event_date datetime NOT NULL DEFAULT '19800101' , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("create unique index uk_applicant_scientific_conference on ".$server_db_prefix."adm.applicant_scientific_conference(applicant_id,event_name_ar);");







AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.applicant_courses;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`applicant_courses` (
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
  
    
   applicant_id bigint(20) NOT NULL , 
   course_title_ar varchar(64)  NOT NULL , 
   course_title_en varchar(64)  NOT NULL DEFAULT '' , 
   course_provider_ar varchar(32)  NOT NULL DEFAULT '' , 
   course_provider_en varchar(32)  NOT NULL DEFAULT '' , 
   course_date datetime NOT NULL DEFAULT '19800101' , 
   course_duration float NOT NULL DEFAULT 0.0 , 
   certificate_ind char(1) NOT NULL DEFAULT 'W' , 
   certificate_file_id int(11) DEFAULT NULL ,  

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("create unique index uk_applicant_courses on ".$server_db_prefix."adm.applicant_courses(applicant_id,course_title_ar);");


AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.sector;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`sector` (
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
   scoring_multiplier float NOT NULL DEFAULT 0.0 ,
  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("create unique index uk_sector on ".$server_db_prefix."adm.sector(lookup_code);");


AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.applicant_professional_experience;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`applicant_professional_experience` (
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
  
    
   applicant_id bigint(20) NOT NULL , 
   job_title_ar varchar(64)  NOT NULL DEFAULT '' , 
   job_title_en varchar(64)  NOT NULL DEFAULT '' , 
   employer varchar(100)  NOT NULL , 
   sector_id int(11) NOT NULL DEFAULT 0 , 
   join_date datetime NOT NULL , 
   job_duration smallint NOT NULL DEFAULT 0 , 
   key_mission text  DEFAULT NULL , 
   experience_file_id int(11) DEFAULT NULL ,

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");



AfwDatabase::db_query("create unique index uk_applicant_professional_experience on ".$server_db_prefix."adm.applicant_professional_experience(applicant_id,employer,join_date);");




AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.certification_level;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`certification_level` (
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
  scoring_multiplier float NOT NULL DEFAULT 0.0 , 
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
 
AfwDatabase::db_query("create unique index uk_certification_level on ".$server_db_prefix."adm.certification_level(lookup_code);");



AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.applicant_certification_appreciation;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`applicant_certification_appreciation` (
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
  
    
   applicant_id bigint(20) NOT NULL , 
   certification_issuer varchar(60)  NOT NULL DEFAULT '' , 
   certification_level_id int(11) NOT NULL DEFAULT 0 , 
   certification_name varchar(48)  NOT NULL , 
   certification_date datetime NOT NULL DEFAULT '19800101' , 
   certification_file_id int(11) DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");



AfwDatabase::db_query("create unique index uk_applicant_certification_appreciation on ".$server_db_prefix."adm.applicant_certification_appreciation(applicant_id,certification_name);");


AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.proficiency_level;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`proficiency_level` (
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


AfwDatabase::db_query("create unique index uk_proficiency_level on ".$server_db_prefix."adm.proficiency_level(lookup_code);");

AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.language;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`language` (
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

 
AfwDatabase::db_query("create unique index uk_language on ".$server_db_prefix."adm.language(lookup_code);");



AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.applicant_language_proficiency;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`applicant_language_proficiency` (
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
  
    
   applicant_id bigint(20) NOT NULL , 
   language_id int(2)  NOT NULL , 
   proficiency_level_id int(11) NOT NULL DEFAULT 0 , 
   certification_ind char(1) NOT NULL DEFAULT 'W' , 
   certification_file_id int(11) DEFAULT NULL , 
  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("create unique index uk_applicant_language_proficiency on ".$server_db_prefix."adm.applicant_language_proficiency(applicant_id,language_id);");





AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`volunteer_membership_type` (
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
   scoring_impact float NOT NULL DEFAULT 0.0 , 
  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("create unique index uk_volunteer_membership_type on ".$server_db_prefix."adm.volunteer_membership_type(lookup_code);");


AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.applicant_volunteer_activity;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`applicant_volunteer_activity` (
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
  
    
   applicant_id bigint(20) NOT NULL , 
   organization varchar(60)  NOT NULL , 
   volunteer_membership_type_id int(11) NOT NULL , 
   membership_level_enum smallint NOT NULL DEFAULT 0 , 
   acivity_date datetime NOT NULL DEFAULT '19800101' , 
   role_held varchar(100)  NOT NULL DEFAULT '' , 
   workflow_file_id int(11) DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("create unique index uk_applicant_volunteer_activity on ".$server_db_prefix."adm.applicant_volunteer_activity(applicant_id,organization,volunteer_membership_type_id);");


AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.authorship_category;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`authorship_category` (
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
   scoring_multiplier float NOT NULL DEFAULT 0.0 , 
  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("create unique index uk_authorship_category on ".$server_db_prefix."adm.authorship_category(lookup_code);");


AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.applicant_scientific_research;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`applicant_scientific_research` (
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
  
    
   applicant_id bigint(20) NOT NULL , 
   title varchar(48)  NOT NULL , 
   publication_venue varchar(60)  NOT NULL , 
   authorship_category_id int(11) NOT NULL DEFAULT 0 , 
   publication_link varchar(255)  NOT NULL DEFAULT '' , 
   citation varchar(200)  NOT NULL DEFAULT '' , 
   publication_date datetime NOT NULL DEFAULT '19800101' , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("create unique index uk_applicant_scientific_research on ".$server_db_prefix."adm.applicant_scientific_research(applicant_id,title,publication_venue);");


AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.applicant_cv_score;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`applicant_cv_score` (
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
  
    
   applicant_id bigint(20) NOT NULL , 
   cv_rubric_id int(11) NOT NULL , 
   application_id int(11) NOT NULL , 
   review_date datetime NOT NULL DEFAULT '19800101' , 
   rubric_score float NOT NULL DEFAULT 0.0 , 
   comments text   DEFAULT NULL , 
  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");



AfwDatabase::db_query("create unique index uk_applicant_cv_score on ".$server_db_prefix."adm.applicant_cv_score(applicant_id,cv_rubric_id,application_id);");

AfwDatabase::db_query("DROP TABLE IF EXISTS nauss_adm.cv_rubric_guide;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS nauss_adm.`cv_rubric_guide` (
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
  
    
   cv_rubric_id int(11) NOT NULL , 
   rubric_score float NOT NULL , 
   rubric_desc text  DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("create unique index uk_cv_rubric_guide on nauss_adm.cv_rubric_guide(cv_rubric_id,rubric_score);  ");


AfwDatabase::db_query("DROP TABLE IF EXISTS nauss_adm.scientific_institution_membership_type;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS nauss_adm.`scientific_institution_membership_type` (
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
   name_ar varchar(128)   DEFAULT '' , 
   name_en varchar(128)  DEFAULT '' , 
   desc_ar text  DEFAULT NULL , 
   desc_en text  DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("create unique index uk_scientific_institution_membership_type on nauss_adm.scientific_institution_membership_type(lookup_code);");

AfwDatabase::db_query("DROP TABLE IF EXISTS nauss_adm.applicant_membership_scientific_institution;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS nauss_adm.`applicant_membership_scientific_institution` (
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
  
    
   applicant_id bigint(20) NOT NULL , 
   organization_name varchar(48)  NOT NULL , 
   scientific_institution_membership_type_id int(11) NOT NULL , 
   scientific_istitution_level_enum smallint NOT NULL DEFAULT 0 , 
   start_date datetime NOT NULL DEFAULT '19800101' , 
   end_date datetime NOT NULL DEFAULT '19800101' , 
   role_held varchar(100)  NOT NULL DEFAULT '' , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

AfwDatabase::db_query("create unique index uk_applicant_membership_scientific_institution on nauss_adm.applicant_membership_scientific_institution(applicant_id,organization_name,scientific_institution_membership_type_id);");

}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}    