<?php
class ApplicationModel extends AdmObject
{


        private $applicationStepList = null;
        private $currentPlan = null;
        private $stepMax=[];

        private static $arrSortingStepIdByModelId = [];

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "application_model";
        public static $DB_STRUCTURE = null;
        public static $stepAppModelApiList = [];
        public static $stepAppModelFieldList = [];
        public static $arrAllApplicationModels = [];
        public static $arrQualificationMfk = [];


        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("application_model", "id", "adm");
                AdmApplicationModelAfwStructure::initInstance($this);
        }

        /**
         * @param integer $id (id of application model)
         * @return ApplicationModel
         */

        public static function loadById($id)
        {
                if (!self::$arrAllApplicationModels[$id]) {
                        $obj = new ApplicationModel();
                        if ($obj->load($id)) {
                                self::$arrAllApplicationModels[$id] = &$obj;
                        } else self::$arrAllApplicationModels[$id] = "NOT-FOUND";
                }
                if (self::$arrAllApplicationModels[$id] == "NOT-FOUND") return null;

                return self::$arrAllApplicationModels[$id];
        }

        public static function getSortingStepId($amodel_id)
        {
                if (!self::$arrSortingStepIdByModelId[$amodel_id]) {
                        $objAppModel = new ApplicationModel();
                        if ($objAppModel->load($amodel_id)) {
                                self::$arrSortingStepIdByModelId[$amodel_id] = $objAppModel->calcSorting_step_id();
                        } else self::$arrSortingStepIdByModelId[$amodel_id] = "NOT-FOUND";
                }
                if (self::$arrSortingStepIdByModelId[$amodel_id] == "NOT-FOUND") return 0;

                return self::$arrSortingStepIdByModelId[$amodel_id];
        }


        public static function getStepApis($applicant_id, $application_model_id, $step_num, $lang, $debugg)
        {
                $data = [];
                $modelObject = self::loadById($application_model_id);
                $appModelApiList = $modelObject->getAppModelApiOfStep($step_num);
                foreach ($appModelApiList as $appModelApiId => $appModelApiItem) {
                        $apiEndpointObj = $appModelApiItem->het("api_endpoint_id");
                        if ($apiEndpointObj->sureIs("import")) {
                                $row = [];
                                $row['api-code'] = $apiEndpointObj->getVal("api_endpoint_code");
                                $row['api-ar'] = $apiEndpointObj->getVal("api_endpoint_name_ar");
                                $row['api-en'] = $apiEndpointObj->getVal("api_endpoint_name_en");
                                $row['api-status'] = "done"; // @todo depends on $applicant_id


                                $data[] = $row;
                        }
                }

                if ($debugg) $data['api-status-list'] = ["failed", "waiting", "done"];

                return $data;
        }


        public function getDisplay($lang = "ar")
        {
                return $this->getVal("application_model_name_$lang");
        }

        public function stepsAreOrdered()
        {
                return true;
        }

        public function getFirstStep()
        {
                $result = $this->convertStepNumToObject(0);
                if (!$result) $result = $this->convertStepNumToObject(1);
                return $result;
        }

        public function getFirstApplicationStep()
        {
                return ApplicationStep::loadFirstStep($this->id, "Y");
        }

        public function getLastApplicationStep()
        {
                return ApplicationStep::loadDesiresSelectionStep($this->id);
        }

        public function getFirstDesireStep()
        {
                return ApplicationStep::loadFirstStep($this->id, "N");
        }

        public function getLastDesireStep()
        {
                $workflowStep = ApplicationStep::loadWorkflowStep($this->id);
                if($workflowStep) return $workflowStep;

                $sortingStep = ApplicationStep::loadSortingStep($this->id);
                if($sortingStep) return $sortingStep;

                return null;
        }

        

        /**
         * 
         * @return ApplicationStep
         */

        public function convertStepNumToObject($step_num)
        {
                return ApplicationStep::loadByMainIndex($this->id, $step_num);
        }

        public function getBrothers()
        {
                $this_id = $this->id;
                $academic_level_id = $this->getVal("academic_level_id");
                $obj = new ApplicationModel();
                $obj->select("academic_level_id", $academic_level_id);
                $obj->where("id != '$this_id'");
                $obj->get_visibilite_horizontale();
                return $obj->loadMany();
        }

        public static function loadByMainIndex($academic_level_id, $gender_enum, $training_period_enum, $create_obj_if_not_found = false)
        {
                $obj = new ApplicationModel();
                $obj->select("academic_level_id", $academic_level_id);
                $obj->select("gender_enum", $gender_enum);
                $obj->select("training_period_enum", $training_period_enum);

                if ($obj->load()) {
                        if ($create_obj_if_not_found) $obj->activate();
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        $obj->set("academic_level_id", $academic_level_id);
                        $obj->set("gender_enum", $gender_enum);
                        $obj->set("training_period_enum", $training_period_enum);


                        $obj->insertNew();
                        if (!$obj->id) return null; // means beforeInsert rejected insert operation
                        $obj->is_new = true;
                        return $obj;
                } else return null;
        }


        public function resetNames($lang = "ar", $which = "all", $commit = true)
        {
                if (($which == "all") or ($which == "ar")) {
                        $new_name_ar = $this->decode("academic_level_id", '', false, "ar");
                        if ($this->getVal('gender_enum') != 3) $new_name_ar .= "-" . $this->decode("gender_enum", '', false, "ar");
                        if ($this->getVal('training_period_enum') != 3) $new_name_ar .= "-" . $this->decode("training_period_enum", '', false, "ar");
                        $this->set("application_model_name_ar", $new_name_ar);
                }

                if (($which == "all") or ($which == "en")) {
                        $new_name_en = $this->decode("academic_level_id", '', false, "en");
                        if ($this->getVal('gender_enum') != 3) $new_name_en .= "-" . $this->decode("gender_enum", '', false, "en");
                        if ($this->getVal('training_period_enum') != 3) $new_name_en .= "-" . $this->decode("training_period_enum", '', false, "en");
                        $this->set("application_model_name_en", $new_name_en);
                }

                if ($commit) $this->commit();

                return ["", "تم تصفير مسمى الخطة بنجاح"];
        }

        public function createDefaultSteps($lang = "ar")
        {
                if ($this->id) {
                        $defaultScreensArr = ["profile", "desire", "sorting", "final"];
                        $info = "default steps : <br>\n";
                        foreach ($defaultScreensArr as $i => $defaultScreen) {
                                $objScreen = ScreenModel::loadByMainIndex($defaultScreen, true);
                                if (!$objScreen) return ["no `$defaultScreen` screen found", ""];
                                $stepObj = ApplicationStep::loadByMainIndex($this->id, $i * 10, "Y", $objScreen, true);
                                $info .= "`$defaultScreen` step";
                                $info .= $stepObj->is_new ? " has been created" : " has been updated";
                                $info .= "<br>\n";
                        }

                        return ["", $info];
                }
        }



        public function calcDesires_selection_step_id($what = "value")
        {
                $application_model_id = $this->id;
                $stepObj = ApplicationStep::loadDesiresSelectionStep($application_model_id);

                return ($what == "value") ? $stepObj->id : $stepObj;
        }

        public function calcSorting_step_id($what = "value")
        {
                $application_model_id = $this->id;
                $return = ApplicationStep::loadSortingStep($application_model_id);

                return ($what == "value") ? $return->id : $return;
        }



        public function afterMaj($id, $fields_updated)
        {
                if ($fields_updated["split_sorting_by_enum"]) {
                        list($err, $info, $war, $tech) = $this->updateSortingPath("en");
                        if ($err) AfwSession::pushError($err);
                        if ($info) AfwSession::pushInformation($info);
                        if ($war) AfwSession::pushWarning($war);
                }
        }






        public function beforeMaj($id, $fields_updated)
        {
                // tentative of update of sorting paths, check that no sorting sessions has started
                if ($fields_updated["split_sorting_by_enum"]) {
                        // if sorting sessions has started refuse the update
                        // @toremove if($this->currentPlan()) return false;
                }

                if ($fields_updated["academic_level_id"] or $fields_updated["gender_enum"] or $fields_updated["training_period_enum"]) {
                        $lang = AfwLanguageHelper::getGlobalLanguage();

                        if (!$fields_updated["application_model_name_ar"] or (!$this->getVal("application_model_name_ar")) or ($this->getVal("application_model_name_ar") == "--")) {
                                $this->resetNames("ar", "ar", false);
                        }

                        if (!$fields_updated["application_model_name_en"] or (!$this->getVal("application_model_name_en")) or ($this->getVal("application_model_name_en") == "--")) {
                                $this->resetNames("en", "en", false);
                        }

                        $this->createDefaultSteps($lang);
                }



                //$this->createDefaultSteps($lang);


                return true;
        }


        public function getAppModelApiOfStep($toStepNum)
        {
                if (!$toStepNum) $toStepNum = 0;
                if (!isset(self::$stepAppModelApiList[$this->id][$toStepNum])) {
                        self::$stepAppModelApiList[$this->id][$toStepNum] = $this->getRelation("appModelApiList")->resetWhere("active='Y' and step_num=$toStepNum")->getList();
                        if (!self::$stepAppModelApiList[$this->id][$toStepNum]) self::$stepAppModelApiList[$this->id][$toStepNum] = "NOT-FOUND";
                }

                if (self::$stepAppModelApiList[$this->id][$toStepNum] == "NOT-FOUND") self::$stepAppModelApiList[$this->id][$toStepNum] = [];

                return self::$stepAppModelApiList[$this->id][$toStepNum];
        }

        public function getApplicationModelFieldListOfStep($stepNum, $onlyMandatory = false, $onlyEditable = false)
        {
                if (!$stepNum) $stepNum = 1;
                if ($onlyMandatory and $onlyEditable) {
                        $case = "OM-OE";
                        $cond_onlyMandatory = "and is_mandatory='Y' and answer = 'Y'";
                } elseif ($onlyMandatory and !$onlyEditable) {
                        $case = "OM";
                        $cond_onlyMandatory = "and is_mandatory='Y'";
                } elseif (!$onlyMandatory and $onlyEditable) {
                        $case = "OE";
                        $cond_onlyMandatory = "and answer = 'Y'";
                } else {
                        $case = "ALL";
                        $cond_onlyMandatory = "";
                }
                if (!isset(self::$stepAppModelFieldList[$this->id][$stepNum][$case])) {
                        $sql = $this->getRelation("applicationModelFieldList")->resetWhere("active='Y' and step_num<=$stepNum $cond_onlyMandatory")->getList(true);
                        // die("applicationModelFieldList case $case => $sql");
                        self::$stepAppModelFieldList[$this->id][$stepNum][$case] = $this->getRelation("applicationModelFieldList")->resetWhere("active='Y' and step_num<=$stepNum $cond_onlyMandatory")->getList();
                }
                return self::$stepAppModelFieldList[$this->id][$stepNum][$case];
        }

        public function getNeededAttributes($step_num)
        {
                $needed = [];
                $afOEFieldsList = $this->getApplicationModelFieldListOfStep($step_num, false, true);

                foreach ($afOEFieldsList as $afOEField) {
                        $applicationFieldObj = $afOEField->het("application_field_id");
                        if ($applicationFieldObj) {
                                $field_name = $applicationFieldObj->getVal("field_name");
                                if ($field_name) $needed[] = $field_name;
                        }
                }

                return $needed;
        }


        public function getMandatoryNeededAttributes($step_num)
        {
                $needed = [];
                $afOEFieldsList = $this->getApplicationModelFieldListOfStep($step_num, true, true);

                foreach ($afOEFieldsList as $afOEField) {
                        $applicationFieldObj = $afOEField->het("application_field_id");
                        if ($applicationFieldObj) {
                                $field_name = $applicationFieldObj->getVal("field_name");
                                if ($field_name) $needed[$field_name] = true;
                        }
                }

                return $needed;
        }

        public function getAppModelFieldsOfStep($stepNum, $splitByTable = false, $onlyTitles = false, $lang = "ar", $onlyMandatory = false)
        {
                if (!$stepNum) $stepNum = 0;
                $applicationModelFieldList = $this->getApplicationModelFieldListOfStep($stepNum, $onlyMandatory);

                if (!$splitByTable) return $applicationModelFieldList;
                else {
                        $applicantFieldsArr = [];
                        $applicationFieldsArr = [];
                        $applicationDesireFieldsArr = [];
                        foreach ($applicationModelFieldList as $applicationModelFieldItem) {
                                $applicationFieldObj = $applicationModelFieldItem->het("application_field_id");
                                if ($applicationFieldObj) {
                                        $field_name = $applicationFieldObj->getVal("field_name");
                                        $field_title = $applicationFieldObj->getDisplay($lang) . "/" . $applicationFieldObj->id;
                                        // $field_reel = $applicationFieldObj->_isReel();
                                        $application_table_id = $applicationFieldObj->getVal("application_table_id");
                                        if ($application_table_id == 1) {
                                                if ($onlyTitles) $applicantFieldsArr[$field_name] = $field_title;
                                                else $applicantFieldsArr[$field_name] = $applicationFieldObj;
                                        } elseif ($application_table_id == 3) {
                                                if ($onlyTitles) $applicationFieldsArr[$field_name] = $field_title;
                                                else $applicationFieldsArr[$field_name] = $applicationFieldObj;
                                        } elseif ($application_table_id == 2) {
                                                if ($onlyTitles) $applicationDesireFieldsArr[$field_name] = $field_title;
                                                else $applicationDesireFieldsArr[$field_name] = $applicationFieldObj;
                                                // die("desire field $field_name / $field_title => <br> ".var_export($applicationFieldObj,true));
                                        } else {
                                                throw new AfwRuntimeException("unknown application_table_id=$application_table_id");
                                        }
                                }
                        }

                        return [$applicantFieldsArr, $applicationFieldsArr, $applicationDesireFieldsArr];
                }
        }


        protected function attributeCanBeEditedBy($attribute, $user, $desc)
        {
                if (($attribute == "academic_level_id") or ($attribute == "gender_enum") or ($attribute == "training_period_enum")) {
                        $applicationPlanListCount = $this->getRelation("applicationPlanList")->count();
                        if ($applicationPlanListCount > 0) return [false, 'applicationPlanList is not empty'];
                }

                if ($attribute == "split_sorting_by_enum") {
                        $objPlan = $this->currentPlan();
                        if ($objPlan) {
                                // because if there's current plan we can not change the sorting method setted
                                // except after this plan is ended and become old plan
                                // @toremove return [false, 'Aplan id '.$objPlan->id.' has started wait the end'];
                        }
                }



                // return type is : array($can, $reason)
                return [true, ''];
        }

        public function reorderBranchsFromProgramOffering($lang = "ar")
        {
                return $this->reorderBranchs($lang, $fromProgramOffering = true);
        }

        public function reorderBranchs($lang = "ar", $fromProgramOffering = false)
        {
                $applicationModelBranchList = $this->get("applicationModelBranchList");
                $branch_order = 0;
                $log_arr = [];
                foreach ($applicationModelBranchList as $applicationModelBranchItem) {
                        if ($fromProgramOffering) {
                                $programOfferingItem = $applicationModelBranchItem->het("program_offering_id");
                                if ($programOfferingItem) $old_branch_order = $programOfferingItem->getVal("academic_program_id.program_rank");
                                else $old_branch_order = 0;
                                if (!$old_branch_order) $fromProgramOffering = false;
                        }

                        if (!$fromProgramOffering) $old_branch_order = $applicationModelBranchItem->getVal("branch_order");
                        if ($branch_order <= 0) {
                                $branch_order = $old_branch_order;
                                if ($branch_order <= 0) $branch_order = 1;
                                if ($branch_order > 1) $branch_order = 1;
                                $step_from = $branch_order;
                        } else $branch_order++;

                        $log_arr[] = "from $old_branch_order to $branch_order";

                        $applicationModelBranchItem->set("branch_order", $branch_order);
                        $applicationModelBranchItem->commit();
                        $step_to = $branch_order;
                }

                return ["", "reordered from $step_from to $step_to " . implode("<br>\n", $log_arr)];
        }

        public function reorderSteps($lang = "ar")
        {
                $applicationStepList = $this->get("applicationStepList");
                $step_num = -1;
                $log_arr = [];
                foreach ($applicationStepList as $applicationStepItem) {
                        $old_step_num = $applicationStepItem->getVal("step_num");
                        if ($step_num < 0) {
                                $step_num = $old_step_num;
                                if ($step_num < 0) $step_num = 0;
                                if ($step_num > 1) $step_num = 1;
                                $step_from = $step_num;
                        } else $step_num++;

                        $log_arr[] = "from $old_step_num to $step_num";

                        $applicationStepItem->set("step_num", $step_num);
                        $applicationStepItem->commit();
                        $step_to = $step_num;
                }

                return ["", "reordered from $step_from to $step_to " . implode("<br>\n", $log_arr)];
        }

        public function findScreenForField($application_field_id)
        {
                $applicationStepList = $this->get("applicationStepList");
                foreach ($applicationStepList as $applicationStepItem) {
                        $screen_model_id = $applicationStepItem->getVal("screen_model_id");
                        $step_num        = $applicationStepItem->getVal("step_num");
                        $general         = $applicationStepItem->getVal("general");
                        $field_exists    = $applicationStepItem->findInMfk("show_field_mfk", $application_field_id);
                        if ($field_exists) {
                                return [$screen_model_id, $step_num, $general];
                        } else {
                                /*
                                        if(($application_field_id=="110312") and ($screen_model_id==3))
                                        {
                                                die("findScreenForField failed to find $application_field_id in ".$applicationStepItem->getVal("show_field_mfk"));
                                        }
                                                */
                        }
                }

                return [0, -1, 'W'];
        }

        public function hideAllApplicationModelConditionList($conditions = true, $fields = true, $apis = true)
        {
                if ($conditions) {
                        $amcObj = new ApplicationModelCondition();
                        $amcObj->select("application_model_id", $this->id);
                        $amcObj->logicDelete(true, false);
                }

                if ($fields) {
                        $amfObj = new ApplicationModelField();
                        $amfObj->select("application_model_id", $this->id);
                        $amfObj->logicDelete(true, false);
                }

                if ($apis) {
                        $amaObj = new AppModelApi();
                        $amaObj->select("application_model_id", $this->id);
                        $amaObj->logicDelete(true, false);
                }
        }

        public function getFieldApiEndpoint($field_name, $application_table_id)
        {
                $application_fieldObj = ApplicationField::loadByMainIndex($field_name, $application_table_id);
                if (!$application_fieldObj) return null;
                // $appModelApiList = $this->objApplicationModel->getAppModelApiOfStep($nextStepNum);
                $amfObj = ApplicationModelField::loadByMainIndex($this->id, $application_fieldObj->id);
                if ($amfObj) return $amfObj->het("api_endpoint_id");
                else return null;
        }

        public function getFieldExpiryDuration($field_name, $application_table_id)
        {
                $application_fieldObj = ApplicationField::loadByMainIndex($field_name, $application_table_id);
                if (!$application_fieldObj) return 8888;
                // $appModelApiList = $this->objApplicationModel->getAppModelApiOfStep($nextStepNum);
                $amfObj = ApplicationModelField::loadByMainIndex($this->id, $application_fieldObj->id);
                if ($amfObj) {
                        $return = $amfObj->getVal("duration_expiry");
                        if (!$return) $return = 180; // 6 months by default or should be customized
                        return $return;
                } else return 9988;
        }

        public function genereScreensAndModels($lang = "ar")
        {
                return $this->genereApplicationModelConditionList($lang, $addNewConditions = false);
        }

        public function genereApplicationModelConditionList($lang = "ar", $addNewConditions = true)
        {
                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];

                $cond_nb_updated = 0;
                $cond_nb_inserted = 0;

                $fld_nb_updated = 0;
                $fld_nb_inserted = 0;

                // $api_nb_updated = 0;
                $api_nb_inserted = 0;

                $apiVirtualManualEntry = ApiEndpoint::loadByMainIndex("ManualEntry");
                $apiVirtualSRT = ApiEndpoint::loadByMainIndex("SRT");

                $this_disp = $this->getDisplay($lang);

                $this->hideAllApplicationModelConditionList($addNewConditions);

                $aconditionOriginList = $this->get("aconditionOriginList");
                foreach ($aconditionOriginList as $aconditionOriginItem) {
                        $aconditionList = $aconditionOriginItem->get("allAconditionList");
                        foreach ($aconditionList as $aconditionItem) {
                                $general = $aconditionItem->getVal("general");
                                $acondition_origin_id = $aconditionItem->getVal("acondition_origin_id");
                                $amcObj = ApplicationModelCondition::loadByMainIndex($this->id, $aconditionItem->id, $acondition_origin_id, $general, $addNewConditions);
                                if ($amcObj) {
                                        $inf_arr[] = "تم الأخذ بعين الاعتبار للشرط : " . $aconditionItem->getDisplay($lang);
                                        if ($amcObj->is_new) $cond_nb_inserted++;
                                        else $cond_nb_updated++;

                                        /**
                                         * @var ACondition $aconditionItem
                                         */

                                        $aconditionFieldList = $aconditionItem->getAllFields($this);
                                        // the condition should be executed in the max step num
                                        // when all fields have been recolted
                                        // but min step of exec of step should be 1
                                        $step_num_max = 1;
                                        foreach ($aconditionFieldList as $aconditionFieldItem) {
                                                $application_field_id = $aconditionFieldItem["id"];
                                                $application_field_name = $aconditionFieldItem["name"];
                                                $amfObj = ApplicationModelField::loadByMainIndex($this->id, $application_field_id, $aconditionItem->id, 0, true);
                                                if ($amfObj->is_new) $fld_nb_inserted++;
                                                else $fld_nb_updated++;
                                                list($screen_model_id, $step_num, $generalScreen) = $this->findScreenForField($application_field_id);
                                                if (!$screen_model_id) {
                                                        $err_arr[] = "no step/screen manage the field $application_field_name/$application_field_id";
                                                }
                                                $arr_api = ApiEndpoint::findAllApiEndpointForField($application_field_id);
                                                /*
                                                        if($application_field_name=="لائق طبيا")
                                                        {
                                                                die("$application_field_name => ApiEndpoint::findAllApiEndpointForField($application_field_id) => ".var_export($arr_api,true));
                                                        }*/
                                                $count_api = count($arr_api);
                                                $apiEndpoint = null;
                                                $apiEndpoint2 = null;
                                                if ($count_api == 0) {
                                                        $amfObj->set("api_endpoint_id", 0);
                                                        $err_arr[] = "no api return the field $application_field_name/$application_field_id";
                                                } elseif ($count_api == 1) {
                                                        /**
                                                         * @var ApiEndpoint $apiEndpoint
                                                         */
                                                        $apiEndpoint = $arr_api[0];
                                                        $inf_arr[] = "بخصوص الحقل $application_field_name/$application_field_id تم العثور على الخدمة " . $apiEndpoint->getDisplay($lang);
                                                } else {
                                                        $api_found = false;
                                                        $api2_found = false;
                                                        foreach ($arr_api as $k => $apiEndpointObj) {
                                                                $last_tentative = ($k == (count($arr_api) - 1));
                                                                if (!$api_found) {
                                                                        $api_found = true;
                                                                        $apiEndpoint = $apiEndpointObj;
                                                                        $inf_arr[] = "بخصوص الحقل $application_field_name/$application_field_id تم العثور على الخدمة " . $apiEndpoint->getDisplay($lang);
                                                                        $oldEndpoint = $amfObj->het("api_endpoint_id");
                                                                        if ($oldEndpoint and ($oldEndpoint->id != $apiEndpoint->id)) {
                                                                                $api2_found = true;
                                                                                $apiEndpoint2 = $oldEndpoint;
                                                                                $war_arr[] = "بخصوص الحقل $application_field_name/$application_field_id سبق اختياركم الخدمة البديلة " . $apiEndpoint2->getDisplay($lang);
                                                                        }
                                                                } elseif ((!$api2_found) and ((!$amfObj->getVal("api_endpoint2_id")) or ($apiEndpointObj->id == $amfObj->getVal("api_endpoint2_id")) or ($last_tentative))) {
                                                                        $api2_found = true;
                                                                        $apiEndpoint2 = $apiEndpointObj;
                                                                        $inf_arr[] = "بخصوص الحقل $application_field_name/$application_field_id تم العثور على الخدمة البديلة " . $apiEndpoint2->getDisplay($lang);
                                                                }
                                                        }
                                                }

                                                if ($apiEndpoint) $amfObj->set("api_endpoint_id", $apiEndpoint->id);
                                                else $amfObj->setForce("api_endpoint_id", 0);
                                                if ($apiEndpoint2) $amfObj->set("api_endpoint2_id", $apiEndpoint2->id);
                                                else $amfObj->setForce("api_endpoint2_id", 0);

                                                if (!$amfObj->getVal("duration_expiry") and $apiEndpoint) $amfObj->set("duration_expiry", $apiEndpoint->getVal("duration_expiry"));
                                                $amfObj->set("screen_model_id", $screen_model_id);
                                                $amfObj->set("step_num", $step_num);
                                                $amfObj->commit();
                                                if ($step_num_max < $step_num) $step_num_max = $step_num;
                                        }

                                        $amcObj->set("step_num", $step_num_max);
                                        $amcObj->commit();
                                }
                        }
                }

                $applicationModelFieldList = $this->get("applicationModelFieldList");
                foreach ($applicationModelFieldList as $applicationModelFieldItem) {

                        $api_endpoints_arr = [];

                        if ($applicationModelFieldItem->getVal("api_endpoint_id") > 0) {
                                $api_endpoints_arr[] = $applicationModelFieldItem->getVal("api_endpoint_id");
                                if ($applicationModelFieldItem->getVal("api_endpoint2_id") > 0) $api_endpoints_arr[] = $applicationModelFieldItem->getVal("api_endpoint2_id");
                        } else $war_arr[] = "field " . $applicationModelFieldItem->getDisplay("en") . " has no api_endpoint defined";

                        // if($applicationModelFieldItem->id==77) die("applicationModelFieldItem=".var_export($applicationModelFieldItem,true)." api_endpoints_arr=".var_export($api_endpoints_arr,true));

                        foreach ($api_endpoints_arr as $api_ep_id) {
                                if ($api_ep_id > 0) {
                                        if (($api_ep_id != $apiVirtualManualEntry->id) and ($api_ep_id != $apiVirtualSRT->id)) {
                                                $application_field_id = $applicationModelFieldItem->getVal("application_field_id");
                                                $new_step_num = $applicationModelFieldItem->getVal("step_num");
                                                if (!$new_step_num) $new_step_num = 1;
                                                $amaObj = AppModelApi::loadByMainIndex($this->id, $api_ep_id, true);
                                                if ($amaObj->is_new) {
                                                        $amaObj->set("application_field_mfk", ",$application_field_id,");
                                                        // $amaObj->set("duration_expiry", 15);
                                                        $api_nb_inserted++;
                                                } else {
                                                        $amaObj->addRemoveInMfk("application_field_mfk", [$application_field_id], []);
                                                }

                                                $amaObj->set("duration_expiry", 15);
                                                $step_num = $amaObj->getVal("step_num");
                                                if ((!$step_num) or ($step_num < 0) or ($step_num > $new_step_num)) {
                                                        $step_num = $new_step_num;
                                                        $amaObj->set("step_num", $step_num);
                                                }

                                                $amaObj->commit();
                                        } else {
                                                $inf_arr[] = "for field $application_field_id `manual entry` virtual API(13) has been ignored";
                                        }
                                }
                        }
                }

                if (!count($aconditionOriginList)) {
                        $err_arr[] = "لا يوجد مصادر للشروط لهذا النموذج $this_disp يرجى مراجعة مجال تطبيق اللوائح المعنية";
                }

                if ($cond_nb_inserted) $inf_arr[] = "تم اضافة $cond_nb_inserted شرط";
                elseif ($cond_nb_updated) $inf_arr[] = "تم تحديث $cond_nb_updated شرط";
                else $war_arr[] = "لم يتم تحديث أي شرط";


                if ($fld_nb_inserted) $inf_arr[] = "تم اضافة $fld_nb_inserted حقل";
                elseif ($fld_nb_updated) $inf_arr[] = "تم تحديث $fld_nb_updated حقل";
                else $war_arr[] = "لم يتم تحديث أي حقل";

                if ($api_nb_inserted) $inf_arr[] = "تم اضافة $api_nb_inserted خدمة";
                //if($cond_nb_inserted)  $inf_arr[] = "تم تحديث $cond_nb_inserted خدمة";

                return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
        }

        public function hideAllApplicationModelBranchList()
        {
                $amcObj = new ApplicationModelBranch();
                $amcObj->select("application_model_id", $this->id);
                $amcObj->logicDelete(true, false);
        }


        public function testOpenApplicationModelBranchList($lang = "ar")
        {
                $capacity = AfwSession::config("capacity-default", 10);
                $application_model_id = $this->id;
                $obj = new ApplicationModelBranch();
                $obj->select("application_model_id", $application_model_id);
                $obj->where("seats_capacity is null or seats_capacity = 0");
                $obj->set("seats_capacity", $capacity);
                $obj->update(false);
                return ["", "done"];
        }



        public function canNotUpdateSortingPath($lang = "ar")
        {
                return ["", "", $this->tm("Can't update the sorting paths because some sorting sessions has already started", $lang)];
        }

        public function updateSortingPath($lang = "ar")
        {
                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];
                $nb_updated = 0;
                $nb_inserted = 0;
                $split_sorting_by_enum = $this->getVal("split_sorting_by_enum");
                if (!$split_sorting_by_enum) $split_sorting_by_enum = 1;

                if ($split_sorting_by_enum > 2) {
                        $err_arr[] = "not implemented yet split_sorting_by_enum=$split_sorting_by_enum";
                } else {
                        $application_model_id = $this->id;
                        if ($split_sorting_by_enum == 1) {
                                $the_code = "NS";
                                $majorPathList = [];
                        } elseif ($split_sorting_by_enum == 2) {
                                $the_code = "MPS";
                                $majorPathList = MajorPath::loadAllLookupObjects();
                        }

                        if (count($majorPathList) == 0) {
                                $the_code = "NS";
                                $majorPathList[$application_model_id] = $this;
                        }


                        SortingPath::deleteWhere("application_model_id = $application_model_id");

                        // SortingPath::deleteWhere("application_model_id = $application_model_id and sorting_path_code not like '$the_code-%' or sorting_num > $max_sorting_num"); 
                        // SortingPath::updateWhere(['active'=>'N'], "application_model_id = $application_model_id");

                        $nbMajorPaths = count($majorPathList);
                        $capacity_pct_total = 100;
                        $capacity_pct_part = $capacity_pct_total / $nbMajorPaths;
                        $sorting_num = 0;
                        $coefs = [];
                        foreach ($majorPathList as $majorPathItem) {
                                $sorting_num++;
                                $coefs[$sorting_num] = $capacity_pct_part;
                                $sorting_path_code = $the_code . "-" . $majorPathItem->id;
                                $name_ar = $this->t("sorting_path", "ar") . " : " . $majorPathItem->getShortDisplay("ar");
                                $desc_ar = "";
                                $name_en = $this->t("sorting_path", "en") . " : " . $majorPathItem->getShortDisplay("en");
                                $desc_en = "";
                                $short_name_ar = $majorPathItem->getShortDisplay("ar");
                                $short_name_en = $majorPathItem->getShortDisplay("en");

                                if ($capacity_pct_part < $capacity_pct_total) $capacity_pct = $capacity_pct_part;
                                else $capacity_pct = $capacity_pct_total;
                                $objItem = SortingPath::loadByMainIndex(
                                        $application_model_id,
                                        $sorting_path_code,
                                        $name_ar,
                                        $desc_ar,
                                        $name_en,
                                        $desc_en,
                                        $capacity_pct,
                                        $short_name_ar,
                                        $short_name_en,
                                        $sorting_num,
                                        true,
                                        false
                                );
                                $capacity_pct_total = $capacity_pct_total - $objItem->getVal("capacity_pct");
                                if ($objItem->is_new) {
                                        $nb_inserted++;
                                        // $inf_arr[] = $objItem->tm("created path")." : ".$objItem->getDisplay($lang);
                                } else {
                                        $nb_updated++;
                                        // $inf_arr[] = $objItem->tm("updated path")." : ".$objItem->getDisplay($lang);  
                                }
                        }

                        if ($nbMajorPaths > 0) {
                                $this->resetCapacitiesAsMajorPath($coefs);
                                $planList = $this->getNextPlans();
                                foreach ($planList as $planObj) {
                                        $planObj->resetCapacitiesAsMajorPath($coefs);
                                }
                        }

                        // SortingPath::deleteWhere("application_model_id = $application_model_id and active='N'");
                }


                $inf_arr[] = "تم انشاء $nb_inserted من المسارات";
                $inf_arr[] = "$nb_updated من المسارات موجودة سابقا";

                return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
        }

        public function resetCapacitiesToFirstMajorPath($lang = "ar")
        {
                $coefs = [1 => 100, 2 => 0, 3 => 0, 4 => 0];
                $this->resetCapacitiesAsMajorPath($coefs);
                return ["", "done"];
        }

        public function resetCapacitiesAsMajorPath($coefs)
        {
                foreach ($coefs as $c => $cv) {
                        ${"coef_$c"} = $cv / 100.0;
                        if (!${"coef_$c"}) ${"coef_$c"} = 0.0;
                }
                $sets_arr = [
                        'capacity_track1' => "round(seats_capacity*$coef_1)",
                        'capacity_track2' => "round(seats_capacity*$coef_2)",
                        'capacity_track3' => "round(seats_capacity*$coef_3)",
                        'capacity_track4' => "seats_capacity-capacity_track1-capacity_track2-capacity_track3",
                ];
                $where_clause = "application_model_id = " . $this->id;
                ApplicationModelBranch::updateWhere($sets_arr, $where_clause, true);
        }

        public function genereApplicationModelBranchList($lang = "ar")
        {

                global $MODE_SQL_PROCESS_LOURD, $nb_queries_executed;
                $old_nb_queries_executed = $nb_queries_executed;
                $old_MODE_SQL_PROCESS_LOURD = $MODE_SQL_PROCESS_LOURD;
                $MODE_SQL_PROCESS_LOURD = true;

                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];
                $nb_updated = 0;
                $nb_inserted = 0;

                $academic_level_id = $this->getVal("academic_level_id");
                $academic_level_display = $this->decode("academic_level_id");
                $gender_enum = $this->getVal("gender_enum");
                $gender_enum_display = $this->decode("gender_enum");
                $training_period_enum_display = $this->decode("training_period_enum");
                $this->hideAllApplicationModelBranchList();

                $trainingPeriodArr = self::splitTrainingPeriods($this->getVal("training_period_enum"));
                // $trainingPeriodArrCount = count($trainingPeriodArr);
                foreach ($trainingPeriodArr as $training_period_enum) {
                        $training_period_title = self::name_of_training_period_enum($training_period_enum, $lang);
                        $progOffList = AcademicProgramOffering::loadListeForModel($academic_level_id, $gender_enum, $training_period_enum);
                        $inf_arr[] = $this->tm("nb of Academic Program Offering for") . " ($academic_level_display / $gender_enum_display / $training_period_title) : " . count($progOffList);
                        foreach ($progOffList as $progOffItem) {
                                $seats_capacity = $this->getVal("seats_capacity_$training_period_enum");
                                // $appModel = ApplicationModel::loadByMainIndex($academic_level_id, $gender_enum, $training_period_enum);

                                if ($progOffItem and $progOffItem->allowTrainingPeriod($training_period_enum)) {
                                        $seats_capacity = 0;
                                        $prog_off_gender_enum = $progOffItem->getVal("gender_enum");
                                        $appModelBr = ApplicationModelBranch::loadByMainIndex($this->id, $progOffItem->id, $prog_off_gender_enum, $training_period_enum, $seats_capacity, $create_obj_if_not_found = true);
                                        $appModelBr->set("major_id", $progOffItem->getVal("major_id"));
                                        $appModelBr->set("academic_program_id", $progOffItem->getVal("academic_program_id"));
                                        $appModelBr->genereName($lang);
                                        if ($appModelBr->is_new) {
                                                $nb_inserted++;
                                                $inf_arr[] = $appModelBr->tm("created branch") . " : " . $appModelBr->getDisplay($lang);
                                        } else {
                                                $nb_updated++;
                                                // $inf_arr[] = $appModelBr->tm("updated branch")." : ".$appModelBr->getDisplay($lang);  
                                        }
                                } else {
                                        $war_arr[] = $progOffItem->getDisplay($lang) . " لا تدعم فترة التدريب $training_period_title.";
                                }
                        }
                }

                // $inf_arr[] = "يوجد $trainingPeriodArrCount من الفترات التدريبية";
                $inf_arr[] = "تم انشاء $nb_inserted من الفروع";
                $inf_arr[] = "$nb_updated من الفروع موجودة سابقا";

                $MODE_SQL_PROCESS_LOURD = $old_MODE_SQL_PROCESS_LOURD;
                $nb_queries_executed = $old_nb_queries_executed;

                return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
        }

        public function currentSortingSession()
        {
                $currentPlan = $this->currentPlan();
                if (!$currentPlan) return null;

                return $currentPlan->currentSortingSession();
        }




        protected function getPublicMethods()
        {
                $lang = AfwLanguageHelper::getGlobalLanguage();

                $pbms = array();



                $color = "gray";
                $title_ar = "تصفير مسمى النموذج";
                $methodName = "resetNames";
                $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "PUBLIC" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("application_model_name_ar"));




                if (!$this->currentSortingSession()) {
                        $color = "yellow";
                        $title_ar = "تحديث مسارات الفرز";
                        $methodName = "updateSortingPath";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("sortingPathList"));
                } else {
                        $color = "yellow";
                        $title_ar = "تحديث مسارات الفرز";
                        $methodName = "canNotUpdateSortingPath";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("sortingPathList"));
                }

                $color = "blue";
                $title_ar = "مزامنة البرامج مع وحدة سير العمل";
                $methodName = "synchronizeProgramsWithWorkflow";
                $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "PUBLIC" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("application_model_name_ar"));


                $currPlan = $this->currentPlan();
                $devMode = AfwSession::config("MODE_DEVELOPMENT", false);
                if ((!$currPlan) or (!$currPlan->sureIs("published")) or ($devMode)) {
                        $color = "green";
                        $title_ar = "تحديث فروع القبول حسب البرامج المتاحة وباقي الاعدادات";
                        $methodName = "genereApplicationModelBranchList";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "PUBLIC" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("applicationModelBranchList"));

                        $methodConfirmationWarningEn = "You agree that you want to erase capacity planning with sample values";
                        $methodConfirmationWarningAr = $this->tm($methodConfirmationWarningEn, "ar");
                        $methodConfirmationQuestionEn = "Are you sure you want to do this approve ?";
                        $methodConfirmationQuestionAr = $this->tm($methodConfirmationQuestionEn, "ar");

                        $color = "red";
                        $title_ar = "فتح جميع فروع القبول بطاقة استيعابية تجريبية";
                        $methodName = "testOpenApplicationModelBranchList";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                                "METHOD" => $methodName,
                                "COLOR" => $color,
                                "LABEL_AR" => $title_ar,
                                "PUBLIC" => true,
                                "BF-ID" => "",
                                'CONFIRMATION_NEEDED' => true,
                                'CONFIRMATION_WARNING' => array('ar' => $methodConfirmationWarningAr, 'en' => $methodConfirmationWarningEn),
                                'CONFIRMATION_QUESTION' => array('ar' => $methodConfirmationQuestionAr, 'en' => $methodConfirmationQuestionEn),
                                'STEP' => $this->stepOfAttribute("applicationModelBranchList")
                        );

                        $color = "blue";
                        $title_ar = "انشاء جميع المراحل الافتراضية";
                        $methodName = "createDefaultSteps";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "PUBLIC" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("applicationStepList"));

                        $color = "green";
                        $title_ar = "اعادة ترتيب جميع المراحل";
                        $methodName = "reorderSteps";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "PUBLIC" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("applicationStepList"));


                        $color = "red";
                        $title_ar = "اعادة ترتيب جميع الفروع";
                        $methodName = "reorderBranchs";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "PUBLIC" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("applicationModelBranchList"));

                        $color = "orange";
                        $title_ar = "اعادة ترتيب جميع الفروع من ترتيب البرامج";
                        $methodName = "reorderBranchsFromProgramOffering";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "PUBLIC" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("applicationModelBranchList"));


                        $methodConfirmationWarningEn = "You agree that you want to cancel capacity planning for different sorting paths";
                        $methodConfirmationWarningAr = $this->tm($methodConfirmationWarningEn, "ar");
                        $methodConfirmationQuestionEn = "Are you sure you want to do this approve ?";
                        $methodConfirmationQuestionAr = $this->tm($methodConfirmationQuestionEn, "ar");
                        $color = "orange";
                        $title_ar = "تجميع الطاقة الاستيعابية";
                        $methodName = "resetCapacitiesToFirstMajorPath";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array(
                                "METHOD" => $methodName,
                                "COLOR" => $color,
                                "LABEL_AR" => $title_ar,
                                "PUBLIC" => true,
                                "BF-ID" => "",
                                'STEP' => $this->stepOfAttribute("applicationModelBranchList"),
                                'CONFIRMATION_NEEDED' => true,
                                'CONFIRMATION_WARNING' => array('ar' => $methodConfirmationWarningAr, 'en' => $methodConfirmationWarningEn),
                                'CONFIRMATION_QUESTION' => array('ar' => $methodConfirmationQuestionAr, 'en' => $methodConfirmationQuestionEn),
                        );


                        $color = "orange";
                        $title_ar = "تحديث الشروط";
                        $methodName = "genereApplicationModelConditionList";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "PUBLIC" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("applicationModelConditionList"));



                        $color = "orange";
                        $title_ar = "تحديث الشاشات والخدمات";
                        $methodName = "genereScreensAndModels";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] =
                                array(
                                        "METHOD" => $methodName,
                                        "COLOR" => $color,
                                        "LABEL_AR" => $title_ar,
                                        "PUBLIC" => true,
                                        "BF-ID" => "",
                                        'STEP' => $this->stepOfAttribute("applicationModelFieldList"),

                                );

                        $amList = $this->getBrothers();
                        /**
                         * @var ApplicationModel $amItem
                         */
                        foreach ($amList as $amItem) {
                                $application_field_mfk = $amItem->getVal("application_field_mfk");
                                if (strlen($application_field_mfk) > 2) {
                                        $color = "yellow";
                                        $title_ar = "نسخ حقول SIS من " . $amItem->getDisplay("ar");
                                        $title_en = "copy SIS fields from " . $amItem->getDisplay("en");
                                        $methodName = "copySISFieldsFrom" . $amItem->id;
                                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "LABEL_EN" => $title_en, "PUBLIC" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("application_field_mfk"));
                                }

                                $thisAsCount = $this->getRelation("applicationStepList")->count();
                                $asCount = $amItem->getRelation("applicationStepList")->count();
                                if (($asCount > 1) and ($thisAsCount < $asCount or !$this->isActive())) {
                                        $color = "yellow";
                                        $title_ar = "تحديث المراحل من " . $amItem->getDisplay("ar") . " من $thisAsCount إلى $asCount خطوات";
                                        $title_en = "copy steps from " . $amItem->getDisplay("en") . " from $thisAsCount to $asCount steps";
                                        $methodName = "copyStepsFrom" . $amItem->id;
                                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "LABEL_EN" => $title_en, "PUBLIC" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("applicationStepList"));
                                }
                        }
                }




                return $pbms;
        }


        protected function afwCall($name, $arguments)
        {
                if (substr($name, 0, 17) == "copySISFieldsFrom") {
                        $amId = intval(substr($name, 17));
                        return $this->copySISFieldsFrom($amId, $arguments[0]);
                }

                if (substr($name, 0, 13) == "copyStepsFrom") {
                        $amId = intval(substr($name, 13));
                        return $this->copyStepsFrom($amId, $arguments[0]);
                }



                return false;
                // the above return should be keeped if not treated
        }

        public function copyStepsFrom($application_model_id, $lang = "ar")
        {
                if (!$this->id) return ["Application Model destination not found", ""];
                if (!$application_model_id) return ["Application Model source not found", ""];
                $amObj = self::loadById($application_model_id);
                if (!$amObj) return ["Application Model $application_model_id not found", ""];
                $asList = $amObj->get("applicationStepList");
                /**
                 * @var ApplicationStep $asItem
                 */
                $nb = 0;
                foreach ($asList as $asItem) {
                        $stepCopiedObj = $asItem->copyMeInto($this->id);
                        if ($stepCopiedObj) $nb += 1;
                }

                return ["", "$nb steps copied"];
        }

        public function copySISFieldsFrom($application_model_id, $lang = "ar")
        {
                $server_db_prefix = AfwSession::currentDBPrefix();

                $application_field_mfk = AfwDatabase::db_recup_value("select application_field_mfk from " . $server_db_prefix . "adm.application_model where id = $application_model_id");
                if (strlen($application_field_mfk) > 2) {
                        $this->set("application_field_mfk", $application_field_mfk);
                        $this->commit();
                        return ["", "copy of SIS fields done"];
                }

                return ["", "", "copy of incomplete SIS fields canceled"];
        }

        public function shouldBeCalculatedField($attribute)
        {
                if ($attribute == "level_degree_mfk") return true;
                if ($attribute == "pic_view") return true;
                return false;
        }

        public function getStepMax($general = true)
        {
                if ($general) $gen = 'Y';
                else $gen = 'N';

                return $this->getRelation("applicationStepList")->resetWhere("active='Y' and general='$gen'")->func("max(step_num)");
        }


        public function getFieldInStep($application_field_id, $step_num)
        {
                return $this->getRelation("applicationStepList")
                        ->resetWhere("active='Y' and step_num='$step_num' and show_field_mfk like '%,$application_field_id,%'")
                        ->func("count(id)");
        }

        public function getNextStepNumOf($step_num, $general)
        {
                $general_name = $general ? "general" : "special";
                if (!$this->stepMax[$general_name]) $this->stepMax[$general_name] = $this->getStepMax($general);
                $return = $step_num + 1;
                if ($return > $this->stepMax[$general_name]) $return = $this->stepMax[$general_name];
                return $return;
        }


        protected function getOtherLinksArray($mode, $genereLog = false, $step = "all")
        {
                $lang = AfwLanguageHelper::getGlobalLanguage();
                // $objme = AfwSession::getUserConnected();
                // $me = ($objme) ? $objme->id : 0;

                $otherLinksArray = $this->getOtherLinksArrayStandard($mode, $genereLog, $step);
                $my_id = $this->getId();
                $displ = $this->getDisplay($lang);

                if ($mode == "mode_academicLevelPrivilegeList") {
                        unset($link);
                        $link = array();
                        $title = "إضافة ميزة جديدة";
                        $title_detailed = $title . "لـ : " . $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=AcademicLevelPrivilege&currmod=adm&sel_academic_level_id=$my_id";
                        $link["TITLE"] = $title;
                        $link["PUBLIC"] = true;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;

                        /*
                                unset($link);
                                $link = array();
                                $title = "إدارة الميزات ";
                                $title_detailed = $title ."لـ : ". $displ;
                                $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=AcademicLevelPrivilege&currmod=adm&ids=all&sel_academic_level_id=$my_id&fixm=academic_level_id=$my_id&fixmtit=$title_detailed&newo=10";
                                $link["TITLE"] = $title;
                                $link["UGROUPS"] = array();
                                $otherLinksArray[] = $link;*/
                }

                if ($mode == "mode_academicLevelOfferingList") {
                        unset($link);
                        $link = array();
                        $title = "إضافة منشأة منفذة جديدة";
                        $title_detailed = $title . "لـ : " . $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=AcademicLevelOffering&currmod=adm&sel_academic_level_id=$my_id";
                        $link["TITLE"] = $title;
                        $link["PUBLIC"] = true;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                }

                if ($mode == "mode_applicationStepList") {
                        $objAS = new ApplicationStep();
                        $objAS->select("application_model_id", $my_id);
                        $nextStep = AfwSqlHelper::aggregFunction($objAS, "max(step_num)") + 1;
                        unset($link);
                        $link = array();
                        $title = "إضافة خطوة تقديم جديدة";
                        $title_detailed = $title . "لـ : " . $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=ApplicationStep&currmod=adm&sel_application_model_id=$my_id&sel_step_num=$nextStep";
                        $link["TITLE"] = $title;
                        $link["PUBLIC"] = true;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;

                        unset($link);
                        $link = array();
                        $title = "تعديل سريع على خطوات التقديم";
                        $title_detailed = $title . "لـ : " . $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=ApplicationStep&currmod=adm&fixm=application_model_id=$my_id&sel_application_model_id=$my_id&id_origin=$my_id&class_origin=ApplicationModel&module_origin=adm&step_origin=5&newo=-1";
                        $link["TITLE"] = $title;
                        $link["PUBLIC"] = true;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                }

                if ($mode == "mode_applicationPlanList") {
                        $academic_level_id = $this->getVal("academic_level_id");
                        $atArr = AcademicTerm::getComingTermsIds($academic_level_id, $nbTerms = 1);
                        $academic_term_id = $atArr[0];
                        $apObjExists = null;
                        if ($academic_term_id) $apObjExists = ApplicationPlan::loadByMainIndex($my_id, $academic_term_id);
                        if ($academic_term_id and (!$apObjExists)) {
                                unset($link);
                                $link = array();
                                $title = "إضافة خطة تقديم جديدة";
                                $title_detailed = $title . "لـ : " . $displ;
                                $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=ApplicationPlan&currmod=adm&sel_application_model_id=$my_id&sel_term_id=$academic_term_id";
                                $link["TITLE"] = $title;
                                $link["PUBLIC"] = true;
                                $link["UGROUPS"] = array();
                                $otherLinksArray[] = $link;
                        } elseif ($apObjExists) {
                                unset($link);
                                $link = array();
                                $title = "يوجد حاليا خطة جارية على الفصل القادم";
                                $title_detailed = $title . "لـ : " . $displ;
                                $link["URL"] = "#";
                                $link["TITLE"] = $title;
                                $link["PUBLIC"] = true;
                                $link["UGROUPS"] = array();
                                $otherLinksArray[] = $link;
                        } else {
                                $academic_level_show = $this->showAttribute("academic_level_id");
                                unset($link);
                                $link = array();
                                $title = "لا يوجد فصل جديد قادم على نفس المرحلة الدراسية [$academic_level_show] ليتم انشاء خطة جديدة عليه";
                                $title_detailed = $title . "لـ : " . $displ;
                                $link["URL"] = "#";
                                $link["COLOR"] = "red";
                                $link["TITLE"] = $title;
                                $link["PUBLIC"] = true;
                                $link["UGROUPS"] = array();
                                $otherLinksArray[] = $link;
                        }
                }

                if ($mode == "mode_financialTransactionList") {
                        unset($link);
                        $link = array();
                        $title = "إضافة بند جديد";
                        $title_detailed = $title . "لـ : " . $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=ApplicationModelFinancialTransaction&currmod=adm&sel_application_model_id=$my_id";
                        $link["TITLE"] = $title;
                        $link["PUBLIC"] = true;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                }
                
                if ($mode == "mode_engagementList") {
                        unset($link);
                        $link = array();
                        $title = "إضافة تعهد جديد";
                        $title_detailed = $title . "لـ : " . $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=ApplicationModelEngagement&currmod=adm&sel_application_model_id=$my_id";
                        $link["TITLE"] = $title;
                        $link["PUBLIC"] = true;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                }
                /*
                        if($mode=="mode_appModelApiList")
                        {
                                unset($link);
                                $link = array();
                                $title = "إضافة انخراط في خدمة جديدة";
                                $title_detailed = $title ."لـ : ". $displ;
                                $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=AppModelApi&currmod=adm&sel_application_model_id=$my_id";
                                $link["TITLE"] = $title;
                                $link["PUBLIC"] = true;
                                $link["UGROUPS"] = array();
                                $otherLinksArray[] = $link;
                        }*/

                // check errors on all steps (by default no for optimization)
                // rafik don't know why this : \//  = false;

                return $otherLinksArray;
        }

        // application_model 
        public function getScenarioItemId($currstep)
        {
                if ($currstep == 1) return 425;
                if ($currstep == 2) return 426;
                if ($currstep == 3) return 427;
                if ($currstep == 4) return 434;
                if ($currstep == 5) return 435;
                if ($currstep == 6) return 491;
                if ($currstep == 7) return 497;
                if ($currstep == 8) return 499;


                return 0;
        }

        public function beforeDelete($id, $id_replace)
        {
                $server_db_prefix = AfwSession::config("db_prefix", "uoh_");

                if (!$id) {
                        $id = $this->getId();
                        $simul = true;
                } else {
                        $simul = false;
                }

                if ($id) {
                        if ($id_replace == 0) {
                                // FK part of me - not deletable 
                                // adm.institution-محاكاة نموذج القبول	application_model_id  أنا تفاصيل لها (required field)
                                // require_once "../adm/institution.php";
                                $obj = new Institution();
                                $obj->where("application_model_id = '$id' and active='Y' ");
                                $nbRecords = $obj->count();
                                // check if there's no record that block the delete operation
                                if ($nbRecords > 0) {
                                        $this->deleteNotAllowedReason = "Used in some Institutions(s) as Simulate the application model";
                                        return false;
                                }
                                // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                                if (!$simul) $obj->deleteWhere("application_model_id = '$id' and active='N'");



                                // FK part of me - deletable 
                                // adm.program_track-نموذج القبول	application_model_id  أنا تفاصيل لها
                                if (!$simul) {
                                        // require_once "../adm/program_track.php";
                                        ProgramTrack::removeWhere("application_model_id='$id'");
                                        // $this->execQuery("delete from ${server_db_prefix}adm.program_track where application_model_id = '$id' ");

                                }


                                // adm.application_plan-نموذج القبول	application_model_id  أنا تفاصيل لها
                                if (!$simul) {
                                        // require_once "../adm/application_plan.php";
                                        ApplicationPlan::removeWhere("application_model_id='$id'");
                                        // $this->execQuery("delete from ${server_db_prefix}adm.application_plan where application_model_id = '$id' ");

                                }


                                // adm.application_model_branch-نموذج القبول	application_model_id  حقل يفلتر به
                                if (!$simul) {
                                        // require_once "../adm/application_model_branch.php";
                                        ApplicationModelBranch::removeWhere("application_model_id='$id'");
                                        // $this->execQuery("delete from ${server_db_prefix}adm.application_model_branch where application_model_id = '$id' ");

                                }


                                // adm.app_model_api-نموذج القبول	application_model_id  أنا تفاصيل لها
                                if (!$simul) {
                                        // require_once "../adm/app_model_api.php";
                                        AppModelApi::removeWhere("application_model_id='$id'");
                                        // $this->execQuery("delete from ${server_db_prefix}adm.app_model_api where application_model_id = '$id' ");

                                }


                                // adm.acondition_origin_scope-نموذج القبول	application_model_id  أنا تفاصيل لها
                                if (!$simul) {
                                        // require_once "../adm/acondition_origin_scope.php";
                                        AconditionOriginScope::removeWhere("application_model_id='$id'");
                                        // $this->execQuery("delete from ${server_db_prefix}adm.acondition_origin_scope where application_model_id = '$id' ");

                                }


                                // adm.application-نموذج القبول	application_model_id  أنا تفاصيل لها
                                if (!$simul) {
                                        // require_once "../adm/application.php";
                                        Application::removeWhere("application_model_id='$id'");
                                        // $this->execQuery("delete from ${server_db_prefix}adm.application where application_model_id = '$id' ");

                                }


                                // adm.application_step-نموذج القبول	application_model_id  أنا تفاصيل لها
                                if (!$simul) {
                                        // require_once "../adm/application_step.php";
                                        ApplicationStep::removeWhere("application_model_id='$id'");
                                        // $this->execQuery("delete from ${server_db_prefix}adm.application_step where application_model_id = '$id' ");

                                }


                                // adm.application_model_condition-نموذج القبول	application_model_id  أنا تفاصيل لها
                                if (!$simul) {
                                        // require_once "../adm/application_model_condition.php";
                                        ApplicationModelCondition::removeWhere("application_model_id='$id'");
                                        // $this->execQuery("delete from ${server_db_prefix}adm.application_model_condition where application_model_id = '$id' ");

                                }


                                // adm.application_model_field-نموذج القبول	application_model_id  أنا تفاصيل لها
                                if (!$simul) {
                                        // require_once "../adm/application_model_field.php";
                                        ApplicationModelField::removeWhere("application_model_id='$id'");
                                        // $this->execQuery("delete from ${server_db_prefix}adm.application_model_field where application_model_id = '$id' ");

                                }




                                // FK not part of me - replaceable 
                                // adm.aparameter_value-تخصيص على نموذج القبول	application_model_id  حقل يفلتر به
                                if (!$simul) {
                                        // require_once "../adm/aparameter_value.php";
                                        AparameterValue::updateWhere(array('application_model_id' => $id_replace), "application_model_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.aparameter_value set application_model_id='$id_replace' where application_model_id='$id' ");
                                }



                                // MFK
                                // adm.acondition_origin-نماذج القبول المعنية	application_model_mfk  حقل يفلتر به
                                if (!$simul) {
                                        // require_once "../adm/acondition_origin.php";
                                        AconditionOrigin::updateWhere(array('application_model_mfk' => "REPLACE(application_model_mfk, ',$id,', ',')"), "application_model_mfk like '%,$id,%'");
                                        // $this->execQuery("update ${server_db_prefix}adm.acondition_origin set application_model_mfk=REPLACE(application_model_mfk, ',$id,', ',') where application_model_mfk like '%,$id,%' ");
                                }
                        } else {
                                // FK on me 


                                // adm.institution-محاكاة نموذج القبول	application_model_id  أنا تفاصيل لها (required field)
                                if (!$simul) {
                                        // require_once "../adm/institution.php";
                                        Institution::updateWhere(array('application_model_id' => $id_replace), "application_model_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.institution set application_model_id='$id_replace' where application_model_id='$id' ");

                                }


                                // adm.program_track-نموذج القبول	application_model_id  أنا تفاصيل لها
                                if (!$simul) {
                                        // require_once "../adm/program_track.php";
                                        ProgramTrack::updateWhere(array('application_model_id' => $id_replace), "application_model_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.program_track set application_model_id='$id_replace' where application_model_id='$id' ");

                                }

                                // adm.application_plan-نموذج القبول	application_model_id  أنا تفاصيل لها
                                if (!$simul) {
                                        // require_once "../adm/application_plan.php";
                                        ApplicationPlan::updateWhere(array('application_model_id' => $id_replace), "application_model_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.application_plan set application_model_id='$id_replace' where application_model_id='$id' ");

                                }

                                // adm.application_model_branch-نموذج القبول	application_model_id  حقل يفلتر به
                                if (!$simul) {
                                        // require_once "../adm/application_model_branch.php";
                                        ApplicationModelBranch::updateWhere(array('application_model_id' => $id_replace), "application_model_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.application_model_branch set application_model_id='$id_replace' where application_model_id='$id' ");

                                }

                                // adm.app_model_api-نموذج القبول	application_model_id  أنا تفاصيل لها
                                if (!$simul) {
                                        // require_once "../adm/app_model_api.php";
                                        AppModelApi::updateWhere(array('application_model_id' => $id_replace), "application_model_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.app_model_api set application_model_id='$id_replace' where application_model_id='$id' ");

                                }

                                // adm.acondition_origin_scope-نموذج القبول	application_model_id  أنا تفاصيل لها
                                if (!$simul) {
                                        // require_once "../adm/acondition_origin_scope.php";
                                        AconditionOriginScope::updateWhere(array('application_model_id' => $id_replace), "application_model_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.acondition_origin_scope set application_model_id='$id_replace' where application_model_id='$id' ");

                                }

                                // adm.application-نموذج القبول	application_model_id  أنا تفاصيل لها
                                if (!$simul) {
                                        // require_once "../adm/application.php";
                                        Application::updateWhere(array('application_model_id' => $id_replace), "application_model_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.application set application_model_id='$id_replace' where application_model_id='$id' ");

                                }

                                // adm.application_step-نموذج القبول	application_model_id  أنا تفاصيل لها
                                if (!$simul) {
                                        // require_once "../adm/application_step.php";
                                        ApplicationStep::updateWhere(array('application_model_id' => $id_replace), "application_model_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.application_step set application_model_id='$id_replace' where application_model_id='$id' ");

                                }

                                // adm.application_model_condition-نموذج القبول	application_model_id  أنا تفاصيل لها
                                if (!$simul) {
                                        // require_once "../adm/application_model_condition.php";
                                        ApplicationModelCondition::updateWhere(array('application_model_id' => $id_replace), "application_model_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.application_model_condition set application_model_id='$id_replace' where application_model_id='$id' ");

                                }

                                // adm.application_model_field-نموذج القبول	application_model_id  أنا تفاصيل لها
                                if (!$simul) {
                                        // require_once "../adm/application_model_field.php";
                                        ApplicationModelField::updateWhere(array('application_model_id' => $id_replace), "application_model_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.application_model_field set application_model_id='$id_replace' where application_model_id='$id' ");

                                }

                                // adm.aparameter_value-تخصيص على نموذج القبول	application_model_id  حقل يفلتر به
                                if (!$simul) {
                                        // require_once "../adm/aparameter_value.php";
                                        AparameterValue::updateWhere(array('application_model_id' => $id_replace), "application_model_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.aparameter_value set application_model_id='$id_replace' where application_model_id='$id' ");
                                }


                                // MFK
                                // adm.acondition_origin-نماذج القبول المعنية	application_model_mfk  حقل يفلتر به
                                if (!$simul) {
                                        // require_once "../adm/acondition_origin.php";
                                        AconditionOrigin::updateWhere(array('application_model_mfk' => "REPLACE(application_model_mfk, ',$id,', ',$id_replace,')"), "application_model_mfk like '%,$id,%'");
                                        // $this->execQuery("update ${server_db_prefix}adm.acondition_origin set application_model_mfk=REPLACE(application_model_mfk, ',$id,', ',$id_replace,') where application_model_mfk like '%,$id,%' ");
                                }
                        }
                        return true;
                }
        }

        public function currentPlan($dateApplyGreg = "")
        {

                if (!$dateApplyGreg) $dateApplyGreg = date("Y-m-d");
                if (!$this->currentPlan[$dateApplyGreg]) {
                        $academic_level_id = $this->getVal("academic_level_id");
                        $objTerm = AcademicTerm::getCurrentTerm($academic_level_id, $dateApplyGreg);
                        if (!$objTerm or !$objTerm->id) $this->currentPlan[$dateApplyGreg] = null;
                        else $this->currentPlan[$dateApplyGreg] = ApplicationPlan::loadByMainIndex($this->id, $objTerm->id);
                        if (!$this->currentPlan[$dateApplyGreg]) $this->currentPlan[$dateApplyGreg] = "NOT-FOUND";
                }

                if ($this->currentPlan[$dateApplyGreg] == "NOT-FOUND") return null;

                return $this->currentPlan[$dateApplyGreg];
        }


        public function getNextPlans()
        {
                $application_model_id = $this->id;
                $academic_level_id = $this->getVal("academic_level_id");
                return ApplicationPlan::nextPlans($application_model_id, $academic_level_id);
        }

        public function calcQualification_mfk($what = "value")
        {
                if (!self::$arrQualificationMfk[$what][$this->id]) {
                        $levelObj = $this->het("academic_level_id");
                        if (!$levelObj) {
                                $mfk = "NOT-FOUND";
                        } else {
                                $min_qualification_level = $levelObj->getVal("min_qualification_level");
                                $max_qualification_level = $levelObj->getVal("max_qualification_level");
                                $mfk = Qualification::getQualificationIdList($min_qualification_level, $max_qualification_level, $what);
                        }

                        self::$arrQualificationMfk[$what][$this->id] = $mfk;
                }

                if (self::$arrQualificationMfk[$what][$this->id] == "NOT-FOUND") return ($what == "value") ? "," : [];

                return self::$arrQualificationMfk[$what][$this->id];
        }

        public function notRetrieve($field_name, $col_struct)
        {
                if (($field_name == "applicationModelBranchList") and ($col_struct == "DO-NOT-RETRIEVE-COLS")) {
                        $split_sorting_by_enum = $this->getVal("split_sorting_by_enum");
                        if ($split_sorting_by_enum == 1) {
                                return ["capacity_track2", "capacity_track3"];
                        } else return [];
                }

                throw new AfwRuntimeException("ApplicationModel::notRetrieve($field_name, $col_struct) not implemented");
        }

        public function isSynchronisedUniqueDesire()
        {
                return ($this->getVal("application_category_enum")==1);
        }

        public static function code_of_application_category_enum($lkp_id = null)
        {
                $lang = AfwLanguageHelper::getGlobalLanguage();
                if ($lkp_id) return self::application_category()['code'][$lkp_id];
                else return self::application_category()['code'];
        }

        public static function name_of_application_category_enum($application_category_enum, $lang = "ar")
        {
                return self::application_category()[$lang][$application_category_enum];
        }

        public static function list_of_application_category_enum($lang = null)
        {
                if (!$lang) $lang = AfwLanguageHelper::getGlobalLanguage();
                return self::application_category()[$lang];
        }

        public static function application_category()
        {
                $arr_list_of_application_category = array();


                $arr_list_of_application_category["code"][1] = "onesynchronised";
                $arr_list_of_application_category["ar"][1] = "رغبة واحدة مع المزامنة مع سجل التقديم";
                $arr_list_of_application_category["en"][1] = "One desire synchronised with the application record";

                $arr_list_of_application_category["code"][2] = "onenotsynchronised";
                $arr_list_of_application_category["ar"][2] = "رغبة واحدة بدون المزامنة مع سجل التقديم";
                $arr_list_of_application_category["en"][2] = "One desire not synchronised with the application record";

                $arr_list_of_application_category["code"][3] = "many";
                $arr_list_of_application_category["ar"][3] = "رغبات متعددة";
                $arr_list_of_application_category["en"][3] = "multi desires";




                return $arr_list_of_application_category;
        }


        public function synchronizeProgramsWithWorkflow($lang='ar')
        {
                $applicationModelBranchList = $this->get("applicationModelBranchList");
                foreach($applicationModelBranchList as $ambObj)
                {
                        $programObj = $ambObj->het("academic_program_id");
                        if($programObj and $programObj->id)
                        {
                                $programObj->synchronizeWithWorkflow(1, $lang);
                        }
                }

                return ['', 'done'];
        }
}
