<?php 

                
$file_dir_name = dirname(__FILE__); 
                
// require_once("$file_dir_name/../afw/afw.php");

class ApplicationSimulation extends AdmObject{

        public static $MY_ATABLE_ID=13951; 
  
        public static $DATABASE		= "uoh_adm";
        public static $MODULE		        = "adm";        
        public static $TABLE			= "application_simulation";

	    public static $DB_STRUCTURE = null;
	
	    public function __construct(){
		parent::__construct("application_simulation","id","adm");
            AdmApplicationSimulationAfwStructure::initInstance($this);    
	    }
        
        public static function loadById($id)
        {
           $obj = new ApplicationSimulation();
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
               return $this->getVal("name_$lang");
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
            $title_ar = "تنفيذ المحاكاة"; 
            $methodName = "runSimulation";
            $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("log"));
            
            
            
            return $pbms;
        }

        public function getOptions($option="all")
        {
            $options_arr = [];
            $settings_arr = explode("\n",$this->getVal("settings"));
            foreach($settings_arr as $settings_item)
            {
                $settings_item = trim($settings_item);
                list($optionItem,$optionVal) = explode("=",$settings_item);
                if($option=="all" or $option=$optionItem)
                {
                    $options_arr[$optionItem] = $optionVal;
                }
            }

            return $options_arr;
        }

        public function getMyApplicantList($applicationModelObj=null, $applicantGroupObj=null, $applicationPlanObj=null, $limit = '', $applyDateGreg='')
        {
            $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
            if(!$applicationModelObj) $applicationModelObj = $this->het("application_model_id");
            if(!$applicationModelObj) return [];
            if(!$applicantGroupObj) $applicantGroupObj = $this->het("applicant_group_id");
            if(!$applicantGroupObj) return [];
            
            $application_model_id = $applicationModelObj->id;            
            $applicant_group_id = $applicantGroupObj->id;
            // $application_simulation_id = $this->id;
            if(!$applicationPlanObj) $applicationPlanObj = $applicationModelObj->getCurrentPlan($applyDateGreg);
            if(!$applicationPlanObj) return [];
            $application_plan_id = $applicationPlanObj->id;

            if($applicantGroupObj->id==2)
            {
                
            
                $where = "id in (select applicant_id from $server_db_prefix"."amd.application where application_plan_id=$application_plan_id and application_simulation_id=2)";
            }
            else
            {
                $where = "active='Y' and application_model_id = $application_model_id and applicant_group_id=$applicant_group_id";
            }

            $obj = new Applicant();
            $obj->where($where);

            return [$applicationModelObj, $applicantGroupObj, $applicationPlanObj, $obj->loadMany($limit)];
        }

        public function runSimulation($lang="ar")
        {
            if($this->id==2) $typeRun = "Real-application";
            else $typeRun = "Application-simulation";

            $arrOptions = $this->getOptions();
            if(!$arrOptions["DATE"]) $arrOptions["DATE"] = date("Y-m-d");

            $err_arr = [];
            $inf_arr = [];
            $war_arr = [];
            $tech_arr = [];
            $log_arr = [];
            try {
                // $application_model_id = $this->getVal("application_model_id");
                // $applicant_group_id = $this->getVal("applicant_group_id");
                list($applicationModelObj, $applicantGroupObj, $applicationPlanObj, $applicantList) = $this->getMyApplicantList(null,null,null,'',$arrOptions["DATE"]);
                foreach($applicantList as $applicantItem)
                {
                    $logMe = $applicantItem->sureIs("log");
                    list($err, $inf, $war, $tech) = $applicantItem->simulateApplication($applicationModelObj, $applicationPlanObj, $this);
                    
                    if($logMe)
                    {
                        $applicant_name = $applicantItem->getDisplay($lang);
                        $applicant_idn = $applicantItem->getVal("idn");
                        if ($err) $err_arr[] = "$applicant_name : " . $err;                    
                        if ($inf) $inf_arr[] = "$applicant_name : " . $inf;
                        if ($war) $war_arr[] = "$applicant_name : " . $war;
                        if ($tech) $tech_arr[] = $tech;    

                        $log_arr[] = "-- $typeRun for $applicant_idn - $applicant_name";
                        if ($err) $log_arr[] = "error : " . $err;                    
                        if ($inf) $log_arr[] = "information : " . $inf;
                        if ($war) $log_arr[] = "warning : " . $war;
                        if ($tech) $log_arr[] = "debugg : " . $tech;    
                    }
                    
                }

                $this->set("log", implode("\n",$log_arr));
                $this->commit();
            } catch (Exception $e) {
                $err_arr[] = $e->getMessage();
            } catch (Error $e) {
                    $err_arr[] = $e->__toString();
            }
            // die("war_arr=".var_export($war_arr));
            return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
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
            $server_db_prefix = AfwSession::config("db_prefix","uoh_");
            
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

    public function stepsAreOrdered()
    {
        return true;
    }
             
}



// errors 

