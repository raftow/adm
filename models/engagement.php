<?php 
// medali 17/10/2024
/*
DROP TABLE IF EXISTS c0adm.engagement;

CREATE TABLE IF NOT EXISTS c0adm.`engagement` (
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
  
    
   engagement_type_id int(11) DEFAULT NULL , 
   engagement_name_ar text  DEFAULT NULL , 
   engagement_name_en text  DEFAULT NULL , 
   academic_level_mfk varchar(255) DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;

-- unique index : 
create unique index uk_engagement on c0adm.engagement(engagement_name_ar);


*/
                
$file_dir_name = dirname(__FILE__); 
                
// require_once("$file_dir_name/../afw/afw.php");

class Engagement extends AFWObject{

        public static $MY_ATABLE_ID=13921; 
  
        public static $DATABASE		= "c0adm";
        public static $MODULE		        = "adm";        
        public static $TABLE			= "engagement";

	    public static $DB_STRUCTURE = null;
	
	    public function __construct(){
		parent::__construct("engagement","id","adm");
            AdmEngagementAfwStructure::initInstance($this);    
	    }
        
        public static function loadById($id)
        {
           $obj = new Engagement();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        
        
        public static function loadByMainIndex($engagement_name_ar,$create_obj_if_not_found=false)
        {


           $obj = new Engagement();
           $obj->select("engagement_name_ar",$engagement_name_ar);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("engagement_name_ar",$engagement_name_ar);

                $obj->insertNew();
                if(!$obj->id) return null; // means beforeInsert rejected insert operation
                $obj->is_new = true;
                return $obj;
           }
           else return null;
           
        }


        public function getDisplay($lang="ar")
        {
               if($this->getVal("engagement_name_$lang")) return $this->getVal("engagement_name_$lang");
               $data = array();
               $link = array();
               


               
               return implode(" - ",$data);
        }
        
        
        

        
        protected function getOtherLinksArray($mode,$genereLog=false,$step="all")      
        {
             global $lang;
             // $objme = AfwSession::getUserConnected();
             // $me = ($objme) ? $objme->id : 0;

             $otherLinksArray = $this->getOtherLinksArrayStandard($mode,$genereLog,$step);
             $my_id = $this->getId();
             $displ = $this->getDisplay($lang);
             
             
             
             // check errors on all steps (by default no for optimization)
             // rafik don't know why this : \//  = false;
             
             return $otherLinksArray;
        }
        
        protected function getPublicMethods()
        {
            
            $pbms = array();
            
            $color = "green";
            $title_ar = "xxxxxxxxxxxxxxxxxxxx"; 
            $methodName = "mmmmmmmmmmmmmmmmmmmmmmm";
            //$pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("xxyy"));
            
            
            
            return $pbms;
        }
        
        public function fld_CREATION_USER_ID()
        {
                return "created_by";
        }

        public function fld_CREATION_DATE()
        {
                return "created_at";
        }

        public function fld_UPDATE_USER_ID()
        {
        	return "updated_by";
        }

        public function fld_UPDATE_DATE()
        {
        	return "updated_at";
        }
        
        public function fld_VALIDATION_USER_ID()
        {
        	return "validated_by";
        }

        public function fld_VALIDATION_DATE()
        {
                return "validated_at";
        }
        
        public function fld_VERSION()
        {
        	return "version";
        }

        public function fld_ACTIVE()
        {
        	return  "active";
        }
        
        public function isTechField($attribute) {
            return (($attribute=="created_by") or ($attribute=="created_at") or ($attribute=="updated_by") or ($attribute=="updated_at") or ($attribute=="validated_by") or ($attribute=="validated_at") or ($attribute=="version"));  
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
                       // adm.application_model_engagement-الالتزام	engagement_id  ManyToOne
                        if(!$simul)
                        {
                            // require_once "../adm/application_model_engagement.php";
                            ApplicationModelEngagement::updateWhere(array('engagement_id'=>$id_replace), "engagement_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.application_model_engagement set engagement_id='$id_replace' where engagement_id='$id' ");
                        }

                        
                   
                   // MFK

               }
               else
               {
                        // FK on me 
                       // adm.application_model_engagement-الالتزام	engagement_id  ManyToOne
                        if(!$simul)
                        {
                            // require_once "../adm/application_model_engagement.php";
                            ApplicationModelEngagement::updateWhere(array('engagement_id'=>$id_replace), "engagement_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.application_model_engagement set engagement_id='$id_replace' where engagement_id='$id' ");
                        }

                        
                        // MFK

                   
               } 
               return true;
            }    
	}
             
}



// errors 

