<?php
// rafik 08/10/2024 : applicant do application

update c0adm.applicant_qualification aq set aq.major_category_id = (select major_category_id from c0adm.qual_major_path mp inner join c0adm.major_path m on mp.major_path_id=m.id where m.qualification_id=aq.qualification_id and mp.qualification_major_id=aq.qualification_major_id);

AfwDatabase::db_query("ALTER TABLE c0adm.application_model_branch 
       add   major_id int(11) DEFAULT NULL  after department_id;");

AfwDatabase::db_query("UPDATE c0adm.application_model_branch mb 
        set mb.major_id = (select po.major_id from c0adm.academic_program_offering po
                   where po.id = mb.program_offering_id
                  );");

AfwDatabase::db_query("ALTER TABLE c0adm.application_model_branch 
    add   gender_enum smallint NOT NULL  AFTER major_id;");

AfwDatabase::db_query("UPDATE c0adm.application_model_branch mb 
        set mb.gender_enum = (select po.gender_enum from c0adm.academic_program_offering po
                   where po.id = mb.program_offering_id
                  );");

AfwDatabase::db_query("ALTER TABLE c0adm.application_model_branch 
                add   academic_program_id int(11) DEFAULT NULL  AFTER major_id;");

AfwDatabase::db_query("UPDATE c0adm.application_model_branch mb 
        set mb.academic_program_id = (select po.academic_program_id from c0adm.academic_program_offering po
                   where po.id = mb.program_offering_id
                  );");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS c0adm.`applicant_evaluation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `created_at`   datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `validated_by` int(11) DEFAULT NULL,
  `validated_at` datetime DEFAULT NULL,
  `active` char(1) NOT NULL,
  `draft` char(1) NOT NULL default 'Y',
  `version` int(4) DEFAULT NULL,
  `update_groups_mfk` varchar(255) DEFAULT NULL,
  `delete_groups_mfk` varchar(255) DEFAULT NULL,
  `display_groups_mfk` varchar(255) DEFAULT NULL,
  `sci_id` int(11) DEFAULT NULL,
  
    
   evaluation_id int(11) NOT NULL , 
   applicant_id int(11) NOT NULL , 
   eval_result float NOT NULL , 
   eval_date datetime DEFAULT NULL , 
   eval_expired_date datetime DEFAULT NULL , 
   eval_level varchar(10)  DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;");


// unique index : 
AfwDatabase::db_query("CREATE unique index uk_applicant_evaluation on c0adm.applicant_evaluation(evaluation_id,applicant_id,eval_date);");

