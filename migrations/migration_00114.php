<?php
if (!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try {

    

   // AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.applicant_payment add   receipt_id varchar(200)  NOT NULL DEFAULT ''  AFTER payment_reference;");
   // AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.applicant_payment add   card_type varchar(200)  NOT NULL DEFAULT ''  AFTER receipt_id;");
   //AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.applicant_payment add   payment_type varchar(200)  NOT NULL DEFAULT ''  AFTER card_type;");

   AfwDatabase::db_query("DROP TABLE IF EXISTS " . $server_db_prefix . "adm.application_class_upgrade;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS " . $server_db_prefix . "adm.`application_class_upgrade` (
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
  
    
   initial_applicant_class_id int(11) NOT NULL , 
   sponsor_id int(11) NOT NULL , 
   final_applicant_class_id int(11) NOT NULL DEFAULT 0 , 
   
  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("create unique index uk_application_class_upgrade on " . $server_db_prefix . "adm.application_class_upgrade(initial_applicant_class_id,sponsor_id);");
} catch (Exception $e) {
    $migration_error .= " " . $e->getMessage();
}
