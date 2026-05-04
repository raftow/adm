<?php
if (!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::currentDBPrefix();
try {

    

    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.applicant_payment add   receipt_id varchar(200)  NOT NULL DEFAULT ''  AFTER payment_reference;");
    AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.applicant_payment add   card_type varchar(200)  NOT NULL DEFAULT ''  AFTER receipt_id;");
   AfwDatabase::db_query("ALTER TABLE " . $server_db_prefix . "adm.applicant_payment add   payment_type varchar(200)  NOT NULL DEFAULT ''  AFTER card_type;");
} catch (Exception $e) {
    $migration_error .= " " . $e->getMessage();
}
