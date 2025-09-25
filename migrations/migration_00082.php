<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
    
    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`academic_period` (
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
  
    
   academic_term_id int(11) NOT NULL DEFAULT 0 , 
   period_type smallint NOT NULL DEFAULT 0 , 
   application_period_name_ar varchar(100)  DEFAULT NULL , 
   application_period_name_en varchar(100)  DEFAULT NULL , 
   application_start_date datetime DEFAULT NULL , 
   application_start_time varchar(8) NOT NULL DEFAULT '00:00' , 
   application_end_date datetime DEFAULT NULL , 
   application_end_time varchar(8) NOT NULL DEFAULT '00:00' ,
   hijri_application_start_date varchar(8) NOT NULL DEFAULT '14000101' , 
   hijri_application_end_date varchar(8) NOT NULL DEFAULT '14000101' , 
   last_date_upload_doc datetime DEFAULT NULL , 
   last_date_appfee datetime DEFAULT NULL , 
   last_date_tuitfee datetime DEFAULT NULL , 
   hijri_last_date_upload_doc varchar(8) DEFAULT NULL , 
   hijri_last_date_appfee varchar(8) DEFAULT NULL , 
   hijri_last_date_tuitfee varchar(8) DEFAULT NULL , 
   
  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

AfwDatabase::db_query("create unique index uk_academic_period on ".$server_db_prefix."adm.academic_period(academic_term_id,application_period_name_ar);");


}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}