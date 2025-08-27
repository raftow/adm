<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
    
    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`grading_scale` (
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
   grade_en varchar(100)  NOT NULL DEFAULT '' , 
   grade_ar varchar(100)  NOT NULL DEFAULT '' , 
   value_ar varchar(100)  NOT NULL DEFAULT '', 
   value_en varchar(100)  NOT NULL DEFAULT '', 
   mark_min smallint NOT NULL DEFAULT 0 , 
   mark_max smallint NOT NULL DEFAULT 0, 
   `level` smallint DEFAULT NULL ,  

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

AfwDatabase::db_query("create unique index uk_grading_scale on  ".$server_db_prefix."adm.grading_scale(mark_min,mark_max);");
AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.applicant_qualification add   grading_scale_id int(11) DEFAULT NULL  AFTER country_id;");


}
catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}