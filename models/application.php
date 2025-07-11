<?php
class Application extends AdmObject
{
        /**
         * @var ApplicationModel $objApplicationModel
         */
        private $objApplicationModel = null;
        /**
         * @var Applicant $applicantObj
         */
        private $applicantObj = null;
        private $myApplicationDesireList = [];

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "application";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        private $attribIsApplic = [];
        private $nb_desires = null;

        public function __construct()
        {
                parent::__construct("application", "id", "adm");
                AdmApplicationAfwStructure::initInstance($this);
        }

        public function setApplicantObject(&$applicantObj)
        {
                $this->applicantObj = $applicantObj;
        }

        public function getApplicant()
        {
                if (!$this->applicantObj) $this->applicantObj = $this->het("applicant_id");
                return $this->applicantObj;
        }

        public function getApplicationModel()
        {
                if (!$this->objApplicationModel) $this->objApplicationModel = $this->het("application_model_id");
                return $this->objApplicationModel;
        }

        

        public static function loadById($id)
        {
                $obj = new Application();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        

        public function loadFinalAcceptanceDesire()
        {
                $applicant_id = $this->getVal("applicant_id");
                $application_plan_id = $this->getVal("application_plan_id");
                $application_simulation_id = $this->getVal("application_simulation_id");
                return ApplicationDesire::loadFinalAcceptanceDesire($applicant_id, $application_plan_id, $application_simulation_id);
        }

        public function loadInitialAcceptanceDesire()
        {
                $applicant_id = $this->getVal("applicant_id");
                $application_plan_id = $this->getVal("application_plan_id");
                $application_simulation_id = $this->getVal("application_simulation_id");
                return ApplicationDesire::loadInitialAcceptanceDesire($applicant_id, $application_plan_id, $application_simulation_id);
        }

        public function countSortedDesires()
        {
                $applicant_id = $this->getVal("applicant_id");
                if(!$applicant_id) return -1;
                $application_plan_id = $this->getVal("application_plan_id");
                $application_simulation_id = $this->getVal("application_simulation_id");
                return ApplicationDesire::countSortedDesires($applicant_id, $application_plan_id, $application_simulation_id);
        }

        public static function checkWeightedPercentageErrors($application_plan_id, $application_simulation_id, $pct, $what="value")
        {
                global $MODE_BATCH_LOURD;
                $old_MODE_BATCH_LOURD = $MODE_BATCH_LOURD;
                $MODE_BATCH_LOURD = true;


                $examples = "";
                $errors = 0;
                $obj = new Application();
                $obj->select("application_plan_id", $application_plan_id);
                $obj->select("application_simulation_id",$application_simulation_id);
                $obj->select("active", 'Y');
                $obj->where("applicant_id % 100 < $pct");

                $objList = $obj->loadMany();
                /**
                 * @var Application $objItem
                 */
                foreach($objList as $objItem)
                {
                        $wpCalculated = $objItem->calcWeighted_percentage(); 
                        $wpStored = $objItem->getVal("weighted_pctg");
                        $current_applicant_id = $objItem->getVal("applicant_id");
                        if(abs($wpCalculated-$wpStored)>=0.01) 
                        {
                                $errors++;
                                if(strlen($examples)<256) $examples .= "AD1-$current_applicant_id (Calculated=$wpCalculated-Stored=$wpStored)>";
                        }
                }

                $MODE_BATCH_LOURD = $old_MODE_BATCH_LOURD;
                AfwQueryAnalyzer::resetQueriesExecuted();


                if($what=="value") return $errors;
                else return $examples;
        }

        public static function recomputeWeightedPercentage($application_plan_id, $application_simulation_id, $indicators_update_date, $applicant_ids_arr=null, $updateDesires=false)
        {
                global $MODE_BATCH_LOURD;
                $old_MODE_BATCH_LOURD = $MODE_BATCH_LOURD;
                $MODE_BATCH_LOURD = true;

                $obj0 = new Application();
                $obj0->select("application_plan_id", $application_plan_id);
                $obj0->select("application_simulation_id",$application_simulation_id);
                $obj0->select("active", 'Y');
                if($applicant_ids_arr) $obj0->selectIn("applicant_id", $applicant_ids_arr);
                $total = $obj0->count();
                $obj1 = new Application();
                $obj1->select("application_plan_id", $application_plan_id);
                $obj1->select("application_simulation_id",$application_simulation_id);
                $obj1->select("active", 'Y');
                if($applicant_ids_arr) $obj1->selectIn("applicant_id", $applicant_ids_arr);
                $obj1->where("validated_at > '$indicators_update_date'");
                $total_done = $obj1->count();

                
                $obj = new Application();
                $obj->select("application_plan_id", $application_plan_id);
                $obj->select("application_simulation_id",$application_simulation_id);
                $obj->select("active", 'Y');
                if($applicant_ids_arr) $obj->selectIn("applicant_id", $applicant_ids_arr);
                $obj->where("validated_at is null or validated_at <= '$indicators_update_date'");
                
                $now_done = 0;
                
                $objList = $obj->loadMany(5000);
                $found = count($objList);
                $objListIds = array_keys($objList);
                
                foreach($objListIds as $objId)
                {
                        $objList[$objId]->storeWeightedPercentage(-1, $updateDesires);
                        // die("hasChanged after storeWeightedPercentage : ".$objList[$objId]->hasChanged()." : sql commit = ".$objList[$objId]->sqlCommit());
                        if($objList[$objId]->commit()) $now_done++;
                        // memory optimize
                        unset($objList[$objId]);
                }

                $MODE_BATCH_LOURD = $old_MODE_BATCH_LOURD;
                AfwQueryAnalyzer::resetQueriesExecuted();

                return [$total_done, $found, $total, $now_done];
        }

        /**
         * @return Application
         */


        public static function loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id, $idn='', $create_obj_if_not_found = false)
        {
                if(!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
                if(!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");
                if(!$application_simulation_id) throw new AfwRuntimeException("loadByMainIndex : application_simulation_id is mandatory field");

                $obj = new Application();
                $obj->select("applicant_id", $applicant_id);
                $obj->select("application_plan_id", $application_plan_id);
                $obj->select("application_simulation_id",$application_simulation_id);
                if ($obj->load()) {
                        if ($create_obj_if_not_found) 
                        {
                                $obj->set("idn", $idn);                                 
                                $obj->activate();
                        }
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        $obj->set("applicant_id", $applicant_id);
                        $obj->set("application_plan_id", $application_plan_id);
                        $obj->set("application_simulation_id",$application_simulation_id);
                        $obj->set("idn", $idn);                                 
                        $obj->insertNew();
                        if (!$obj->id) return null; // means beforeInsert rejected insert operation
                        $obj->is_new = true;
                        return $obj;
                } else return null;
        }


        public static function currentStepData($input_arr, $debugg=0)
        {
                $application_plan_id = $input_arr['plan_id'];
                $applicant_id = $input_arr['applicant_id'];
                $lang = $input_arr['lang'];
                $whereiam = $input_arr['whereiam'];
                
                $application_simulation_id = 2;
                $applicationObj = Application::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id);
                if($applicationObj)
                {
                        $step_num = $input_arr['step_num'] = $applicationObj->getVal("step_num");
                        list($status0, $error_message, $applicationData) = ApplicationPlan::getStepData($input_arr, $debugg, "currentStepData", $whereiam);
                }
                else
                {
                        $step_num = null;
                        $applicationData = null;
                        $error_message = self::transMess("This application is not found", $lang);
                }

                

                $data = [
                        "current_step" => $step_num,
                        "application" => $applicationData,
                        "application_id" => $applicationObj->id,
                ];

                $status = $error_message ? "error" : "success";
                return [$status, $error_message, $data]; 

        }

        

        public function getNeededAttributes()
        {
                
                $this->getApplicationModel();
                if ($this->objApplicationModel) {
                        return $this->objApplicationModel->getNeededAttributes($this->getVal("step_num"));                            
                }
                else return [];
        }

        public function getMandatoryNeededAttributes()
        {
                
                $this->getApplicationModel();
                if ($this->objApplicationModel) {
                        return $this->objApplicationModel->getMandatoryNeededAttributes($this->getVal("step_num"));                            
                }
                else return [];
        }

        public function saveNeededAttributes($input_arr, $commit = true)
        {
                $ok = true;
                $not_ok_reason = "";
                $saved = [];
                $needed = $this->getNeededAttributes();
                $mandatoryNeeded = $this->getMandatoryNeededAttributes();
                foreach($needed as $field_name)
                {
                        if(isset($input_arr[$field_name]))
                        {
                                $this->set($field_name, $input_arr[$field_name]);
                                $saved[$field_name] = $input_arr[$field_name];
                        }
                        elseif($mandatoryNeeded[$field_name] and (!$this->getVal($field_name)))
                        {
                                $ok = false;
                                $not_ok_reason = "$field_name is missed";
                        }
                }
                

                if($commit) $this->commit();
                

                return [$input_arr, $saved, "saveNeededAttributes : ".$this->getTechnicalNotes(), $ok, $not_ok_reason];
        }


        public static function acceptOfferWithUpgradeRequest($input_arr, $debugg=0, $dataShouldBeUpdated = true, $forceRunApis=true)
        {
                $application_simulation_id = $input_arr['simulation_id'];
                $application_plan_id = $input_arr['plan_id'];
                $applicant_id = $input_arr['applicant_id'];
                $lang = $input_arr['lang'];
                // $whereiam = $input_arr['whereiam'];
                if(!$application_simulation_id) $application_simulation_id = AfwSession::config("default-simulation-id",3);

                $applicationObj = Application::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id);
                $decide_offer_infos = null;
                $decide_offer_wars = null;
                if($applicationObj)
                {
                        list($error_message, $decide_offer_infos, $decide_offer_wars, $assignedDesire) = $applicationObj->decideAcceptOfferWithUpgradeRequest($lang);                        

                }
                else
                {
                        $decide_offer_status = null;
                        $assignedDesire = null;
                        $error_message = self::transMess("This application is not found", $lang);
                }

                

                $data = [
                        "decide_offer_infos" => $decide_offer_infos,
                        "decide_offer_wars" => $decide_offer_wars,
                        "assigned_desire" => $assignedDesire ? $assignedDesire->getJsonMe() : null,
                        

                ];

                $status = $error_message ? "error" : "success";
                return [$status, $error_message, $data]; 
        }

        public static function acceptOffer($input_arr, $debugg=0, $dataShouldBeUpdated = true, $forceRunApis=true)
        {
                $application_simulation_id = $input_arr['simulation_id'];
                $application_plan_id = $input_arr['plan_id'];
                $applicant_id = $input_arr['applicant_id'];
                $lang = $input_arr['lang'];
                // $whereiam = $input_arr['whereiam'];
                if(!$application_simulation_id) $application_simulation_id = AfwSession::config("default-simulation-id",3);

                $applicationObj = Application::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id);
                $decide_offer_infos = null;
                $decide_offer_wars = null;
                if($applicationObj)
                {
                        list($error_message, $decide_offer_infos, $decide_offer_wars, $assignedDesire) = $applicationObj->decideAcceptOffer($lang);                        

                }
                else
                {
                        $decide_offer_status = null;
                        $assignedDesire = null;
                        $error_message = self::transMess("This application is not found", $lang);
                }

                

                $data = [
                        "decide_offer_infos" => $decide_offer_infos,
                        "decide_offer_wars" => $decide_offer_wars,
                        "assigned_desire" => $assignedDesire ? $assignedDesire->getJsonMe() : null,
                        

                ];

