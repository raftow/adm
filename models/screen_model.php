<?php
    /*
DROP TABLE IF EXISTS c0adm.screen_model;

CREATE TABLE IF NOT EXISTS c0adm.`screen_model` (
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
  
    
   screen_code varchar(32)  NOT NULL , 
   screen_title varchar(32)  NOT NULL , 
   screen_name_ar varchar(64)  NOT NULL , 
   screen_name_en varchar(64)  NOT NULL , 
   application_field_mfk smallint NOT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;


-- unique index : 
create unique index uk_screen_model on c0adm.screen_model(screen_code);


    */
        class ScreenModel extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "screen_model"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("screen_model","id","adm");
                        AdmScreenModelAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ScreenModel();
                        
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