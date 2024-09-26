<?php
// insert medali as auser in UMS
AfwDatabase::db_query("INSERT INTO c0ums.auser 
      SET username = 'm.mewani', 
          lang_id = '1', genre_id = '1', 
          firstname = _utf8'محمد علي', f_firstname = _utf8'', 
          lastname = _utf8'معواني', 
          idn = '2357172689', pwd = '1', mobile = '', 
          address = _utf8'', cp = _utf8'', quarter = _utf8'', 
          avail = 'Y', id_aut = 1, id_mod = 1, id_valid = 0, 
          sci_id = 0, email = 'm.mewani@tvtc.gov.sa', country_id = 213, 
          idn_type_id = 2, date_aut = now(), date_mod = now(), version = 1");

// $medali_id
$medali_id = AfwDatabase::db_recup_value("select id from c0ums.auser where email = 'm.mewani@tvtc.gov.sa'");

// give medali privileges on adm system (id_module = 1282)
AfwDatabase::db_query("INSERT INTO c0ums.module_auser 
   SET description = _utf8'', avail = 'Y', id_aut = 1, id_mod = 1, 
       id_valid = 0, sci_id = 0, 
       id_auser = $medali_id, id_module = 1282, 
       arole_mfk = ',382,386,384,383,385,381,'
       date_aut = now(), date_mod = now(), version = 1");

//        