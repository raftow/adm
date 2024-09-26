<?php
// medali 22/09/2024

/*
CREATE TABLE IF NOT EXISTS c0adm.`application_status` (
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
  
    
   status_order smallint NOT NULL , 
   statu_code varchar(3)  NOT NULL , 
   status_name_ar varchar(100)  NOT NULL , 
   status_name_en varchar(100)  NOT NULL , 
   application_admission_enum char(1) NOT NULL , 
   draft_status char(1) DEFAULT NULL , 
   initial_state char(1) DEFAULT NULL , 
   cancel_status char(1) DEFAULT NULL , 
   web_visible char(1) DEFAULT NULL , 
   allow_multiple_app_model char(1) DEFAULT NULL , 
   applicant_can_cancel char(1) DEFAULT NULL , 
   admin_can_cancel char(1) DEFAULT NULL , 
   allow_print_notifification char(1) DEFAULT NULL , 
   allow_processing  char(1) DEFAULT NULL , 
   is_final_admission char(1) DEFAULT NULL , 
   allow_multiple_adm_institution char(1) DEFAULT NULL , 
   roll_to_sis char(1) DEFAULT NULL , 
   disable_application_editing char(1) DEFAULT NULL , 
   consider_as_seat char(1) DEFAULT NULL , 
   allow_print_agreement char(1) DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;

*/
        class ApplicationStatus extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "application_status"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("application_status","id","adm");
                        AdmApplicationStatusAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ApplicationStatus();
                        
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