<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
try
{
    $migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'sorting_session', 180, "+t", "qsearch", null);

    AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.api_endpoint 
                SET id=18, api_endpoint_code = _utf8'offline_evqual', 
                    published = 'N', import = 'N', 
                    api_endpoint_title = _utf8'تحديث الشهادة والاختبارات من البيانات الجاهزة', 
                    api_endpoint_name_ar = _utf8'تحديث الشهادة والاختبارات من البيانات الجاهزة', 
                    api_endpoint_name_en = 'Updating the certificate and tests from the offline data', 
                    active = 'Y', can_refresh = 'N', duration_expiry = 15, adm_file_id = 0, 
                    api_url = _utf8'xx/offline_evqual', api_endpoint_mfk = ',', application_field_mfk = ',110332,', institution_id = 0, created_by = 1, updated_by = 1, validated_by = 0, update_groups_mfk = ',', delete_groups_mfk = ',', display_groups_mfk = ',', failure_text = _utf8'', created_at = '2025-06-09 16:51:26', updated_at = '2025-06-09 16:51:26', version = 1");
    
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`api_endpoint`
        CHANGE `api_endpoint_name_ar` `api_endpoint_name_ar` varchar(128) COLLATE 'utf8mb3_unicode_ci' NULL AFTER `api_endpoint_title`,
        CHANGE `api_endpoint_name_en` `api_endpoint_name_en` varchar(128) COLLATE 'utf8mb3_unicode_ci' NULL AFTER `api_endpoint_name_ar`;");

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_session add   desires_nb int DEFAULT NULL  AFTER started_ind;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_session add   applicants_nb int DEFAULT NULL  AFTER desires_nb;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_session add   errors_nb int DEFAULT NULL  AFTER applicants_nb;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_session add   data_date datetime DEFAULT NULL  AFTER errors_nb;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_session add   stats_date datetime DEFAULT NULL  AFTER data_date;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_session add   settings text  DEFAULT NULL  AFTER applicant_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_session add   task_pct decimal(5,2) DEFAULT NULL  AFTER stats_date;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_session add   sorting_well_done char(1) DEFAULT NULL  AFTER started_ind;");
    

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application add key(application_plan_id, application_simulation_id, active);");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.application_plan_branch add   cond_weighted_percentage decimal(5,2) NOT NULL  AFTER min_weighted_percentage;");
    AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."adm.sorting_session_stat;");

    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`sorting_session_stat` (
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
        
            
        application_plan_id int(11) NOT NULL , 
        session_num smallint NOT NULL , 
        application_simulation_id int(11) NOT NULL , 
        branch_order smallint DEFAULT NULL , 
        application_plan_branch_id int(11) NOT NULL , 
        track_num smallint NULL , 
        capacity smallint NULL , 
        original_capacity smallint NULL,
        nb_accepted smallint NULL , 
        execo smallint NULL , 
        waiting smallint NULL , 
        min_weighted_percentage float NULL ,
        min_app_score1 float DEFAULT NULL , 
        min_app_score2 float DEFAULT NULL , 
        min_app_score3 float DEFAULT NULL , 
        cond_weighted_percentage float DEFAULT NULL,
        min_acc_score1 float DEFAULT NULL , 
        min_acc_score2 float DEFAULT NULL , 
        min_acc_score3 float DEFAULT NULL , 
        min_show_score float DEFAULT 0.0 ,
        max_show_score float DEFAULT 100.0 ,
        
        PRIMARY KEY (`id`)
        ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");
    }
    catch(Exception $e)
    {
        $migration_info .= " " . $e->getMessage();
    }