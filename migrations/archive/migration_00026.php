<?php
$server_db_prefix = AfwSession::currentDBPrefix();

AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."ums.doc_type add   titre_short_en varchar(48)  DEFAULT NULL  AFTER titre_short;");
AfwDatabase::db_query("UPDATE ".$server_db_prefix."ums.doc_type set titre_short_en = `lookup_code`;");
