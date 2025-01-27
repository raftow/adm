<?php
// ------------------------------------------------------------------------------------
// 27/1/2023
// ALTER TABLE `acondition` CHANGE `acondition_order` `acondition_order` SMALLINT(6) NOT NULL DEFAULT '0'; 

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class Acondition extends AdmObject{

	public static $DATABASE		= ""; 
        public static $MODULE		    = "adm"; 
        public static $TABLE			= "acondition"; 
        public static $DB_STRUCTURE = null; 


        private ?Acondition $cond1Obj = null;
        private ?Acondition $cond2Obj = null;
        private ?ApplicationField $afObj = null;
        private ?Aparameter $aparamObj = null;
        
        

        public function __construct(){
		parent::__construct("acondition","id","adm");
                AdmAconditionAfwStructure::initInstance($this);
	}

        public static function loadById($id)
        {
                $obj = new Acondition();
                
                if($obj->load($id))
                {
                        return $obj;
                }
                else return null;
        }
        
        public function getAllFields($amObj=null) 
        {
                $return_arr = [];
                if($this->id==1)
                {
                        if($amObj)
                        {
                                $takeDefault = false;
                                $boolIndex = false;
                                $fieldsArr = $amObj->mfkValueToArrayOrBoolIndex("application_field_mfk", $boolIndex, $takeDefault);
                                foreach($fieldsArr as $fieldId)
                                {
                                        $objAF = ApplicationField::loadById($fieldId);
                                        $return_arr[] = ["id"=>$fieldId, "name"=>$objAF->getVal("field_name")];                
                                }
                        }
                }
                elseif($this->_isComposed())
                {
                        if(!$this->cond1Obj) $this->cond1Obj = $this->het("condition_1_id");
                        if(!$this->cond2Obj) $this->cond2Obj = $this->het("condition_2_id");
                        $return_1_arr = [];
                        if($this->cond1Obj) $return_1_arr = $this->cond1Obj->getAllFields($amObj);
                        $return_2_arr = [];
                        if($this->cond2Obj) $return_2_arr = $this->cond2Obj->getAllFields($amObj);

                        $return_arr = array_merge($return_1_arr, $return_2_arr);
                        // die("getAllFields case _isComposed => ".var_export($return_arr, true));
                }    
                else
                {
                        $return_arr[] = ["id"=>$this->getVal("afield_id"), "name"=>$this->showAttribute("afield_id",null,true,'en')];
                }

                return $return_arr;
        }

        /**
         * @param AFWObject $objToApplyOn
         * 
         */

        public function getExcuseText($lang="ar", $objToApplyOn=null)
        {
               if($lang=="fr") $lang = "en";
               $return = $this->getVal("excuse_text_$lang"); 
               if($objToApplyOn) $return = $objToApplyOn->decodeTpl($return,[],$lang);
               return $return;
        }
        

        public function getDisplay($lang="ar")
        {
               if($lang=="fr") $lang = "en";
               list($data,$link) = $this->displayAttribute("acondition_origin_id");
               $data2 = $this->getVal("acondition_name_$lang");
               //$data3 = $this->getVal("acondition_order");
               return $data." ← ".$data2;
        }

        public function getShortDisplay($lang="ar")
        {
               if($lang=="fr") $lang = "en";
               return $this->getVal("acondition_name_$lang");               
        }

        public function getDropdownDisplay($lang="ar")
        {
               if($lang=="fr") $lang = "en";
               // list($data,$link) = $this->displayAttribute("acondition_origin_id");
               $data2 = $this->getVal("acondition_name_$lang");
               // $data3 = $this->getVal("acondition_order");
               return $data2;
        }

        public static function loadByMainIndex($acondition_origin_id,$acondition_order,$create_obj_if_not_found=false)
        {
           $obj = new Acondition();
           if(!$acondition_origin_id) throw new AfwRuntimeException("loadByMainIndex : acondition_origin_id is mandatory field");
           if(!$acondition_order) throw new AfwRuntimeException("loadByMainIndex : acondition_order is mandatory field");
           $obj->select("acondition_origin_id",$acondition_origin_id);
           $obj->select("acondition_order",$acondition_order); 
           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("acondition_origin_id",$acondition_origin_id);
                $obj->set("acondition_order",$acondition_order); 
                $obj->insertNew();
                $obj->is_new = true;
                return $obj;
           }
           else return null;
 
        }

        public static function list_of_operator_id()
        {
            global $lang;
            return self::operator()[$lang];
        }
        
        public static function operator()
        {
                $arr_list_of_operator = array();
                
                
                $arr_list_of_operator["en"][1] = "And";
                $arr_list_of_operator["ar"][1] = "و";

                $arr_list_of_operator["en"][2] = "Or";
                $arr_list_of_operator["ar"][2] = "أو";

                
                
                
                return $arr_list_of_operator;
        } 


        public static function code_of_compare_id($lkp_id=null)
        {
            global $lang;
            if($lkp_id) return self::compare()['code'][$lkp_id];
            else return self::compare()['code'];
        }
        
        
        public static function list_of_compare_id()
        {
            global $lang;
            return self::compare()[$lang];
        }

        public static function translateComparator($comparator, $lang)
        {
                return self::compare()[$lang][$comparator];  
        }
        
        public static function compare()
        {
                $arr_list_of_compare = array();
                
                
                $arr_list_of_compare["en"][7] = "Belongs to";
                $arr_list_of_compare["ar"][7] = "ينتمي إلى";
                $arr_list_of_compare["code"][7] = "in";

                $arr_list_of_compare["en"][8] = "Does not belong to";
                $arr_list_of_compare["ar"][8] = "لا ينتمي إلى";
                $arr_list_of_compare["code"][8] = "!in";

                $arr_list_of_compare["en"][1] = "Equal to";
                $arr_list_of_compare["ar"][1] = "يساوي";
                $arr_list_of_compare["code"][1] = "=";

                $arr_list_of_compare["en"][2] = "Greater than";
                $arr_list_of_compare["ar"][2] = "أكبر من";
                $arr_list_of_compare["code"][2] = ">";

                $arr_list_of_compare["en"][3] = "Less than";
                $arr_list_of_compare["ar"][3] = "أصغر من";
                $arr_list_of_compare["code"][3] = "<";

                $arr_list_of_compare["en"][4] = "Greater than or equal to";
                $arr_list_of_compare["ar"][4] = "أكبر أو يساوي";
                $arr_list_of_compare["code"][4] = ">=";

                $arr_list_of_compare["en"][5] = "Less than or equal to";
                $arr_list_of_compare["ar"][5] = "أصغر أو يساوي";
                $arr_list_of_compare["code"][5] = "<=";

                $arr_list_of_compare["en"][6] = "Not equal to";
                $arr_list_of_compare["ar"][6] = "لا يساوي";
                $arr_list_of_compare["code"][6] = "!=";

                $arr_list_of_compare["en"][9] = "Contains";
                $arr_list_of_compare["ar"][9] = "يحتوي علي";
                $arr_list_of_compare["code"][9] = "";

                $arr_list_of_compare["en"][10] = "Not contains";
                $arr_list_of_compare["ar"][10] = "لا يحتوي علي";
                $arr_list_of_compare["code"][10] = "";

                
                
                
                return $arr_list_of_compare;
        } 


        public function attributeIsApplicable($attribute)
        {
                /*
                global $objme;
                
                
                */

                if (($attribute == "condition_1_id") or ($attribute == "operator_id") or ($attribute == "condition_2_id")) 
                {
                        return $this->_isComposed();
                }

                if (($attribute == "afield_id") or ($attribute == "compare_id") or ($attribute == "aparameter_id")) 
                {
                        return (!$this->_isComposed());
                }

                return true;
        }


        public function calcApplication_table_id()
        {
               return $this->_isGeneral() ? '1,3' : '1,2,3';
        }

        protected function getPublicMethods()
        {
        
                $pbms = array();
                
                

                $color = "green";
                $title_ar = "محاكاة هذا الشرط"; 
                $methodName = "simulateMeOnSomeCases";
                $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "PUBLIC"=>true, "BF-ID"=>"", 'STEPS' =>[2,3]);
                

                
                
                return $pbms;
        }

        public function simulateMeOnSomeCases($lang="ar")
        {
                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];

                $cond_name = "الشرط " . $this->getShortDisplay($lang);

                try{
                        // from simulation config get data :
                        // load simulation applicants
                        $simulation_applicants_ids = AfwSession::config("simulation_applicants","");
                        // simulation_application_plan_id
                        $simulation_application_plan_id = AfwSession::config("simulation_application_plan_id",0);
                        // simulation_application_model_id 
                        $simulation_application_model_id = AfwSession::config("simulation_application_model_id",0);
                        $appObj = new Applicant();
                        $appObj->where("id in ($simulation_applicants_ids)");
                        $appList = $appObj->loadMany();
                        // die("appList=".var_export($appList,true));
                        if(count($appList)>0)
                        {
                                foreach($appList as $appItem)
                                {
                                        if($this->_isGeneral())
                                        {
                                                // if this is a general condition we apply on simulation applicant
                                                $err = "";
                                                $inf = "";
                                                $war = "";
                                                
                                                list($res, $comments) = $this->applyOnObject($lang, $appItem, $simulation_application_plan_id, $simulation_application_model_id);
                                                if($res)
                                                {
                                                        $inf = "<b>$cond_name</b> متحقق في : ".$appItem->getWideDisplay($lang)." <i>".$comments."</i>";      
                                                }
                                                else
                                                {
                                                        $war = "<b>$cond_name</b> غير متحقق في : ".$appItem->getWideDisplay($lang)." <i>".$comments."</i>";      
                                                }
        
                                                if($err) $err_arr[] = $err;
                                                if($inf) $inf_arr[] = $inf;
                                                if($war) $war_arr[] = $war;
                                        }
                                        else
                                        {
                                                // if this is a special condition we apply on desires of these simulation applicant 
                                                $desireList = $appItem->getMyDesires($simulation_application_plan_id);
                                                if(count($desireList)==0) 
                                                {
                                                        $err_arr[] = "لا يوجد رغبات للمتقدم ".$appItem->getWideDisplay($lang)." على حملة القبول ".$simulation_application_plan_id;
                                                }
                                                foreach($desireList as $desireItem)
                                                {
                                                        // if this is a general condition we apply on simulation applicant
                                                        $err = "";
                                                        $inf = "";
                                                        $war = "";
                                                        
                                                        list($res, $comments) = $this->applyOnObject($lang, $desireItem, $simulation_application_plan_id, $simulation_application_model_id);
                                                        if($res)
                                                        {
                                                                $inf = "<b>$cond_name</b> متحقق في : ".$appItem->getWideDisplay($lang)." على الرغبة " .$desireItem->getDisplay($lang)." <i>".$comments."</i>";      
                                                        }
                                                        else
                                                        {
                                                                $war = "<b>$cond_name</b> غير متحقق في : ".$appItem->getWideDisplay($lang)." على الرغبة " .$desireItem->getDisplay($lang)." <i>".$comments."</i>";      
                                                        }
        
                                                        if($err) $err_arr[] = $err;
                                                        if($inf) $inf_arr[] = $inf;
                                                        if($war) $war_arr[] = $war;
                                                }
        
                                        }     
        
                                        
                                }
                        }
                        else
                        {
                                $war_arr[] = "لم يتم العثور على المتقدمين للمحاكاة $simulation_applicants_ids";
                        }

                        
                }
                catch(Exception $e)
                {
                        $devMode = AfwSession::config("MODE_DEVELOPMENT", false);
                        if($devMode) $error_message = $e->getMessage()."<br> trace is : <br>".$e->getTraceAsString();
                        else $error_message = $this->translate("error-occured-try-later",$lang);

                        $err_arr[] = $error_message;
                }
                // die("war_arr=".var_export($war_arr));
                return AfwFormatHelper::pbm_result($err_arr,$inf_arr,$war_arr,"<br>\n",$tech_arr);
                
        }

        public function applyOnObject($lang, $obj, $application_plan_id, $application_model_id, $simulate=true)
        {
                /*
                if(!$application_model_id)
                {
                        throw new AfwRuntimeException("no valid application_model_id given for condition execution");   
                }

                if(!$application_plan_id)
                {
                        throw new AfwRuntimeException("no valid application_plan_id given for condition execution");   
                }

                */

                if((!$obj) or ($obj->isEmpty()))
                {
                        throw new AfwRuntimeException("no valid object given for applying condition");
                }


                $objApplicant = null;
                $objApplication = null;
                $application_id = 0;

                if($obj instanceof Applicant)
                {                       
                        $objApplicant = $obj;
                        $applicant_id = $obj->id;
                        $adesire_id = 0;
                        
                }
                elseif($obj instanceof Application)
                {
                        $objApplication = $obj;
                        $application_id = $obj->id;
                        $objApplicant = $obj->het("applicant_id");
                        $applicant_id = $obj->getVal("applicant_id");
                        $adesire_id = 0;
                }
                /*
                elseif($obj instanceof ApplicationDesire)
                {
                        $applicant_id = $obj->getVal("applicant_id");
                        $adesire_id = $obj->id;
                }*/
                else
                {
                        throw new AfwRuntimeException("unknown class for applying condition : ".get_class($obj));
                }

                $has_failed = $this->tm("has failed");
                $has_succeeded = $this->tm("has succeeded");

                if($this->_isComposed())
                {
                        // to avoid for big loops to recreate the composing objects for each iteration
                        // save it inside a private attribute
                        if(!$this->cond1Obj) $this->cond1Obj = $this->get("condition_1_id");
                        if(!$this->cond2Obj) $this->cond2Obj = $this->get("condition_2_id");

                        if(!$this->cond1Obj) throw new AfwRuntimeException("no valid part 1 given for composed condition");
                        if(!$this->cond2Obj) throw new AfwRuntimeException("no valid part 2 given for composed condition");

                        $cond1Desc = $this->tm("condition part", $lang)." 1";
                        $cond2Desc = $this->tm("condition part", $lang)." 2";

                        list($res1, $comments1, $tech1) = $this->cond1Obj->applyOnObject($lang, $obj, $application_plan_id, $application_model_id, $simulate);
                        
                        // if(!$res1) die($this->cond1Obj->getShortDisplay($lang)." => comments1=$comments1, tech1=$tech1");
                        $operator = $this->getVal("operator_id");
                        

                        if($operator==1) // and
                        {
                                if($res1)
                                {
                                        list($res2, $comments2, $tech2) = $this->cond2Obj->applyOnObject($lang, $obj, $application_plan_id, $application_model_id, $simulate);
                                        if(!$res2) return [false, $cond2Desc." " .$has_failed. " : ".$comments2, $cond2Desc.":".$tech2];
                                        else return [true, $cond1Desc." " .$has_succeeded. " : ".$comments1."<br>\n".$cond2Desc." " .$has_succeeded. " : ".$comments2, $cond2Desc.":".$tech2."<br>\n".$cond1Desc.":".$tech1];
                                }
                                else
                                {
                                        return [false, $cond1Desc." " .$has_failed. " : ".$comments1, $cond1Desc.":".$tech1];        
                                }
                                

                                
                        }
                        else // or
                        {
                                if(!$res1)
                                {
                                        list($res2, $comments2, $tech2) = $this->cond2Obj->applyOnObject($lang, $obj, $application_plan_id, $application_model_id, $simulate);
                                        if(!$res2) return [false, $cond1Desc." " .$has_failed. " : ".$comments1."<br>\n".$cond2Desc.":".$comments2, $cond1Desc.":".$tech1."<br>\n".$cond2Desc.":".$tech2];
                                        else return [true, $cond2Desc." " .$has_succeeded. " : ".$comments2, $cond2Desc.":".$tech2];        
                                }
                                else return [true, $cond1Desc." " .$has_succeeded. " : ".$comments1, $cond1Desc.":".$tech1];        
                                
                        }
                }
                else
                {
                        if(!$this->afObj) $this->afObj = $this->get("afield_id");
                        if(!$this->aparamObj) $this->aparamObj = $this->get("aparameter_id");

                        if(!$this->afObj) throw new AfwRuntimeException("no valid field given for simple condition");
                        if(!$this->aparamObj) throw new AfwRuntimeException("no valid param given for simple condition");
                        $aparameter_id = $this->aparamObj->id;
                        $afield_id = $this->afObj->id;

                        $comparator = $this->getVal("compare_id");

                        $field_name = $this->afObj->getVal("field_name");
                        $field_title = $this->afObj->getDisplay($lang);
                        $field_reel = $this->afObj->_isReel();
                        $application_table_id = $this->afObj->getVal("application_table_id");
                        $objToApplyOn = null;
                        if($application_table_id==1)
                        {
                                $objApplicant->updateCalculatedFields();
                                if($field_reel)
                                {
                                        $field_value = $objApplicant->getVal($field_name);
                                        $field_value_case = "getVal";
                                }
                                else
                                {
                                        $field_value = $objApplicant->calc($field_name);
                                        $field_value_case = "calc";
                                }
                                $objToApplyOn =& $objApplicant;
                        }
                        elseif($application_table_id==3)
                        {
                                // die("here rafik applicant_id=$applicant_id application_table_id=$application_table_id application_plan_id=$application_plan_id field_name=$field_name field_reel=$field_reel");
                                if(!$objApplication) $objApplication = Application::loadByMainIndex($applicant_id, $application_plan_id, $simulate);
                                if(!$objApplication)
                                {
                                        // die("here rafik Application::loadByMainIndex($applicant_id, $application_plan_id, $simulate) keyf failed ??");
                                        $field_value = null;
                                        $field_value_case = "Application::loadByMainIndex($applicant_id, $application_plan_id) return null"; 
                                }
                                elseif($field_reel)
                                {
                                        $field_value = $objApplication->getVal($field_name);
                                        $field_value_case = "getVal";
                                }
                                else
                                {
                                        // die("before objApp->calc rafik applicant_id=$applicant_id application_table_id=$application_table_id field_name=$field_name");
                                        $field_value = $objApplication->calc($field_name);
                                        $field_value_case = "calc";
                                }
                                $objToApplyOn =& $objApplication;
                        }
                        elseif($application_table_id==2)
                        {
                                $objDesire = ApplicationDesire::loadById(1);
                                if(!$objDesire)
                                {
                                        $field_value = null;
                                        $field_value_case = "ApplicationDesire::loadByMainIndex return null"; 
                                }
                                elseif($field_reel)
                                {
                                        $field_value = $objDesire->getVal($field_name);
                                        $field_value_case = "getVal";
                                }
                                else
                                {
                                        $field_value = $objDesire->calc($field_name);
                                        $field_value_case = "calc";
                                }
                                $objToApplyOn =& $objDesire;
                        }
   
                        if(is_string($field_value) and (strlen($field_value)>15))
                        {
                                throw new AfwRuntimeException("not valid field value : $field_value = <br> $obj => <br> $field_value_case($field_name)");        
                        }
                        $param_valueObj = $this->aparamObj->getMyValueForContext($application_model_id, $application_plan_id, $obj);

                        if(!$param_valueObj) 
                        {
                                $exec_result = false;
                                $comments = $this->tm("no general or customized value for parameter", $lang)." : ".$this->aparamObj->getDisplay($lang);
                        }
                        else
                        {
                                $param_value = $param_valueObj->getVal("value");
                                list($exec_result, $tech) = $this->applyComparison($field_value, $comparator, $param_value, $lang, $field_title);
                                $excuseText = $this->getExcuseText($lang, $objToApplyOn);
                                $devMode = AfwSession::config("MODE_DEVELOPMENT", false);
                                if(!$excuseText or $devMode) $excuseText .= " " . $this->tm("The condition")." : ". $this->getShortDisplay($lang)." ".$has_failed;
                                if($devMode) $excuseText .= " [[$tech]]";
                                $successText = $this->tm("The condition")." : ". $this->getShortDisplay($lang)." ".$has_succeeded;
                                $comments = $exec_result ? $successText : $excuseText;
                        } 
                        
                        

                        if(!$simulate or true)
                        {
                                $acondition_id = $this->id;
                                $aparameter_value_date = $field_date = $condition_exec_date = date("Y-m-d H:i:s");
                                $acExecObj = ApplicationConditionExec::loadByMainIndex($application_plan_id,$applicant_id,$adesire_id,$acondition_id, true);
                                $acExecObj->set("field_value",$field_value);
                                $acExecObj->set("condition_exec_date",$condition_exec_date);
                                $acExecObj->set("field_date",$field_date);
                                $acExecObj->set("aparameter_id",$aparameter_id);
                                $acExecObj->set("aparameter_value",$param_value);
                                $acExecObj->set("aparameter_value_date",$aparameter_value_date);
                                $success_ind = $exec_result ? "Y" : "N";
                                $acExecObj->set("success_ind",$success_ind);
                                
                                $acExecObj->commit();
                                unset($acExecObj);
                        }


                        return [$exec_result, $comments, $tech];
                }
        }

        public function applyComparison($field_value, $comparator, $param_value, $lang="ar", $field_title="[اسم حقل]")
        {
                // arr_list_of_compare["en"][1] = "Equal to";
                if($comparator == 1)
                {
                        // $comparatorDesc = "Equal to";
                        $return = ($field_value == $param_value);
                }
                // arr_list_of_compare["en"][2] = "Greater than";
                elseif($comparator == 2)
                {
                        // $comparatorDesc = "Greater than";
                        $return = ($field_value > $param_value); 
                }
                // arr_list_of_compare["en"][3] = "Less than";
                elseif($comparator == 3)
                {
                        // $comparatorDesc = "Less than";
                        $return = ($field_value < $param_value);  
                }
                // arr_list_of_compare["en"][4] = "Greater than or equal to";
                elseif($comparator == 4)
                {
                        // $comparatorDesc = "Greater than or equal to";
                        $return = ($field_value >= $param_value); 
                }
                // arr_list_of_compare["en"][5] = "Less than or equal to";
                elseif($comparator == 5)
                {
                        // $comparatorDesc = "Less than or equal to";
                        $return = ($field_value <= $param_value); 
                }
                // arr_list_of_compare["en"][6] = "Not equal to";
                elseif($comparator == 6)
                {
                        // $comparatorDesc = "Not equal to";
                        $return = ($field_value != $param_value); 
                }
                // arr_list_of_compare["en"][7] = "Belongs to";
                elseif($comparator == 7)
                {
                        // $comparatorDesc = "Belongs to";
                        $param_value_arr = explode(",",trim(trim($param_value),","));
                        $return = in_array($field_value,$param_value_arr);  
                }
                // arr_list_of_compare["en"][8] = "Does not belong to";
                elseif($comparator == 8)
                {
                        // $comparatorDesc = "Does not belong to";
                        $param_value_arr = explode(",",trim(trim($param_value),","));
                        $return = !in_array($field_value,$param_value_arr);  
                }
                // arr_list_of_compare["en"][9] = "Contains";
                elseif($comparator == 9)
                {
                        // $comparatorDesc = "Contains";
                        $field_value_arr = explode(",",trim(trim($field_value),","));
                        $return = in_array($param_value,$field_value_arr);
                }
                // arr_list_of_compare["en"][10] = "Not contains";
                elseif($comparator == 10)
                {
                        // $comparatorDesc = "Not contains";
                        $field_value_arr = explode(",",trim(trim($field_value),","));
                        $return = !in_array($param_value,$field_value_arr);
                }
                else throw new AfwRuntimeException("unknown comparator = $comparator");

                $comparatorDesc = self::translateComparator($comparator, $lang);
                $field_value_tr = $this->tm("the following field value", $lang); 
                if($return) $is_or_isnt = $this->tm("very the condition that", $lang); 
                else $is_or_isnt = $this->tm("does'nt very the condition that", $lang);

                return [$return, "$field_value_tr [ $field_title = $field_value ] $is_or_isnt $comparatorDesc $param_value"];

        }        

        // acondition 
        public function getScenarioItemId($currstep)
        {
                if ($currstep == 1) return 381;
                if ($currstep == 2) return 382;
                if ($currstep == 3) return 383;

                return 0;
        }

        protected function getOtherLinksArray($mode, $genereLog = false, $step="all")      
        {
                global $me, $objme, $lang;
                
                $displ = $this->getDisplay($lang);
                $otherLinksArray = $this->getOtherLinksArrayStandard($mode, false, $step);
                $my_id = $this->getId();

                if(
                        $my_id and (
                                (($mode=="mode_condition_1_id") and (!$this->getVal("condition_1_id"))) or 
                                (($mode=="mode_condition_2_id") and (!$this->getVal("condition_2_id")))
                               )
                        )

                {
                        $aco_id = $this->getVal("acondition_origin_id");
                        unset($link);
                        $link = array();
                        $title = "إضافة هذا الشرط";
                        $general = $this->getVal("general");
                        // $title_detailed = $title ."لـ : ". $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=Acondition&currmod=adm&sel_acondition_origin_id=$aco_id&sel_general=$general&sel_acondition_type_id=3";
                        $link["TITLE"] = $title;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;     

                }

                if($my_id and ($mode=="mode_aconditionOriginScopeList"))
                {
                        
                        unset($link);
                        $link = array();
                        $title = "إضافة مجال تطبيق جديد";
                        $title_detailed = $title ."لـ : ". $displ;
                        $link["URL"] = "main.php?mp=ed&cl=AconditionOriginScope&cm=adm&sel_acondition_origin_id=$my_id";
                        $link["TITLE"] = $title;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;     

                }
                
                return $otherLinksArray;          
        }


        public function shouldBeCalculatedField($attribute){
                if($attribute=="afile_ext") return true;
                if($attribute=="afield_type_id") return true;
                return false;
        }


        public function switcherConfig($col, $auser=null)
        {
                global $lang;

                $switcher_authorized = false;        
                $switcher_title = "";
                $switcher_text = "";

                if($col== $this->fld_ACTIVE())
                {
                        $switcher_authorized = true;        
                }

                if($col == "show_fe")
                {
                        $switcher_authorized = true;        
                        $switcher_title = $this->tm("Are you sure ?", $lang);
                        $switcher_text = $this->tm("This will show or hide the appearance of this condition in gate frontend", $lang);
                }

                return [$switcher_authorized, $switcher_title, $switcher_text];
        }

        // generalCondition
        /*
        public function generalCondition($field_name, $col_struct)
        {
                $acoObj = $this->het("acondition_origin_id");        
                if($acoObj)
                {
                        return $acoObj->getVal("general");
                }

                // should not happen
                return 'W';
        }

        
        public function whyAttributeIsNotApplicable($attribute, $lang = "ar")
        {
                $icon = "na20.png";
                $textReason = $this->translateMessage("ACTIVATE-STATS-COMPUTE-OPTION", $lang);
                return array($icon, $textReason);
        }*/
}
?>      