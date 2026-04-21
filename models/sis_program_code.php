<?php 

                
$file_dir_name = dirname(__FILE__); 
                
// require_once("$file_dir_name/../afw/afw.php");

class SisProgramCode extends AFWObject{

        public static $MY_ATABLE_ID=14044; 
  
        public static $DATABASE		= "";
        public static $MODULE		        = "adm";        
        public static $TABLE			= "sis_program_code";

	    public static $DB_STRUCTURE = null;
	
	    public function __construct(){
		parent::__construct("sis_program_code","id","adm");
            AdmSisProgramCodeAfwStructure::initInstance($this);    
	    }
        
        public static function loadById($id)
        {
           $obj = new SisProgramCode();
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
            $title_ar = "xxxxxxxxxxxxxxxxxxxx"; 
            $title_en = "xxxxxxxxxxxxxxxxxxxx"; 
            $methodName = "mmmmmmmmmmmmmmmmmmmmmmm";
            //$pbms[AfwStringHelper::hzmEncode($methodName)] = 
                    array("METHOD"=>$methodName,
                          "COLOR"=>$color, 
                          "LABEL_AR"=>$title_ar, 
                          "LABEL_EN"=>$title_en,
                          "ADMIN-ONLY"=>true, 
                          "BF-ID"=>"", 
                          'STEP' =>$this->stepOfAttribute("xxyy"));
            
            
            
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
         * Fetches all programs from NaussApi::getProgramsByLevel() for every level
         * stored in the sis_level_code table, then upserts into sis_program_code
         * (matched by lookup_code + sis_level_code FK).
         * Returns ['inserted' => int, 'updated' => int, 'errors' => array].
         */
        public static function syncFromSIS()
        {
                include_once(__DIR__ . "/../NaussSisApi.php");
                $api = new NaussApi();

                $inserted = 0;
                $updated  = 0;
                $errors   = [];

                // Load all locally known levels to iterate over
                $levelObj = new SisLevelCode();
                $levelObj->select_visibilite_horizontale();
                $levels = $levelObj->loadMany();

                foreach ($levels as $level) {
                        $levelCode = $level->getVal('lookup_code');
                        $levelId   = $level->getId();

                        $response = $api->getProgramsByLevel($levelCode);

                        if (!isset($response['body']) || !is_array($response['body'])) {
                                $errors[] = "Invalid API response for level: $levelCode (HTTP " . ($response['status'] ?? '?') . ")";
                                continue;
                        }

                        $body = $response['body'];
                        if (isset($body['data']) && is_array($body['data'])) {
                                $items = $body['data'];
                        } elseif (isset($body['programs']) && is_array($body['programs'])) {
                                $items = $body['programs'];
                        } else {
                                $items = $body;
                        }

                        foreach ($items as $program) {
                                if (!is_array($program)) continue;

                                $code   = $program['code']          ?? ($program['programCode']   ?? null);
                                $nameAr = $program['nameAr']        ?? ($program['name_ar']       ?? ($program['description'] ?? ($program['name'] ?? $code)));
                                $nameEn = $program['nameEn']        ?? ($program['name_en']       ?? ($program['descriptionEn'] ?? $nameAr));
                                $descAr = $program['descriptionAr'] ?? ($program['desc_ar']       ?? '');
                                $descEn = $program['descriptionEn'] ?? ($program['desc_en']       ?? '');

                                if ($code === null) continue;

                                // Upsert: match by lookup_code + sis_level_code (FK id)
                                $obj = new SisProgramCode();
                                $obj->where("lookup_code = '" . addslashes($code) . "' AND sis_level_code = '" . (int)$levelId . "'");
                                $exists = $obj->load();

                                $obj->set('lookup_code',   $code);
                                $obj->set('name_ar',       $nameAr);
                                $obj->set('name_en',       $nameEn);
                                if ($descAr !== '') $obj->set('desc_ar', $descAr);
                                if ($descEn !== '') $obj->set('desc_en', $descEn);
                                $obj->set('sis_level_code', $levelId);
                                $obj->set('active', 'Y');

                                $ok = $obj->commit();
                                if ($ok) {
                                        $exists ? $updated++ : $inserted++;
                                } else {
                                        $errors[] = "Failed to save program code: $code (level: $levelCode)";
                                }
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

