<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try
{
    
    

    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`nominating_authority_category` (
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
        name_ar varchar(128)  NOT NULL DEFAULT '' , 
        desc_ar text  DEFAULT NULL , 
        name_en varchar(128)  NOT NULL DEFAULT '' , 
        desc_en text  DEFAULT NULL , 

        
        PRIMARY KEY (`id`)
        ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


        AfwDatabase::db_query("create unique index uk_nominating_authority_category on ".$server_db_prefix."adm.nominating_authority_category(lookup_code);");



        AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`nominating_authority` (
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
        
            
        nominating_authority_name_ar varchar(48)  NOT NULL , 
        nominating_authority_name_en varchar(48)  NOT NULL , 
        nominating_authority_category_id int(11) DEFAULT NULL , 
        nominating_authority_source_enum smallint DEFAULT NULL , 
        principal_autority_ind char(1) NOT NULL DEFAULT 'W' , 
        country_id int(11) NOT NULL DEFAULT 0 , 
        

        
        PRIMARY KEY (`id`)
        ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


        AfwDatabase::db_query("create unique index uk_nominating_authority on ".$server_db_prefix."adm.nominating_authority(nominating_authority_name_ar,nominating_authority_name_en,nominating_authority_category_id);");


        AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`sponsor_cordinator` (
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
        
            
        nominating_authority_id int(11) DEFAULT NULL , 
        sponsor_cordinator_name_ar varchar(48)  NOT NULL , 
        sponsor_cordinator_name_en varchar(48)  NOT NULL DEFAULT '' , 
        email varchar(32)  DEFAULT NULL , 
        Mobile varchar(25)  DEFAULT NULL , 

        
        PRIMARY KEY (`id`)
        ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


        AfwDatabase::db_query("create unique index uk_sponsor_cordinator on ".$server_db_prefix."adm.sponsor_cordinator(nominating_authority_id,sponsor_cordinator_name_ar);");

        AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`nomination_letter` (
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
        
            
        application_plan_id int(11) DEFAULT NULL , 
        nominating_authority_source_enum smallint DEFAULT NULL , 
        nominating_authority_id int(11) DEFAULT NULL , 
        nomination_letter_date varchar(8) DEFAULT NULL , 
        sponsor_cordinator_id int(11) DEFAULT NULL , 
        nomination_letter_file_id int(11) DEFAULT NULL , 
       
        
        PRIMARY KEY (`id`)
        ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


        AfwDatabase::db_query("create unique index uk_nomination_letter on ".$server_db_prefix."adm.nomination_letter(application_plan_id,nominating_authority_source_enum,nominating_authority_id,nomination_letter_date);");




        AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`study_funding_status` (
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
        desc_ar text  DEFAULT NULL , 
        name_en varchar(128)  NOT NULL DEFAULT '' , 
        desc_en text  DEFAULT NULL , 

        
        PRIMARY KEY (`id`)
        ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");

        AfwDatabase::db_query("create unique index uk_study_funding_status on ".$server_db_prefix."adm.study_funding_status(lookup_code);");

        AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`nominating_candidates` (
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
        
            
        identity_type_id int(11) DEFAULT NULL , 
        idn varchar(40)  DEFAULT NULL , 
        first_name_ar varchar(32)  NOT NULL DEFAULT '' , 
        second_name_ar varchar(32)  NOT NULL DEFAULT '' , 
        third_name_ar varchar(32)  NOT NULL DEFAULT '' , 
        last_name_ar varchar(32)  NOT NULL DEFAULT '' , 
        first_name_en varchar(48)  NOT NULL DEFAULT '' , 
        second_name_en varchar(48)  NOT NULL DEFAULT '' , 
        third_name_en varchar(48)  NOT NULL DEFAULT '' , 
        last_name_en varchar(48)  NOT NULL DEFAULT '' , 
        academic_program_id int(11) DEFAULT NULL , 
        email varchar(32)  DEFAULT NULL , 
        Mobile varchar(25)  DEFAULT NULL , 
        study_funding_status_id int(11) DEFAULT NULL , 
        

        
        PRIMARY KEY (`id`)
        ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


        AfwDatabase::db_query("create unique index uk_nominating_candidates on ".$server_db_prefix."adm.nominating_candidates(identity_type_id,idn);");

}
catch(Exception $e)
{
    $migration_error .= " " . $e->getMessage();
}