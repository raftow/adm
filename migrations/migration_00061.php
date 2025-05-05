<?php
if(!class_exists("AfwSession")) die("Denied access");

$server_db_prefix = AfwSession::config("db_prefix", "default_db_");
try
{
    AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."adm.`ADMStudentAdmission` (
    `id`                INTEGER  NOT NULL auto_increment,
    `updated_at`        date  default NULL,
    `created_at`        date default Null,
    `FirstNameAr`       varchar(100) NULL,
    `SecondNameAr`      varchar(100) NULL,
    `ThirdNameAr`       varchar(100) NULL,
    `ForthNameAr`       varchar(100) NULL,
    `LastNameAr`        varchar(100) NULL,
    `FirstNameEn`       varchar(100) NULL,
    `SecondNameEn`      varchar(100) NULL,
    `ThirdNameEn`       varchar(100) NULL,
    `FourthNameEn`      varchar(100) NULL,
    `LastNameEn`        varchar(100) NULL,
    `NationalID`        VARCHAR(50)   NULL,
    `StudentID`         VARCHAR(50)   NULL,
    `AdmissionStatusAr` varchar(256) NULL,
    `AdmissionStatusEn` varchar(100) NULL,
    `StudentStatusAr`   varchar(256) NULL,
    `StudentStatus`     varchar(256) NULL,
    `StudentStatusEn`   varchar(256) NULL,
    `StudyTypeEn`       varchar(256) NULL,
    `JoiningDateHijri`  varchar(100) NULL,
    `JoiningDateGreg`   varchar(100) NULL,
    `RELEASEDDATEHIJRI` varchar(100) NULL,
    `RELEASEDNUMBER`    varchar(50)  NULL,
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;");
    
    
}catch(Exception $e)
{
    $migration_info .= " " . $e->getMessage();
}