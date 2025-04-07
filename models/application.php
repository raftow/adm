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
        private $myApplicationDesireList = null;

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "application";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        private $attribIsApplic = [];
        private $nb_desires = null;

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

        /**
         * @return Application
         */


        public static function loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id, $idn, $create_obj_if_not_found = false)
        {
                if (!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
                if (!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");
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




        public function beforeMaj($id, $fields_updated)
        {
                $objApplicant = null;
                $objApplicantQual = null;
                $objApplicationPlan = null;

                if (!$this->getVal("application_model_id")) {
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
                                $fields_updated["step_num"] = $this->getVal("step_num");
                                $this->set("step_num", 1);
                        }
                }

                if ($fields_updated["step_num"]) $this->requestAPIsOfStep($this->getVal("step_num"));

                // if(!$objApplicationPlan) $objApplicationPlan = $this->het("application_plan_id");

                if ($fields_updated["step_num"] or (!$this->getVal("application_step_id"))) {
                        $this->getApplicationModel();
                        if ($this->objApplicationModel) {
                                $appStepObj = $this->objApplicationModel->convertStepNumToObject($this->getVal("step_num"));
                                if ($appStepObj) {
                                        $application_step_id = $appStepObj->id;
                                        $this->set("application_step_id", $application_step_id);
                                }
                        } else {
                                AfwSession::pushError($this->getDisplay("en") . " : Application Model Not Found : " . $this->getVal("application_model_id"));
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

        protected function getPublicMethods()
        {

                $pbms = array();


                $currentStepNum = $this->getVal("step_num");
                $nextStepNum = $currentStepNum + 1;
                $this->getApplicationModel();
                if ($this->objApplicationModel) {
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
                for ($s = 1; $s <= $this->getVal("step_num"); $s++) {
                        $this->requestAPIsOfStep($s);
                }

                $this->getApplicant();
                if (!$this->applicantObj) return ["no-applicantObj", ""];

                return $this->applicantObj->runNeededApis($lang, $force);
        }

        public function getMyApplicationDesireList($force=false)
        {
                if($force or !$this->myApplicationDesireList) 
                {
                        $this->myApplicationDesireList = $this->get("applicationDesireList");
                        foreach($this->myApplicationDesireList as $adid => $adObj)
                        {
                                $this->myApplicationDesireList[$adid]->setApplicationObject($this);
                        }
                }
                
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

        public function deduceSimulationBranchs($applicationSimulationObj, $applicationPlanObj, $offlineDesiresRow=[])
        {
                        $simulation_method = $applicationSimulationObj->getVal("simul_method_enum");
                        $nb_desires = $applicationSimulationObj->getVal("nb_desires");
                
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
                                
                                if($offlineDesiresRow) $applicationModelBranchArr = self::createOfflineModelBranchArr($offlineDesiresRow);
                        }

                        $applicationPlanBranchArr = [];
                        foreach($applicationModelBranchArr as $applicationModelBranchId)
                        {
                                if($applicationModelBranchId)
                                {
                                        $applicationPlanId = $applicationPlanObj->id;
                                        $applicationPlanBranchId = $applicationPlanObj->getApplicationPlanBranchId($applicationModelBranchId);
                                        if(!$applicationPlanBranchId) 
                                        {
                                                $lang = AfwLanguageHelper::getGlobalLanguage();
                                                throw new AfwBusinessException("The following model branch ID %d has no plan branch ID, please check your plan if the branchs are ready for application", $lang, "", "", "", "", "adm", $applicationModelBranchId);
                                        }
                                        //if($applicationPlanBranchId==65) throw new AfwRuntimeException("Here The PB applicationPlanBranchId = $applicationPlanBranchId from applicationModelBranchId=$applicationModelBranchId inside plan=$applicationPlanId");
                                        $applicationPlanBranchArr[]  = $applicationPlanBranchId;
                                }
                                
                        }
                        

                        return ",".implode(",",$applicationPlanBranchArr).",";
        }

        public function simulateDesires($applicationSimulationObj, $applicationPlanObj, $lang, $offlineDesiresRow)
        {
                $nb_desires = $applicationSimulationObj->getVal("nb_desires");
                $options = $applicationSimulationObj->getOptions();
                if(!$nb_desires) $nb_desires = 1;
                if(strtolower($options["ERASE-EXISTING-DESIRES"])=="on" 
                     or (!$this->getApplicationDesireByNum($nb_desires)) // if the last desire doesn't exist we need to erase
                     )
                {

                        $new_application_plan_branch_mfk = $this->deduceSimulationBranchs($applicationSimulationObj, $applicationPlanObj, $offlineDesiresRow);
                        $old_application_plan_branch_mfk = $this->getVal("application_plan_branch_mfk");
                        $forceReload = false;
                        if($old_application_plan_branch_mfk != $new_application_plan_branch_mfk)
                        {
                                $this->set("application_plan_branch_mfk", $new_application_plan_branch_mfk);
                                $this->commit();
                                $forceReload = true;
                        }
                        
                }

                $this->getMyApplicationDesireList($forceReload);
                return $this->myApplicationDesireList;
        }

        public function bootstrapApplication($lang = "ar", $returnLastStepCode=false, $options=[])
        {
                $app_name = $this->getDisplay($lang);
                $devMode = AfwSession::config("MODE_DEVELOPMENT", false);
                $dataShouldBeUpdated = (strtolower($options["DATA-SHOULD-BE-UPDATED-BEFORE-APPLY"]) != "off");
                $application_simulation_id = $options["SIMULATION-ID"];
                $simulate = ($application_simulation_id!=2);
                $logConditionExec = (strtolower($options["LOG-CONDITION-EXEC"]) != "off");
                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];
                try {
                        $max_tentatives = 300;
                        $tentatives = 0; // limit tentatives to 300 to avoid infinite loop
                        $currentStepObj = $this->het("application_step_id");
                        $currentStepCode = $currentStepObj->getStepCode();        
                        $bootstrapStatus = "--trying";
                        while(($bootstrapStatus!="--blocked") and ($currentStepCode!="DSR") and ($tentatives<$max_tentatives))
                        {
                                $tentatives++;
                                // refresh data
                                $this->runNeededApis($lang = "ar", ($bootstrapStatus == "--forcing"));
                                // try to go to next step
                                
                                list($err, $inf, $war, $tech) = $this->gotoNextStep($lang, $dataShouldBeUpdated, $simulate, $application_simulation_id, $logConditionExec);
                                if ($err) 
                                {
                                        $err_arr[] = "$app_name : " . $err;    
                                        $bootstrapStatus = "--blocked";
                                }
                                else
                                {
                                        if ($inf) $inf_arr[] = "$app_name : " . $inf;
                                        if ($war) $war_arr[] = "$app_name : " . $war;
                                        if ($tech) $tech_arr[] = $tech; 
                                        $newStepObj = $this->het("application_step_id");
                                        $newStepCode = $newStepObj->getStepCode();  
        
                                        if($newStepCode==$currentStepCode)
                                        {
                                                if(($currentStepCode!="DSR"))
                                                {
                                                        if($bootstrapStatus == "--trying") $bootstrapStatus = "--forcing"; 
                                                        if($bootstrapStatus == "--forcing") $bootstrapStatus = "--blocked"; 
                                                }
                                                else
                                                {
                                                        $bootstrapStatus = "--success";   
                                                }
                                        }
                                        else
                                        {
                                                $currentStepCode = $newStepCode;
                                                $bootstrapStatus = "--trying";
                                        }
                                }
                        }

                        if(($bootstrapStatus == "--blocked") and ($currentStepCode!="DSR"))
                        {
                                $war_arr[] = $app_name." : ". $this->tm("Application is faltered, please see details and resolve manually", $lang);
                                $war_arr[] = $app_name." : ". $this->tm("Reached step", $lang)." : ".$currentStepCode."<!-- bootstrapStatus$bootstrapStatus tentatives=$tentatives-->";
                        }
                        elseif(($currentStepCode=="DSR"))
                        {
                                $war_arr[] = $app_name." : ". $this->tm("Application desire selection reached", $lang)."<!-- bootstrapStatus$bootstrapStatus tentatives=$tentatives-->";
                        }

                } catch (Exception $e) {
                        if($devMode) throw $e;
                        $err_arr[] = $e->getMessage();
                } catch (Error $e) {
                        if($devMode) throw $e;
                        $err_arr[] = $e->__toString();
                }

                $resPbm = AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);

                if($returnLastStepCode) return [$currentStepCode, $resPbm];

                return $resPbm;
        }

        public function gotoNextStep($lang = "ar", $dataShouldBeUpdated=true, $simulate=true, $application_simulation_id=0, $logConditionExec=true)
        {
                $devMode = AfwSession::config("MODE_DEVELOPMENT", false);
                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];
                // $nb_updated = 0;
                // $nb_inserted = 0;
                try {

                        $this->getApplicationModel();
                        if (!$this->objApplicationModel) return [$this->tm("Error happened, no application model defined for this application", $lang), ""];
                        /**
                         * @var ApplicationStep $currentStepObj
                         */
                        $currentStepObj = $this->het("application_step_id");
                        $currentStepNum = $this->getVal("step_num");

                        $dataReady = $this->fieldsMatrixForStep($currentStepNum, "ar", $onlyIfTheyAreUpdated = true);
                        if ($dataShouldBeUpdated and !$dataReady) 
                        {
                                $message_war = $this->tm("We can not apply conditions because the data is not updated", $lang);
                                $this->set("application_status_enum", self::application_status_enum_by_code('data-review'));
                                $this->set("comments", $message_war);
                                $this->commit();
                                return ["", "", $message_war];
                        }
                        
                        $currentStepId = $this->getVal("application_step_id");
                        // die("before currentStepObj=$currentStepObj->id currentStepNum=$currentStepNum currentStepId=$currentStepId");
                        if (!$currentStepObj or !$currentStepObj->id) $currentStepObj = $this->objApplicationModel->getFirstStep();
                        if (!$currentStepObj) 
                        {
                                $this->set("application_status_enum", self::application_status_enum_by_code('pending'));
                                $message_err = $this->tm("No first step defined for this application model, you may need to reorder the steps to have first step having number equal 0 or number equal 1", $lang);
                                $this->set("comments", $message_err);
                                $this->commit();
                                return [$message_err, ""];
                        }

                        // to go to next step we should apply conditions of the current step
                        $applyResult = $this->applyMyCurrentStepConditions($lang, false, $simulate, $application_simulation_id, $logConditionExec);
                        $success = $applyResult['success'];

                        list($error_message, $success_message, $fail_message, $tech) = $applyResult['res'];
                        if ($success) {

                                $nextStepNum = $this->objApplicationModel->getNextStepNumOf($currentStepNum,false);
                                $tech_arr[] = "nextStepNum=$nextStepNum currentStepNum=$currentStepNum";
                                $this->set("step_num", $nextStepNum);
                                $this->set("application_status_enum", self::application_status_enum_by_code('pending'));
                                $this->set("comments", "--");
                                
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
                                $this->set("application_status_enum", self::application_status_enum_by_code('pending'));
                                $this->set("comments", $fail_message);                                
                                $this->commit();
                        }
                } catch (Exception $e) {
                        if($devMode) throw $e;
                        $err_arr[] = $e->getMessage();
                } catch (Error $e) {
                        if($devMode) throw $e;
                        $err_arr[] = $e->__toString();
                }
                return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
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
                        AfwSession::pushError("requestAPIsOfStep : " . $this->getDisplay("en") . " :Application Model Not Found : " . $this->getVal("application_model_id"));
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

        public function getFieldsMatrix($applicationFieldsArr, $lang = "ar", $onlyIfTheyAreUpdated = false)
        {
                return self::getObjectFieldsMatrix($this, $applicationFieldsArr, $lang, $onlyIfTheyAreUpdated);
        }
        
        public static function getObjectFieldsMatrix(&$object, $applicationFieldsArr, $lang = "ar", $onlyIfTheyAreUpdated = false)
        {
                $matrix = [];
                $theyAreUpdated = true;
                $not_avail = [];
                // $this->updateCalculatedFields();
                foreach ($applicationFieldsArr as $field_name => $applicationFieldObj) {
                        $row_matrix = [];
                        $field_reel = $applicationFieldObj->_isReel();
                        $row_matrix['reel'] = $field_reel;
                        $field_title = $applicationFieldObj->getDisplay($lang) . "<!-- $field_name -->";
                        $row_matrix['title'] = $field_title;
                        if ($field_reel) {
                                $field_value = $object->getVal($field_name);
                                $field_value_case = "getVal";
                        } else {
                                $field_value = $object->calc($field_name);
                                $field_value_case = "calc";
                        }
                        $field_decode = $object->decode($field_name);
                        $row_matrix['decode'] = $field_decode . "<!-- $field_value -->";
                        $row_matrix['value'] = $field_value;
                        $row_matrix['case'] = $field_value_case;

                        $field_empty = ((!$field_value) or ($field_value === "W"));
                        $row_matrix['empty'] = $field_empty;

                        $field_value_datetime = "";
                        $api = "";
                        if (!$field_empty) {
                                [$field_value_datetime, $api] = $object->getFieldUpdateDate($field_name);
                        }


                        $row_matrix['datetime'] = $field_value_datetime;
                        $row_matrix['api'] = $api;
                        if ($field_value_datetime) {

                                $duration_expiry = $object->getFieldExpiryDuration($field_name);
                                if (!$duration_expiry) $duration_expiry = 180;
                                $expiry_date = AfwDateHelper::shiftGregDate('', -$duration_expiry);
                                if ($field_value_datetime < $expiry_date) {
                                        $row_matrix['status'] = self::needUpdateIcon($api . " $field_value_datetime < $expiry_date (duration_expiry of $field_name =$duration_expiry)");
                                        $theyAreUpdated = false;
                                        $not_avail[] = $field_title;
                                } else {
                                        $row_matrix['status'] = self::updatedIcon($api);
                                }
                        } else {
                                $row_matrix['status'] = self::needUpdateIcon($api . " => never updated");
                                $not_avail[] = $field_title;
                                $theyAreUpdated = false;
                        }



                        $matrix[] = $row_matrix;
                }

                if ($onlyIfTheyAreUpdated === true) return $theyAreUpdated;
                if ($onlyIfTheyAreUpdated === "list-fields-not-available") return implode(",", $not_avail);

                return $matrix;
        }

        public function fieldsMatrixForStep($stepNum, $lang = "ar", $onlyIfTheyAreUpdated = false)
        {
                if (!$this->applicantObj) $this->applicantObj = $this->het("applicant_id");
                if (!$this->applicantObj) throw new AfwRuntimeException("Can't retrieve fields matrix without any applicant defined");

                $this->getApplicationModel();
                if (!$this->objApplicationModel) throw new AfwRuntimeException("Can't retrieve fields matrix without any Application Model defined");
                list($applicantFieldsArr, $applicationFieldsArr, $applicationDesireFieldsArr) = $this->objApplicationModel->getAppModelFieldsOfStep($stepNum, true);
                if (count($applicationDesireFieldsArr) > 0) {
                        $applicationDesireFieldsArrKeys = array_keys($applicationDesireFieldsArr);
                        AfwSession::pushWarning("some desire fields are required in general step $stepNum => " . implode(",", $applicationDesireFieldsArrKeys) . " => " . implode(",", $applicationDesireFieldsArr));
                        // throw new AfwRuntimeException("some desire fields are required in general step $stepNum => ".implode(",",$applicationDesireFieldsArrKeys));
                }

                $fieldsMatrix_1 = $this->applicantObj->getFieldsMatrix($applicantFieldsArr, $lang, $this, $onlyIfTheyAreUpdated);
                $fieldsMatrix_2 = $this->getFieldsMatrix($applicationFieldsArr, $lang, $onlyIfTheyAreUpdated);

                if ($onlyIfTheyAreUpdated) return ($fieldsMatrix_1 and $fieldsMatrix_2);

                $fieldsMatrix = array_merge($fieldsMatrix_1, $fieldsMatrix_2);

                return $fieldsMatrix;
        }

        public function fieldsMatrixNeedUpdate() {}

        public function calcCurrent_fields_matrix()
        {
                global $lang;

                $currentStepNum = $this->getVal("step_num");
                $matrix = $this->fieldsMatrixForStep($currentStepNum, $lang);

                $matrix_header = ['title' => 'الحقل', 'decode' => 'القيمة', 'datetime' => 'تاريخ التحديث', 'api' => 'الخدمة', 'status' => 'حالة التحديث',];


                $return = AfwHtmlHelper::tableToHtml($matrix, $matrix_header);
                //$return .= "matrix = ".var_export($matrix, true)."<br>\n";

                return $return;
        }


        public function beforeDelete($id, $id_replace)
        {
                $server_db_prefix = AfwSession::config("db_prefix", "default_db_");

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

        public function applicationAttributeIsApplicable($attribute)
        {
                if (!isset($this->attribIsApplic[$attribute])) {
                        if ($attribute == "program_id") {
                                $application_field_id = 110809;
                                $this->getApplicationModel();
                                if (!$this->objApplicationModel) return false;
                                $this->attribIsApplic[$attribute] = ($this->objApplicationModel->getFieldInStep($application_field_id, $this->getVal("step_num")) == 1);
                        } elseif ($attribute == "applicant_qualification_id") {
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

                if (($attribute == "program_id") or ($attribute == "applicant_qualification_id")) 
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

        public function calcNb_desires($what = "value")
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
                return ($applicantAvail and $applicationAvail) ? $yes : $no;
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

        public function shouldBeCalculatedField($attribute)
        {
                if ($attribute == "allow_add_qualification") return true;
                return false;
        }

        public function getApplicationDesireByNum($desire_num)
        {
                $applicant_id = $this->getVal("applicant_id");
                $application_plan_id = $this->getVal("application_plan_id");
                $application_simulation_id = $this->getVal("application_simulation_id");

                return ApplicationDesire::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id, $desire_num);
        }

        public function getApplicationDesireByBranchId($application_plan_branch_id, $idn, $create_obj_if_not_found = false)
        {
                $applicant_id = $this->getVal("applicant_id");
                $application_plan_id = $this->getVal("application_plan_id");
                $application_simulation_id = $this->getVal("application_simulation_id");
                return ApplicationDesire::loadByBigIndex($applicant_id, $application_plan_id, $application_simulation_id, $application_plan_branch_id, $idn, $create_obj_if_not_found, $this);
        }


        public function afterMaj($id, $fields_updated)
        {
                if ($fields_updated["application_plan_branch_mfk"]) {
                        $application_plan_branch_mfk = $this->getVal("application_plan_branch_mfk");
                        $applicationPlanBranchList = $this->get("application_plan_branch_mfk");
                        foreach ($applicationPlanBranchList as $applicationPlanBranchItem) {
                                $idn = $this->getVal("idn");                                 
                                $applicationDesireObj = $this->getApplicationDesireByBranchId($applicationPlanBranchItem->id, $idn, true);
                                $applicationDesireObj->repareData();
                        }
                        // what is not in application_plan_branch_mfk should be removed
                        $applicationDesireList = $this->getRelation("applicationDesireList")->resetWhere("application_plan_branch_id not in (0 $application_plan_branch_mfk 0)")->getList();
                        /**
                         * @var ApplicationDesire $applicationDesireItem
                         */
                        foreach ($applicationDesireList as $applicationDesireItem) {
                                if ($applicationDesireItem->delete()) {
                                        // has been deleted successfully
                                } else {
                                        // the delete is refused we put back the application_plan_branch_id in application_plan_branch_mfk
                                        // to synchronize both fields
                                        $this->addRemoveInMfk("application_plan_branch_mfk", [$applicationDesireItem->getVal("application_plan_branch_id")], []);
                                }
                        }
                        $this->nb_desires = null;
                        $this->reorderDesires();
                }
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

        public function applyMyCurrentStepConditions($lang="ar", $pbm=true, $simulate=true, $application_simulation_id=0, $logConditionExec=true)
        {
                $application_model_id = $this->getVal("application_model_id");
                $application_plan_id = $this->getVal("application_plan_id");
                $step_num = $this->getVal("step_num");
                $general="W";
                $return =  ApplicationStep::applyStepConditionsOn($this, $application_model_id, $application_plan_id, $step_num, $general, $lang, $simulate, $application_simulation_id, $logConditionExec);

                if($pbm) return $return["res"];
                else return $return;
        }
}
