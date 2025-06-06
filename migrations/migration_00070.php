<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
try
{
    $migration_info .= " " . Atable::generateTablePrevileges($moduleId, 'sorting_session', 180, "+t", "qsearch", null);

    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_session add   desires_nb int DEFAULT NULL  AFTER started_ind;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_session add   applicants_nb int DEFAULT NULL  AFTER desires_nb;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_session add   errors_nb int DEFAULT NULL  AFTER applicants_nb;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_session add   data_date datetime DEFAULT NULL  AFTER errors_nb;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_session add   stats_date datetime DEFAULT NULL  AFTER data_date;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.sorting_session add   settings text  DEFAULT NULL  AFTER applicant_id;");

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