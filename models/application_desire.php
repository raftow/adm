<?php
class ApplicationDesire extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "application_desire";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        /**
         * @var ApplicationPlan $objApplicationPlan
         */
        private $objApplicationPlan = null;

        /**
         * @var Application $applicationObj
         */
        private $applicationObj = null;

        public function __construct()
        {
                parent::__construct("application_desire", "id", "adm");
                AdmApplicationDesireAfwStructure::initInstance($this);
        }

        public function getApplicationPlan()
        {
            if (!$this->objApplicationPlan) $this->objApplicationPlan = $this->het("application_plan_id");
            return $this->objApplicationPlan;
        }


        public function getApplicationObject()
        {
            if (!$this->applicationObj) $this->applicationObj = $this->het("application_id");
            return $this->applicationObj;
        }


        public function moveColumn()
        {
                return "desire_num";
        }

        public function moveLimit($col)
        {
                return 1;
        }

        public static function loadById($id)
        {
                $obj = new ApplicationDesire();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public static function loadByMainIndex($applicant_id, $application_plan_id, $desire_num)
        {
                // should not be able to insert but the insert is to be done by loadByBigIndex as it have the full attribute values
                $create_obj_if_not_found = false;

                if (!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
                if (!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");
                if (!$desire_num) throw new AfwRuntimeException("loadByMainIndex : desire_num is mandatory field");


                $obj = new ApplicationDesire();
                $obj->select("applicant_id", $applicant_id);
                $obj->select("application_plan_id", $application_plan_id);
                $obj->select("desire_num", $desire_num);

                if ($obj->load()) {
                        if ($create_obj_if_not_found) $obj->activate();
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        $obj->set("applicant_id", $applicant_id);
                        $obj->set("application_plan_id", $application_plan_id);                        
                        $obj->set("desire_num", $desire_num);

                        $obj->insertNew();
                        if (!$obj->id) return null; // means beforeInsert rejected insert operation
                        $obj->is_new = true;
                        return $obj;
                } else return null;
        }


        public static function loadByBigIndex($applicant_id, $application_plan_id, $application_plan_branch_id, $create_obj_if_not_found, $applicationObj)
        {
                if (!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
                if (!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");
                if (!$application_plan_branch_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_branch_id is mandatory field");


                $obj = new ApplicationDesire();
                $obj->select("applicant_id", $applicant_id);
                $obj->select("application_plan_id", $application_plan_id);
                $obj->select("application_plan_branch_id", $application_plan_branch_id);

                if ($obj->load()) {
                        return $obj;
                } elseif ($create_obj_if_not_found and $applicationObj) {
                        $desire_num = $applicationObj->getRelation("applicationDesireList")->func("max(desire_num)")+1;
                        $obj->set("applicant_id", $applicant_id);
                        $obj->set("application_plan_id", $application_plan_id);
                        $obj->set("application_plan_branch_id", $application_plan_branch_id);
                        $obj->set("application_id", $applicationObj->id);
                        $obj->set("applicant_qualification_id", $applicationObj->getVal("applicant_qualification_id"));
                        $obj->set("qualification_id", $applicationObj->getVal("qualification_id"));
                        $obj->set("major_category_id", $applicationObj->getVal("major_category_id"));
                        $obj->set("desire_num", $desire_num);
                          
                        $obj->insertNew();
                        if (!$obj->id) return null; // means beforeInsert rejected insert operation
                        $obj->is_new = true;
                        return $obj;
                } else return null;
        }

        public function getFieldsMatrix($applicationDesireFieldsArr, $lang = "ar", $onlyIfTheyAreUpdated = false)
        {
                return Application::getObjectFieldsMatrix($this, $applicationDesireFieldsArr, $lang, $onlyIfTheyAreUpdated);
        }


        public function fieldsMatrixForStep($stepNum, $lang = "ar", $onlyIfTheyAreUpdated = false)
        {
                $this->getApplicationObject();
                if (!$this->applicationObj) throw new AfwRuntimeException("Can't retrieve fields matrix without any application defined");

                $objApplicationModel = $this->getApplicationPlan()->getApplicationModel();
                if (!$objApplicationModel) throw new AfwRuntimeException("Can't retrieve fields matrix without any Application Model defined");
                
                list($applicantFieldsArr, $applicationFieldsArr, $applicationDesireFieldsArr) = $objApplicationModel->getAppModelFieldsOfStep($stepNum, true);
                

                $fieldsMatrix_0 = $this->applicationObj->getApplicant()->getFieldsMatrix($applicantFieldsArr, $lang, $this->applicationObj, $onlyIfTheyAreUpdated);
                $fieldsMatrix_1 = $this->applicationObj->getFieldsMatrix($applicationFieldsArr, $stepNum, $lang, $onlyIfTheyAreUpdated);
                $fieldsMatrix_2 = $this->getFieldsMatrix($applicationDesireFieldsArr, $lang, $onlyIfTheyAreUpdated);

                if ($onlyIfTheyAreUpdated) return ($fieldsMatrix_0 and $fieldsMatrix_1 and $fieldsMatrix_2);

                $fieldsMatrix = array_merge($fieldsMatrix_0, $fieldsMatrix_1, $fieldsMatrix_2);

                return $fieldsMatrix;
        }

        public function gotoNextDesireStep($lang = "ar")
        {

                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];
                // $nb_updated = 0;
                // $nb_inserted = 0;
                try {

                        if (!$this->objApplicationPlan) $this->objApplicationPlan = $this->het("application_plan_id");
                        if (!$this->objApplicationPlan) return [$this->tm("Error happened, no application plan defined for this application", $lang), ""];
                        
                        /**
                         * @var ApplicationStep $currentStepObj
                         */
                        $currentStepObj = $this->het("application_step_id");
                        $currentStepNum = $this->getVal("step_num");

                        $dataReady = $this->fieldsMatrixForStep($currentStepNum, "ar", $onlyIfTheyAreUpdated = true);
                        if (!$dataReady) return [$this->tm("The data is not updated we can not apply conditions", $lang), ""];
                        $currentStepId = $this->getVal("application_step_id");
                        // die("before currentStepObj=$currentStepObj->id currentStepNum=$currentStepNum currentStepId=$currentStepId");
                        if (!$currentStepObj or !$currentStepObj->id) $currentStepObj = $this->objApplicationPlan->getApplicationModel()->getFirstStep();
                        if (!$currentStepObj) return [$this->tm("No current step defined for this application model, you may need to reorder the steps to have step num=0 or step num = 1", $lang), ""];

                        // to go to next step we should apply conditions of the current step
                        $applyResult = $this->applyMyCurrentStepConditions($lang, false);
                        $success = $applyResult['success'];

                        list($error_message, $success_message, $fail_message, $tech) = $applyResult['res'];
                        if ($success) {

                                $nextStepNum = $this->objApplicationModel->getNextGeneralStepNumOf($currentStepNum);
                                $tech_arr[] = "nextStepNum=$nextStepNum currentStepNum=$currentStepNum";
                                $this->set("step_num", $nextStepNum);
                                $this->commit();
                                if ($nextStepNum != $currentStepNum) {
                                        $this->requestAPIsOfStep($nextStepNum);
                                }
                                $inf_arr[]  = $this->tm("The move from step", $lang) . " : " . $currentStepObj->getDisplay($lang) . " " . $this->tm("has been successfully done", $lang);
                                $inf_arr[]  = $success_message;
                                $tech_arr[] = $tech;
                        } else {
                                $war_arr[]  = $this->tm("The move from step", $lang) . " : " . $currentStepObj->getDisplay($lang) . " " . $this->tm("has failed for the following reason", $lang) . " : ";
                                $war_arr[]  = $fail_message;
                                $tech_arr[] = $tech;
                        }
                } catch (Exception $e) {
                        $err_arr[] = $e->getMessage();
                } catch (Error $e) {
                        $err_arr[] = $e->__toString();
                }
                return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
        }

        public function getDisplay($lang = 'ar')
        {
                return $this->getDefaultDisplay($lang);
        }

        public function stepsAreOrdered()
        {
                return false;
        }

        public function repareData()
        {
                $is_to_commit = false;
                $lang = AfwLanguageHelper::getGlobalLanguage();
                $step_num = $this->getVal("step_num"); 
                if((!$step_num) or ($step_num=="0"))
                {                        
                        $objStep = $this->getApplicationPlan()->getApplicationModel()->getFirstDesireStep();
                        if($objStep)
                        {
                                $this->set("step_num", $objStep->getVal("step_num"));
                                $this->set("application_step_id", $objStep->id);
                                $is_to_commit = true;     
                        }
                        else
                        {
                                AfwSession::pushWarning($this->getDisplay($lang)." : ".$this->tm("All steps are general & There are no special steps to be the path of application desires", $lang));
                        }
                        
                }

                $desire_status_enum = $this->getVal("desire_status_enum"); 
                if((!$desire_status_enum) or ($desire_status_enum=="0"))
                {                        
                        $this->set("desire_status_enum", 1);
                        $is_to_commit = true;     
                }

                if($is_to_commit) $this->commit();
                
        }

        protected function getPublicMethods()
        {

                $pbms = array();


                $currentStepNum = $this->getVal("step_num");
                $nextStepNum = $currentStepNum + 1;
                $objApplicationModel = $this->getApplicationPlan()->getApplicationModel();
                //$objFirstStep = $objApplicationModel->getFirstDesireStep();
                if ($objApplicationModel) {
                        $asObj = ApplicationStep::loadByMainIndex($objApplicationModel->id, $nextStepNum);

                        $color = "green";
                        $title_ar = $asObj->tm("go to next step", 'ar') . " '" . $asObj->getDisplay("ar") . "'";
                        $title_en = $asObj->tm("go to next step", 'en') . " '" . $asObj->getDisplay("en") . "'";
                        $methodName = "gotoNextDesireStep";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                                "METHOD" => $methodName,
                                "COLOR" => $color,
                                "LABEL_AR" => $title_ar,
                                "LABEL_EN" => $title_en,
                                "PUBLIC" => true,
                                "BF-ID" => "",
                                'STEP' => '1'
                        );

                        $color = "blue";
                        $title_ar = $asObj->tm("Force updating data via electronic services", 'ar');
                        $title_en = $asObj->tm("Force updating data via electronic services", 'en');
                        $methodName = "runNeededApis";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                                "METHOD" => $methodName,
                                "COLOR" => $color,
                                "LABEL_AR" => $title_ar,
                                "LABEL_EN" => $title_en,
                                "PUBLIC" => true,
                                "BF-ID" => "",
                                'STEP' => '1'
                        );

                        $color = "gray";
                        $title_ar = $asObj->tm("Updating data via electronic services", 'ar');
                        $title_en = $asObj->tm("Updating data via electronic services", 'en');
                        $methodName = "runOnlyNeedUpdateApis";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                                "METHOD" => $methodName,
                                "COLOR" => $color,
                                "LABEL_AR" => $title_ar,
                                "LABEL_EN" => $title_en,
                                "PUBLIC" => true,
                                "BF-ID" => "",
                                'STEP' => '1'
                        );
                }
                else die("no ApplicationModel for this desire");

                return $pbms;
        }

        

        public function beforeDelete($id,$id_replace)         
        {
            $server_db_prefix = AfwSession::config("db_prefix","uoh_");
            $objFirstStep = $this->getApplicationPlan()->getApplicationModel()->getFirstDesireStep();
            $first_step_num = $objFirstStep ? $objFirstStep->getVal("step_num") : 9999;
            $desire_status_enum = $this->getVal("desire_status_enum");
            $step_num = $this->getVal("step_num");
            if (($step_num > $first_step_num) or ($desire_status_enum > 1)) {
                $this->deleteNotAllowedReason = "الرغبة أخذت طريقها في مسار التقديم يمكن فقط الغاء التقديم (الانسحاب) وليس حذفها بالكامل";
                return false;
            }

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


        public function calcWeighted_percentage_details($what = "value")
        {
                return $this->calcWeighted_percentage("details");
        }

        public function calcProgram_track_id($what = "value")
        {
                $program_track_id = 0;
                $branchObj = $this->het("application_plan_branch_id"); 
                if(!$branchObj) return $program_track_id;
                $programObj = $branchObj->het("program_id"); 
                if($programObj) 
                {
                        $program_track_id = $programObj->getVal("program_track_id");
                }
                
                return $program_track_id;
                
        }

        public function calcTrackAndMajorPath()
        {
                $applicantQualificationObj = $this->het("applicant_qualification_id");
                $major_path_id = 0;
                $program_track_id = $this->calcProgram_track_id(); 
                if ($applicantQualificationObj) {
                        $major_path_id = $applicantQualificationObj->getInfo("secondary_major_path");
                }

                return [$program_track_id, $major_path_id, $applicantQualificationObj];
        }

        public function calcWeighted_percentage($what = "value")
        {
                list($program_track_id, $major_path_id, $applicantQualificationObj) = $this->calcTrackAndMajorPath($what);
                if (!$applicantQualificationObj) return ($what == "value") ? -88 : "No applicant qualification object";
                if (!$this->applicantObj) $this->applicantObj = $this->het("applicant_id");
                if (!$this->applicantObj) return ($what == "value") ? -99 : "No applicant object";

                return $this->applicantObj->weighted_percentage($what, $program_track_id, $major_path_id, $applicantQualificationObj);
        }


        public function applyMyCurrentStepConditions($lang="ar", $pbm=true)
        {
                $objApplicationModel = $this->getApplicationPlan()->getApplicationModel();
                if (!$objApplicationModel)
                {
                        if($pbm) return ["Strange Error : no ApplicationModel object for this desire"];
                        else return [];  
                }
                $application_model_id = $objApplicationModel->id;
                $application_plan_id = $this->getVal("application_plan_id");
                $step_num = $this->getVal("step_num");
                $general="N";
                $return =  ApplicationStep::applyStepConditionsOn($this, $application_model_id, $application_plan_id, $step_num, $general, $lang);

                if($pbm) return $return["res"];
                else return $return;
        }
}
