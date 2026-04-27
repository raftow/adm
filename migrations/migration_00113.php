<?php
if (!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try {

    AfwDatabase::db_query("DROP TABLE IF EXISTS " . $server_db_prefix . "adm.application_class;");

    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS " . $server_db_prefix . "adm.`application_class` (
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

 
AfwDatabase::db_query("create unique index uk_application_class on " . $server_db_prefix . "adm.application_class(lookup_code);");

AfwDatabase::db_query("DROP TABLE IF EXISTS " . $server_db_prefix . "adm.financial_transaction_sis_settings;");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS " . $server_db_prefix . "adm.`financial_transaction_sis_settings` (
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
  
    
   financial_transaction_id int(11) NOT NULL , 
   application_class_id int(11) NOT NULL , 
   add_charge_ind char(1) NOT NULL DEFAULT 'W' , 
   add_payment_ind char(1) NOT NULL DEFAULT 'W' , 
   
  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


AfwDatabase::db_query("create unique index uk_financial_transaction_sis_settings on " . $server_db_prefix . "adm.financial_transaction_sis_settings(financial_transaction_id,application_class_id);");


AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.application_model_financial_transaction add   is_composite_ind char(1) DEFAULT NULL  AFTER phase_enum;");
AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.application_model_financial_transaction add   financial_transaction_mfk varchar(255) DEFAULT NULL  AFTER is_composite_ind;");

AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.tuition_base add   financial_transaction_id int(11) DEFAULT NULL  AFTER currency_en;");

AfwDatabase::db_query("INSERT INTO `application_class` VALUES (1,1,'2026-04-27 12:12:32',1,'2026-04-27 12:24:32',0,NULL,'Y','Y',3,'','','',0,'APPOWN','غير مرشح - على حسابه الخاص','Not a candidate - on his own account','',''),(2,1,'2026-04-27 12:21:23',1,'2026-04-27 12:21:24',0,NULL,'Y','Y',2,'','','',0,'APPNAIF','غير مرشح - منحة الأمير نايف','Not a candidate - Prince Nayef Scholarship','',''),
                                                              (3,1,'2026-04-27 12:22:24',1,'2026-04-27 12:22:24',0,NULL,'Y','Y',1,',',',',',',0,'CANFNP','مرشح – ممول من جهة الترشيح','Candidate - funded by the nominating party','',''),(4,1,'2026-04-27 12:23:24',1,'20２６-０４-２７ １２:２３:２４',0,NULL,'Y','Y',1,',',',',',',0,'CANOWN','مرشح – على حسابه الخاص','Candidate - on his own account','',''),
                                                              (5,1,'２０２６-０４-２７ １２:２３:５０',1,'２０２６-０４-２７ １２:２３:５０',0,NULL,'Y','Y',1,',',',',',',0,'CANNAIF','مرشح – منحة الأمير نايف','Candidate - Prince Nayef Scholarship','',''),(6,1,'２０２６-０４-２７ １２:２４:２１',1,'２０２６-０４-２７ １２:２４:２１',0,NULL,'Y','Y',1,',',',',',',0,'CANUNSP','مرشح – غير محدد التمويل','Candidate - Unspecified funding','','');");
} catch (Exception $e) {
    $migration_error .= " " . $e->getMessage();
}
