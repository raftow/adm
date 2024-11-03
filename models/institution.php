<?php

// medali 14/09/2024
/*
DROP TABLE IF EXISTS c0adm.institution;

CREATE TABLE `institution` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `validated_by` int(11) DEFAULT NULL,
  `validated_at` datetime DEFAULT NULL,
  `active` char(1) NOT NULL,
  `draft` char(1) NOT NULL DEFAULT 'Y',
  `version` int(4) DEFAULT NULL,
  `update_groups_mfk` varchar(255) DEFAULT NULL,
  `delete_groups_mfk` varchar(255) DEFAULT NULL,
  `display_groups_mfk` varchar(255) DEFAULT NULL,
  `sci_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `institution_code` varchar(10) DEFAULT NULL,
  `institution_name_ar` varchar(50) DEFAULT NULL,
  `institution_name_en` varchar(50) DEFAULT NULL,
  `map_location` varchar(60) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `logo_file_id` int(11) DEFAULT NULL,
  `background_file_id` int(11) DEFAULT NULL,
  `facebook_profile_link` varchar(255) DEFAULT NULL,
  `linkedin_profile_link` varchar(255) DEFAULT NULL,
  `youtube_profile_link` varchar(255) DEFAULT NULL,
  `snapchat_profile_link` varchar(255) DEFAULT NULL,
  `twitter_profile_link` varchar(255) DEFAULT NULL,
  `instagram_profile_link` varchar(255) DEFAULT NULL,
  `adress` varchar(100) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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

                // institution 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 400;
      if ($currstep == 2) return 401;

      return 0;
   }

        }
?>