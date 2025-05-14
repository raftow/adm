<?php

        class ApplicationStep extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "application_step"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public static $SPECIAL_STEPS = [];

                public function __construct(){
                        parent::__construct("application_step","id","adm");
                        AdmApplicationStepAfwStructure::initInstance($this);
                        
                }

                public function moveColumn()
                {
                        return "step_num";
                }

                public static function loadById($id)
                {
                        $obj = new ApplicationStep();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
                }

                public function copyMeInto($application_model_id)
                {
                        try{
                                $stp = clone $this;
                                $stp->resetAsCopy();
                                $stp->set("application_model_id", $application_model_id);
                                $stp->commit();
                                return $stp;
                        }
                        catch(Exception $e)
                        {
                                return null;
                        }
                        catch(Error $e)
                        {
                                return null;
                        }
                        return null;
                }

                public static function loadFirstStep($application_model_id, $general='Y')
                {
                        if(!self::$SPECIAL_STEPS["FIRST-STEP-FOR-AM-$application_model_id-G-$general"]) 
                        {
                                $obj = new ApplicationStep();  
                                $obj->select("application_model_id",$application_model_id);
                                $obj->select("general",$general);
                                if($obj->load()) self::$SPECIAL_STEPS["FIRST-STEP-FOR-AM-$application_model_id-G-$general"] = $obj; 
                                else self::$SPECIAL_STEPS["FIRST-STEP-FOR-AM-$application_model_id-G-$general"] = "NOT-FOUND"; 
                        }
                        
                        if(self::$SPECIAL_STEPS["FIRST-STEP-FOR-AM-$application_model_id-G-$general"] == "NOT-FOUND") return null;
                        
                        return self::$SPECIAL_STEPS["FIRST-STEP-FOR-AM-$application_model_id-G-$general"];
                }

                

                public static function loadDesiresSelectionStep($application_model_id)
                {
                        if(!self::$SPECIAL_STEPS["DESIRES-SELECTION-STEP-$application_model_id"]) 
                        {
                                $obj = new ApplicationStep();  
                                $obj->select("application_model_id",$application_model_id);
                                $obj->select("step_code","DSR");
                                if($obj->load()) self::$SPECIAL_STEPS["DESIRES-SELECTION-STEP-$application_model_id"] = $obj; 
                                else self::$SPECIAL_STEPS["DESIRES-SELECTION-STEP-$application_model_id"] = "NOT-FOUND"; 
                        }
                        
                        if(self::$SPECIAL_STEPS["DESIRES-SELECTION-STEP-$application_model_id"] == "NOT-FOUND") return null;
                        
                        return self::$SPECIAL_STEPS["DESIRES-SELECTION-STEP-$application_model_id"];
                }

                public static function loadSortingStep($application_model_id)
                {
                        if(!self::$SPECIAL_STEPS["SORTING-STEP-$application_model_id"]) 
                        {
                                $obj = new ApplicationStep();  
                                $obj->select("application_model_id",$application_model_id);
                                $obj->select("step_code","SRT");
                                if($obj->load()) self::$SPECIAL_STEPS["SORTING-STEP-$application_model_id"] = $obj; 
                                else self::$SPECIAL_STEPS["SORTING-STEP-$application_model_id"] = "NOT-FOUND"; 
                        }
                        
                        if(self::$SPECIAL_STEPS["SORTING-STEP-$application_model_id"] == "NOT-FOUND") return null;
                        
                        return self::$SPECIAL_STEPS["SORTING-STEP-$application_model_id"];
                }

                public static function loadByMainIndex(
                        $application_model_id, 
                        $step_num,
                        $general='Y',    
                        $screenModelObj=null,                        
                        $create_obj_if_not_found=false)
                {
                   if(!$application_model_id) throw new AfwRuntimeException("loadByMainIndex : application_model_id is mandatory field");
                   if($step_num<0) throw new AfwRuntimeException("loadByMainIndex : step_num is mandatory field");

                   if($create_obj_if_not_found) 
                   {
                        if(!$screenModelObj) throw new AfwRuntimeException("loadByMainIndex : screenModelObj is mandatory attribute when you will create an instance");
                        $screen_model_id = $screenModelObj->id;
                        $show_field_mfk = $screenModelObj->getVal("application_field_mfk");
                        $step_name_ar = $screenModelObj->getVal("screen_name_ar");
                        $step_name_en = $screenModelObj->getVal("screen_name_en");
                   }
                   
        
                   $obj = new ApplicationStep();
                   $obj->select("application_model_id",$application_model_id);
                   $obj->select("step_num",$step_num);
        
                   if($obj->load())
                   {
                        if($create_obj_if_not_found) 
                        {
                                $obj->set("general",$general);
                                $obj->set("screen_model_id",$screen_model_id);
                                $obj->set("step_name_ar",$step_name_ar);
                                $obj->set("step_name_en",$step_name_en);
                                $obj->set("show_field_mfk",$show_field_mfk);
                                $obj->activate();
                        }
                        return $obj;
                   }
                   elseif($create_obj_if_not_found)
                   {
                        $obj->set("application_model_id",$application_model_id);
                        $obj->set("step_num",$step_num);


                        $obj->set("general",$general);
                        $obj->set("screen_model_id",$screen_model_id);
                        $obj->set("step_name_ar",$step_name_ar);
                        $obj->set("step_name_en",$step_name_en);
                        $obj->set("show_field_mfk",$show_field_mfk);
        
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
                        return true;
                }

                public function beforeMaj($id, $fields_updated)
                {
                        if((!$this->getVal("step_name_ar")) or (!$this->getVal("step_name_en"))) 
                        {
                                $screenObj = $this->het("screen_model_id");
                                if($screenObj)
                                {
                                        $step_name_ar = $screenObj->getVal("screen_name_ar");
                                        $step_name_en = $screenObj->getVal("screen_name_en");
                                        $this->set("step_name_ar", $step_name_ar);
                                        $this->set("step_name_en", $step_name_en);                                        
                                }
                                
                        }

                        if(!$this->getVal("show_field_mfk"))
                        {
                                $screenObj = $this->het("screen_model_id");
                                if($screenObj)
                                {
                                        $application_field_mfk = $screenObj->getVal("application_field_mfk");
                                        
                                        $this->set("show_field_mfk", $application_field_mfk);
                                }
                                
                        }

                        return true;
                }

                public function shouldBeCalculatedField($attribute){
                        if($attribute=="application_field_mfk") return true;
                        return false;
                }

                public function getScenarioItemId($currstep)
                {
                      if($currstep == 1) return 479;
                      if($currstep == 2) return 482;

                      return 0;
                }

                public function beforeDelete($id,$id_replace) 
                {
                        $server_db_prefix = AfwSession::config("db_prefix","default_db_");
                        
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
                                                // adm.application-مسمى المرحلة الحالية	application_step_id  ManyToOne
                                                if(!$simul)
                                                {
                                                        // require_once "../adm/application.php";
                                                        Application::updateWhere(array('application_step_id'=>$id_replace), "application_step_id='$id'");
                                                        // $this->execQuery("update ${server_db_prefix}adm.application set application_step_id='$id_replace' where application_step_id='$id' ");
                                                }

                                                
                                        
                                        // MFK

                                }
                                else
                                {
                                                // FK on me 
                                        // adm.application-مسمى المرحلة الحالية	application_step_id  ManyToOne
                                                if(!$simul)
                                                {
                                                // require_once "../adm/application.php";
                                                Application::updateWhere(array('application_step_id'=>$id_replace), "application_step_id='$id'");
                                                // $this->execQuery("update ${server_db_prefix}adm.application set application_step_id='$id_replace' where application_step_id='$id' ");
                                                }

                                                
                                                // MFK

                                        
                                } 
                                return true;
                        }    
                }

                protected function userCanEditMeWithoutRole($auser)
                {
                        // @todo this temporary for demo of amjad
                        return [true, 'for demo'];
                }

                public function canBeDeletedWithoutRoleBy($auser)
                {
                        return [true, 'for demo'];
                }


                public function getStepCode()
                {
                       if(($this->getVal("step_code")))  return $this->getVal("step_code");

                       return "STEP-".$this->getVal("step_num");
                }


                public function isTheSortingStep()
                {
                        return ($this->getStepCode() == "SRT");
                }

                public function isTheDesireSelectStep()
                {
                        return ($this->getStepCode() == "DSR");
                }
                
                public static function getStepData($applicant_id, $application_plan_id, $step_num, $lang, $debugg=0, $application_plan_branch_id=0, $application_simulation_id=2, $application_model_id = 0) 
                {
                        if(!$application_model_id) $application_model_id = ApplicationPlan::getApplicationModelId($application_plan_id);
                        $stepFieldsArr = ApplicationModelField::stepFields($application_model_id, $step_num);
                        $applicantObj = null;
                        $applicationObj = null;
                        $desireObj = null;
                        foreach($stepFieldsArr as $scrIndex => $scrData)
                        {
                                $scrFields = $scrData["fields"];
                                unset($stepFieldsArr[$scrIndex]["fields"]);
                                foreach($scrFields as $afield_id => $scrField)
                                {
                                        $field_name = $scrField["field"];
                                        $field_code = $field_name;
                                        if($scrField["reel"]) 
                                        {
                                                $method = "getVal";
                                        }
                                        else
                                        {
                                              if($scrField["type"]=="list") $method = "getJsonArray";
                                              else $method = "calc";
                                        } 

                                        $suffix2 = "";
                                        $method2 = "";

                                        if($scrField["answer"]) 
                                        {
                                                $suffix2 = "answer";
                                                $method2 = "getAnswerTableJsonArray";
                                        }

                                        $context = "";
                                        $error_message = "";
                                        
                                        if($scrField["table"]=="applicant")
                                        {
                                                if(!$applicantObj) $applicantObj = Applicant::loadById($applicant_id);                                                
                                                if(!$applicantObj) $error_message = self::transMess("This applicant is not found", $lang);
                                                $context = "field $field_name Applicant::loadById($applicant_id)";
                                                $theObj =& $applicantObj;                                                                                                
                                                $atb_id = 1;
                                        }
                                        elseif($scrField["table"]=="application")
                                        {
                                                if(!$applicationObj) $applicationObj = Application::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id);                                                
                                                if(!$applicationObj) $error_message = self::transMess("This application is not found", $lang);
                                                $context = "field $field_name Application::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id)";
                                                $theObj =& $applicationObj;                                                                                                
                                                $atb_id = 3;
                                        }
                                        elseif($scrField["table"]=="adesire")
                                        {
                                                if(!$application_plan_branch_id) throw new AfwRuntimeException("application_plan_branch_id should be provided to get Data of a desire");
                                                if(!$desireObj) $desireObj = ApplicationDesire::loadByBigIndex($applicant_id, $application_plan_id, $application_simulation_id, $application_plan_branch_id);                                                
                                                if(!$desireObj) $error_message = self::transMess("This desire is not found", $lang);
                                                $context = "field $field_name ApplicationDesire::loadByBigIndex($applicant_id, $application_plan_id, $application_simulation_id, $application_plan_branch_id)";
                                                $theObj =& $desireObj;                                                                                                
                                                $atb_id = 2;
                                        }
                                        else
                                        {
                                                $error_message = $scrField["table"]." table unknown to define admission context";
                                        }
                                        if((!$theObj) or (!$theObj->id))
                                        {
                                                if(!$error_message) $error_message = "Failed to load applier object with context $context";
                                        }
                                        if($scrField["additional"])
                                        {
                                                $field_code = ApplicationField::fieldNameToCode($field_name, $atb_id);
                                                // $stepFieldsArr[$scrIndex]["code-of-$field_code"] = $field_name;                                                        
                                        } 
                                        if(($debugg==="all") or ($debugg===$field_code)) $stepFieldsArr[$scrIndex]["props-of-$field_code"] = $scrField; 
                                        if((!$theObj) or (!$theObj->id)) $my_field_value = $error_message;
                                        else $my_field_value = $theObj->$method($field_name);        
                                        $stepFieldsArr[$scrIndex][$field_code] = $my_field_value;         

                                        if($suffix2 and $method2 and $theObj and ($theObj->id>0))
                                        {
                                                $stepFieldsArr[$scrIndex][$field_code."_".$suffix2] = $theObj->$method2($field_name);   ;    
                                        }



                                }

                                if($applicationObj) 
                                {
                                        $stepFieldsArr[$scrIndex]["application_status"]["value"] = $applicationObj->getVal("application_status_enum");         
                                        $stepFieldsArr[$scrIndex]["application_status"]["description"] = $applicationObj->decode("application_status_enum", '', false, $lang);         
                                }

                        }

                        return [$application_model_id, $stepFieldsArr, $error_message];
                }
                
                public static function applyStepConditionsOn($object, $application_model_id, $application_plan_id, $step_num, $general, $lang, $simulate=true, $application_simulation_id=0, $logConditionExec=true, $audit_conditions_pass=[], $audit_conditions_fail=[],)
                {
                        
                        $err_arr = [];
                        $inf_arr = [];
                        $war_arr = [];
                        $tech_arr = [];

                        
                        $acondList = ApplicationModelCondition::loadStepNumConditions($application_model_id, $step_num, $general);
                        // die("ApplicationModelCondition::loadStepNumConditions($application_model_id, $step_num, $general) = ".var_export($acondList,true));
                        /**
                         *
                         * @var ApplicationModelCondition $aModelCondItem
                         * 
                         */
                        $success = true; // if one condition fail so all fail
                        $c = 0;
                        $f = 0;
                        foreach($acondList as $acondId => $aModelCondItem)
                        {
                                /**
                                 * @var Acondition $acondItem 
                                 */
                                $acondItem = $aModelCondItem->het("acondition_id");
                                if($acondItem)
                                {
                                        $acondItemId = $acondItem->id;
                                        $audit_pass = in_array($acondItemId, $audit_conditions_pass);
                                        $audit_fail = true; //in_array($acondItemId, $audit_conditions_fail); has no sens, always we need to know reason of fail

                                        $c++;
                                        list($exec_result, $comments, $tech) = $acondItem->applyOnObject($lang, $object, $application_plan_id, $application_model_id, $simulate, $application_simulation_id, $logConditionExec); 
                                        if($exec_result) 
                                        {
                                                if($audit_pass) $inf_arr[] = "($c) ".$comments;
                                                else $tech_arr[] = "($c) ".$comments;
                                        } 
                                        else 
                                        {
                                                $success = $exec_result;
                                                if($audit_fail) $war_arr[] = "($c) ".$comments;
                                                else $tech_arr[] = "($c) ".$comments;

                                                if($exec_result===false) break; // because if one condition fail so all fail no need to continue
                                                if($exec_result===null) break; // because if we can not apply one condition we can not continue until resolve the pb (data update, etc..)
                                                
                                        }
                                        if($tech)  $tech_arr[] = $tech;
                                }
                                else
                                {
                                        $err_arr[] = "model condition item has not valid condition : id=".$aModelCondItem->id;
                                }
                        }

                        if($success and (!$audit_pass))
                        {
                                $inf_arr[] = "$c "."conditions passed";
                        }
                        else
                        {
                                // die("xxxx");
                        }

                        
                        return ['success'=>$success, 'nb_conds'=>$c, 'res'=> AfwFormatHelper::pbm_result($err_arr,$inf_arr,$war_arr,"<br>\n",$tech_arr)];
                }
                /* replaced by generic applyStepConditionsOn above
                public function applyMyDesireConditionsOn($desireObject, $lang)
                {
                        $err_arr = [];
                        $inf_arr = [];
                        $war_arr = [];
                        $tech_arr = [];

                        $application_model_id = $desireObject->getVal("application_model_id");
                        $application_plan_id = $desireObject->getVal("application_plan_id");
                        $step_num = $desireObject->getVal("step_num");
                        $acondList = ApplicationModelCondition::loadStepNumConditions($application_model_id, $step_num, false);
                        /**
                         *
                         * @var ApplicationModelCondition $aModelCondItem
                         * 
                         *
                        $success = true; // if one condition fail so all fail
                        $c = 0;
                        foreach($acondList as $aModelCondItem)
                        {
                                /**
                                 * @var Acondition $acondItem 
                                 *
                                $acondItem = $aModelCondItem->het("acondition_id");
                                if($acondItem)
                                {
                                        $c++;
                                        list($exec_result, $comments, $tech) = $acondItem->applyOnObject($lang, $desireObject, $application_plan_id, $application_model_id, $simulate = false); 
                                        if($exec_result) 
                                        {
                                                $inf_arr[] = "($c) ".$comments;
                                        } 
                                        else 
                                        {
                                                $success = false;
                                                $war_arr[] = $comments;
                                        }
                                        if($tech)  $tech_arr[] = $tech;
                                }
                                else
                                {
                                        $err_arr[] = "model condition item has not valid condition : id=".$aModelCondItem->id;
                                }
                        }

                        
                        return ['success'=>$success, 'res'=> AfwFormatHelper::pbm_result($err_arr,$inf_arr,$war_arr,"<br>\n",$tech_arr)];
                }*/

        }
?>
