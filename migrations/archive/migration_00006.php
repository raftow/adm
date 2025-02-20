<?php
// medali 06/10/2024
AfwDatabase::db_query("alter table c0adm.academic_term add   Results_Announcement_date datetime DEFAULT NULL  after migration_end_date");
AfwDatabase::db_query("alter table c0adm.academic_term add   hijri_Results_Announcement_date varchar(8) DEFAULT NULL  after hijri_migration_end_date");
AfwDatabase::db_query("alter table c0adm.academic_term add   hijri_sorting_start_date varchar(8) DEFAULT NULL  after hijri_Results_Announcement_date");
AfwDatabase::db_query("alter table c0adm.academic_term add   hijri_sorting_end_date varchar(8) DEFAULT NULL  after hijri_sorting_start_date");


//        