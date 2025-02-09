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
                        $applyResult = $currentStepObj->applyMyGeneralConditionsOn($this, $lang);
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
                
                $step_num = $this->getVal("step_num"); 
                if((!$step_num) or ($step_num=="0"))
                {                        
                        $objStep = $this->getApplicationPlan()->getApplicationModel()->getFirstDesireStep();
                        $this->set("step_num", $objStep->getVal("step_num"));
                        $this->set("application_step_id", $objStep->id);
                        $is_to_commit = true;     
                }

                $desire_status_enum = $this->getVal("desire_status_enum"); 
                if((!$desire_status_enum) or ($desire_status_enum=="0"))
                {                        
                        $this->set("desire_status_enum", 1);
                        $is_to_commit = true;     
                }

                if($is_to_commit) $this->commit();
                
        }

        

        public function beforeDelete($id,$id_replace)         
        {
            $server_db_prefix = AfwSession::config("db_prefix","uoh_");
            $objFirstStep = $this->getApplicationPlan()->getApplicationModel()->getFirstDesireStep();
            $first_step_num = $objFirstStep->getVal("step_num");
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
}
