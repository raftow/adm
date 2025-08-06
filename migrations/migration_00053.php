<?php
if(!class_exists("AfwSession")) die("Denied access");
$server_db_prefix = AfwSession::currentDBPrefix();

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.`applicant_evaluation` CHANGE `imported` `imported` CHAR(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N';");



AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.applicant set qiyas_aptitude_sc_date = '2020-01-01' where qiyas_aptitude_sc>0 and qiyas_aptitude_sc_date is null;");

AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.`applicant_evaluation` 
                       (`created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, 
                        `applicant_id`, `evaluation_id`, `eval_date`, `eval_result`)
    select 1, now(), 1, now(), NULL, NULL, 'Y', 'Y', 0, NULL, NULL, NULL, NULL, 
          id, 1, qiyas_aptitude_sc_date, qiyas_aptitude_sc 
          from ".$server_db_prefix."adm.applicant where qiyas_aptitude_sc_date is not null and qiyas_aptitude_sc>0");


AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.applicant set qiyas_aptitude_th_date = '2020-01-01' where qiyas_aptitude_th>0 and qiyas_aptitude_th_date is null;");          

AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.`applicant_evaluation` 
                       (`created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, 
                        `applicant_id`, `evaluation_id`, `eval_date`, `eval_result`)
    select 1, now(), 1, now(), NULL, NULL, 'Y', 'Y', 0, NULL, NULL, NULL, NULL, 
          id, 2, qiyas_aptitude_th_date, qiyas_aptitude_th 
          from ".$server_db_prefix."adm.applicant where qiyas_aptitude_th_date is not null and qiyas_aptitude_th>0");