                $status = $error_message ? "error" : "success";
                return [$status, $error_message, $data]; 
        }

        

        public static function rejectOffer($input_arr, $debugg=0, $dataShouldBeUpdated = true, $forceRunApis=true)
        {
                $application_simulation_id = $input_arr['simulation_id'];
                $application_plan_id = $input_arr['plan_id'];
                $applicant_id = $input_arr['applicant_id'];
                $lang = $input_arr['lang'];
                // $whereiam = $input_arr['whereiam'];
                if(!$application_simulation_id) $application_simulation_id = AfwSession::config("default-simulation-id",3);

                $applicationObj = Application::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id);
                $decide_offer_infos = null;
                $decide_offer_wars = null;
                if($applicationObj)
                {
                        list($error_message, $decide_offer_infos, $decide_offer_wars, $assignedDesire) = $applicationObj->decideRejectOffer($lang);                        

                }
                else
                {
                        $decide_offer_status = null;
                        $assignedDesire = null;
                        $error_message = self::transMess("This application is not found", $lang);
                }

                

                $data = [
                        "decide_offer_infos" => $decide_offer_infos,
                        "decide_offer_wars" => $decide_offer_wars,
                        "assigned_desire" => $assignedDesire ? $assignedDesire->getJsonMe() : null,
                        

                ];

                $status = $error_message ? "error" : "success";
                return [$status, $error_message, $data]; 
        }

        public static function disclaim($input_arr, $debugg=0, $dataShouldBeUpdated = true, $forceRunApis=true)
        {
                $application_simulation_id = $input_arr['simulation_id'];
                $application_plan_id = $input_arr['plan_id'];
                $applicant_id = $input_arr['applicant_id'];
                $lang = $input_arr['lang'];
                // $whereiam = $input_arr['whereiam'];
                if(!$application_simulation_id)
                {
                        $application_simulation_id = AfwSession::config("default-simulation-id",2);
                } 

                $applicationObj = Application::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id);
                $disclaim_infos = null;
                $disclaim_wars = null;
                if($applicationObj)
                {
                        list($error_message, $disclaim_infos, $disclaim_wars, $assignedDesire) = $applicationObj->disclaimoffer($lang);                        

                }
                else
                {
                        // $disclaim_status = null;
                        $assignedDesire = null;
                        $error_message = self::transMess("This application is not found", $lang);
                }

                

                $data = [
                        "disclaim_infos" => $disclaim_infos,
                        "disclaim_wars" => $disclaim_wars,
                        "assigned_desire" => $assignedDesire ? $assignedDesire->getJsonMe() : null,
                        

                ];

                $status = $error_message ? "error" : "success";
                return [$status, $error_message, $data]; 
        }

        public static function nextApplicationStep($input_arr, $debugg=0, $dataShouldBeUpdated = true, $forceRunApis=true)
        {
                $application_simulation_id = $input_arr['simulation_id'];
                $application_plan_id = $input_arr['plan_id'];
                $applicant_id = $input_arr['applicant_id'];
                $lang = $input_arr['lang'];
                $whereiam = $input_arr['whereiam'];
                if(!$application_simulation_id) $application_simulation_id = AfwSession::config("default-simulation-id",2);
                $move_step_details = null;
                $move_step_details_2 = null;

                $applicationObj = Application::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id);
                $apis_err = ""; 
                $apis_inf = "";
                $apis_war = "";
                $notes = "";
                $saved = [];
                $received = [];
                if($applicationObj)
                {
                        $step_num = $input_arr['step_num'] = $applicationObj->getVal("step_num");
                        
                        if($dataShouldBeUpdated)
                        {
                                $dataReady = $applicationObj->fieldsMatrixForStep($step_num, "ar", $onlyIfTheyAreUpdated = true, true, true);
                                if(!$dataReady) list($apis_err, $apis_inf, $apis_war) = $applicationObj->runNeededApis($lang = "ar", $forceRunApis);
                                else 
                                {
                                        $apis_err = ""; 
                                        $apis_inf = "";
                                        $apis_war = "data up to date";
                                }
                        }
                        else
                        {
                                $apis_err = ""; 
                                $apis_inf = "";
                                $apis_war = "case of data does not need update";
                        }

                        list($received, $saved, $notes, $ok, $not_ok_reason) = $applicationObj->saveNeededAttributes($input_arr);
                        if($ok)
                        {
                                // list($status0, $error_message0, $applicationData0) = ApplicationPlan::getStepData($input_arr, $debugg);
                                list($error_message,$inf,$war,$tech, $result) = $applicationObj->gotoNextStep($lang, $dataShouldBeUpdated, false, 2, false);
                                
                                
                                
                                $move_step_status = $result["result"];
                                $move_step_message = $result["message"];
                                $move_step_details = $result["details"];
                                $move_step_details_2 = $result["details_2"];
                                if(!$error_message)
                                {
                                        $step_num = $input_arr['step_num'] = $applicationObj->getVal("step_num");
                                        list($status0, $error_message, $applicationData) = ApplicationPlan::getStepData($input_arr, $debugg,"nextApplicationStep", $whereiam);
                                }
                                else
                                {
                                        $applicationData = null;
                                }
                        }
                        else
                        {
                                $move_step_status = "fail";
                                $move_step_message = $not_ok_reason;
                                $move_step_details = "";
                                $move_step_details_2 = "";
                                $applicationData = null;
                        }
                        
                        
                }
                else
                {
                        $move_step_message = null;
                        $move_step_status = null;
                        $step_num = null;
                        $applicationData = null;
                        $error_message = self::transMess("This application is not found", $lang);
                }

                

                $data = [
                        "move_step_status" => $move_step_status,
                        "move_step_message" => $move_step_message,
                        "move_step_details" => $move_step_details,
                        "move_step_details_2" => $move_step_details_2,
                        "current_step" => $step_num,
                        "got" => $received,
                        "saved" => $saved, 
                        "notes" => $notes,                       
                        "application" => $applicationData,
                        "apis-run"=> ['errors'=>$apis_err, 
                                      'info'=>$apis_inf, 
                                      'warnings'=>$apis_war],

                ];

                $status = $error_message ? "error" : "success";
                return [$status, $error_message, $data]; 

        }


        

        public function getDisplay($lang = "ar")
        {

                $data = array();
                $link = array();
                list($data[0], $link[0]) = $this->displayAttribute("applicant_id", false, $lang);
                $data[1] = $this->translateOperator("on",$lang);
                list($data[2], $link[2]) = $this->displayAttribute("application_simulation_id", false, $lang);
                // $this->singleTranslation($lang)." ".
                
                //list($data[3], $link[3]) = $this->displayAttribute("application_plan_id", false, $lang);

                // die("AQ::getDisplay = ".var_export($data,true));
                $return = implode(" ", $data);

                // die("return=$return AQ::getDisplay = ".var_export($data,true));

                return $return;
        }

        public function getShortDisplay($lang = "ar")
        {

                $data = array();
                $link = array();
                list($data[0], $link[0]) = $this->displayAttribute("applicant_id", false, $lang);

                $return = implode(" ", $data);

                return $return;
        }

        

        public function stepsAreOrdered()
        {
                return false;
        }

        protected function afterSetAttribute($attribute)
        {
                if ($attribute == "step_num") {
                        $this->attribIsApplic = [];
                }
        }

        public function storeWeightedPercentage($min_weighted_pctg=-1, $updateDesires=false)
        {
                $wp = $this->calcWeighted_percentage();
                if(!$wp) $wp = 0.0;
                if($wp<$min_weighted_pctg)
                {
                        /**
                         * @var Applicant $applicantObj
                         */
                        $applicantObj = $this->het("applicant_id");
                        $api_runner_class = self::loadApiRunner();
                        $wp_apis = $api_runner_class::weighted_perecentage_apis();
                        // create register apis call requests to be done by applicant-api-request-job                        
                        foreach ($wp_apis as $wp_api) {
                                $aepObj = ApiEndpoint::loadByMainIndex($wp_api);
                                if (!$aepObj) throw new AfwRuntimeException("the register API $wp_api is not found in DB");                                
                                ApplicantApiRequest::loadByMainIndex($applicantObj->id, $aepObj->id, true);
                        }

                        $applicantObj->runNeededApis("ar", true, false, $stopMethod="readyWeighted_percentage");
                        $wp = $this->calcWeighted_percentage();
                        if(!$wp) $wp = 0.0;
                }
                
                $now = date("Y-m-d H:i:s");
                
                $this->set("weighted_pctg", $wp);
                $this->set("validated_at", $now);
                $application_plan_id = $this->getVal("application_plan_id");
                $application_simulation_id = $this->getVal("application_simulation_id");
                if($updateDesires)
                {
                        ApplicationDesire::refreshWeightedPctgForAllApplicantDesires($this->getVal("applicant_id"), $application_plan_id, $application_simulation_id, $wp);                
                }
        }


        public function beforeMaj($id, $fields_updated)
        {
                try
                {
                        if(!$this->getVal("weighted_pctg"))
                        {
                                $this->setForce("weighted_pctg", 0, true);
                        }
                        $objApplicant = null;
                        $objApplicantQual = null;
                        $objApplicationPlan = null;
                        $application_model_id = $this->getVal("application_model_id");
                        if (!$application_model_id) {
                                $objApplicationPlan = $this->het("application_plan_id");
                                if ($objApplicationPlan) {
                                        $this->set("application_model_id", $objApplicationPlan->getVal("application_model_id"));
                                        $fields_updated["application_model_id"] = "@WasEmpty";
                                }
                        }

                        if (!$this->getVal("idn")) {
                                if(!$objApplicant) $objApplicant = $this->het("applicant_id");
                                if ($objApplicant) {
                                        $this->set("idn", $objApplicant->getVal("idn"));
                                        $fields_updated["idn"] = "@WasEmpty";
                                }
                        }

                        if (!$this->getVal("applicant_qualification_id")) {
                                $this->getApplicant();
                                if ($this->applicantObj) {
                                        $objApplicantQual = $this->applicantObj->getLastQualification();
                                        if ($objApplicantQual) {
                                                $this->set("applicant_qualification_id", $objApplicantQual->id);
                                                $fields_updated["applicant_qualification_id"] = "@WasEmpty";
                                        }
                                }
                        }

                        if (!$this->getVal("step_num")) {
                                $fields_updated["step_num"] = "@WasEmpty";
                                $this->set("step_num", 1);
                        }


                        if ($fields_updated["applicant_qualification_id"] and $this->getVal("applicant_qualification_id")) {

                                if (!$objApplicantQual) $objApplicantQual = $this->het("applicant_qualification_id");
                                if ($objApplicantQual) {
                                        $this->set("qualification_id",  $objApplicantQual->getVal("qualification_id"));
                                        $this->set("major_category_id", $objApplicantQual->getVal("major_category_id"));
                                        // reset step to 1 when applicant_qualification_id change
                                        $fields_updated["step_num"] = $this->getVal("step_num") ? $this->getVal("step_num") : "@WasEmpty";
                                        $this->set("step_num", 1);
                                }
                        }

                        if ($fields_updated["step_num"]) $this->requestAPIsOfStep($this->getVal("step_num"));

                        // if(!$objApplicationPlan) $objApplicationPlan = $this->het("application_plan_id");

                        if ($fields_updated["step_num"] or (!$this->getVal("application_step_id"))) {
                                $this->getApplicationModel();
                                if ($this->objApplicationModel) {
                                        $setted_step_num = $this->getVal("step_num");
                                        if(!$setted_step_num) $setted_step_num = 1;
                                        $appStepObj = $this->objApplicationModel->convertStepNumToObject($setted_step_num);
                                        $step_invalid_reason = "";
                                        if(!$appStepObj) $step_invalid_reason = "step $setted_step_num not found";
                                        if(!$appStepObj->sureIs("general")) $step_invalid_reason = "step $setted_step_num is not general";
                                        if($step_invalid_reason)
                                        {
                                                throw new AfwRuntimeException("Error setting application step num to value $setted_step_num : $step_invalid_reason");
                                                /*
                                                $this->set("step_num", 1);
                                                $appStepObj = $this->objApplicationModel->convertStepNumToObject(1);
                                                if ($appStepObj) {
                                                        $application_step_id = $appStepObj->id;
                                                        $this->set("application_step_id", $application_step_id);                                                
                                                        $this->set("comments", "invalid step by beforeMaj : $setted_step_num reason $step_invalid_reason");
                                                        $fields_updated["application_step_id"] = $this->getVal("application_step_id") ? $this->getVal("application_step_id") : "@WasEmpty";
                                                }
                                                else
                                                {
                                                        $this->set("application_step_id", 0);                                                
                                                        $this->set("comments", "step 1 not found");
                                                }*/                                                
                                        }
                                        else
                                        {
                                                $application_step_id = $appStepObj->id;
                                                if($application_step_id != $this->getVal("application_step_id"))
                                                {
                                                        $fields_updated["application_step_id"] = $this->getVal("application_step_id") ? $this->getVal("application_step_id") : "@empty";
                                                        $this->set("application_step_id", $application_step_id);
                                                }

                                                if($setted_step_num != $this->getVal("step_num"))
                                                {
                                                        $fields_updated["step_num"] = $this->getVal("step_num") ? $this->getVal("step_num") : "@empty";
                                                        $this->set("step_num", $setted_step_num);
                                                }
                                                
                                        }
                                } else {
                                        AfwSession::pushError($this->getDisplay("en") . " : Application Model Not Found : " . $this->getVal("application_model_id"));
                                }
                        }

                        if ($fields_updated["application_step_id"])
                        {
                                $dsrStepObj = ApplicationStep::loadDesiresSelectionStep($application_model_id); 
                                if($dsrStepObj->id == $this->getVal("application_step_id"))
                                {
                                        $this->storeWeightedPercentage(50.0);
                                }
                        }
                }
                catch(Exception $e)
                {
                        $this->setTechnicalNotes($e->getMessage());
                        return false;
                }
                
                return true;
        }

        public static function getApplicationAdditionalFieldParams($field_name)
        {
                global $application_additional_fields;
                if (!$application_additional_fields) {
                        $main_company = AfwSession::config("main_company", "all");
                        $file_dir_name = dirname(__FILE__);
                        require_once($file_dir_name . "/../../client-$main_company/extra/application_additional_fields-$main_company.php");
                }

                $return = $application_additional_fields[$field_name];

                //if(!$return) die("no params for getAdditionalFieldParams($field_name) look additional_fields[$field_name] in additional_fields=".var_export($additional_fields,true));

                return $return;
        }

        public function additional($field_name, $col_struct)
        {
                $params = self::getApplicationAdditionalFieldParams($field_name);

                $col_struct = strtolower($col_struct);
                if ($col_struct == "obsolete") return (!$params["type"]);
                if ($col_struct == "show") return ($params["type"] != "");
                if ($col_struct == "edit") return ($params["type"] != "");
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


                //if($col_struct=="type" and $return != "INT") throw new AfwRuntimeException("debugg additional field $field_name col_struct=$col_struct return = $return params=".var_export($params,true));
                //if(!$return) die("no param for additional($field_name, $col_struct) params=".var_export($params,true));

                return $return;
        }

        public function getFormuleResult($attribute, $what = "value")
        {
                if (AfwStringHelper::stringStartsWith($attribute, "attribute_")) {
                        $params = self::getApplicationAdditionalFieldParams($attribute);
                        $formulaMethod = $params["formula"];
                        if ($formulaMethod) {
                                $main_company = AfwSession::config("main_company", "all");
                                $classFM = AfwStringHelper::firstCharUpper($main_company) . "ApplicationFormulaManager";
                                if (!class_exists($classFM)) {
                                        $file_dir_name = dirname(__FILE__);
                                        require_once($file_dir_name . "/../../client-$main_company/extra/application_additional_fields-$main_company.php");
                                }
                                return $classFM::$formulaMethod($this, $what);
                        }
                }
                return AfwFormulaHelper::calculateFormulaResult($this, $attribute, $what);
        }

        protected function paggableAttribute($attribute, $structure)
        {
                if (AfwStringHelper::stringStartsWith($attribute, "attribute_")) {
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
                if ($currstep == 1) return 477;
                if ($currstep == 2) return 478;
                if ($currstep == 3) return 483;
                if ($currstep == 4) return 485;

                return 0;
        }

        


        public function uncompleteApplication($lang="ar")
        {
                $this->set("application_status_enum", self::application_status_enum_by_code('pending'));
                $this->commit();

                return ["", $this->tm("done",$lang ), ""];
        }

        public function resetApplication($lang="ar")
        {
                $id = $this->id;
                $applicant_id = $this->getVal("applicant_id");
                

                $objDes = new ApplicationDesire();
                $objDes->where("applicant_id = '$applicant_id' and application_id = '$id' and active='Y' and desire_status_enum in (2,3)");
                $nbRecordsCritical = $objDes->count();

                
                if(!$nbRecordsCritical)
                {
                        $objDes->deleteWhere("applicant_id = '$id' and application_id = '$id'");
                        $this->set("application_plan_branch_mfk", ",");
                        $this->forceGotoFirstStep($lang);                        
                        return ["", $this->tm("The application has been reset",$lang )];
                }
                else
                {
                        return [$this->tm("The applicant has some accepted desires and can't be deleted",$lang ), ""];
                }


                

                
        }



        public function decideAcceptOffer($lang="ar")
        {
                // [1] = "تأكيد القبول" - "Admission accepted"
                return $this->decideForOffer($lang, 1);
        }

        public function decideAcceptOfferWithUpgradeRequest($lang="ar")
        {
                // [2] = "تأكيد القبول مع طلب ترقية" - "Admission accepted with Upgrade Request"
                return $this->decideForOffer($lang, 2);
        }

        public function decideRejectOffer($lang="ar")
        {
                // [3] = "رفض القبول" - "Admission rejected"
                return $this->decideForOffer($lang, 3);
        }

        public function disclaimOffer($lang="ar", $commit = true)
        {
                $curr_status = $this->getVal("application_status_enum");
                if($curr_status != self::application_status_enum_by_code('accepted'))
                {
                        $curr_status_phrase = ", current status = [$curr_status] != (".self::application_status_enum_by_code('accepted').")";
                        return ["This application is not in final acceptance".$curr_status_phrase, ""];
                }

                $desireObj = $this->loadFinalAcceptanceDesire();
                if(!$desireObj) return ["no final acceptance desire found", ""];


                $desireObj->set("desire_status_enum", self::desire_status_enum_by_code('disclaimer'));
                $this->set("application_status_enum", self::application_status_enum_by_code('withdrawn'));

                $desireObj->commit();
                if($commit) $this->commit();
                return ["", "done", "", $desireObj];
        }

        public function decideForOffer($lang="ar", $new_applicant_decision_enum=null, $commit = true)
        {
                $curr_status = $this->getVal("application_status_enum");
                $curr_status_code = self::application_status_code($curr_status);
                if($curr_status == self::application_status_enum_by_code('accepted'))
                {
                        return ["This application is already in final acceptance", ""];
                }

                if($curr_status != self::application_status_enum_by_code('complete')) return ["application status ".$curr_status."/".$curr_status_code." is not allowed to switch to final acceptance"];

                $desireObj = $this->loadInitialAcceptanceDesire();
                if(!$desireObj) return ["no initial acceptance desire found", ""];
                if(($new_applicant_decision_enum==1) or ($new_applicant_decision_enum==2))
                {
                        $applicantObj = $this->het("applicant_id");
                        list($err, $inf, $war, $tech, $result) = $applicantObj->verifyEnrollment($lang);
                        if($result["universities"]>0)
                        {
                                $universities_names = implode("\n<br>", $result["universities_arr"][$lang]);
                                return [$this->tm("applicant is already enrolled in the following universities",$lang)." : ".$universities_names, "", ""]; 
                        }
                }

                $this->set("applicant_decision_enum", $new_applicant_decision_enum);
                $desireObj->set("applicant_decision_enum", $new_applicant_decision_enum);
                
                if(($new_applicant_decision_enum==1) or ($new_applicant_decision_enum==2))
                {
                        $desireObj->set("desire_status_enum", self::desire_status_enum_by_code('final-acceptance'));
                        $this->set("application_status_enum", self::application_status_enum_by_code('accepted'));
                }
                else
                {
                        $desireObj->set("desire_status_enum", self::desire_status_enum_by_code('rejected-acceptance'));
                        $this->set("application_status_enum", self::application_status_enum_by_code('withdrawn'));
                }
                $desireObj->commit();
                if($commit) $this->commit();
                return ["", "done", "", $desireObj];
        }

        protected function getPublicMethods()
        {

                $pbms = array();
                
                if($this->calcNb_desires()==0)
                {
                        $color = "green";
                        $title_ar = $this->tm("simulate desires from offline data", 'ar');
                        $title_en = $this->tm("simulate desires from offline data", 'en');
                        $methodName = "simulateDesiresFromOfflineData";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                                "METHOD" => $methodName,
                                "COLOR" => $color,
                                "LABEL_AR" => $title_ar,
                                "LABEL_EN" => $title_en,
                                "ADMIN-ONLY" => true,
                                "BF-ID" => "",
                                'STEP' => $this->stepOfAttribute("application_plan_branch_mfk")
                        );
                }
                

                $currentStepNum = $this->getVal("step_num");
                $nextStepNum = $currentStepNum + 1;
                $this->getApplicationModel();
                if ($this->objApplicationModel) {
                        
                        
                        $initialAcceptanceDesire = $this->loadInitialAcceptanceDesire();
                        if($initialAcceptanceDesire)
                        {
                                $color = "red";
                                $title_en = "reject admission";
                                $title_ar = $this->tm($title_en, 'ar');                                
                                $methodName = "decideRejectOffer";
                                $methodConfirmationWarningEn = "I refuse the nomination for admission and am not entitled to reclaim the seat";
                                $methodConfirmationWarning = $this->tm($methodConfirmationWarningEn, "ar");
                                $methodConfirmationQuestionEn = "Are you sure you want to do this action ?";
                                $methodConfirmationQuestion = $this->tm($methodConfirmationQuestionEn, "ar");
                                $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                                        "METHOD" => $methodName,
                                        "COLOR" => $color,
                                        "LABEL_AR" => $title_ar,
                                        "LABEL_EN" => $title_en,
                                        "ADMIN-ONLY" => true,
                                        'CONFIRMATION_NEEDED' => true,
                                        'CONFIRMATION_WARNING' => array('ar' => $methodConfirmationWarning, 'en' => $methodConfirmationWarningEn),
                                        'CONFIRMATION_QUESTION' => array('ar' => $methodConfirmationQuestion, 'en' => $methodConfirmationQuestionEn),
                                        "BF-ID" => "",
                                        'STEP' => $this->stepOfAttribute("applicant_decision_enum")
                                );  


                                


                                $color = "green";
                                $title_en = "accept admission";
                                $title_ar = $this->tm($title_en, 'ar');                                
                                $methodName = "decideAcceptOffer";
                                $methodConfirmationWarningEn = "This means that the applicant confirms his acceptance at the university without seeking any alternative options";
                                $methodConfirmationWarning = $this->tm($methodConfirmationWarningEn, "ar");
                                $methodConfirmationQuestionEn = "Are you sure you want to do this action ?";
                                $methodConfirmationQuestion = $this->tm($methodConfirmationQuestionEn, "ar");
                                $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                                        "METHOD" => $methodName,
                                        "COLOR" => $color,
                                        "LABEL_AR" => $title_ar,
                                        "LABEL_EN" => $title_en,
                                        "ADMIN-ONLY" => true,
                                        'CONFIRMATION_NEEDED' => true,
                                        'CONFIRMATION_WARNING' => array('ar' => $methodConfirmationWarning, 'en' => $methodConfirmationWarningEn),
                                        'CONFIRMATION_QUESTION' => array('ar' => $methodConfirmationQuestion, 'en' => $methodConfirmationQuestionEn),
                                        "BF-ID" => "",
                                        'STEP' => $this->stepOfAttribute("applicant_decision_enum")
                                ); 


                                $color = "blue";
                                $title_en = "accept admission with a request for promotion";
                                $title_ar = $this->tm($title_en, 'ar');                                
                                $methodName = "decideAcceptOfferWithUpgradeRequest";
                                $methodConfirmationWarningEn = "This means that the applicant's first choice was not fulfilled, and he was offered a lower option. He wishes to confirm his acceptance along with a request for promotion";
                                $methodConfirmationWarning = $this->tm($methodConfirmationWarningEn, "ar");
                                $methodConfirmationQuestionEn = "Are you sure you want to do this action ?";
                                $methodConfirmationQuestion = $this->tm($methodConfirmationQuestionEn, "ar");
                                $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                                        "METHOD" => $methodName,
                                        "COLOR" => $color,
                                        "LABEL_AR" => $title_ar,
                                        "LABEL_EN" => $title_en,
                                        "ADMIN-ONLY" => true,
                                        'CONFIRMATION_NEEDED' => true,
                                        'CONFIRMATION_WARNING' => array('ar' => $methodConfirmationWarning, 'en' => $methodConfirmationWarningEn),
                                        'CONFIRMATION_QUESTION' => array('ar' => $methodConfirmationQuestion, 'en' => $methodConfirmationQuestionEn),
                                        "BF-ID" => "",
                                        'STEP' => $this->stepOfAttribute("applicant_decision_enum")
                                ); 
                        }
                        else
                        {
                                $finalAcceptanceDesire = $this->loadFinalAcceptanceDesire();
                                if($finalAcceptanceDesire)
                                {
                                        $color = "red";
                                        $title_en = "disclaim";
                                        $title_ar = $this->tm($title_en, 'ar');                                
                                        $methodName = "disclaimOffer";
                                        $methodConfirmationWarningEn = "I refuse the nomination for admission and am not entitled to reclaim the seat";
                                        $methodConfirmationWarning = $this->tm($methodConfirmationWarningEn, "ar");
                                        $methodConfirmationQuestionEn = "Are you sure you want to do this action ?";
                                        $methodConfirmationQuestion = $this->tm($methodConfirmationQuestionEn, "ar");
                                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                                                "METHOD" => $methodName,
                                                "COLOR" => $color,
                                                "LABEL_AR" => $title_ar,
                                                "LABEL_EN" => $title_en,
                                                "ADMIN-ONLY" => true,
                                                'CONFIRMATION_NEEDED' => true,
                                                'CONFIRMATION_WARNING' => array('ar' => $methodConfirmationWarning, 'en' => $methodConfirmationWarningEn),
                                                'CONFIRMATION_QUESTION' => array('ar' => $methodConfirmationQuestion, 'en' => $methodConfirmationQuestionEn),
                                                "BF-ID" => "",
                                                'STEP' => $this->stepOfAttribute("applicant_decision_enum")
                                        );
                                }
                                
                        }


                        $color = "orange";
                        $title_ar = $this->tm("refresh Desire List", 'ar');
                        $title_en = $this->tm("refresh Desire List", 'en');
                        $methodName = "refreshDesireList";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                                "METHOD" => $methodName,
                                "COLOR" => $color,
                                "LABEL_AR" => $title_ar,
                                "LABEL_EN" => $title_en,
                                "ADMIN-ONLY" => true,
                                "BF-ID" => "",
                                'STEP' => $this->stepOfAttribute("applicationDesireList")
                        );

                        if($currentStepNum>1)
                        {
                                $color = "red";
                                $title_ar = $this->tm("reset Application", 'ar');
                                $title_en = $this->tm("reset Application", 'en');
                                $methodName = "resetApplication";
                                $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                                        "METHOD" => $methodName,
                                        "COLOR" => $color,
                                        "LABEL_AR" => $title_ar,
                                        "LABEL_EN" => $title_en,
                                        "ADMIN-ONLY" => true,
                                        "BF-ID" => "",
                                        'STEPS' => "all"
                                );

                                $color = "red";
                                $title_ar = $this->tm("Back to first step", 'ar');
                                $title_en = $this->tm("Back to first step", 'en');
                                $methodName = "forceGotoFirstStep";
                                $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                                        "METHOD" => $methodName,
                                        "COLOR" => $color,
                                        "LABEL_AR" => $title_ar,
                                        "LABEL_EN" => $title_en,
                                        "ADMIN-ONLY" => true,
                                        "BF-ID" => "",
                                        'STEP' => $this->stepOfAttribute("application_status_enum")
                                );
                        }
                        
                        $desires_selection_stepObj = $this->objApplicationModel->calcDesires_selection_step_id("object");
                        $desires_selection_stepNum = $desires_selection_stepObj->getVal("step_num");

                        if($currentStepNum<$desires_selection_stepNum)
                        {
                                $color = "red";
                                $title_ar = $this->tm("Force goto desires selection step", 'ar');
                                $title_en = $this->tm("Force goto desires selection step", 'en');
                                $methodName = "forceGotoDesireStep";
                                $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                                        "METHOD" => $methodName,
                                        "COLOR" => $color,
                                        "LABEL_AR" => $title_ar,
                                        "LABEL_EN" => $title_en,
                                        "ADMIN-ONLY" => true,
                                        "BF-ID" => "",
                                        'STEP' => $this->stepOfAttribute("application_status_enum")
                                );
                        }

                        
                        
                        $asObj = ApplicationStep::loadByMainIndex($this->objApplicationModel->id, $nextStepNum);
                        if($asObj)
                        {
                                if($asObj->sureIs("general"))
                                {
                                        $color = "green";
                                        $title_ar = $asObj->tm("go to next step", 'ar') . " '" . $asObj->getDisplay("ar") . "'";
                                        $title_en = $asObj->tm("go to next step", 'en') . " '" . $asObj->getDisplay("en") . "'";
                                        $methodName = "gotoNextStep";
                                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                                                "METHOD" => $methodName,
                                                "COLOR" => $color,
                                                "LABEL_AR" => $title_ar,
                                                "LABEL_EN" => $title_en,
                                                "ADMIN-ONLY" => true,
                                                "BF-ID" => "",
                                                'STEP' => $this->stepOfAttribute("application_status_enum")
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
                                                "ADMIN-ONLY" => true,
                                                "BF-ID" => "",
                                                'STEP' => $this->stepOfAttribute("application_status_enum")
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
                                                "ADMIN-ONLY" => true,
                                                "BF-ID" => "",
                                                'STEP' => $this->stepOfAttribute("application_status_enum")
                                        );
                                }
                                else
                                {
                                        $color = "blue";
                                        $title_ar = $asObj->tm("Crowd desires", 'ar');
                                        $title_en = $asObj->tm("Crowd desires", 'en');
                                        $methodName = "crowdDesires";
                                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                                                "METHOD" => $methodName,
                                                "COLOR" => $color,
                                                "LABEL_AR" => $title_ar,
                                                "LABEL_EN" => $title_en,
                                                "ADMIN-ONLY" => true,
                                                "BF-ID" => "",
                                                'STEP' => $this->stepOfAttribute("nb_desires")
                                        );
                                }
                                
                        }
                        
                }


                return $pbms;
        }

        public function runOnlyNeedUpdateApis($lang = "ar")
        {
                return $this->runNeededApis($lang, false);
        }

        public function runNeededApis($lang = "ar", $force=true)
        {
                $this->getApplicant();
                if (!$this->applicantObj) return ["no-applicantObj", ""];

                for ($s = 1; $s <= $this->getVal("step_num"); $s++) {
                        $this->requestAPIsOfStep($s);
                }

                return $this->applicantObj->runNeededApis($lang, $force);
        }

        public function getMyApplicationDesireList($force=false)
        {
                $application_plan_branch_mfk_count = $this->countMfkItems("application_plan_branch_mfk");
                if((!$this->myApplicationDesireList) or (count($this->myApplicationDesireList)!=$application_plan_branch_mfk_count))
                {
                        $force = true;     
                }
                if($force) 
                {
                        $this->myApplicationDesireList = $this->get("applicationDesireList");                        
                        foreach($this->myApplicationDesireList as $adid => $adObj)
                        {
                                $this->myApplicationDesireList[$adid]->setApplicationObject($this);
                        }
                }

                return [count($this->myApplicationDesireList), $application_plan_branch_mfk_count];
                
        }


        public function crowdDesires($lang = "ar")
        {
                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];  
                // $nb_updated = 0;
                // $nb_inserted = 0;
                try {

                        $this->getMyApplicationDesireList();
                        /**
                         * @var ApplicationDesire $applicationDesireItem
                         */
                        $to_stop_crowd = [];

                        while(count($this->myApplicationDesireList)>0)
                        {
                                foreach($to_stop_crowd as $sadid)
                                {
                                        unset($this->myApplicationDesireList[$sadid]);
                                }
                                $to_stop_crowd = [];
                                foreach ($this->myApplicationDesireList as $adid => $applicationDesireItem) 
                                {
                                        $desire_name = $this->myApplicationDesireList[$adid]->getShortDisplay($lang);
                                        $old_step_num = $this->myApplicationDesireList[$adid]->getVal("step_num");
                                        list($err, $inf, $war, $tech) = $this->myApplicationDesireList[$adid]->gotoNextDesireStep($lang);
                                        
                                        if ($err) $err_arr[] = "$desire_name : " . $err;
                                        if ($inf) $inf_arr[] = "$desire_name : " . $inf;
                                        if ($war) $war_arr[] = "$desire_name : " . $war;
                                        if ($tech) $tech_arr[] = "$desire_name : " . $tech;
                                        $new_step_num = $this->myApplicationDesireList[$adid]->getVal("step_num");
                                        if($new_step_num==$old_step_num)
                                        {
                                                // stop crowd for this desire
                                                $to_stop_crowd[] = $adid;
                                        }
                                }
                        }

                } catch (Exception $e) {
                        $err_arr[] = $e->getMessage();
                } catch (Error $e) {
                        $err_arr[] = $e->__toString();
                }
                return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
        }

        public static function createOfflineModelBranchArr($offlineDesiresRow, $maxDesires=50)
        {
                $modelBranchArr = [];
                for($k=1; $k<=$maxDesires; $k++)
                {
                        if($offlineDesiresRow["pb".$k]) $modelBranchArr[] = $offlineDesiresRow["pb".$k];
                        else break;
                }

                return $modelBranchArr;
        }

        /**
         * 
         * @param ApplicationSimulation $applicationSimulationObj
         * @param ApplicationPlan $applicationPlanObj
         * @param array $offlineDesiresRow
         */

        public function deduceSimulationBranchs($applicationSimulationObj, $applicationPlanObj, $offlineDesiresRow=[], $ignoreDataErrors=false, $ignoreClosedBranchs=false)
        {
                $lang = AfwLanguageHelper::getGlobalLanguage();
                $simulation_method = $applicationSimulationObj->getVal("simul_method_enum");
                $simulation_method_dec = $applicationSimulationObj->translate("simul_method_enum", $lang)." : ".$applicationSimulationObj->decode("simul_method_enum");
                $nb_desires = $applicationSimulationObj->getVal("nb_desires");
                $log = $simulation_method_dec;
                
                // "code"][1] = "ALL";
                // "ar"][1] = "جميع الفروع المختارة";
                // "en"][1] = "All selected branches";
                $selectedApplicationModelBranchArr = [];
                if($simulation_method==1) 
                {
                        $applicationModelBranchArr = $applicationSimulationObj->getMyPlanBranchArr();
                        // all should be keeped ignore $nb_desires
                        $selectedApplicationModelBranchArr = $applicationModelBranchArr;
                }

                // "code"][2] = "RANDOM";
                // "ar"][2] = "عشوائيا من الفروع المختارة";
                // "en"][2] = "Randomly from selected branches";
                if($simulation_method==2) 
                {
                        $applicationModelBranchArr = $applicationSimulationObj->getMyPlanBranchArr();
                        if($nb_desires>count($applicationModelBranchArr)) $nb_desires = count($applicationModelBranchArr);
                        $log .= " ($nb_desires)";
                        // keep only $nb_desires
                        $rand_keys = array_rand($applicationModelBranchArr, $nb_desires);
                        foreach($rand_keys as $rk)
                        {
                                $selectedApplicationModelBranchArr[] = $applicationModelBranchArr[$rk];
                        }
                }


                // "code"][3] = "FAVORITE";
                // "ar"][3] = "الفروع المفضلة لكل متقدم";
                // "en"][3] = "Favorite branches for each applicant";
                if($simulation_method==3) 
                {
                        $applicant = $this->getApplicant();
                        if($applicant) $applicationModelBranchArr = $applicant->getMyPlanBranchArr();
                }

                // "code"][4] = "PROSPECT";
                // "ar"][4] = "الفروع المدخلة في البيانات الجاهزة للمتقدم";
                // "en"][4] = "Entered branchs in applicant prospect off-line data";
                if($simulation_method==4) 
                {
                        $idn = $this->getVal("idn");
                        if(!$offlineDesiresRow or (count($offlineDesiresRow)==0))
                        {
                                $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
                                $offlineDesiresRow = AfwDatabase::db_recup_row("select * from ".$server_db_prefix."adm.prospect_desire where idn='$idn'");
                        }
                        if(!$nb_desires) $nb_desires = 999;
                        if($offlineDesiresRow) $applicationModelBranchArr = self::createOfflineModelBranchArr($offlineDesiresRow, $nb_desires);
                        else  $log .= "\n<br> This applicant is not found in prospect offline data";
                }

                if($applicationModelBranchArr) $log .= "\n<br> MB ".AfwLanguageHelper::translateKeyword("Found", $lang)." : ".count($applicationModelBranchArr);
                else $log .= "\n<br> No Model Branchs found";

                $applicationPlanBranchArr = [];
                foreach($applicationModelBranchArr as $applicationModelBranchId)
                {
                        if($applicationModelBranchId)
                        {
                                // $applicationPlanId = $applicationPlanObj->id;
                                $applicationPlanBranchId = $applicationPlanObj->getApplicationPlanBranchId($applicationModelBranchId);
                                if((!$applicationPlanBranchId) and (!$ignoreDataErrors) and (!$ignoreClosedBranchs))
                                {
                                        throw new AfwBusinessException("The following model branch ID %d has no plan branch ID, please check your plan if the branchs are ready for application", $lang, "", "", "", "", "adm", $applicationModelBranchId);
                                }
                                //if($applicationPlanBranchId==65) throw new AfwRuntimeException("Here The PB applicationPlanBranchId = $applicationPlanBranchId from applicationModelBranchId=$applicationModelBranchId inside plan=$applicationPlanId");
                                if($applicationPlanBranchId) $applicationPlanBranchArr[]  = $applicationPlanBranchId;
                        }
                        
                }
                $log .= "\n<br> PB ".AfwLanguageHelper::translateKeyword("Found", $lang)." : ".count($applicationPlanBranchArr);

                return [",".implode(",",$applicationPlanBranchArr).",", $log];
        }

        public function simulateDesiresFromOfflineData($lang="ar")
        {
                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];


                $applicationSimulationObj = $this->het("application_simulation_id");
                $applicationPlanObj = $this->het("application_plan_id");

                if($applicationSimulationObj and $applicationPlanObj)
                {
                        $idn = $this->getVal("idn");
                        $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
                        $offlineDesiresRow = AfwDatabase::db_recup_row("select * from ".$server_db_prefix."adm.prospect_desire where idn='$idn'");
                        list($myApplicationDesireList, $log)  = $this->simulateDesires($applicationSimulationObj, $applicationPlanObj, $lang, $offlineDesiresRow);
                        $tech_arr[] = $log;
                        $inf_arr[] = count($myApplicationDesireList)." desires has been created";
                }

                return AfwFormatHelper::pbm_result($err_arr,$inf_arr,$war_arr,"<br>\n",$tech_arr);
        }

        public function simulateDesires($applicationSimulationObj, $applicationPlanObj, $lang, $offlineDesiresRow)
        {
                $nb_desires = $applicationSimulationObj->getVal("nb_desires");
                $options = $applicationSimulationObj->getOptions();
                if(!$nb_desires) $nb_desires = 1;
                $log = "";
                $forceReload = false;
                $ignoreDataErrors = (strtolower($options["IGNORE-DATA-ERRORS"])=="on");
                $ignoreClosedBranchs = (strtolower($options["IGNORE-CLOSED-BRANCHS"])=="on");
                if(strtolower($options["ERASE-EXISTING-DESIRES"])=="on")
                {
                        $applicant_id = $this->getVal("applicant_id");
                        $application_id = $this->id;   
                        list($result, $row_count, $affected_row_count) = ApplicationDesire::deleteWhere("applicant_id = $applicant_id and application_id = $application_id");   
                        $this->set("application_plan_branch_mfk", "");   
                        $this->commit();
                        $old_application_plan_branch_mfk = "";
                        if($affected_row_count) $log .= "$affected_row_count ".$this->tm("desires already existing deleted", $lang)."<br>\n";
                        $forceReload = true;
                }
                else $old_application_plan_branch_mfk = $this->getVal("application_plan_branch_mfk");

                list($new_application_plan_branch_mfk, $log00) = $this->deduceSimulationBranchs($applicationSimulationObj, $applicationPlanObj, $offlineDesiresRow, $ignoreDataErrors, $ignoreClosedBranchs);
                $log .= $log00;

                $nb_desires_gen = count($this->myApplicationDesireList);
                $nb_desires_mfk = $this->countMfkItems("application_plan_branch_mfk");
                if(($old_application_plan_branch_mfk != $new_application_plan_branch_mfk) or ($nb_desires_mfk != $nb_desires_gen))
                {
                        $this->set("application_plan_branch_mfk", $new_application_plan_branch_mfk);
                        $this->commit();
                        $this->refreshDesireList();
                        $forceReload = true;
                }
                else
                {
                        $nb_desires = $this->calcReal_nb_desires();
                        
                        if((strtolower($options["FORCE-RELAOD-DESIRES"])=="on") or
                           ((!$nb_desires) and (strtolower($options["FORCE-RELAOD-DESIRES"])=="when-empty")))
                        {
                                $this->refreshDesireList();
                                $forceReload = true;
                        }
                }
                $this->getMyApplicationDesireList($forceReload);
                $nb_desires_gen = count($this->myApplicationDesireList);
                $log .= "<br>\nDesires : " . $nb_desires_gen;
                $nb_desires_mfk = $this->countMfkItems("application_plan_branch_mfk");
                return [$this->myApplicationDesireList, $log, $nb_desires_gen, $nb_desires_mfk];
        }

        public function bootstrapApplication($lang = "ar", $returnLastStepCode=false, $options=[])
        {
                $app_name = $this->getDisplay($lang);
                $devMode = AfwSession::config("MODE_DEVELOPMENT", false);
                $dataShouldBeUpdated = (strtolower($options["DATA-SHOULD-BE-UPDATED-BEFORE-APPLY"]) != "off");
                $audit_conditions_pass = explode(",", $options["AUDIT_ON_PASS_CONDITION_IDS"]);
                $audit_conditions_fail = explode(",", $options["AUDIT_ON_FAIL_CONDITION_IDS"]);
                $application_simulation_id = $options["SIMULATION-ID"];
                $simulate = ($application_simulation_id!=2);
                $logConditionExec = (strtolower($options["LOG-CONDITION-EXEC"]) != "off");
                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];
                $bootstrapResult = "standby";
                try {
                        $max_tentatives = 300;
                        $tentatives = 0; // limit tentatives to 300 to avoid infinite loop
                        $currentStepObj = $this->het("application_step_id");
                        $currentStepCode = $currentStepObj->getStepCode();        
                        $bootstrapStatus = "--trying";
                        $bootstrapStatusComment = "";
                        while(($bootstrapStatus!="--blocked") and ($currentStepCode!="DSR") and ($tentatives<$max_tentatives))
                        {
                                $tentatives++;
                                $current_tentative = "$app_name : tentative $tentatives $bootstrapStatus : ";
                                // refresh data
                                $this->runNeededApis($lang = "ar", ($bootstrapStatus == "--forcing"));
                                // try to go to next step
                                
                                list($err, $inf, $war, $tech, $resultGotoNextStep) = $this->gotoNextStep($lang, $dataShouldBeUpdated, $simulate, $application_simulation_id, $logConditionExec, $audit_conditions_pass, $audit_conditions_fail);
                                if ($err) 
                                {
                                        $bootstrapStatusComment .= " blocked after error in gotoNextStep ". $current_tentative . $err;
                                        $err_arr[] = $bootstrapStatusComment;    
                                        $bootstrapStatus = "--blocked";
                                        
                                }
                                else
                                {
                                        if ($inf) $inf_arr[]   = $current_tentative . $inf;
                                        if ($war) $war_arr[]   = $current_tentative . $war;
                                        if ($tech) $tech_arr[] = $current_tentative . $tech; 
                                        $newStepObj = $this->het("application_step_id");
                                        $newStepCode = $newStepObj->getStepCode();  
        
                                        if($newStepCode==$currentStepCode)
                                        {
                                                if(($currentStepCode!="DSR"))
                                                {
                                                        if($bootstrapStatus == "--forcing") 
                                                        {
                                                                $bootstrapStatus = "--blocked"; 
                                                                $bootstrapStatusComment .= " and forced but blocked and still in $currentStepCode step ";
                                                        }

                                                        if($bootstrapStatus == "--trying") 
                                                        {
                                                                $bootstrapStatusComment .= " tried";
                                                                $bootstrapStatus = "--forcing"; 
                                                        }
                                                        
                                                }
                                                else
                                                {
                                                        $bootstrapStatus = "--success";   
                                                        $bootstrapStatusComment .= " succeeded";
                                                }
                                        }
                                        else
                                        {
                                                $bootstrapStatusComment .= " transition from $currentStepCode to $newStepCode";
                                                $currentStepCode = $newStepCode;
                                                $bootstrapStatus = "--trying";                                                
                                        }
                                }
                        }

                        if(($bootstrapStatus == "--blocked") and ($currentStepCode!="DSR"))
                        {
                                $bootstrapResult = $resultGotoNextStep["result"];
                                if($bootstrapResult=="pass") throw new AfwRuntimeException("Application $app_name :<br> How can bootstrapResult=$bootstrapResult in step $currentStepCode and bootstrapStatus=$bootstrapStatus");
                                $war_arr[] = $current_tentative . $this->tm("Application is faltered, please see details and resolve manually", $lang);
                                $war_arr[] = $current_tentative . $this->tm("Reached step", $lang)." : ".$currentStepCode."<!-- bootstrapStatus$bootstrapStatus tentatives=$tentatives bootstrapStatusComment=$bootstrapStatusComment-->";
                        }
                        elseif(($currentStepCode=="DSR"))
                        {
                                $bootstrapResult = "done";
                                $war_arr[] = $current_tentative . $this->tm("Application desire selection reached", $lang)."<!-- bootstrapStatus$bootstrapStatus tentatives=$tentatives bootstrapStatusComment=$bootstrapStatusComment-->";
                        }

                } catch (Exception $e) {
                        if($devMode) throw $e;
                        $err_arr[] = $current_tentative . $e->getMessage();
                } catch (Error $e) {
                        if($devMode) throw $e;
                        $err_arr[] = $current_tentative . $e->__toString();
                }

                $resPbm = AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);

                if($returnLastStepCode) return [$currentStepCode, $resPbm, $tentatives, $bootstrapResult];

                return $resPbm;
        }

        public function forceGotoDesireStep($lang = "ar")
        {
                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];
                $result_arr = [];
                
                $this->getApplicationModel();
                if (!$this->objApplicationModel) 
                {
                        $err_arr[] = $this->tm("Error happened, no application model defined for this application", $lang);
                }
                
                if(count($err_arr)==0)
                {
                        $desiresSelectionStepObj = $this->objApplicationModel->calcDesires_selection_step_id("object");
                        $application_step_id = $desiresSelectionStepObj->id;
                        $desiresSelectionStepNum = $desiresSelectionStepObj->getVal("step_num");
                        $desiresSelectionStepCode = $desiresSelectionStepObj->getVal("step_code");
                        // die("desiresSelectionStepCode=$desiresSelectionStepCode desiresSelectionStepNum=$desiresSelectionStepNum desiresSelectionStepObjId= ".$desiresSelectionStepObj->id." descr = ".$desiresSelectionStepObj->getDisplay("ar"));
                        if($desiresSelectionStepCode != "DSR")
                        {
                             $err_arr[] = "strange desiresSelectionStepCode=$desiresSelectionStepCode";
                        }
                        else
                        {
                                $this->set("application_step_id", $application_step_id);
                                $this->set("step_num", $desiresSelectionStepNum);
                                $this->set("application_status_enum", self::application_status_enum_by_code('pending'));
                                $war = $this->tm("conditions apply skipped",$lang)." !!";
                                $war_arr[]  = $war;
                                $this->set("comments", $war);                        
                                $hasChanged = $this->hasChanged();
                                if($hasChanged)
                                {
                                        if(!$this->commit(true))
                                        {
                                                // $application_id = $this->id;
                                                // $error = "columns $hasChanged has changed for application id = $application_id (after set step_num to $desiresSelectionStepNum and application_step_id to $application_step_id) but forceGotoDesireStep commit failed : ".$this->getTechnicalNotes()." ".$this->reallyUpdated();
                                                // $err_arr[] = $error;
                                                $currentStepObj = $this->het("application_step_id");
                                                $result_arr["STEP_CODE"] = $currentStepObj->getVal("step_code");
                                        }
                                        else
                                        {
                                                $inf_arr[] = $this->tm("quick arrive to desires selection step", $lang)." ".$this->tm("has been successfully done", $lang);
                                                $result_arr["STEP_CODE"] = $desiresSelectionStepCode;
                                                // die("rafik we succeeded desiresSelectionStepCode=$desiresSelectionStepCode desiresSelectionStepNum=$desiresSelectionStepNum desiresSelectionStepObjId= ".$desiresSelectionStepObj->id);
                                        }
                                }
                                else
                                {
                                        $currentStepObj = $this->het("application_step_id");
                                        $result_arr["STEP_CODE"] = $currentStepObj->getVal("step_code");
                                }
                                
                        }
                        
                        
                }
                else
                {
                        $currentStepObj = $this->het("application_step_id");
                        $result_arr["STEP_CODE"] = $currentStepObj->getVal("step_code");
                }

                return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr, $result_arr);
                
        }


        public function forceGotoFirstStep($lang = "ar")
        {
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];
                $result_arr = [];
                
                $this->getApplicationModel();
                if (!$this->objApplicationModel) 
                {
                        $err_arr[] = $this->tm("Error happened, no application model defined for this application", $lang);
                }
                else
                {
                        $firstApplicationStepObj = $this->objApplicationModel->getFirstApplicationStep();
                        $application_step_id = $firstApplicationStepObj->id;
                        $this->set("application_step_id", $application_step_id);                        
                        $firstStepNum = $firstApplicationStepObj->getVal("step_num");
                        $firstStepCode = $firstApplicationStepObj->getVal("step_code");
                        $this->set("step_num", $firstStepNum);
                        $this->set("application_status_enum", self::application_status_enum_by_code('pending'));
                        $war = $this->tm("The admin has forced move to first step",$lang)." !!";
                        $war_arr[]  = $war;
                        $this->set("comments", $war);                        
                        $this->commit();
                        $inf_arr[] = $this->tm("The move to first step", $lang)." ".$this->tm("has been successfully done", $lang);
                        $result_arr["STEP_CODE"] = $firstStepCode;
                }

                return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr, $result_arr);
                
        }


        public function dataIsCompleted()
        {
                list($is_ok, $dataErr) = $this->isOk(true, true);
                if(!$is_ok) return [false, implode("<br>\n", $dataErr)];
                else 
                {
                        $nb_desires = $this->calcReal_nb_desires();     

                        if($nb_desires==0) return [false, "select your desires"];

                        return [true, ""];
                }
        }


        public function applicationIsCompleted()
        {
                list($is_ok, $error) = $this->dataIsCompleted();
                if($is_ok)
                {
                        return ($this->getVal("application_status_enum") == self::application_status_enum_by_code('complete'));
                }

                return false;
        }

        public function gotoNextStep($lang = "ar", $dataShouldBeUpdated=true, $simulate=true, $application_simulation_id=0, $logConditionExec=true, $audit_conditions_pass = [], $audit_conditions_fail = [])
        {
                $devMode = AfwSession::config("MODE_DEVELOPMENT", false);
                
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];
                $result_arr = [];
                $result_arr["result"] = "standby";
                // $nb_updated = 0;
                // $nb_inserted = 0;
                try {

                        $this->getApplicationModel();
                        if (!$this->objApplicationModel) 
                        {
                                $message_err = $this->tm("Error happened, no application model defined for this application", $lang);
                                $result_arr["result"] = "fail";
                                $result_arr["message"] = $message_err;
                                $err_arr[] = $message_err;
                        }
                        else
                        {
                                /**
                                 * @var ApplicationStep $currentStepObj
                                 */
                                $currentStepObj = $this->het("application_step_id");
                                $currentStepNum = $this->getVal("step_num");

                                $dataReady = $this->fieldsMatrixForStep($currentStepNum, $lang, $onlyIfTheyAreUpdated = true, true, true);
                                if ($dataShouldBeUpdated and !$dataReady) 
                                {
                                        $fieldsNotAvail = $this->fieldsMatrixForStep($currentStepNum, $lang, "list-fields-not-available", false, true);
                                        $reasonNotAvail = $this->fieldsMatrixForStep($currentStepNum, $lang, "reason-fields-not-available", false, true);
                                        
                                        $message_war = $this->tm("We can not apply conditions because the data is not updated", $lang);
                                        $war_arr[] = $message_war;
                                        $result_arr["message"] = $message_war;
                                        $result_arr["details"] = $fieldsNotAvail;
                                        $result_arr["details_2"] = $reasonNotAvail;
                                        $this->set("application_status_enum", self::application_status_enum_by_code('data-review'));
                                        $this->set("comments", $message_war);
                                        
                                }
                                else
                                {
                                         /**
                                         * @var ApplicationStep $lastStepObj
                                         */
                                        $lastStepObj = $this->objApplicationModel->getLastApplicationStep();
                                        // $currentStepId = $this->getVal("application_step_id");
                                        // die("before currentStepObj=$currentStepObj->id currentStepNum=$currentStepNum currentStepId=$currentStepId");
                                        if (!$currentStepObj or !$currentStepObj->id) $currentStepObj = $this->objApplicationModel->getFirstStep();
                                        if (!$currentStepObj) 
                                        {
                                                $this->set("application_status_enum", self::application_status_enum_by_code('pending'));
                                                $message_err = $this->tm("No first step defined for this application model, you may need to reorder the steps to have first step having number equal 0 or number equal 1", $lang);
                                                $result_arr["result"] = "fail";
                                                $result_arr["message"] = $message_err;
                                                $this->set("comments", $message_err);
                                                
                                                $err_arr[] = $message_err;
                                        }
                                        elseif (!$lastStepObj) 
                                        {
                                                $this->set("application_status_enum", self::application_status_enum_by_code('pending'));
                                                $message_err = $this->tm("No last general step defined for this application model, you may need to reorder correcty the steps to have last general step is the desire selection step", $lang);
                                                $result_arr["result"] = "fail";
                                                $result_arr["message"] = $message_err;
                                                $this->set("comments", $message_err);
                                                
                                                $err_arr[] = $message_err;
                                        }
                                        elseif($currentStepObj->sureIs("general") and ($currentStepObj->id != $lastStepObj->id))
                                        {
                                                // to go to next step we should apply conditions of the current step
                                                $applyResult = $this->applyMyCurrentStepConditions($lang, false, $simulate, $application_simulation_id, $logConditionExec, $audit_conditions_pass, $audit_conditions_fail);
                                                // die("applyResult = ".var_export($applyResult,true));
                                                $success = $applyResult['success'];
                                                $nb_conds = $applyResult['nb_conds'];

                                                list($error_message, $success_message, $fail_message, $tech, $res_arr) = $applyResult['res'];
                                                if ($success and (!$error_message)) {
                                                        $result_arr["result"] = "pass";
                                                        $result_arr["message"] = $success_message;
                                                        $nextStepNum = $this->objApplicationModel->getNextStepNumOf($currentStepNum,true);
                                                        $tech_arr[] = "nextStepNum=$nextStepNum currentStepNum=$currentStepNum";
                                                        $this->set("step_num", $nextStepNum);
                                                        $this->set("application_status_enum", self::application_status_enum_by_code('pending'));
                                                        $inf_arr[]  = $this->tm("The move from step", $lang) . " : " . $currentStepObj->getDisplay($lang) . " " . $this->tm("has been successfully done", $lang);
                                                        $inf_arr[]  = $success_message;                                
                                                        $this->set("comments", $nb_conds." ".$this->tm("conditions successfully passed",$lang));
                                                        
                                                        
                                                        if ($nextStepNum != $currentStepNum) {
                                                                $this->requestAPIsOfStep($nextStepNum);
                                                        }
                                                        $tech_arr[] = $tech;
                                                } else {
                                                        if((!$error_message) and ($success===false)) $result_arr["result"] = "fail";
                                                        else $result_arr["result"] = "standby";
                                                        $result_arr["message"] = $res_arr["status_comment"];
                                                        if(!$fail_message) $fail_message = $error_message;
                                                        $war_arr[]  = $this->tm("The move from step", $lang) . " : " . $currentStepObj->getDisplay($lang) . " " . $this->tm("has failed for the following reason", $lang) . " : ";
                                                        $war_arr[]  = $fail_message;
                                                        $tech_arr[] = $tech;
                                                        $this->set("application_status_enum", self::application_status_enum_by_code('pending'));
                                                        $this->set("comments", $fail_message);                                                                                        
                                                        
                                                }
                                        }
                                        else{
                                                if($this->dataIsCompleted())
                                                {
                                                        $result_arr["result"] = "success";
                                                        
                                                        $result_arr["message"] = "";


                                                        $last_step_num = $lastStepObj->getVal("step_num");
                                                        $this->set("step_num", $last_step_num);
                                                        $this->set("application_step_id", $lastStepObj->id);
                                                        $this->set("application_status_enum", self::application_status_enum_by_code('complete'));
                                                        $this->set("comments", $this->tm("application is complete",$lang));
                                                }
                                                else
                                                {
                                                        $result_arr["result"] = "fail";
                                                        $result_arr["message"] = "attempt to goto next step when this is the last step, please select the desires";
                                                        $last_step_num = $lastStepObj->getVal("step_num");
                                                        $this->set("step_num", $last_step_num);
                                                        $this->set("application_step_id", $lastStepObj->id);
                                                        $this->set("application_status_enum", self::application_status_enum_by_code('pending'));
                                                        $this->set("comments", $this->tm("please select the desires",$lang));
                                                }
                                                
                                                
                                        }
                                        
                                }
                        }
                        
                        
                        
                } catch (Exception $e) {
                        if($devMode) throw $e;
                        $err_arr[] = $fail_message = $e->getMessage();
                        $this->set("comments", $fail_message);                        
                        
                } catch (Error $e) {
                        if($devMode) throw $e;
                        $err_arr[] = $fail_message = $e->__toString();
                        $this->set("comments", $fail_message);                        
                        
                }
                $this->commit();
                return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr, $result_arr);
        }

        public function statusExplanations()
        {
                return $this->getVal("comments");
        }

        public function requestAPIsOfStep($nextStepNum)
        {
                $this->getApplicationModel();
                if ($this->objApplicationModel) {
                        $appModelApiList = $this->objApplicationModel->getAppModelApiOfStep($nextStepNum);

                        $appModelApiListCount = count($appModelApiList);

                        // die("appModelApiList ($appModelApiListCount apis) = objApplicationModel->getAppModelApiOfStep($nextStepNum) = ".var_export($appModelApiList,true));
                        // $api_runner_class = Applicant::loadApiRunner();

                        if (!$this->applicantObj) $this->applicantObj = $this->het("applicant_id");
                        if ($this->applicantObj) {
                                // create step apis call requests to be done by applicant-api-request-job            
                                foreach ($appModelApiList as $appModelApiItem) {
                                        $apiEndPointObj = $appModelApiItem->het("api_endpoint_id");
                                        if ($apiEndPointObj) {
                                                // $api_endpoint_code = $apiEndPointObj->getVal("api_endpoint_code");                                
                                                ApplicantApiRequest::loadByMainIndex($this->applicantObj->id, $apiEndPointObj->id, true);
                                        }
                                }
                        }
                } else {
                        AfwSession::pushError("requestAPIsOfStep($nextStepNum) on Application " . $this->getDisplay("en") . "<br> :Not Found Application Model ID = " . $this->getVal("application_model_id"));
                }
        }

        public function getFieldApiEndpoint($field_name, $application_table_id = 3)
        {
                $this->getApplicationModel();
                if (!$this->objApplicationModel) return null;
                return $this->objApplicationModel->getFieldApiEndpoint($field_name, $application_table_id);
        }



        public function getFieldExpiryDuration($field_name, $application_table_id = 3)
        {
                $this->getApplicationModel();
                if (!$this->objApplicationModel) return 9999;
                return $this->objApplicationModel->getFieldExpiryDuration($field_name, $application_table_id);
        }

        public function getFieldUpdateDate($field_name, $lang = "ar", $application_table_id = 3)
        {
                if (!$this->applicantObj) $this->applicantObj = $this->het("applicant_id");
                $apiEndpointDisplay = "";
                if ($this->applicantObj) {
                        $apiEndpoint = $this->getFieldApiEndpoint($field_name, $application_table_id);
                        if ($apiEndpoint) {
                                $apiEndpointDisplay = $apiEndpoint->getDisplay($lang)." <!-- ".$apiEndpoint->getVal("api_endpoint_code")." -->";;
                                if ($apiEndpoint->id != 13) {
                                        $field_value_datetime = $this->applicantObj->getApiUpdateDate($apiEndpoint);
                                } else {
                                        $field_value_datetime = $this->getVal("created_at");
                                }
                        } else $apiEndpointDisplay = get_class($this)."[$this->id] > no-apiEndpoint for $field_name";
                } else $apiEndpointDisplay = "no-applicant";
                if (!$field_value_datetime) $field_value_datetime = $this->getVal($field_name . "_update_date");

                return [$field_value_datetime, $apiEndpointDisplay];
        }

        public function getApplicantFieldUpdateDate($field_name, $lang = "ar")
        {
                if (!$this->applicantObj) $this->applicantObj = $this->het("applicant_id");
                $apiEndpointDisplay = "";
                if ($this->applicantObj) {
                        $apiEndpoint = $this->getFieldApiEndpoint($field_name, 1);
                        if ($apiEndpoint) {
                                $apiEndpointDisplay = $apiEndpoint->getDisplay($lang)." <!-- ".$apiEndpoint->getVal("api_endpoint_code")." -->";
                                if ($apiEndpoint->id != 13) {
                                        $field_value_datetime = $this->applicantObj->getApiUpdateDate($apiEndpoint);
                                } else {
                                        $field_value_datetime = $this->applicantObj->getVal("updated_at");
                                }
                        } else $apiEndpointDisplay = ">> no-apiEndpoint for $field_name";
                } else $apiEndpointDisplay = "no-applicant";
                if (!$field_value_datetime) $field_value_datetime = $this->applicantObj->getVal($field_name . "_update_date");

                return [$field_value_datetime, $apiEndpointDisplay];
        }

        public function getFieldsMatrix($applicationFieldsArr, $lang = "ar", $onlyIfTheyAreUpdated = false, $technical_infos=true)
        {
                return self::getObjectFieldsMatrix($this, $applicationFieldsArr, $lang, $onlyIfTheyAreUpdated, $technical_infos);
        }
        
        public static function getObjectFieldsMatrix(&$object, $applicationFieldsArr, $lang = "ar", $onlyIfTheyAreUpdated = false, $technical_infos=true)
        {
                $matrix = [];
                $theyAreUpdated = true;
                $not_avail = [];
                $not_avail_reason = [];
                // $this->updateCalculatedFields();
                foreach ($applicationFieldsArr as $field_name => $applicationFieldObj) {
                        $row_matrix = [];
                        $field_reel = $applicationFieldObj->_isReel();
                        $row_matrix['reel'] = $field_reel;
                        $field_title = $applicationFieldObj->getDisplay($lang);
                        if($technical_infos) $field_title .= "<!-- $field_name -->";
                        $row_matrix['title'] = $field_title;
                        if ($field_reel) {
                                $field_value = $object->getVal($field_name);
                                $field_value_case = "getVal";
                        } else {
                                $field_value = $object->calc($field_name);
                                $field_value_case = "calc";
                        }
                        $field_decode = $object->decode($field_name);
                        if($technical_infos) $field_decode .= "<!-- $field_value -->";
                        $row_matrix['decode'] = $field_decode;
                        $row_matrix['value'] = $field_value;
                        $row_matrix['case'] = $field_value_case;

                        $field_empty = ((!$field_value) or ($field_value === "W"));
                        $row_matrix['empty'] = $field_empty;

                        $field_value_datetime = date("Y-m-d");
                        $api = "";
                        if (!$field_empty) {

                                $default_update_date_of_field_is_api_run_date = false; /* @todo should be in settings */
                                if($default_update_date_of_field_is_api_run_date)
                                {
                                        [$field_value_datetime, $api] = $object->getFieldUpdateDate($field_name);
                                }
                                else
                                {
                                        // @todo : in this case how to know the field update datetime
                                        $field_value_datetime = date("Y-m-d");
                                }
                                
                        }


                        $row_matrix['datetime'] = $field_value_datetime;
                        $row_matrix['api'] = $api;
                        if ($field_value_datetime) {

                                $duration_expiry = $object->getFieldExpiryDuration($field_name);
                                if (!$duration_expiry) $duration_expiry = 180;
                                $expiry_date = AfwDateHelper::shiftGregDate('', -$duration_expiry);
                                if ($field_value_datetime < $expiry_date) 
                                {
                                        $need_update_message = $api . " updated=$field_value_datetime < expiry=$expiry_date (duration_expiry of $field_name =$duration_expiry)";
                                        $row_matrix['status'] = self::needUpdateIcon($need_update_message);
                                        $theyAreUpdated = false;
                                        $not_avail[] = $field_title;
                                        $not_avail_reason[] = $field_title . " " . $need_update_message;
                                } else {
                                        $row_matrix['status'] = self::updatedIcon($api);
                                }
                        } else {
                                $need_update_message = $api . " => never updated";
                                $row_matrix['status'] = self::needUpdateIcon($need_update_message);
                                $not_avail[] = $field_title;
                                $not_avail_reason[] = $field_title . " " . $need_update_message;
                                $theyAreUpdated = false;
                        }



                        $matrix[] = $row_matrix;
                }

                if ($onlyIfTheyAreUpdated === true) return $theyAreUpdated;
                if ($onlyIfTheyAreUpdated === "list-fields-not-available") return implode(",", $not_avail);
                if ($onlyIfTheyAreUpdated === "reason-fields-not-available") return implode(",", $not_avail_reason);

                return $matrix;
        }


        public function calcMandatory_fields_matrix($what="value")
        {
                $onlyMandatory=true;
                $lang = AfwLanguageHelper::getGlobalLanguage();
                $this->getApplicationModel();
                if (!$this->objApplicationModel) "no app model defined !!!! starnge";
                $step_num = $this->getVal("step_num");
                list($applicantFieldsArr, $applicationFieldsArr, $applicationDesireFieldsArr) = $this->objApplicationModel->getAppModelFieldsOfStep($step_num, true, false, $lang, $onlyMandatory);

                return " applicantFieldsArr = " . AfwExportHelper::afwExport($applicantFieldsArr, false) . "<br>\n" .
                       " applicationFieldsArr = " . AfwExportHelper::afwExport($applicationFieldsArr, false) . "<br>\n" .
                       " applicationDesireFieldsArr = " . AfwExportHelper::afwExport($applicationDesireFieldsArr, false);                      
        }

        public function fieldsMatrixForStep($stepNum, $lang = "ar", $onlyIfTheyAreUpdated = false, $technical_infos=true, $onlyMandatory = false)
        {
                if (!$this->applicantObj) $this->applicantObj = $this->het("applicant_id");
                if (!$this->applicantObj) throw new AfwRuntimeException("Can't retrieve fields matrix without any applicant defined");

                $this->getApplicationModel();
                if (!$this->objApplicationModel) throw new AfwRuntimeException("Can't retrieve fields matrix without any Application Model defined");
                list($applicantFieldsArr, $applicationFieldsArr, $applicationDesireFieldsArr) = $this->objApplicationModel->getAppModelFieldsOfStep($stepNum, true, false, $lang, $onlyMandatory);
                if (count($applicationDesireFieldsArr) > 0) {
                        $applicationDesireFieldsArrKeys = array_keys($applicationDesireFieldsArr);
                        AfwSession::pushWarning("some desire fields are required in general step $stepNum => " . implode(",", $applicationDesireFieldsArrKeys) . " => " . implode(",", $applicationDesireFieldsArr));
                        // throw new AfwRuntimeException("some desire fields are required in general step $stepNum => ".implode(",",$applicationDesireFieldsArrKeys));
                }

                $fieldsMatrix_1 = $this->applicantObj->getFieldsMatrix($applicantFieldsArr, $lang, $this, $onlyIfTheyAreUpdated, $technical_infos);
                $fieldsMatrix_2 = $this->getFieldsMatrix($applicationFieldsArr, $lang, $onlyIfTheyAreUpdated, $technical_infos);

                if ($onlyIfTheyAreUpdated===true) return ($fieldsMatrix_1 and $fieldsMatrix_2);
                if ($onlyIfTheyAreUpdated==="list-fields-not-available") return $fieldsMatrix_1 . "," . $fieldsMatrix_2;
                if ($onlyIfTheyAreUpdated==="reason-fields-not-available") return $fieldsMatrix_1 . "," . $fieldsMatrix_2;

                $fieldsMatrix = array_merge($fieldsMatrix_1, $fieldsMatrix_2);

                return $fieldsMatrix;
        }

        public function fieldsMatrixNeedUpdate() {}

        public function calcCurrent_fields_matrix()
        {
                $lang = AfwLanguageHelper::getGlobalLanguage();

                $currentStepNum = $this->getVal("step_num");
                $matrix = $this->fieldsMatrixForStep($currentStepNum, $lang);

                $matrix_header = ['title' => 'الحقل', 'decode' => 'القيمة', 'datetime' => 'تاريخ التحديث', 'api' => 'الخدمة', 'status' => 'حالة التحديث',];


                $return = AfwHtmlHelper::tableToHtml($matrix, $matrix_header);
                //$return .= "matrix = ".var_export($matrix, true)."<br>\n";

                return $return;
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
                       // adm.application_desire-ملف التقديم	application_id  أنا تفاصيل لها (required field)
                        // require_once "../adm/application_desire.php";
                        $obj = new ApplicationDesire();
                        $obj->where("application_id = '$id' and active='Y' and desire_status_enum in (2,3)");
                        $nbRecords = $obj->count();
                        // check if there's no record that block the delete operation
                        if($nbRecords>0)
                        {
                            $this->deleteNotAllowedReason = "The applicant has some accepted desires and can't be deleted";
                            return false;
                        }
                        // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                        if(!$simul) $obj->deleteWhere("application_id = '$id' and (active='N' or desire_status_enum not in (2,3))");


                        
                   // FK part of me - deletable 

                   
                   // FK not part of me - replaceable 

                        
                   
                   // MFK

               }
               else
               {
                        // FK on me 
 

                        // adm.application_desire-ملف التقديم	application_id  أنا تفاصيل لها (required field)
                        if(!$simul)
                        {
                            // require_once "../adm/application_desire.php";
                            ApplicationDesire::updateWhere(array('application_id'=>$id_replace), "application_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.application_desire set application_id='$id_replace' where application_id='$id' ");
                            
                        } 
                        


                        
                        // MFK

                   
               } 
               return true;
            }    
	}

        public function applicationAttributeIsApplicable($attribute)
        {
                if (!isset($this->attribIsApplic[$attribute])) {
                        /*
                        if ($attribute == "program_id") {
                                $application_field_id = 110809;
                                $this->getApplicationModel();
                                if (!$this->objApplicationModel) return false;
                                $this->attribIsApplic[$attribute] = ($this->objApplicationModel->getFieldInStep($application_field_id, $this->getVal("step_num")) == 1);
                        } else
                        */
                        if ($attribute == "applicant_qualification_id") {
                                $application_field_id = 110694;
                                $this->getApplicationModel();
                                if (!$this->objApplicationModel) return false;
                                $this->attribIsApplic[$attribute] = ($this->objApplicationModel->getFieldInStep($application_field_id, $this->getVal("step_num")) == 1);
                        } else {
                                throw new AfwRuntimeException("$attribute is not a knwon application attribute");
                        }
                }

                return $this->attribIsApplic[$attribute];
        }

        public function attributeIsApplicable($attribute)
        {

                if (/*($attribute == "program_id") or */($attribute == "applicant_qualification_id")) 
                {
                        return $this->applicationAttributeIsApplicable($attribute);
                }

                // nb_desires -- عدد الرغبات
		// applicationDesireList -- ترتيب الرغبات
		// application_plan_branch_mfk -- اختيار الرغبات
                if (($attribute == "nb_desires") or 
                    ($attribute == "applicationDesireList") or 
                    ($attribute == "application_plan_branch_mfk")) 
                {
                        // current step should be desire step or the desire select/sort step
                        $currentStepObj = $this->het("application_step_id");
                        if(!$currentStepObj) return false;
                        if($currentStepObj->sureIs("general") and (!$currentStepObj->isTheDesireSelectStep())) return false;                        
                }

                if ($attribute == "applicant_decision_enum") 
                {
                        return ($this->countSortedDesires()>0);
                }

                return true;
        }


        public function fieldDataAvailable($field, $application_table_id = 3)
        {
                $applicationFieldsArr = [];
                if (is_string($field)) {
                        $field_name = $field;
                        $applicationFieldItem = ApplicationField::loadByMainIndex($field_name, $application_table_id);
                        if (!$applicationFieldItem) return false;
                        $applicationFieldsArr[$field_name] = $applicationFieldItem;
                } else {
                        $applicationFieldItem = $field;
                        $field_name = $applicationFieldItem->getVal("field_name");
                        $application_table_id = $applicationFieldItem->getVal("application_table_id");
                        $applicationFieldsArr[$field_name] = $applicationFieldItem;
                }

                return $this->getFieldsMatrix($applicationFieldsArr, $lang = "ar", $onlyIfTheyAreUpdated = true);
        }


        public function calcQualification_mfk($what = "value")
        {
                $this->getApplicationModel();
                if (!$this->objApplicationModel) return ($what == "value") ? "," : [];
                
                return $this->objApplicationModel->calcQualification_mfk($what);
        }

        public function calcNb_desires($what = "value")
        {
                $application_plan_branch_mfk = $this->getVal("application_plan_branch_mfk");
                $application_plan_branch_mfk = trim(trim($application_plan_branch_mfk,","));
                if(!$application_plan_branch_mfk) return 0;
                return count(explode(",",$application_plan_branch_mfk));
                /*
                if($this->nb_desires === null)
                {
                        $this->nb_desires = $this->getRelation("applicationDesireList")->count();
                }
                return $this->nb_desires;*/

        }


        public function calcReal_nb_desires($what = "value")
        {
                if($this->nb_desires === null)
                {
                        $this->nb_desires = $this->getRelation("applicationDesireList")->count();
                }
                return $this->nb_desires;

        }

        public function calcSis_fields_available($what = "value", $lang = "")
        {
                //die("rafik debugg 20250203");
                list($yes, $no) = AfwLanguageHelper::translateYesNo($what, $lang);
                /*NOT WORKING WELL to debugg
                $this->getApplicationModel();
                if (!$this->objApplicationModel) return $no;

                $applicationFieldList = $this->objApplicationModel->get("application_field_mfk");
                $applicationFieldsArr = [];
                $applicantFieldsArr = [];
                foreach ($applicationFieldList as $applicationFieldItem) {
                        $field_name = $applicationFieldItem->getVal("field_name");
                        $application_table_id = $applicationFieldItem->getVal("application_table_id");
                        if ($application_table_id == 3) $applicationFieldsArr[$field_name] = $applicationFieldItem;
                        elseif ($application_table_id == 1) $applicantFieldsArr[$field_name] = $applicationFieldItem;
                        else throw new AfwRuntimeException("The field $field_name is not related neither Applicant nor Application entities so can not be in the SIS-fields");
                }
                if (count($applicantFieldsArr) > 0) {
                        if (!$this->applicantObj) $this->applicantObj = $this->het("applicant_id");
                        if (!$this->applicantObj) $applicantAvail = false;
                        else $applicantAvail = $this->applicantObj->getFieldsMatrix($applicantFieldsArr, $lang = "ar", $this, $onlyIfTheyAreUpdated = true);
                } else {
                        $applicantAvail = true;
                }

                $applicationAvail = $this->getFieldsMatrix($applicationFieldsArr, $lang = "ar", $onlyIfTheyAreUpdated = true);
                // die("applicantAvail and applicationAvail => $applicantAvail and $applicationAvail");

                return ($applicantAvail and $applicationAvail) ? $yes : $no;*/

                return $yes;
        }

        public function calcSis_fields_not_available($what = "value", $lang = "")
        {
                $this->getApplicationModel();
                if (!$this->objApplicationModel) return "No Application Model Object";

                $applicationFieldList = $this->objApplicationModel->get("application_field_mfk");
                $applicationFieldsArr = [];
                $applicantFieldsArr = [];
                foreach ($applicationFieldList as $applicationFieldItem) {
                        $field_name = $applicationFieldItem->getVal("field_name");
                        $application_table_id = $applicationFieldItem->getVal("application_table_id");
                        if ($application_table_id == 3) $applicationFieldsArr[$field_name] = $applicationFieldItem;
                        elseif ($application_table_id == 1) $applicantFieldsArr[$field_name] = $applicationFieldItem;
                        else throw new AfwRuntimeException("The field $field_name is not related neither Applicant nor Application entities so can not be in the SIS-fields");
                }

                $returnApplication = $this->getFieldsMatrix($applicationFieldsArr, $lang = "ar", $onlyIfTheyAreUpdated = "list-fields-not-available");
                if (count($applicantFieldsArr) > 0) {
                        if (!$this->applicantObj) $this->applicantObj = $this->het("applicant_id");
                        if (!$this->applicantObj) $returnApplicant = "applicantObj not correct";
                        else $returnApplicant = $this->applicantObj->getFieldsMatrix($applicantFieldsArr, $lang = "ar", $this, $onlyIfTheyAreUpdated = "list-fields-not-available");
                } else {
                        $returnApplicant = "";
                }

                if ($returnApplicant) $returnApplication .= "," . $returnApplicant;

                return $returnApplication;
        }


        public function calcProgram_offering_mfk($what = "value")
        {
                $applicantQualificationObj = $this->het("applicant_qualification_id");

                $qualification_id = $applicantQualificationObj->getVal("qualification_id");
                $major_path_id  = $applicantQualificationObj->getVal("major_path_id");
                $this->getApplicationModel();
                if ($this->objApplicationModel) {
                        $academic_level_id = $this->objApplicationModel->getVal("academic_level_id");
                }
                else return ($what == "value") ? "," : [];

                $server_db_prefix = AfwSession::config("db_prefix", "default_db_");

                $po_id_arr = AfwDatabase::db_recup_liste("select po.id from ".$server_db_prefix."adm.academic_program_offering po
                                                inner join ".$server_db_prefix."adm.program_qualification pq on pq.academic_program_id = po.academic_program_id 
                                where pq.qualification_id = $qualification_id
                                  and pq.major_path_id = $major_path_id
                                  and pq.academic_level_id = $academic_level_id", "id");
                

                
                $po_id_mfk = implode(",", $po_id_arr);
                if(!$po_id_mfk) $po_id_mfk = ",";
                else $po_id_mfk = ",$po_id_mfk,";

                return $po_id_mfk;
        }

        public function calcWeighted_percentage_details($what = "value")
        {
                return $this->calcWeighted_percentage("details");
        }

        public function calcTrackAndMajorPath()
        {
                $applicantQualificationObj = $this->het("applicant_qualification_id");
                $major_path_id = 0;
                $major_path_name = "all";
                $program_track_id = 0; // no program track in level of application (only level of desire)
                $program_track_name = "all";
                if ($applicantQualificationObj) {
                        $major_path_id = $applicantQualificationObj->getInfo("secondary_major_path");
                        $major_path_name = $applicantQualificationObj->getInfo("secondary_major_path_decoded");
                }

                return [$program_track_id, $major_path_id, $applicantQualificationObj, $program_track_name, $major_path_name];
        }

        public function calcWeighted_percentage($what = "value")
        {
                list($program_track_id, $major_path_id, $applicantQualificationObj) = $this->calcTrackAndMajorPath($what);
                if (!$applicantQualificationObj) return ($what == "value") ? -88 : "No applicant qualification object";
                if (!$this->applicantObj) $this->applicantObj = $this->het("applicant_id");
                if (!$this->applicantObj) return ($what == "value") ? -99 : "No applicant object";

                return $this->applicantObj->weighted_percentage($what, $program_track_id, $major_path_id, $applicantQualificationObj);
        }

        

        public function getApplicationDesireByNum($desire_num)
        {
                $applicant_id = $this->getVal("applicant_id");
                $application_plan_id = $this->getVal("application_plan_id");
                $application_simulation_id = $this->getVal("application_simulation_id");

                return ApplicationDesire::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id, $desire_num);
        }

        public function getApplicationDesireByBranchId($application_plan_branch_id, $idn, $desire_num, $create_obj_if_not_found = false)
        {
                $applicant_id = $this->getVal("applicant_id");
                $application_plan_id = $this->getVal("application_plan_id");
                $application_simulation_id = $this->getVal("application_simulation_id");
                return ApplicationDesire::loadByBigIndex($applicant_id, $application_plan_id, $application_simulation_id, $application_plan_branch_id, $idn, $create_obj_if_not_found, $this, $desire_num);
        }

        public function calcFrom_desires_application_plan_branch_mfk($what="value")
        {
                $applicationDesireList = $this->get("applicationDesireList");
                if($what!="value") return $applicationDesireList;
                
                $mfk = ",";
                foreach($applicationDesireList as $applicationDesireItem)
                {
                        $mfk .= $applicationDesireItem->getVal("application_plan_branch_id").",";
                }

                return $mfk;
        }

        public function refreshDesireList($lang="ar")
        {
                // below is obsolete because we have 2 unique keys the only correct way to proceed if mfk changed is to delete all items 
                // and create again with correct application_plan_branch_id and desire_num without SQL errors because of both unique indexes
                // 1) what is not in application_plan_branch_mfk should be removed
                // if((!$application_plan_branch_mfk) or (!trim($application_plan_branch_mfk)) or (trim($application_plan_branch_mfk)==",") or (trim($application_plan_branch_mfk)==",,")) $application_plan_branch_mfk = ",0,";
                // $applicationDesireList = $this->getRelation("applicationDesireList")->resetWhere("application_plan_branch_id not in (0 ".$application_plan_branch_mfk." 0)")->getList();
                

                $info = "";
                $warn = "";

                $idn = $this->getVal("idn");                                 
                $application_plan_branch_mfk = $this->getVal("application_plan_branch_mfk");
                
                $previous_application_plan_branch_mfk = $this->calcFrom_desires_application_plan_branch_mfk();

                $mfk_has_changed = (trim($previous_application_plan_branch_mfk,",") != trim($application_plan_branch_mfk,","));
                if($mfk_has_changed)
                {
                        // 1. delete all old desires
                        $applicationDesireList = $this->get("applicationDesireList");
                        /**
                         * @var ApplicationDesire $applicationDesireItem
                         */
                        $deleted = 0;
                        $delete_refused = 0;
                        foreach ($applicationDesireList as $applicationDesireItem) {
                                if($applicationDesireItem->delete()) $deleted++;
                                else $delete_refused++;
                        }

                        // 2. create all new desires
                        $added = 0;
                        $existing = 0;
                        // $applicationPlanBranchList = $this->get("application_plan_branch_mfk");
                        $application_plan_branch_arr = explode(",", trim(trim($application_plan_branch_mfk),","));
                        $desire_num = 0;
                        foreach ($application_plan_branch_arr as $applicationPlanBranchId) {
                                if($applicationPlanBranchId)
                                {
                                        $desire_num++;                        
                                        $applicationDesireObj = $this->getApplicationDesireByBranchId($applicationPlanBranchId, $idn, $desire_num, true);
                                        // if($desire_num==5) die("Rafik Debugging : applicationDesireObj = ".var_export($applicationDesireObj,true));
                                        if($applicationDesireObj->is_new) $added++;
                                        else $existing++;
                                        $applicationDesireObj->repareData();
                                }                                
                        }

                        $this->nb_desires = null;

                        $info = "Rafik Debugging : prev = $previous_application_plan_branch_mfk is different than new $application_plan_branch_mfk : existing : $existing, added : $added, deleted : $deleted, delete refused : $delete_refused";
                        $this->setTechnicalNotes($info);
                        // die($info);

                }
                else
                {
                        $warn = "Rafik Debugging : prev = $previous_application_plan_branch_mfk is same than new $application_plan_branch_mfk";
                        $this->setTechnicalNotes($warn);
                        // die($warn);
                        
                }
                

                return ["", $info, $warn];
        }

        public function afterMaj($id, $fields_updated)
        {
                $this->setTechnicalNotes("Application::afterMaj($id, [".implode(",", $fields_updated)."])");
                if ($fields_updated["application_plan_branch_mfk"]) {
                        
                       $this->refreshDesireList(); 
                }
                // else die(var_export($fields_updated,true));
        }

        public function reorderDesires($lang = "ar")
        {
                $this->getMyApplicationDesireList();
                $desire_num = -1;
                $log_arr = [];
                foreach ($this->myApplicationDesireList as $adid => $applicationDesireItem) {
                        $old_desire_num = $this->myApplicationDesireList[$adid]->getVal("desire_num");
                        if ($desire_num < 0) {
                                $desire_num = $old_desire_num;
                                if ($desire_num < 0) $desire_num = 0;
                                if ($desire_num > 1) $desire_num = 1;
                                $step_from = $desire_num;
                        } else $desire_num++;

                        $log_arr[] = "from $old_desire_num to $desire_num";

                        $this->myApplicationDesireList[$adid]->set("desire_num", $desire_num);
                        $this->myApplicationDesireList[$adid]->commit();
                        $step_to = $desire_num;
                }

                // inutile car deja reordonnees ci dessus 
                // $this->getMyApplicationDesireList(true);

                return ["", "reordered from $step_from to $step_to " . implode("<br>\n", $log_arr)];
        }

        public function applyMyCurrentStepConditions($lang="ar", $pbm=true, $simulate=true, $application_simulation_id=0, $logConditionExec=true, $audit_conditions_pass = [], $audit_conditions_fail = [])
        {
                $application_model_id = $this->getVal("application_model_id");
                $application_plan_id = $this->getVal("application_plan_id");
                $step_num = $this->getVal("step_num");
                $general="W";
                $return =  ApplicationStep::applyStepConditionsOn($this, $application_model_id, $application_plan_id, $step_num, $general, $lang, $simulate, $application_simulation_id, $logConditionExec, $audit_conditions_pass, $audit_conditions_fail);
                // die("ApplicationStep::applyStepConditionsOn(this, $application_model_id, $application_plan_id, $step_num, $general, $lang, $simulate, $application_simulation_id, $logConditionExec, audit_conditions_pass=".var_export($audit_conditions_pass, true).", audit_conditions_fail=".var_export($audit_conditions_fail, true).") returned ".var_export($return, true));
                if($pbm) return $return["res"];
                else return $return;
        }



        public function shouldBeCalculatedField($attribute){
                if($attribute=="gender_enum") return true;
                if($attribute=="allow_add_qualification") return true;
                if($attribute=="qualification_mfk") return true;
                if($attribute=="assignedDesire") return true;
                
                if($attribute=="weighted_percentage") return true;
                if($attribute=="weighted_percentage_details") return true;
                if($attribute=="sis_fields_available") return true;
                if($attribute=="sis_fields_not_available") return true;
                if($attribute=="program_offering_mfk") return true;
                if($attribute=="nb_desires") return true;
                if($attribute=="current_fields_matrix") return true;
                return false;
        }

        public function calcAssignedDesire($what="value")
        {
                $application_plan_id = $this->getVal("application_plan_id");
                $applicant_id = $this->getVal("applicant_id");
                $application_simulation_id = $this->getVal("application_simulation_id");
                $obj = ApplicationDesire::loadAssignedDesire($applicant_id, $application_plan_id, $application_simulation_id);

                return ($what=="value") ? $obj->id : $obj;
        }

        public function calcAdmission_history($what="value")
        {
                $application_plan_id = $this->getVal("application_plan_id");
                $applicationPlanObj = $this->het("application_plan_id");
                $application_simulation_id = $this->getVal("application_simulation_id");
                $application_model_id = ApplicationPlan::getApplicationModelId($application_plan_id);
                // $appModelObj = ApplicationModel::loadById($application_model_id);
                // $split_sorting_by_enum = $appModelObj->getVal("split_sorting_by_enum");
                $maxPaths = SortingPath::nbPaths($application_model_id);
                $sortingSessionList = $applicationPlanObj->get("sortingSessionList");
                $sortingGroupList = $this->get("sortingGroupList");
                $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
                $data = [];
                foreach($sortingSessionList as $sortingSessionId => $sortingSessionItem)
                {
                        if($sortingSessionItem->sureIs("started_ind"))
                        {
                                $session_num = $sortingSessionItem->getVal("session_num");
                                foreach($sortingGroupList as $sortingGroupId => $sortingGroupItem)
                                {
                                        for ($spath = 1; $spath <= $maxPaths; $spath++) 
                                        {
                                                list($nb, $final_sorting_table) = SortingSession::hasBeenExecuted($application_plan_id, $application_simulation_id, $session_num, $sortingGroupId, $spath);
                                                if($nb>0)
                                                {
                                                        $data_tmp = AfwDatabase::db_recup_rows("select $session_num as session_num, $sortingGroupId as sg_id, $spath as spath, st.* from $final_sorting_table st");
                                                        $data = array_merge($data, $data_tmp);
                                                }                                        
                                        }
                                }
                        }
                }


                // @todo : show result as html or other depending on $what parameter
                
        }
}

