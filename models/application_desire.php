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


        /**
         * @var Applicant $applicantObj
         */
        private $applicantObj = null;

        public function __construct()
        {
                parent::__construct("application_desire", "id", "adm");
                AdmApplicationDesireAfwStructure::initInstance($this);
        }

        public function getApplicationPlan()
        {
                if (!$this->objApplicationPlan) $this->objApplicationPlan = ApplicationPlan::loadById($this->getVal("application_plan_id"));
                return $this->objApplicationPlan;
        }


        public function setApplicationObject(&$applicationObj)
        {
                $this->applicationObj = $applicationObj;
        }

        public function getApplicationObject()
        {
                if (!$this->applicationObj) 
                {
                     $applicant_id = $this->getVal("applicant_id");   
                     $application_plan_id = $this->getVal("application_plan_id");   
                     $application_simulation_id = $this->getVal("application_simulation_id");   

                     $this->applicationObj = Application::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id);
                }
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


        public static function getApplicantsDesiresMatrix($application_plan_id, $application_simulation_id, $sortingGroupId, $track_num, $onlyForUpgrade=false)
        {
                $server_db_prefix = AfwSession::currentDBPrefix();

                if($onlyForUpgrade)
                {
                        $onlyForUpgradeSQL = "AND desire_status_enum = 7";
                }
                else
                {
                        $onlyForUpgradeSQL = "";
                }
                
                $sql_matrix = "SELECT applicant_id, desire_num, application_plan_branch_id
                                FROM ".$server_db_prefix."adm.application_desire
                                WHERE application_plan_id = $application_plan_id 
                                AND application_simulation_id = $application_simulation_id 
                                AND sorting_group_id = $sortingGroupId
                                AND track_num = $track_num
                                $onlyForUpgradeSQL
                                AND active = 'Y'
                                ORDER BY applicant_id, desire_num, application_plan_branch_id";
                
                return AfwDatabase::db_recup_bi_index($sql_matrix, "applicant_id", "desire_num", "application_plan_branch_id");                                
        }

        public static function getSimpleApplicantsDesiresMatrix($application_plan_id, $application_simulation_id, $where="1")
        {
                $server_db_prefix = AfwSession::currentDBPrefix();
                $application_table = $server_db_prefix."adm.application";

                // << updated_at asc >> below is because amjad at 17/07/2025 in whatsapp voice-message
                // has requested that for upgrade sorting if execo applicants we prior the one who  
                // has requested the upgrade before (oldest update date)
                $sql_matrix = "SELECT applicant_id, application_plan_branch_mfk
                                FROM $application_table
                                WHERE application_plan_id = $application_plan_id 
                                  AND application_simulation_id = $application_simulation_id                                   
                                  AND active = 'Y'
                                  AND $where
                                ORDER BY weighted_pctg desc, updated_at asc";



                $rows_matrix = AfwDatabase::db_recup_rows($sql_matrix);                  

                $result_rows = [];

                foreach($rows_matrix as $row_matrix)
                {
                        $result_rows[$row_matrix["applicant_id"]] = self::mfkValueToOrderedList($row_matrix["application_plan_branch_mfk"], $start_from=1);
                }

                return $result_rows;
        }

        public static function loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id, $desire_num)
        {
                // should not be able to insert but the insert is to be done by loadByBigIndex as it have the full attribute values
                $create_obj_if_not_found = false;

                if (!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
                if (!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");
                if (!$application_simulation_id) throw new AfwRuntimeException("loadByMainIndex : application_simulation_id is mandatory field");
                if (!$desire_num) throw new AfwRuntimeException("loadByMainIndex : desire_num is mandatory field");


                $obj = new ApplicationDesire();
                $obj->select("applicant_id", $applicant_id);
                $obj->select("application_plan_id", $application_plan_id);
                $obj->select("application_simulation_id", $application_simulation_id);
                $obj->select("desire_num", $desire_num);

                if ($obj->load()) {
                        if ($create_obj_if_not_found) {

                                $obj->activate();
                        }
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        $obj->set("applicant_id", $applicant_id);
                        $obj->set("application_plan_id", $application_plan_id);
                        $obj->set("application_simulation_id", $application_simulation_id);
                        $obj->set("desire_num", $desire_num);
                        $obj->insertNew();
                        if (!$obj->id) return null; // means beforeInsert rejected insert operation
                        $obj->is_new = true;
                        return $obj;
                } else return null;
        }

        public static function loadAllAssignedDesire($application_plan_id, $application_simulation_id)
        {
                if (!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");
                if (!$application_simulation_id) throw new AfwRuntimeException("loadByMainIndex : application_simulation_id is mandatory field");

                $statuses = [];
                $statuses[] = self::desire_status_enum_by_code('initial-acceptance');
                $statuses[] = self::desire_status_enum_by_code('final-acceptance');
                $statuses[] = self::desire_status_enum_by_code('rejected-acceptance');

                $obj = new ApplicationDesire();
                $obj->select("application_plan_id", $application_plan_id);
                $obj->select("application_simulation_id", $application_simulation_id);
                $obj->selectIn("desire_status_enum", $statuses);

                return $obj->loadMany();
        }

        public static function countSortedDesires($applicant_id, $application_plan_id, $application_simulation_id)
        {
                if (!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
                if (!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");
                if (!$application_simulation_id) throw new AfwRuntimeException("loadByMainIndex : application_simulation_id is mandatory field");


                $obj = new ApplicationDesire();
                $obj->select("applicant_id", $applicant_id);
                $obj->select("application_plan_id", $application_plan_id);
                $obj->select("application_simulation_id", $application_simulation_id);

                $statuses = [];
                $statuses[] = self::desire_status_enum_by_code('initial-acceptance');
                $statuses[] = self::desire_status_enum_by_code('final-acceptance');
                $statuses[] = self::desire_status_enum_by_code('rejected-acceptance');
                $statuses[] = self::desire_status_enum_by_code('higher-desire');
                $statuses[] = self::desire_status_enum_by_code('not-achieved');

                $obj->selectIn("desire_status_enum", $statuses);

                return $obj->count();
        }

        public static function loadAssignedDesire($applicant_id, $application_plan_id, $application_simulation_id)
        {
                if (!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
                if (!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");
                if (!$application_simulation_id) throw new AfwRuntimeException("loadByMainIndex : application_simulation_id is mandatory field");

                $statuses = [];
                $statuses[] = self::desire_status_enum_by_code('initial-acceptance');
                $statuses[] = self::desire_status_enum_by_code('final-acceptance');
                $statuses[] = self::desire_status_enum_by_code('rejected-acceptance');

                $obj = new ApplicationDesire();
                $obj->select("applicant_id", $applicant_id);
                $obj->select("application_plan_id", $application_plan_id);
                $obj->select("application_simulation_id", $application_simulation_id);
                $obj->selectIn("desire_status_enum", $statuses);

                if ($obj->load()) {
                        return $obj;
                }
                else return null;
        }



        public static function loadFinalAcceptanceDesire($applicant_id, $application_plan_id, $application_simulation_id)
        {
                if (!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
                if (!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");
                if (!$application_simulation_id) throw new AfwRuntimeException("loadByMainIndex : application_simulation_id is mandatory field");


                $obj = new ApplicationDesire();
                $obj->select("applicant_id", $applicant_id);
                $obj->select("application_plan_id", $application_plan_id);
                $obj->select("application_simulation_id", $application_simulation_id);
                $obj->select("desire_status_enum", self::desire_status_enum_by_code('final-acceptance'));

                if ($obj->load()) {
                        return $obj;
                }
                else return null;
        }

        public static function loadInitialAcceptanceDesire($applicant_id, $application_plan_id, $application_simulation_id)
        {
                if (!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
                if (!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");
                if (!$application_simulation_id) throw new AfwRuntimeException("loadByMainIndex : application_simulation_id is mandatory field");


                $obj = new ApplicationDesire();
                $obj->select("applicant_id", $applicant_id);
                $obj->select("application_plan_id", $application_plan_id);
                $obj->select("application_simulation_id", $application_simulation_id);
                $obj->select("desire_status_enum", self::desire_status_enum_by_code('initial-acceptance'));

                if ($obj->load()) {
                        return $obj;
                }
                else return null;
        }

        public static function getInitialAcceptanceApplicantIds($application_plan_id, $application_simulation_id)
        {
                $server_db_prefix = AfwSession::currentDBPrefix();
                $initial_acceptance = self::desire_status_enum_by_code('initial-acceptance');
                $sql = "SELECT applicant_id, desire_num
                                FROM ".$server_db_prefix."adm.application_desire
                                WHERE application_plan_id = $application_plan_id 
                                  AND application_simulation_id = $application_simulation_id                                   
                                  AND desire_status_enum = $initial_acceptance
                                  AND active = 'Y'";

                return AfwDatabase::db_recup_rows($sql);
        }

        /**
         * 
         * @param Application $applicationObj
         */

        public static function loadByBigIndex($applicant_id, $application_plan_id, $application_simulation_id, $application_plan_branch_id, $idn='', $create_obj_if_not_found=false, $applicationObj=null, $desire_num=0)
        {
                if (!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
                if (!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");
                if (!$application_simulation_id) throw new AfwRuntimeException("loadByMainIndex : application_simulation_id is mandatory field");
                if (!$application_plan_branch_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_branch_id is mandatory field");

                if(!$desire_num) $desire_num = $applicationObj->getRelation("applicationDesireList")->func("max(desire_num)") + 1;

                $obj = new ApplicationDesire();
                $obj->select("applicant_id", $applicant_id);
                $obj->select("application_plan_id", $application_plan_id);
                $obj->select("application_simulation_id", $application_simulation_id);
                $obj->select("application_plan_branch_id", $application_plan_branch_id);
                if ($obj->load()) {
                        if ($create_obj_if_not_found) {
                                $obj->set("desire_num", $desire_num);
                                $obj->set("idn", $idn);
                                $applicationPlanBranchObj = $obj->het("application_plan_branch_id");
                                $applicationModelBranchObj = $applicationPlanBranchObj->het("application_model_branch_id");
                                $obj->set("application_model_branch_id", $applicationModelBranchObj->id);
                                if (!$applicationModelBranchObj)  throw new AfwRuntimeException("loadByMainIndex : application_plan_branch_id $application_plan_branch_id doesn't have an application_model_branch_id");
                                $obj->set("sorting_group_id", $applicationModelBranchObj->getVal("sorting_group_id",));
                                $obj->set("applicant_qualification_id", $applicationObj->getVal("applicant_qualification_id"));
                                $obj->set("qualification_id", $applicationObj->getVal("qualification_id"));
                                $obj->set("major_category_id", $applicationObj->getVal("major_category_id"));
                                $obj->activate();
                        }
                        return $obj;
                } elseif ($create_obj_if_not_found and $applicationObj) {
                        
                        $obj->set("applicant_id", $applicant_id);
                        $obj->set("application_plan_id", $application_plan_id);
                        $obj->set("application_simulation_id", $application_simulation_id);
                        $obj->set("application_plan_branch_id", $application_plan_branch_id);
                        $applicationPlanBranchObj = $obj->het("application_plan_branch_id");
                        $applicationModelBranchObj = $applicationPlanBranchObj->het("application_model_branch_id");
                        $obj->set("application_model_branch_id", $applicationModelBranchObj->id);
                        if (!$applicationModelBranchObj)  throw new AfwRuntimeException("loadByMainIndex : application_plan_branch_id $application_plan_branch_id doesn't have an application_model_branch_id");

                        $obj->set("sorting_group_id", $applicationModelBranchObj->getVal("sorting_group_id",));
                        $obj->set("applicant_qualification_id", $applicationObj->getVal("applicant_qualification_id"));
                        $obj->set("qualification_id", $applicationObj->getVal("qualification_id"));
                        $obj->set("major_category_id", $applicationObj->getVal("major_category_id"));
                        $obj->set("desire_num", $desire_num);
                        $obj->set("idn", $idn);
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


        public function fieldsMatrixForStep($stepNum, $lang = "ar", $onlyIfTheyAreUpdated = false)
        {
                $this->getApplicationObject();
                if (!$this->applicationObj) throw new AfwRuntimeException("Can't retrieve fields matrix without any application defined");

                $objApplicationModel = $this->getApplicationPlan()->getApplicationModel();
                if (!$objApplicationModel) throw new AfwRuntimeException("Can't retrieve fields matrix without any Application Model defined");

                list($applicantFieldsArr, $applicationFieldsArr, $applicationDesireFieldsArr) = $objApplicationModel->getAppModelFieldsOfStep($stepNum, true);


                $fieldsMatrix_0 = $this->applicationObj->getApplicant()->getFieldsMatrix($applicantFieldsArr, $lang, $this->applicationObj, $onlyIfTheyAreUpdated);
                $fieldsMatrix_1 = $this->applicationObj->getFieldsMatrix($applicationFieldsArr, $lang, $onlyIfTheyAreUpdated);
                $fieldsMatrix_2 = $this->getFieldsMatrix($applicationDesireFieldsArr, $lang, $onlyIfTheyAreUpdated);

                if ($onlyIfTheyAreUpdated) return ($fieldsMatrix_0 and $fieldsMatrix_1 and $fieldsMatrix_2);

                $fieldsMatrix = array_merge($fieldsMatrix_0, $fieldsMatrix_1, $fieldsMatrix_2);

                return $fieldsMatrix;
        }

        // bootstrap the Desire to step of sorting (Farz)
        public function bootstrapDesire($lang = "ar", $returnLastStepCode = false, $options = [])
        {
                $app_des_name = $this->getDisplay($lang);
                $devMode = AfwSession::config("MODE_DEVELOPMENT", false);
                $dataShouldBeUpdated = (strtolower($options["DATA-SHOULD-BE-UPDATED-BEFORE-APPLY"]) != "off");

                $application_simulation_id = $options["SIMULATION-ID"];
                $audit_conditions_pass = explode(",", $options["AUDIT_ON_PASS_CONDITION_IDS"]);
                $audit_conditions_fail = explode(",", $options["AUDIT_ON_FAIL_CONDITION_IDS"]);
                $simulate = ($application_simulation_id != 2);
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
                        while (($bootstrapStatus != "--blocked") and ($currentStepCode != "SRT") and ($tentatives < $max_tentatives)) {
                                $tentatives++;
                                // refresh data
                                $this->runNeededApis($lang = "ar", ($bootstrapStatus == "--forcing"));
                                // try to go to next step
                                list($err, $inf, $war, $tech, $resultGotoNextDesireStep) = $this->gotoNextDesireStep($lang = "ar", $dataShouldBeUpdated, $simulate, $application_simulation_id, $logConditionExec, $audit_conditions_pass, $audit_conditions_fail);
                                if ($err) {
                                        $err_arr[] = "Error $app_des_name : " . $err;
                                        $bootstrapStatus = "--blocked";
                                } else {
                                        if ($inf) $inf_arr[] = "$app_des_name : " . $inf;
                                        if ($war) $war_arr[] = "$app_des_name : " . $war;
                                        if ($tech) $tech_arr[] = $tech;
                                        $newStepObj = $this->het("application_step_id");
                                        $newStepCode = $newStepObj->getStepCode();

                                        if ($newStepCode == $currentStepCode) {
                                                if ($bootstrapStatus == "--forcing") $bootstrapStatus = "--blocked";
                                                if ($bootstrapStatus == "--trying") $bootstrapStatus = "--forcing";
                                        } else {
                                                $currentStepCode = $newStepCode;
                                                $bootstrapStatus = "--trying";
                                        }
                                }
                        }

                        if (($bootstrapStatus == "--blocked") and ($currentStepCode != "SRT")) {
                                $bootstrapResult = $resultGotoNextDesireStep["result"];
                                if ($bootstrapResult == "pass") throw new AfwRuntimeException("Desire $app_des_name :<br> How can bootstrapResult=$bootstrapResult in step $currentStepCode and bootstrapStatus=$bootstrapStatus");
                                $war_arr[] = $app_des_name . " : " . $this->tm("Desire is faltered, please see details and resolve manually", $lang);
                                $war_arr[] = $app_des_name . " : " . $this->tm("Reached step", $lang) . " : " . $currentStepCode . "<!-- bootstrapStatus$bootstrapStatus tentatives=$tentatives-->";
                        } else {

                                $bootstrapResult = "done";
                                $war_arr[] = $app_des_name . " : " . $this->tm("Sorting step reached", $lang) . "<!-- bootstrapStatus$bootstrapStatus tentatives=$tentatives-->";
                        }
                } catch (Exception $e) {
                        if ($devMode) throw $e;
                        $err_arr[] = $e->getMessage();
                } catch (Error $e) {
                        if ($devMode) throw $e;
                        $err_arr[] = $e->__toString();
                }

                $resPbm = AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);

                if ($returnLastStepCode) return [$currentStepCode, $resPbm, $tentatives, $bootstrapResult];

                return $resPbm;
        }

        public function statusExplanations($lang = "ar")
        {
                $return = $this->getVal("comments");
                if (!$return) $return = $this->tm("unknown, try again");

                return $return;
        }


        public function forceGotoSortingStep($lang = "ar")
        {
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];
                $result_arr = [];
                $objApplicationModel = $this->getApplicationPlan()->getApplicationModel();
                if (!$objApplicationModel) {
                        $err_arr[] = $this->tm("Error happened, no application model defined for this application", $lang);
                } else {
                        $application_step_id = $objApplicationModel->calcSorting_step_id();
                        $this->set("application_step_id", $application_step_id);
                        $currentStepObj = $this->het("application_step_id");
                        $desireStepNum = $currentStepObj->getVal("step_num");
                        $desireStepCode = $currentStepObj->getVal("step_code");
                        $this->set("step_num", $desireStepNum);
                        $this->set("desire_status_enum", self::desire_status_enum_by_code('candidate'));
                        $war = $this->tm("conditions apply skipped", $lang) . " !!";
                        $war_arr[]  = $war;
                        $this->set("comments", $war);
                        $this->commit();
                        $inf_arr[] = $this->tm("quick arrive to sorting step", $lang) . " " . $this->tm("has been successfully done", $lang);
                        $result_arr["STEP_CODE"] = $desireStepCode;
                }

                return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr, $result_arr);
        }

        public function gotoNextDesireStep($lang = "ar", $dataShouldBeUpdated = true, $simulate = true, $application_simulation_id = 0, $logConditionExec = false, $audit_conditions_pass = [], $audit_conditions_fail = [])
        {
                $devMode = AfwSession::config("MODE_DEVELOPMENT", false);
                // die("dbg devMode=$devMode");
                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];
                $result_arr = [];
                $result_arr["result"] = "standby";
                // $nb_updated = 0;
                // $nb_inserted = 0;
                try {

                        $this->getApplicationPlan();
                        if (!$this->objApplicationPlan) return [$this->tm("Error happened, no application plan defined for this application", $lang), ""];

                        /**
                         * @var ApplicationStep $currentStepObj
                         */
                        $currentStepObj = $this->het("application_step_id");
                        $currentStepCode = $currentStepObj->getStepCode();
                        $currentStepNum = $this->getVal("step_num");

                        $dataReady = $this->fieldsMatrixForStep($currentStepNum, "ar", $onlyIfTheyAreUpdated = true);
                        if ($dataShouldBeUpdated and !$dataReady) {
                                $message_war = $this->tm("We can not apply conditions because the data is not updated", $lang);
                                // في حالة الفرز يبقى المتقدم في حالة ترشح الى حين تطبيق الفرز
                                if ($currentStepCode != "SRT") {
                                        $this->set("desire_status_enum", self::desire_status_enum_by_code('data-review'));
                                        $this->set("comments", $message_war);
                                        $this->commit();
                                }


                                return ["", "", $message_war];
                        }
                        $currentStepId = $this->getVal("application_step_id");
                        // die("before currentStepObj=$currentStepObj->id currentStepNum=$currentStepNum currentStepId=$currentStepId");
                        if (!$currentStepObj or !$currentStepObj->id) $currentStepObj = $this->objApplicationPlan->getApplicationModel()->getFirstStep();
                        if (!$currentStepObj) return [$this->tm("No current step defined for this application model, you may need to reorder the steps to have step num=0 or step num = 1", $lang), ""];

                        // to go to next step we should apply conditions of the current step
                        $applyResult = $this->applyMyCurrentStepConditions($lang, false, $simulate, $application_simulation_id, $logConditionExec, $audit_conditions_pass, $audit_conditions_fail);
                        $success = $applyResult['success'];

                        list($error_message, $success_message, $fail_message, $tech) = $applyResult['res'];
                        if ($success and (!$error_message)) {
                                $result_arr["result"] = "pass";
                                $nextStepNum = $this->getApplicationPlan()->getApplicationModel()->getNextStepNumOf($currentStepNum, false);
                                $tech_arr[] = "nextStepNum=$nextStepNum currentStepNum=$currentStepNum";
                                $this->set("step_num", $nextStepNum);
                                $this->set("desire_status_enum", self::desire_status_enum_by_code('candidate'));
                                $newStepObj = $this->getApplicationPlan()->getApplicationModel()->convertStepNumToObject($nextStepNum);
                                $this->set("application_step_id", $newStepObj->id);
                                $newStepCode = $newStepObj->getStepCode();
                                // في حالة الفرز يبقى المتقدم في حالة ترشح الى حين تطبيق الفرز
                                if ($newStepCode != "SRT") {
                                        $message_war = $this->tm("Waiting to apply conditions ...", $lang);
                                } elseif ($newStepCode == "SRT") {
                                        $message_war = $this->tm("Waiting to apply sorting process ...", $lang);
                                }
                                $this->set("comments", $message_war . "<!-- new step : code=$newStepCode/num=$nextStepNum -->");
                                $this->commit();
                                if ($nextStepNum != $currentStepNum) {
                                        $this->requestAPIsOfStep($nextStepNum);
                                }
                                $inf_arr[]  = $this->tm("The move from step", $lang) . " : " . $currentStepObj->getDisplay($lang) . " " . $this->tm("has been successfully done", $lang);
                                $inf_arr[]  = $success_message;
                                $tech_arr[] = $tech;
                        } else {
                                if ((!$error_message) and ($success === false)) 
                                {
                                        $result_arr["result"] = "fail";
                                        $new_status = self::desire_status_enum_by_code('excluded');
                                }
                                else 
                                {
                                        $result_arr["result"] = "standby";
                                        $new_status = self::desire_status_enum_by_code('data-review');
                                }
                                $fail_message .= " " . $error_message;
                                $this->set("desire_status_enum", $new_status);
                                $this->set("comments", $fail_message);
                                $this->commit();
                                $war_arr[]  = $this->tm("The move from step", $lang) . " : " . $currentStepObj->getDisplay($lang) . " " . $this->tm("has failed for the following reason", $lang) . " : ";
                                $war_arr[]  = $fail_message;
                                $tech_arr[] = $tech;
                        }
                } catch (Exception $e) {
                        // if($devMode) throw new AfwRuntimeException("Mode dev so see this : ". $e->getMessage() . " trace : " . $e->getTraceAsString());
                        $err_arr[] = $e->getMessage() . ($devMode ? $e->getTraceAsString() : "");
                } catch (Error $e) {
                        if ($devMode) throw $e;
                        $err_arr[] = $e->__toString();
                }
                return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr, $result_arr);
        }

        public function getDisplay($lang = 'ar')
        {
                return $this->getDefaultDisplay($lang);
        }

        public function stepsAreOrdered()
        {
                return false;
        }

        public function repareData($lang = "ar", $fullRepare=false, $echo=false)
        {
                $is_to_commit = false;
                $lang = AfwLanguageHelper::getGlobalLanguage();

                if($fullRepare)
                {
                        if (!$this->applicantObj) $this->applicantObj = $this->het("applicant_id");
                        if ($this->applicantObj) 
                        {
                                $this->applicantObj->runNeededApis($lang, true, $echo);
                        }
                }

                $step_num = $this->getVal("step_num");
                if ((!$step_num) or ($step_num == "0")) {
                        $objStep = $this->het("application_step_id");
                        if(!$objStep) $objStep = $this->getApplicationPlan()->getApplicationModel()->getFirstDesireStep();
                        if ($objStep) {
                                $this->set("step_num", $objStep->getVal("step_num"));
                                $this->set("application_step_id", $objStep->id);
                                $is_to_commit = true;
                        } else {
                                AfwSession::pushWarning($this->getDisplay($lang) . " : " . $this->tm("All steps are general & There are no special steps to be the path of application desires", $lang));
                        }
                } else {
                        $objStep = $this->het("application_step_id");
                        if ($objStep and ($objStep->getVal("step_num") != $this->getVal("step_num"))) {
                                $this->set("step_num", $objStep->getVal("step_num"));
                                $is_to_commit = true;
                        }
                }

                $desire_status_enum = $this->getVal("desire_status_enum");
                if ((!$desire_status_enum) or ($desire_status_enum == "0")) {
                        $this->set("desire_status_enum", 1);
                        $is_to_commit = true;
                }

                if (!$this->getVal("application_model_branch_id")) {
                        $applicationPlanBranchObj = $this->het("application_plan_branch_id");
                        $applicationModelBranchObj = $applicationPlanBranchObj->het("application_model_branch_id");
                        if ($applicationModelBranchObj) {
                                $this->set("application_model_branch_id", $applicationModelBranchObj->id);
                                $is_to_commit = true;
                        }
                }


                if ($this->sortingCritereaNeedRefresh()) {
                        if($echo) AfwBatch::print_debugg("sorting Criterea Need Refresh");
                        $this->reComputeSortingCriterea($lang, false, $echo);
                        $is_to_commit = true;
                }


                if ($is_to_commit) $this->commit();
        }

        protected function getPublicMethods()
        {

                $pbms = array();


                $currentStepNum = $this->getVal("step_num");
                $nextStepNum = $currentStepNum + 1;
                $objApplicationModel = $this->getApplicationPlan()->getApplicationModel();
                //$objFirstStep = $objApplicationModel->getFirstDesireStep();
                if ($objApplicationModel) {
                        
                        $color = "blue";
                        $title_ar = $this->tm("Compute sorting criterea", 'ar');
                        $title_en = $this->tm("Compute sorting criterea", 'en');
                        $methodName = "reComputeSortingCriterea";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                                "METHOD" => $methodName,
                                "COLOR" => $color,
                                "LABEL_AR" => $title_ar,
                                "LABEL_EN" => $title_en,
                                "PUBLIC" => true,
                                "BF-ID" => "",
                                'STEP' => 6
                        );

                        $asObj = ApplicationStep::loadByMainIndex($objApplicationModel->id, $nextStepNum);
                        if ($asObj) {
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
                                        'STEP' => 3
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
                                        'STEP' => 2
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
                                        'STEP' => 2
                                );
                        }


                        $color = "yellow";
                        $title_ar = $this->tm("Repare data", 'ar');
                        $title_en = $this->tm("Repare data", 'en');
                        $methodName = "repareData";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                                "METHOD" => $methodName,
                                "COLOR" => $color,
                                "LABEL_AR" => $title_ar,
                                "LABEL_EN" => $title_en,
                                "PUBLIC" => true,
                                "BF-ID" => "",
                                'STEP' => 2
                        );
                } else die("no ApplicationModel for this desire");

                return $pbms;
        }



        public function beforeDelete($id, $id_replace)
        {
                /* we should allow delete desire in all cases only if farz has started
                   because application_plan_branch_mfk change trigger delete of some desires and add of others
                $server_db_prefix = AfwSession::config("db_prefix", "uoh_");
                $objFirstStep = $this->getApplicationPlan()->getApplicationModel()->getFirstDesireStep();
                $first_step_num = $objFirstStep ? $objFirstStep->getVal("step_num") : 9999;
                $desire_status_enum = $this->getVal("desire_status_enum");
                $application_simulation_id = $this->getVal("application_simulation_id");
                $step_num = $this->getVal("step_num");
                if ((($step_num > $first_step_num) or ($desire_status_enum > 1)))  // ($application_simulation_id == 2) and 
                {
                        $this->deleteNotAllowedReason = "الرغبة أخذت طريقها في مسار التقديم يمكن فقط الغاء التقديم (الانسحاب) وليس حذفها بالكامل أو يمكنكم التواصل مع المشرف";
                        return false;
                }*/

                if (!$id) {
                        $id = $this->getId();
                        $simul = true;
                } else {
                        $simul = false;
                }

                if ($id) {
                        if ($id_replace == 0) {
                                // FK part of me - not deletable 


                                // FK part of me - deletable 


                                // FK not part of me - replaceable 



                                // MFK

                        } else {
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
                $program_track_id = ($what == "value") ? 0 : (($what == "object") ? null :"all");
                $branchObj = $this->het("application_plan_branch_id");
                if (!$branchObj) return $program_track_id;
                $programObj = $branchObj->het("program_id");
                if ($programObj) {
                        $program_track_id = ($what == "value") ? $programObj->getVal("program_track_id") : (($what == "object") ? $programObj->het("program_track_id") : $programObj->decode("program_track_id"));
                }

                return $program_track_id;
        }

        public function calcNeeded_docs_available($what = "value")
        {
                list($yes, $no) = AfwLanguageHelper::translateYesNo($what);
                $objProgramTrack = $this->calcProgram_track_id("object");
                if (!$this->applicantObj) $this->applicantObj = $this->het("applicant_id");
                
                $required_doc_type_arr = explode(",",trim($objProgramTrack->getVal("doc_type_mfk"),","));
                foreach($required_doc_type_arr as $required_doc_type_id)
                {
                      if(!$this->applicantObj->getAttachedFileWithType($required_doc_type_id)) return $no;
                }
                return $yes;                 
        }



        

        public function calcTrackAndMajorPath()
        {
                /**
                 * @var ApplicantQualification $applicantQualificationObj
                 */
                $applicantQualificationObj = $this->het("applicant_qualification_id");
                if (!$applicantQualificationObj) {
                        $applicantQualificationObj = $this->getApplicationObject()->het("applicant_qualification_id");
                }
                $major_path_id = 0;
                $major_path_name = "all";
                $program_track_id = $this->calcProgram_track_id();
                $program_track_name = $this->calcProgram_track_id("decode");
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

                $return = $this->applicantObj->weighted_percentage($what, $program_track_id, $major_path_id, $applicantQualificationObj);

                if ($what != "value") {
                        $return_value = $this->applicantObj->weighted_percentage("value", $program_track_id, $major_path_id, $applicantQualificationObj);
                } else $return_value = $return;

                if (!$return_value) {
                        $return = $this->getApplicationObject()->calcWeighted_percentage($what);
                }

                return $return;
        }


        public function applyMyCurrentStepConditions($lang = "ar", $pbm = true, $simulate = true, $application_simulation_id = 0, $logConditionExec = false, $audit_conditions_pass = [], $audit_conditions_fail = [])
        {
                $objApplicationModel = $this->getApplicationPlan()->getApplicationModel();
                if (!$objApplicationModel) {
                        if ($pbm) return ["Strange Error : no ApplicationModel object for this desire"];
                        else return [];
                }
                $application_model_id = $objApplicationModel->id;
                $application_plan_id = $this->getVal("application_plan_id");
                $step_num = $this->getVal("step_num");
                $general = "N";
                $return =  ApplicationStep::applyStepConditionsOn($this, $application_model_id, $application_plan_id, $step_num, $general, $lang, $simulate, $application_simulation_id, $logConditionExec, $audit_conditions_pass, $audit_conditions_fail);

                if ($pbm) return $return["res"];
                else return $return;
        }

        public function getFieldUpdateDate($field_name, $lang = "ar")
        {
                return $this->getApplicationObject()->getFieldUpdateDate($field_name, $lang, $application_table_id = 2);
        }


        public function runOnlyNeedUpdateApis($lang = "ar")
        {
                return $this->getApplicationObject()->runOnlyNeedUpdateApis($lang);
        }

        public function runNeededApis($lang = "ar", $force = true)
        {
                return $this->getApplicationObject()->runNeededApis($lang, $force);
        }

        public function getFieldExpiryDuration($field_name)
        {
                return $this->getApplicationPlan()->getApplicationModel()->getFieldExpiryDuration($field_name, $application_table_id = 2);
        }

        public function requestAPIsOfStep($nextStepNum)
        {
                return $this->getApplicationObject()->requestAPIsOfStep($nextStepNum);
        }

        public function beforeMaj($id, $fields_updated)
        {
                $objApplicant = null;
                $objApplicationModel = null;
                $objApplicationPlanBranch = null;
                $objProgram = null;
                if ($fields_updated["applicant_id"] or !$this->getVal("idn")) {
                        if (!$objApplicant) $objApplicant = $this->het("applicant_id");
                        if ($objApplicant) {
                                $this->set("idn", $objApplicant->getVal("idn"));
                                $fields_updated["idn"] = "@WasEmpty";
                        }
                }

                if ($fields_updated["applicant_id"] or !$this->getVal("gender_enum")) {
                        if (!$objApplicant) $objApplicant = $this->het("applicant_id");
                        if ($objApplicant) {
                                $this->set("gender_enum", $objApplicant->getVal("gender_enum"));
                        }
                }

                if ($fields_updated["application_plan_id"] or !$this->getVal("application_model_id") or !$this->getVal("academic_level_id")) {
                        if (!$objApplicationModel) $objApplicationModel = $this->getApplicationPlan()->getApplicationModel();
                        if ($objApplicationModel) {
                                $this->set("application_model_id", $objApplicationModel->id);
                                $this->set("academic_level_id", $objApplicationModel->getVal("academic_level_id"));
                        }
                }

                if ($fields_updated["application_plan_branch_id"] or !$this->getVal("training_unit_type_id") or !$this->getVal("training_unit_id")) {
                        if (!$objApplicationPlanBranch) $objApplicationPlanBranch = $this->het("application_plan_branch_id");
                        if ($objApplicationPlanBranch) {
                                $this->set("training_unit_id", $objApplicationPlanBranch->getVal("training_unit_id"));
                                if (!$objProgram) $objProgram = $objApplicationPlanBranch->het("program_id");
                                if ($objProgram) {
                                        $this->set("training_unit_type_id", $objProgram->getVal("college_id"));
                                }
                        }
                }



                if ($fields_updated["step_num"]) $this->requestAPIsOfStep($this->getVal("step_num"));
                if ($fields_updated["step_num"] or (!$this->getVal("application_step_id"))) {
                        if (!$objApplicationModel) $objApplicationModel = $this->getApplicationPlan()->getApplicationModel();
                        if ($objApplicationModel) {
                                if ($this->getVal("step_num")) {
                                        $appStepObj = $objApplicationModel->convertStepNumToObject($this->getVal("step_num"));
                                } else {
                                        $appStepObj = $objApplicationModel->getFirstDesireStep();
                                }

                                if ($appStepObj) {
                                        $application_step_id = $appStepObj->id;
                                        $application_step_num = $appStepObj->getVal("step_num");
                                        $this->set("application_step_id", $application_step_id);
                                        $this->set("step_num", $application_step_num);
                                }
                        } else {
                                AfwSession::pushError($this->getDisplay("en") . " : Application Model Not Found : " . $this->getVal("application_model_id"));
                        }
                }
                return true;
        }

        public function afterMaj($id, $fields_updated)
        {
                if ($fields_updated["application_step_id"]) {
                        $objApplicationModel = $this->getApplicationPlan()->getApplicationModel();
                        if($this->isSynchronisedUniqueDesire())
                        {
                                $stepObj = $this->het("application_step_id");
                                $this->getApplicationObject()->forceGotoStep($stepObj, "because isSynchronisedUniqueDesire");
                        }
                        $sorting_application_step_id = $objApplicationModel->calcSorting_step_id();
                        
                        if ($this->getVal("application_step_id") == $sorting_application_step_id) {
                                if ($this->sortingCritereaNeedRefresh()) {
                                        $this->reComputeSortingCriterea("en");
                                }
                        }
                }
        }



        public function select_visibilite_horizontale($dropdown = false)
        {
                $objme = AfwSession::getUserConnected();

                if ($objme and $objme->isAdmin()) {
                        // no VH for system admin
                } else {
                        $scopeList = self::getAuthenticatedUserScopeList();
                        $scopeSQL = EmployeeScope::scopeListToSQL($scopeList);
                        if ($scopeSQL) $this->where($scopeSQL);
                }

                $selects = array();
                $this->select_visibilite_horizontale_default($dropdown, $selects);
        }

        protected function afterSetAttribute($attribute)
        {
                /*
                if(($attribute == "application_plan_branch_id") and ($this->getVal("application_plan_branch_id")==65))
                {
                        throw new AfwRuntimeException("Here our mochkel");
                }*/
        }

        protected function beforeSetAttribute($attribute, $newvalue)
        {
                $oldvalue = $this->getVal($attribute);

                if (($attribute == "step_num") and ($oldvalue == 5) and ($newvalue == 4)) {
                        throw new AfwRuntimeException("ApplicationDesire :: before set attribute $attribute from '$oldvalue' to '$newvalue'");
                }

                return true;
        }


        public function shouldBeCalculatedField($attribute){
                if($attribute=="sorting_field_1_id") return true;
                if($attribute=="sorting_field_2_id") return true;
                if($attribute=="sorting_field_3_id") return true;
                if($attribute=="applicant_decision_enum") return true;
                if($attribute=="formula_field_1_id") return true;
                if($attribute=="formula_field_2_id") return true;
                if($attribute=="formula_field_3_id") return true;
                if($attribute=="formula_field_4_id") return true;
                if($attribute=="formula_field_5_id") return true;
                if($attribute=="formula_field_6_id") return true;
                if($attribute=="formula_field_7_id") return true;
                if($attribute=="formula_field_8_id") return true;
                if($attribute=="formula_field_9_id") return true;
                if($attribute=="weighted_percentage") return true;
                if($attribute=="weighted_percentage_details") return true;
                if($attribute=="current_fields_matrix") return true;
                if($attribute=="secondary_cumulative_pct") return true;
                if($attribute=="aptitude_score") return true;
                if($attribute=="achievement_score") return true;
                return false;
        }




        
        public function calcSecondary_cumulative_pct($what = "value")
        {
                $objSQ = null;
                $objApplicant = $this->het("applicant_id");
                return $objApplicant->calcSecondary_cumulative_pct($what = "value", $objSQ);
        }

        public function calcAptitude_score($what = "value")
        {
                $objApplicant = $this->het("applicant_id");
                return $objApplicant->calcAptitude_score($what);
        }

        public function calcAchievement_score($what = "value")
        {
                $objApplicant = $this->het("applicant_id");
                return $objApplicant->calcAchievement_score($what);
        }

        public function sortingCritereaNeedRefresh()
        {
                if (!$this->getVal("track_num")) return true;
                if(!$this->getVal("sorting_group_id")) return false;
                $sortingCriterea = SortingGroup::loadSortingCriterea($this->getVal("sorting_group_id"));
                for ($i = 1; $i <= 3; $i++) {
                        if ($sortingCriterea["c$i"]) {
                                if (!$this->getVal("sorting_value_$i")) return true;
                        }
                }

                for ($f = 1; $f <= 9; $f++) {
                        if ($sortingCriterea["f$f"]) {
                                if (!$this->getVal("formula_value_$f")) return true;
                        }
                }

                

                return false;
        }

        public static function checkWeightedPercentageErrors($application_plan_id, $application_simulation_id, $pct, $what="value")
        {
                global $MODE_BATCH_LOURD;
                $old_MODE_BATCH_LOURD = $MODE_BATCH_LOURD;
                $MODE_BATCH_LOURD = true;


                $examples = "";
                $errors = 0;
                $obj = new ApplicationDesire();
                $obj->select("application_plan_id", $application_plan_id);
                $obj->select("application_simulation_id",$application_simulation_id);
                $obj->select("active", 'Y');
                $obj->select("desire_num", 1);
                $obj->where("applicant_id % 100 < $pct");

                $objList = $obj->loadMany();
                /**
                 * @var Application $objItem
                 */
                $current_applicant_id = 0;
                foreach($objList as $objItem)
                {
                        if($current_applicant_id != $objItem->getVal("applicant_id"))
                        {
                                $wpCalculated = $objItem->calcWeighted_percentage(); 
                                $wpStored = $objItem->getVal("sorting_value_1");
                                $current_applicant_id = $objItem->getVal("applicant_id");
                                if(abs($wpCalculated-$wpStored)>=0.01) 
                                {
                                        $errors++;
                                        if(strlen($examples)<256) $examples .= "AD1-$current_applicant_id (Calculated=$wpCalculated-Stored=$wpStored)>";
                                }
                                
                        }
                        else
                        {
                                // if same applicant skip
                        }
                }

                $MODE_BATCH_LOURD = $old_MODE_BATCH_LOURD;
                AfwQueryAnalyzer::resetQueriesExecuted();


                if($what=="value") return $errors;
                else return $examples;
        }

        public static function refreshWeightedPctgForAllApplicantDesires($applicant_id, $application_plan_id, $application_simulation_id, $wp)
        {
                $sets_arr = [];
                $sets_arr["sorting_value_1"] = $wp;
                $where_clause = "applicant_id=$applicant_id and application_plan_id=$application_plan_id and application_simulation_id=$application_simulation_id";
                ApplicationDesire::updateWhere($sets_arr, $where_clause,true);
        }

        public function reComputeSortingCriterea($lang = "ar", $commit = true)
        {
                $applicationPlanObj = $this->getApplicationPlan();
                $application_model_id = $applicationPlanObj->getVal("application_model_id");
                $applicant_id = $this->getVal("applicant_id");
                $sorting_group_id = $this->getVal("sorting_group_id");
                if($sorting_group_id)
                {
                        $sortingCriterea = SortingGroup::loadSortingCriterea($sorting_group_id);
                        for ($i = 1; $i <= 3; $i++) {
                                if ($sortingCriterea["c$i"]) {
                                        $field_name = $sortingCriterea["c$i"]["field_name"];
                                        // $field_sens = $sortingCriterea["c$i"]["field_sens"];
                                        $field_method = $sortingCriterea["c$i"]["field_method"];

                                        $value = $this->$field_method($field_name);
                                        $this->set("sorting_value_$i", $value);
                                }
                        }

                        for ($f = 1; $f <= 9; $f++) {
                                if ($sortingCriterea["f$f"]) {
                                        $field_name = $sortingCriterea["f$f"]["field_name"];
                                        $field_method = $sortingCriterea["f$f"]["field_method"];                                
                                        $value = $this->$field_method($field_name);
                                        if (!$value) $value = 0; // throw new AfwRuntimeException("for applicant_id=$applicant_id reComputeSortingCriterea :: this->$field_method($field_name) return nothing");
                                        $this->set("formula_value_$f", $value);
                                } else {
                                        if ($f <= 3) die("reComputeSortingCriterea :: sortingCriterea = " . var_export($sortingCriterea, true));
                                }
                        }
                }

                
                // $applicationModelBranchObj = $applicationPlanBranchObj->het("application_model_branch_id");
                list($program_track_id, $major_path_id, $applicantQualificationObj, $program_track_name, $major_path_name) = $this->calcTrackAndMajorPath();
                
                $track_num = SortingPath::majorPathIdTrack($application_model_id, $major_path_id);
                if(!$track_num) 
                {
                        $track_num = 1;
                        // die("For applicant_id=$applicant_id : track_num = $track_num = SortingPath::majorPathIdTrack(application_model_id=$application_model_id, major_path_id=$major_path_id)");
                }
                $this->set("track_num", $track_num);
                if($this->sortingCritereaNeedRefresh()) $war = "sorting Criterea was Needing Refresh";
                else $war = "sorting Criterea wasnt Needing Refresh";
                if ($commit) $this->commit();

                return ["", $this->translate("done", $lang), $war];
        }


        public static function upgradeApplicantTo($application_plan_id, $application_simulation_id, $applicant_id, $application_plan_branch_id_desired, $desire_num, $branchsCapacityMatrix)
        {
                $objCurrentDesireToFree = ApplicationDesire::loadFinalAcceptanceDesire($applicant_id, $application_plan_id, $application_simulation_id);
                $application_plan_branch_id_to_free = $objCurrentDesireToFree->getVal("application_plan_branch_id");
                $objDesireToUpgrade = ApplicationDesire::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id, $desire_num);
                $objApplication = Application::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id);
                // check by security if mistake abort the upgrade and not continue
                if($objApplication and ($objDesireToUpgrade->getVal("application_plan_branch_id") == $application_plan_branch_id_desired))
                {
                        if($branchsCapacityMatrix[$application_plan_branch_id_desired]>0)
                        {
                                $branchsCapacityMatrix[$application_plan_branch_id_desired]--;
                                $branchsCapacityMatrix[$application_plan_branch_id_to_free]++;
                                $objApplication->set("application_status_enum", self::application_status_enum_by_code('accepted'));
                                $objDesireToUpgrade->set("desire_status_enum", self::desire_status_enum_by_code('final-acceptance'));
                                $objCurrentDesireToFree->set("desire_status_enum", self::desire_status_enum_by_code('higher-desire'));

                                $objApplication->notifyDesireAssign($application_plan_branch_id_desired, $desire_num, "upgradeSorting");
                        }
                        
                }

                
                return $branchsCapacityMatrix;
        }

        public function attributeIsApplicable($attribute)
        {
                for ($f = 1; $f <= 9; $f++) {
                        if (($attribute == "formula_field_" . $f . "_id") or ($attribute == "formula_value_" . $f)) {
                                return ($this->getVal("formula_field_" . $f . "_id") > 0);
                        }
                }

                if ($attribute == "applicant_decision_enum") 
                {
                        return (($this->getVal("desire_status_enum") == self::desire_status_enum_by_code('initial-acceptance')) or
                                ($this->getVal("desire_status_enum") == self::desire_status_enum_by_code('final-acceptance')) or
                                ($this->getVal("desire_status_enum") == self::desire_status_enum_by_code('rejected-acceptance')));
                }

                return true;
        }

        public function getAttributeLabel($attribute, $lang = 'ar', $short = false)
        {

                for ($s = 1; $s <= 3; $s++) {
                        if ($attribute == "sorting_value_" . $s) {
                                $objFld = $this->het("sorting_field_" . $s . "_id");
                                if($objFld) return $objFld->getShortDisplay($lang);
                        }
                }

                for ($f = 1; $f <= 9; $f++) {
                        if ($attribute == "formula_value_" . $f) {
                                $objFld = $this->het("formula_field_" . $f . "_id");
                                if($objFld) return $objFld->getShortDisplay($lang);
                        }
                }

                // die("calling getAttributeLabel($attribute, $lang, short=$short)");
                return AfwLanguageHelper::getAttributeTranslation($this, $attribute, $lang, $short);
        }

        public function dataIsCompleted()
        {
                list($is_ok, $dataErr) = $this->isOk(true, true);
                if (!$is_ok) return [false, implode("<br>\n", $dataErr)];
                else {
                        $currentStepNum = $this->getVal("step_num");
                        if($currentStepNum>=6) return [true, ""];
                        return [false, "please continue in application process your are in step $currentStepNum/6"];
                }
        }

        public function isSynchronisedUniqueDesire()
        {                
                return ($this->getApplicationPlan()->getApplicationModel()->isSynchronisedUniqueDesire());
        }
}
