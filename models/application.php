<?php
        /*
         medali 19/9/2024
         CREATE TABLE IF NOT EXISTS c0adm.`application` (
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
  
    
   applicant_id int(11) NOT NULL , 
   application_plan_id int(11) NOT NULL , 
   application_model_id int(11) NOT NULL , 
   step_num smallint DEFAULT NULL , 
   application_step_id int(11) DEFAULT NULL , 
   application_status_enum smallint NOT NULL , 
   applicant_qualification_id int(11) DEFAULT NULL , 
   qualification_id int(11) DEFAULT NULL , 
   major_category_id int(11) DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;

         */
        class Application extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "application"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("application","id","adm");
                        AdmApplicationAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new Application();
                        
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