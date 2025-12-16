<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
          


    AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.application_cv_score;");

    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`application_cv_score` (
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
   application_plan_id int(11) NOT NULL , 
   application_simulation_id int(11) NOT NULL , 
   score_QUAL float  DEFAULT NULL , 
   review_date_QUAL datetime DEFAULT NULL , 
   review_comments_QUAL varchar(200)  DEFAULT NULL , 
   score_PEXP float  DEFAULT NULL , 
   review_date_PEXP datetime DEFAULT NULL , 
   review_comments_PEXP varchar(200)  DEFAULT NULL , 
   score_CRWQ float  DEFAULT NULL , 
   review_date_CRWQ datetime DEFAULT NULL , 
   review_comments_CRWQ varchar(200)  DEFAULT NULL , 
   score_SCINT float  DEFAULT NULL , 
   review_date_SCINT datetime DEFAULT NULL , 
   review_comments_SCINT varchar(200)  DEFAULT NULL , 
   review_date_VOLAC datetime DEFAULT NULL , 
   score_VOLAC float  DEFAULT NULL , 
   review_comments_VOLAC varchar(200)  DEFAULT NULL , 
   score_AWAP float  DEFAULT NULL , 
   review_date_AWAP datetime DEFAULT NULL , 
   review_comments_AWAP varchar(200)  DEFAULT NULL , 
   score_SCRSC float  DEFAULT NULL , 
   review_date_SCRSC datetime DEFAULT NULL , 
   review_comments_SCRSC varchar(200)  DEFAULT NULL , 
   score_LANGP float  DEFAULT NULL , 
   review_date_LANGP datetime DEFAULT NULL , 
   review_comments_LANGP varchar(200)  DEFAULT NULL , 
   score_SCCONF float  DEFAULT NULL , 
   review_date_SCCONF datetime DEFAULT NULL , 
   review_comments_SCCONF varchar(200)  DEFAULT NULL , 
   score_RECLT float  DEFAULT NULL , 
   review_date_RECLT datetime DEFAULT NULL , 
   review_comments_RECLT varchar(200)  DEFAULT NULL , 
  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

    AfwDatabase::db_query("create unique index uk_application_cv_score on ".$server_db_prefix."adm.application_cv_score(applicant_id,application_plan_id,application_simulation_id);");

AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.cv_rubric_guide;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`cv_rubric_guide` (
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
  
    
   cv_rubric_item_id int(11) NOT NULL , 
   rubric_score float NOT NULL , 
   rubric_desc text   DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("create unique index uk_cv_rubric_guide on ".$server_db_prefix."adm.cv_rubric_guide(cv_rubric_item_id,rubric_score);");

}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}    