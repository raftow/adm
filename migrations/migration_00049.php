<?php

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");

AfwDatabase::db_query("INSERT INTO ".$server_db_prefix."adm.applicant_group SET id=3, name_ar = _utf8'البيانات الجاهزة', name_en = 'Offline data', desc_ar = _utf8'', desc_en = '', created_by = 1, updated_by = 1, validated_by = 0, active = 'Y', draft = 'Y', sci_id = 0, created_at = '2025-03-13 15:21:04', updated_at = '2025-03-13 15:21:04', `version` = 1");
 
