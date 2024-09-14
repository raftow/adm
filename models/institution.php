<?php

// medali 14/09/2024
/*
DROP TABLE IF EXISTS c0adm.institution;

CREATE TABLE IF NOT EXISTS c0adm.`institution` (
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
  
    
   institution_code varchar(50)  DEFAULT NULL , 
   institution_name_ar varchar(50)  DEFAULT NULL , 
   institution_name_en varchar(30)  DEFAULT NULL , 
   country_id varchar(50)  DEFAULT NULL , 
   map_location varchar(100)  DEFAULT NULL , 
   website varchar(30)  DEFAULT NULL , 
   logo_file_id int(11) DEFAULT NULL , 
   background_file_id int(11) DEFAULT NULL , 
   facebook_profile_link varchar(50)  DEFAULT NULL , 
   linkedin_profile_link varchar(50)  DEFAULT NULL , 
   youtube_profile_link varchar(50)  DEFAULT NULL , 
   snapchat_profile_link varchar(50)  DEFAULT NULL , 
   twitter_profile_link varchar(50)  DEFAULT NULL , 
   instagram_profile_link varchar(50)  DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;
create unique index uk_institution on c0adm.institution(institution_code);
*/

        class Institution extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "institution"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("institution","id","adm");
                        AdmInstitutionAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new Institution();
                        
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

                public function beforeDelete($id,$id_replace) 
                {
                    $server_db_prefix = AfwSession::config("db_prefix","c0");
                    
                    if(!$id)
                    {
                        $id = $this->getId();
                        $simul = true;
                    }
                    else
                    {
                        $simul = false;
                    }
                    
                    if($id)
                    {   
                        if($id_replace==0)
                        {
                            // FK part of me - not deletable 

                                    
                            // FK part of me - deletable 

                            
                            // FK not part of me - replaceable 

                                    
                            
                            // MFK

                        }
                        else
                        {
                                    // FK on me 

                                    
                                    // MFK

                            
                        } 
                        return true;
                    }    
                }

        }
?>