<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
try
{
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.institution add   adress_ar varchar(100)  DEFAULT NULL  AFTER adress;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.institution add   main_color1 varchar(10)  NOT NULL  AFTER application_simulation_id;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.institution add   main_color2 varchar(10)  NOT NULL  AFTER main_color1;");
    AfwDatabase::db_query("ALTER TABLE ".$server_db_prefix."adm.institution add   horizontal_logo_file_id int(11) DEFAULT NULL  AFTER main_color2;");
   

}
catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}