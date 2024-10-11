<?php
$main_company = AfwSession::config("main_company", "all");
$file_dir_name = dirname(__FILE__);
require_once($file_dir_name . "/../extra/application_additional_fields-$main_company.php");
         
class Application extends AdmObject
{

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
                $objApplicationModel = null;
                
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

                // if(!$objApplicationPlan) $objApplicationPlan = $this->het("application_plan_id");

                if($fields_updated["step_num"] or (!$this->getVal("application_step_id")))
                {
                        if(!$objApplicationModel) $objApplicationModel = $this->het("application_model_id");
                        $appStepObj = $objApplicationModel->convertStepNumToID($this->getVal("step_num"));
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
                $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("application_model_name_ar"));
                
                
                
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
                        $currentStepObj = $this->het("application_step_id");
                        $currentStepNum = $this->het("step_num");

                        if(!$currentStepObj) return [$this->tm("No current step defined for this application", $lang), ""];

                        // to go to next step we should apply conditions of the current step
                        list($fail_reason, $success, $wwaarr, $tech) = $currentStepObj->applyMyGeneralConditionsOn($this, $lang);
                        if($success)
                        {
                                $inf_arr[]  = $this->tm("The step", $lang)." : ".$currentStepObj->getDisplay($lang)." ".$this->tm("has been successfully passed", $lang); 
                                $tech_arr[] = $tech;
                        }
                        else
                        {
                                $war_arr[]  = $this->tm("The step", $lang)." : ".$currentStepObj->getDisplay($lang)." ".$this->tm("has failel for the following reason", $lang)." : ".$fail_reason; 
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

        
}



