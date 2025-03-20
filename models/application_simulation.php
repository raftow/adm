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

        public function getOptions($option="all", $value=false)
        {
            $options_arr = [];
            $settings_arr = explode("\n",$this->getVal("settings"));
            foreach($settings_arr as $settings_item)
            {
                $settings_item = trim($settings_item);
                list($optionItem, $optionVal) = explode("=",$settings_item);
                if($option=="all" or $option==$optionItem)
                {
                    if($value) 
                    {
                        // return "($option==all or $option=$optionItem) $settings_item => optionVal=$optionVal";
                        return $optionVal;                        
                    }
                    $options_arr[$optionItem] = $optionVal;
                }
            }

            return $options_arr;
        }

        public function getMyApplicantList($applicationModelObj=null, $applicantGroupObj=null, $applicationPlanObj=null, $limit = '', $applyDateGreg='')
        {
            $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
            if(!$applicationModelObj) $applicationModelObj = $this->het("application_model_id");
            if(!$applicationModelObj) return [$applicationModelObj, $applicantGroupObj, $applicationPlanObj, [], "No application model defined"];
            if(!$applicantGroupObj) $applicantGroupObj = $this->het("applicant_group_id");
            if(!$applicantGroupObj) return [$applicationModelObj, $applicantGroupObj, $applicationPlanObj, [], "No applicant group defined"];
            
            $application_model_id = $applicationModelObj->id;            
            $applicant_group_id = $applicantGroupObj->id;
            // $application_simulation_id = $this->id;
            $apContext = "defined";
            if(!$applicationPlanObj) 
            {
                $apContext = "current (at $applyDateGreg)";
                $applicationPlanObj = $applicationModelObj->getCurrentPlan($applyDateGreg);
            }
            if(!$applicationPlanObj) return [$applicationModelObj, $applicantGroupObj, $applicationPlanObj, [], "No $apContext application plan"];
            $application_plan_id = $applicationPlanObj->id;

            if($applicantGroupObj->id==2)
            {
                $where = "id in (select applicant_id from $server_db_prefix"."amd.application where application_plan_id=$application_plan_id and application_simulation_id=2)";
                $context = "Real applicants, applied on this plan (id=$application_plan_id)";
            }
            else
            {
                $where = "active='Y' and application_model_id = $application_model_id and applicant_group_id=$applicant_group_id";
                $context = "Applicants that has favorite model (id=$application_model_id) and belongs to group (id=$applicant_group_id)";
            }

            $obj = new Applicant();
            $obj->where($where);

            return [$applicationModelObj, $applicantGroupObj, $applicationPlanObj, $obj->loadMany($limit), $context];
        }

        public function runSimulation($lang="ar")
        {
            if($this->id==2) $typeRun = $this->tm("Real application", $lang);
            else $typeRun = $this->tm("Application simulation", $lang);

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
                list($applicationModelObj, $applicantGroupObj, $applicationPlanObj, $applicantList, $context) = $this->getMyApplicantList(null,null,null,'',$arrOptions["DATE"]);
                $err = "";
                if(!$applicationModelObj) $err = $this->tm("No Application Model Defined for this simulation", $lang);
                elseif(!$applicantGroupObj) $err = $this->tm("No Applicant Group Defined for this simulation", $lang);
                elseif(!$applicationPlanObj) $err = $this->tm("No Application Plan Defined for this simulation", $lang) . ". ".$this->tm("If you have not defined the DATE parameter for simulation, the system will take the current gregorian date and the current academic term to find the appropriate application plan", $lang);
                else
                {
                    $this->set("application_plan_id", $applicationPlanObj->id);
                    $nbApplicants = count($applicantList);
                    if($nbApplicants==0) $err = $this->tm("No Applicants found in context", $lang) . " : $context";
                    else 
                    {
                        $log1 = $this->tm("Number of Applicants found in context", $lang) . " : *** <!-- $context --> = $nbApplicants";
                        $inf_arr[] = $log1;
                        $log_arr[] = $log1;
                    }
                }

                if ($err) 
                {
                    $err_arr[] = "error : " . $err;                    
                    $log_arr[] = "error : " . $err; 
                }
                else
                {
                    foreach($applicantList as $applicantItem)
                    {
                        $logMe = $applicantItem->sureIs("log");
                        list($err, $inf, $war, $tech) = $applicantItem->simulateApplication($applicationPlanObj, $this);
                        
                        if($logMe)
                        {
                            $applicant_name = $applicantItem->getDisplay($lang);
                            $applicant_idn = $applicantItem->getVal("idn");
                            if ($err) $err_arr[] = "$applicant_name : " . $err;                    
                            if ($inf) $inf_arr[] = "$applicant_name : " . $inf;
                            if ($war) $war_arr[] = "$applicant_name : " . $war;
                            if ($tech) $tech_arr[] = $tech;    
                            $t_for = $this->translateOperator("for", $lang);
                            $t_error = $this->translateOperator("error", $lang);
                            $t_information = $this->translateOperator("information", $lang);
                            $t_warning = $this->translateOperator("warning", $lang);
                            $t_debugg = $this->translateOperator("debugg", $lang);
    
                            $log_arr[] = "<h1>$typeRun $t_for $applicant_idn - $applicant_name </h1>";
                            if ($err) $log_arr[] = "$t_error : " . $err;                    
                            if ($inf) $log_arr[] = "$t_information : " . $inf;
                            if ($war) $log_arr[] = "$t_warning : " . $war;
                            if ($tech) $log_arr[] = "$t_debugg : " . $tech;    
                            
                        }
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

        
        
        public function userCanDoOperationOnMe(
            $auser,
            $operation,
            $operation_sql
        ) {
            throw new AfwRuntimeException("userCanDoOperationOnMe($auser->id,$operation,$operation_sql)");
            if($operation_sql=="delete" or $operation_sql=="update") return (($this->id != 1) and ($this->id != 2));
            
            return true;
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


    public function calcApplicant_ids($what="value")
    {
        $return = $this->getOptions("SHOW_APPLICANTS", true);
        // die("getOptions(SHOW_APPLICANTS, true) = $return");
        return $return;
    }
             
}



// errors 

