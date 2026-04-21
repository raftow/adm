<?php 

                
$file_dir_name = dirname(__FILE__); 
                
// require_once("$file_dir_name/../afw/afw.php");

class SisSponsorCode extends AFWObject{

        public static $MY_ATABLE_ID=14047; 
  
        public static $DATABASE		= "";
        public static $MODULE		        = "adm";        
        public static $TABLE			= "sis_sponsor_code";

	    public static $DB_STRUCTURE = null;
	
	    public function __construct(){
		parent::__construct("sis_sponsor_code","id","adm");
            AdmSisSponsorCodeAfwStructure::initInstance($this);    
	    }
        
        public static function loadById($id)
        {
           $obj = new SisSponsorCode();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        

        public function getScenarioItemId($currstep)
                {
                    
                    return 0;
                }
        
        
        public function getDisplay($lang="ar")
        {
                $data = [];
                $data[0] = $this->getVal("lookup_code");

                $data[1] = $this->getVal("name_$lang");
                return implode('-', $data);
        }
        
        
        

        
        protected function getOtherLinksArray($mode,$genereLog=false,$step="all")      
        {
             $lang = AfwLanguageHelper::getGlobalLanguage();
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
            $title_ar = "تحديث قائمة جهات الترشيح من نظام SIS"; 
            $title_en = "Update Nominating Authorities list from SIS"; 
            $methodName = "syncFromSIS";
            //$pbms[AfwStringHelper::hzmEncode($methodName)] = 
                    array("METHOD"=>$methodName,
                          "COLOR"=>$color, 
                          "LABEL_AR"=>$title_ar, 
                          "LABEL_EN"=>$title_en,
                          "ADMIN-ONLY"=>true, 
                          "BF-ID"=>"", 
                          'STEP' =>$this->stepOfAttribute("sis_code"));
            
            
            
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
        
        

        /**
         * Fetches all sponsors from NaussApi::getSponsors() and upserts them
         * into the sis_sponsor_code table (matched by lookup_code).
         * sponsorId  → lookup_code
         * sponsorName → name_ar, name_en
         * Returns ['inserted' => int, 'updated' => int, 'errors' => array].
         */
        public static function syncFromSIS()
        {
                include_once(__DIR__ . "/../NaussSisApi.php");
                $api = new NaussApi();

                $inserted = 0;
                $updated  = 0;
                $errors   = [];

                $response = $api->getSponsors();

                if (!isset($response['body']) || !is_array($response['body'])) {
                        $errors[] = "Invalid API response (HTTP " . ($response['status'] ?? '?') . ")";
                        return compact('inserted', 'updated', 'errors');
                }

                $body = $response['body'];
                if (isset($body['data']) && is_array($body['data'])) {
                        $items = $body['data'];
                } elseif (isset($body['sponsors']) && is_array($body['sponsors'])) {
                        $items = $body['sponsors'];
                } else {
                        $items = $body;
                }

                foreach ($items as $sponsor) {
                        if (!is_array($sponsor)) continue;

                        $code = $sponsor['sponsorId'] ?? null;
                        $name = $sponsor['sponsorName'] ?? $code;

                        if ($code === null) continue;

                        $obj = new SisSponsorCode();
                        $obj->where("lookup_code = '" . addslashes($code) . "'");
                        $exists = $obj->load();

                        $obj->set('lookup_code', $code);
                        $obj->set('name_ar',     $name);
                        $obj->set('name_en',     $name);
                        $obj->set('active',      'Y');

                        $ok = $obj->commit();
                        if ($ok) {
                                $exists ? $updated++ : $inserted++;
                        } else {
                                $errors[] = "Failed to save sponsor code: $code";
                        }
                }

                return compact('inserted', 'updated', 'errors');
        }

        public function beforeMaj($id, $fields_updated)
        {
            return true;
        }            
        
        
        public function beforeDelete($id,$id_replace) 
        {
            $server_db_prefix = AfwSession::config("db_prefix","nauss_");
            
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



// errors 

