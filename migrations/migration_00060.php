<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
try
{
    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`relationship` (
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
   relationship_name_ar varchar(100)  NOT NULL , 
   relationship_name_en varchar(100)  NOT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
    AfwDatabase::db_query("create unique index uk_relationship on ".$server_db_prefix."adm.relationship(relationship_name_ar);");
    AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.`relationship` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `lookup_code`, `relationship_name_ar`, `relationship_name_en`) VALUES
    (1, 1, '2025-05-01 12:35:40', 1, '2025-05-01 12:35:40', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, NULL, 'أب', 'Father'),
    (2, 1, '2025-05-01 12:36:56', 1, '2025-05-01 12:36:56', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, NULL, 'أم', 'Mother'),
    (3, 1, '2025-05-01 12:36:56', 1, '2025-05-01 12:36:56', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, NULL, 'أخ', 'Brother'),
    (4, 1, '2025-05-01 12:36:56', 1, '2025-05-01 12:36:56', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, NULL, 'أخت', ' Sister'),
    (5, 1, '2025-05-01 12:37:33', 1, '2025-05-01 12:37:33', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, NULL, 'عم', 'Uncle'),
    (6, 1, '2025-05-01 12:37:33', 1, '2025-05-01 12:37:33', 0, NULL, 'Y', 'Y', 1, ',', ',', ',', 0, NULL, 'صديق', 'Friend');");
    
    
}catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}