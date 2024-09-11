<?php

// 09/10/2024 medali
/*
CREATE TABLE IF NOT EXISTS c0adm.`application_condition_exec` (
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
  
    
   applicant_id int(11) DEFAULT NULL , 
   application_plan_id int(11) DEFAULT NULL , 
   adesire_id int(11) DEFAULT NULL , 
   acondition_id int(11) DEFAULT NULL , 
   field_value varchar(64)  DEFAULT NULL , 
   field_date datetime DEFAULT NULL , 
   condition_exec_date datetime DEFAULT NULL , 
   aparameter_id int(11) DEFAULT NULL , 
   aparameter_value varchar(64)  DEFAULT NULL , 
   aparameter_value_date datetime DEFAULT NULL , 
   success_ind char(1) DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;

create unique index uk_application_condition_exec on c0adm.application_condition_exec(applicant_id,application_plan_id,adesire_id,acondition_id);

*/
        class ApplicationConditionExec extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "application_condition_exec"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("application_condition_exec","id","adm");
                        AdmApplicationConditionExecAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ApplicationConditionExec();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
                }

                public function getDisplay($lang = 'ar')
                {
                        return $this->getDefaultDisplay($lang);
                }

                public function stepsAreOrdered()
                {
                        return false;
                }

        }
?>