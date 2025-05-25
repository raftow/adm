<?php 

                
$file_dir_name = dirname(__FILE__); 
                
// require_once("$file_dir_name/../afw/afw.php");

class SortingSessionStat extends AFWObject{

        public static $MY_ATABLE_ID=13955; 
  
        public static $DATABASE		= "uoh_adm";
        public static $MODULE		        = "adm";        
        public static $TABLE			= "sorting_session_stat";

	    public static $DB_STRUCTURE = null;
	
	    public function __construct(){
		parent::__construct("sorting_session_stat","id","adm");
            AdmSortingSessionStatAfwStructure::initInstance($this);    
	    }
        
        public static function loadById($id)
        {
           $obj = new SortingSessionStat();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        public function list_of_track_num()
        {
            $application_plan_id = $this->getVal("application_plan_id");
            $application_model_id = ApplicationPlan::getApplicationModelId($application_plan_id);
            $lang = AfwLanguageHelper::getGlobalLanguage();
            $keyDecodeArr = [];
            $maxPaths = SortingPath::nbPaths($application_model_id);
            for ($spath = 1; $spath <= $maxPaths; $spath++) 
            {
                $keyDecodeArr[$spath] = SortingPath::trackTranslation($application_model_id, $spath, $lang);
            }
            return $keyDecodeArr;
        }

        public function getScenarioItemId($currstep)
                {
                    
                    return 0;
                }
        
        public static function loadByMainIndex($application_plan_id, $session_num, $application_simulation_id, $application_plan_branch_id, $track_num,$create_obj_if_not_found=false)
        {
           if(!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");
           if(!$session_num) throw new AfwRuntimeException("loadByMainIndex : session_num is mandatory field");
           if(!$application_simulation_id) throw new AfwRuntimeException("loadByMainIndex : application_simulation_id is mandatory field");
           if(!$application_plan_branch_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_branch_id is mandatory field");
           if(!$track_num) throw new AfwRuntimeException("loadByMainIndex : track_num is mandatory field");


           $obj = new SortingSessionStat();
           $obj->select("application_plan_id",$application_plan_id);
           $obj->select("session_num",$session_num);
           $obj->select("application_simulation_id",$application_simulation_id);
           $obj->select("application_plan_branch_id",$application_plan_branch_id);
           $obj->select("track_num",$track_num);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("application_plan_id",$application_plan_id);
                $obj->set("session_num",$session_num);
                $obj->set("application_simulation_id",$application_simulation_id);
                $obj->set("application_plan_branch_id",$application_plan_branch_id);
                $obj->set("track_num",$track_num);

                $obj->insertNew();
                if(!$obj->id) return null; // means beforeInsert rejected insert operation
                $obj->is_new = true;
                return $obj;
           }
           else return null;
           
        }

        public function rowCategoryAttribute()
        {
            return "correct:FORMULA";
        }


        public function getDisplay($lang="ar")
        {
                
                $data = array();
                $link = array();
                

                list($data[0],$link[0]) = $this->displayAttribute("application_plan_branch_id",false, $lang);
                list($data[1],$link[1]) = $this->displayAttribute("session_num",false, $lang);

                
                return implode(" - كرة فرز رقم ",$data);
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
            return false;    
	    }


        public function attributeIsApplicable($attribute)
        {
                if (($attribute == "min_app_score2") or
                    ($attribute == "min_app_score3") or
                    ($attribute == "min_acc_score2") or
                    ($attribute == "min_acc_score3")) {
                        return false;
                }
                
                return true;
        }



        public function calcFarz_karra_table($what="withPrefix")
        {
            $session_num = $this->getVal("session_num");
            $application_plan_id = $this->getVal("application_plan_id");
            $application_simulation_id = $this->getVal("application_simulation_id");
            $track_num = $this->getVal("track_num");
            $application_plan_branchObj = $this->het("application_plan_branch_id");
            $sorting_group_id = $application_plan_branchObj ? $application_plan_branchObj->getVal("sorting_group_id") : 0;
            $server_db_prefix = AfwSession::config("db_prefix", "default_db_");

                

            $sorting_table_without_prefix = "final_farz_ap".$application_plan_id."_as".$application_simulation_id."_k".$session_num."_sg$sorting_group_id"."_pth$track_num";
            $sorting_table = $server_db_prefix."adm.".$sorting_table_without_prefix;

            if($what=="withPrefix") return $sorting_table; else return $sorting_table_without_prefix;
        }

        public function calcCorrect($what="value")
        {
            $lang = AfwLanguageHelper::getGlobalLanguage();
            list($yes , $no, $euh) = $this->translateMyYesNo("correct", $what, $lang);
            $nb_accepted = $this->getVal("nb_accepted"); 
            $capacity = $this->getVal("capacity");

            if(!$capacity) return $euh;

            $correct = ($nb_accepted<=$capacity);
            return $correct ? $yes : $no;
        }

        public function calcSorting_session_id($what="value")
        {
            $session_num = $this->getVal("session_num");
            $application_plan_id = $this->getVal("application_plan_id");
            $obj = SortingSession::loadByMainIndex($application_plan_id, $session_num);

            return ($what=="value") ? $obj->id : $obj;
        }
             
}