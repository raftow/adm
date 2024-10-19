<?php
$main_company = AfwSession::config("main_company", "all");
$file_dir_name = dirname(__FILE__);
require_once($file_dir_name . "/../extra/application_additional_fields-$main_company.php");
         
class Application extends AdmObject
{
        /**
         * @var ApplicationModel $objApplicationModel
         */
        private $objApplicationModel = null;

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "application";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("application", "id", "adm");
                AdmApplicationAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new Application();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public static function loadByMainIndex($applicant_id, $application_plan_id,$create_obj_if_not_found=false)
        {
           if(!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
           if(!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");


           $obj = new Application();
           $obj->select("applicant_id",$applicant_id);
           $obj->select("application_plan_id",$application_plan_id);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("applicant_id",$applicant_id);
                $obj->set("application_plan_id",$application_plan_id);

                $obj->insertNew();
                if(!$obj->id) return null; // means beforeInsert rejected insert operation
                $obj->is_new = true;
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

        public function beforeMaj($id, $fields_updated)
        {
                $objApplicantQual = null;
                $objApplicationPlan = null;

                if(!$this->getVal("application_model_id"))
                {
                        $objApplicationPlan = $this->het("application_plan_id");
                        if($objApplicationPlan) 
                        {
                                $this->set("application_model_id", $objApplicationPlan->getVal("application_model_id")); 
                                $fields_updated["application_model_id"] = "@WasEmpty";
                        }
                }
                
                if(!$this->getVal("applicant_qualification_id"))
                {
                        $applicantObj = $this->het("applicant_id");
                        if($applicantObj)
                        {
                                $objApplicantQual = $applicantObj->getLastQualification(); 
                                if($objApplicantQual) 
                                {
                                        $this->set("applicant_qualification_id", $objApplicantQual->id); 
                                        $fields_updated["applicant_qualification_id"] = "@WasEmpty";
                                }
                        }
                }

                if(!$this->getVal("step_num"))
                {
                        $fields_updated["step_num"] = "@WasEmpty";
                        $this->set("step_num", 1); 
                }
                

                if($fields_updated["applicant_qualification_id"] and $this->getVal("applicant_qualification_id"))
                {
                        
                        if(!$objApplicantQual) $objApplicantQual = $this->het("applicant_qualification_id");
                        if($objApplicantQual)
                        {
                                $this->set("qualification_id",  $objApplicantQual->getVal("qualification_id")); 
                                $this->set("major_category_id", $objApplicantQual->getVal("major_category_id")); 
                                // reset step to 1 when applicant_qualification_id change
                                $fields_updated["step_num"] = $this->getVal("step_num");
                                $this->set("step_num", 1); 
                                
                        }
                }

                if($fields_updated["step_num"]) $this->requestAPIsOfStep($this->getVal("step_num"));

                // if(!$objApplicationPlan) $objApplicationPlan = $this->het("application_plan_id");

                if($fields_updated["step_num"] or (!$this->getVal("application_step_id")))
                {
                        if(!$this->objApplicationModel) $this->objApplicationModel = $this->het("application_model_id");
                        $appStepObj = $this->objApplicationModel->convertStepNumToObject($this->getVal("step_num"));
                        if($appStepObj)
                        {
                                $application_step_id = $appStepObj->id;
                                $this->set("application_step_id", $application_step_id);
                        }
                        
                }
                return true;
        }

        public static function getApplicationAdditionalFieldParams($field_name)
        {
                global $application_additional_fields;
                if (!$application_additional_fields) {
                        $main_company = AfwSession::config("main_company", "all");
                        $file_dir_name = dirname(__FILE__);
                        require_once($file_dir_name . "/../extra/application_additional_fields-$main_company.php");
                }

                $return = $application_additional_fields[$field_name];

                //if(!$return) die("no params for getAdditionalFieldParams($field_name) look additional_fields[$field_name] in additional_fields=".var_export($additional_fields,true));

                return $return;
        }

        public function additional($field_name, $col_struct)
        {
                $params = self::getApplicationAdditionalFieldParams($field_name);

                $col_struct = strtolower($col_struct);
                if ($col_struct == "mandatory") return (!$params["optional"]);
                if ($col_struct == "required") return (!$params["optional"]);

                if ($col_struct == "css") {
                        if (!$params["css"]) $params["css"] = 'width_pct_50';
                }


                if ($col_struct == "step") {
                        $step =  $params["step"] + 4;
                        //if($col_struct=="step" and $field_name=="attribute_1") throw new AfwRuntimeException("step additional for $field_name =".$step);
                        return $step;
                }

                $return = $params[$col_struct];
                if ($col_struct == "css") {
                        // if($field_name=="attribute_18") throw new AfwRuntimeException("css additional for $field_name params=".var_export($params,true)." return=".$return);
                }


                if($col_struct=="type" and $return != "INT") throw new AfwRuntimeException("debugg additional field $field_name col_struct=$col_struct return = $return params=".var_export($params,true));

                //if(!$return) die("no param for additional($field_name, $col_struct) params=".var_export($params,true));

                return $return;
        }

        public function getFormuleResult($attribute, $what = "value")
        {
                if(AfwStringHelper::stringStartsWith($attribute,"attribute_"))
                {
                        $params = self::getApplicationAdditionalFieldParams($attribute); 
                        $formulaMethod = $params["formula"];
                        if(!class_exists('ApplicationFormulaManager'))
                        {
                                $main_company = AfwSession::config("main_company", "all");
                                $file_dir_name = dirname(__FILE__);
                                require_once($file_dir_name . "/../extra/application_additional_fields-$main_company.php");  
                        }
                        if($formulaMethod)
                        {
                                return ApplicationFormulaManager::$formulaMethod($this);
                        }
                }
                return AfwFormulaHelper::calculateFormulaResult($this,$attribute, $what);
        }

        protected function paggableAttribute($attribute)
        {
                if (AfwStringHelper::stringStartsWith($attribute, "attribute_")) 
                {
                        $params = self::getApplicationAdditionalFieldParams($attribute);
                        if (!$params) {
                                // die("paggableAttribute died for attribute $attribute : params = ".var_export($params,true));
                                return [false, "no params defined for this additional attribute"];
                        }
                }
                
                return [true, ""];
        }

        public function getAttributeLabel($attribute, $lang = 'ar', $short = false)
        {
                if (AfwStringHelper::stringStartsWith($attribute, "attribute_")) {
                $params = self::getApplicationAdditionalFieldParams($attribute);
                if ($params) {
                        $return = $params["title_$lang"];
                        if ($return) return $return;
                }
                }
                // die("calling getAttributeLabel($attribute, $lang, short=$short)");
                return AfwLanguageHelper::getAttributeTranslation($this, $attribute, $lang, $short);
        }

        public function getScenarioItemId($currstep)
        {
                if($currstep == 1) return 477;
                if($currstep == 2) return 478;
                if($currstep == 3) return 483;
                if($currstep == 4) return 485;

                return 0;
        }

        protected function getPublicMethods()
        {
        
                $pbms = array();
                
                $color = "orange";
                $title_ar = "الانتقال الى الخطوة الموالية"; 
                $methodName = "gotoNextStep";
                $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("application_status_enum"));
                
                
                
                return $pbms;
        }

        public function gotoNextStep($lang="ar")
        {

                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];
                // $nb_updated = 0;
                // $nb_inserted = 0;
                try
                {
                        /**
                         * @var ApplicationStep $currentStepObj
                         */
                        $currentStepObj = $this->het("application_step_id");
                        $currentStepNum = $this->getVal("step_num");

                        if(!$currentStepObj) return [$this->tm("No current step defined for this application", $lang), ""];

                        // to go to next step we should apply conditions of the current step
                        $applyResult = $currentStepObj->applyMyGeneralConditionsOn($this, $lang);
                        $success = $applyResult['success'];
                        
                        list($error_message, $success_message, $fail_message, $tech) = $applyResult['res'];
                        if($success)
                        {
                                if(!$this->objApplicationModel) $this->objApplicationModel = $this->het("application_model_id");
                                $nextStepNum = $this->objApplicationModel->getNextGeneralStepNumOf($currentStepNum);
                                $tech_arr[] = "nextStepNum=$nextStepNum currentStepNum=$currentStepNum";
                                $this->set("step_num", $nextStepNum);
                                $this->commit();
                                if($nextStepNum != $currentStepNum)
                                {
                                        $this->requestAPIsOfStep($nextStepNum);
                                }
                                $inf_arr[]  = $this->tm("The move from step", $lang)." : ".$currentStepObj->getDisplay($lang)." ".$this->tm("has been successfully done", $lang); 
                                $inf_arr[]  = $success_message;
                                $tech_arr[] = $tech;
                        }
                        else
                        {
                                $err_arr[]  = $this->tm("The move from step", $lang)." : ".$currentStepObj->getDisplay($lang)." ".$this->tm("has failed for the following reason", $lang)." : "; 
                                $war_arr[]  = $fail_message;
                                $tech_arr[] = $tech;
                        }
                }
                catch(Exception $e)
                {
                        $err_arr[] = $e->getMessage();
                }
                catch(Error $e)
                {
                        $err_arr[] = $e->__toString();
                }
                return AfwFormatHelper::pbm_result($err_arr,$inf_arr,$war_arr,"<br>\n",$tech_arr);
                
                
        }

        public function requestAPIsOfStep($nextStepNum)
        {
                if(!$this->objApplicationModel) $this->objApplicationModel = $this->het("application_model_id");
                $appModelApiList = $this->objApplicationModel->getAppModelApiOfStep($nextStepNum);

                $appModelApiListCount = count($appModelApiList);

                // die("appModelApiList ($appModelApiListCount apis) = objApplicationModel->getAppModelApiOfStep($nextStepNum) = ".var_export($appModelApiList,true));
                // $api_runner_class = Applicant::loadApiRunner();

                $applicantObj = $this->het("applicant_id");
                if($applicantObj)
                {
                        // create step apis call requests to be done by applicant-api-request-job            
                        foreach($appModelApiList as $appModelApiItem)
                        {
                                $apiEndPointObj = $appModelApiItem->het("api_endpoint_id");
                                if($apiEndPointObj)
                                {
                                        // $api_endpoint_code = $apiEndPointObj->getVal("api_endpoint_code");                                
                                        ApplicantApiRequest::loadByMainIndex($applicantObj->id, $apiEndPointObj->id, true);
                                }
                                
                        }
                }

                
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



