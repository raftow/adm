<?php


$file_dir_name = dirname(__FILE__);

// require_once("$file_dir_name/../afw/afw.php");

class SortingSession extends AFWObject
{

    public static $MY_ATABLE_ID = 13952;

    public static $DATABASE            = "uoh_adm";
    public static $MODULE            = "adm";
    public static $TABLE            = "sorting_session";

    public static $DB_STRUCTURE = null;

    public function __construct()
    {
        parent::__construct("sorting_session", "id", "adm");
        AdmSortingSessionAfwStructure::initInstance($this);
    }


    protected function afterSetAttribute($attribute)
    {
        if (($attribute == "application_plan_id") and (!$this->getVal("session_num"))) {
            $applicationPlanObj = $this->het("application_plan_id");
            if ($applicationPlanObj) {
                $application_plan_id = $applicationPlanObj->id;
                $session_num = $applicationPlanObj->getRelation("sortingSessionList")->func("max(session_num)") + 1;
                if ($session_num == 1) {
                    $sorting_start_date = $applicationPlanObj->getVal("sorting_start_date");
                    if (!$sorting_start_date) {
                        $application_end_date = $applicationPlanObj->getVal("application_end_date");
                        $sorting_start_date = AfwDateHelper::shiftGregDate($application_end_date, 1);
                    }
                    $sorting_end_date = $applicationPlanObj->getVal("sorting_end_date");
                } elseif ($session_num > 1) {
                    $sessPrevious = self::loadByMainIndex($application_plan_id, $session_num - 1);
                    if ($sessPrevious) {
                        $prev_end_date = $sessPrevious->getVal("end_date");
                        $sorting_start_date = AfwDateHelper::shiftGregDate($prev_end_date, 1);
                    }
                    $sorting_end_date = $applicationPlanObj->getVal("sorting_end_date");
                }
                $this->set("start_date", $sorting_start_date);

                if (!$sorting_end_date) $sorting_end_date = AfwDateHelper::shiftGregDate($sorting_start_date, 15);
                $this->set("end_date", $sorting_end_date);

                $days_for_revision_and_validate = AfwSession::config("days_for_revision_and_validate", 1);
                $validate_date = AfwDateHelper::shiftGregDate($sorting_end_date, $days_for_revision_and_validate);
                $this->set("validate_date", $validate_date);
                $this->set("validated", "N");

                $days_between_validate_and_publish_sorting = AfwSession::config("days_between_validate_and_publish_sorting", 2);
                $publish_date = AfwDateHelper::shiftGregDate($validate_date, $days_between_validate_and_publish_sorting);
                $this->set("publish_date", $publish_date);
                $this->set("published", "N");
                
                $days_between_publish_sorting_and_last_approve = AfwSession::config("days_between_publish_sorting_and_last_approve", 3);
                $last_approve_date = AfwDateHelper::shiftGregDate($publish_date, $days_between_publish_sorting_and_last_approve);
                $this->set("last_approve_date", $last_approve_date);


                $this->set("session_num", $session_num);

                
                
            }
        }


        return true;
    }



    public static function loadById($id)
    {
        $obj = new SortingSession();
        $obj->select_visibilite_horizontale();
        if ($obj->load($id)) {
            return $obj;
        } else return null;
    }

    public static function loadByMainIndex($application_plan_id, $session_num, $create_obj_if_not_found = false)
    {
        $obj = new SortingSession();
        $obj->select("application_plan_id", $application_plan_id);
        $obj->select("session_num", $session_num);

        if ($obj->load()) {
            if ($create_obj_if_not_found) $obj->activate();
            return $obj;
        } elseif ($create_obj_if_not_found) {
            $obj->set("application_plan_id", $application_plan_id);
            $obj->set("session_num", $session_num);

            $obj->insertNew();
            if (!$obj->id) return null; // means beforeInsert rejected insert operation
            $obj->is_new = true;
            return $obj;
        } else return null;
    }


    public function getScenarioItemId($currstep)
    {

        return 0;
    }


    public function getDisplay($lang = "ar")
    {
        return $this->getVal("name_$lang");
    }





    protected function getOtherLinksArray($mode, $genereLog = false, $step = "all")
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        // $objme = AfwSession::getUserConnected();
        // $me = ($objme) ? $objme->id : 0;

        $otherLinksArray = $this->getOtherLinksArrayStandard($mode, $genereLog, $step);
        $my_id = $this->getId();
        $displ = $this->getDisplay($lang);



        // check errors on all steps (by default no for optimization)
        // rafik don't know why this : \//  = false;

        return $otherLinksArray;
    }

    

    public function fld_CREATION_USER_ID()
    {
        return "created_by";
    }

    public function fld_CREATION_DATE()
    {
        return "created_at";
    }

    public function fld_UPDATE_USER_ID()
    {
        return "updated_by";
    }

    public function fld_UPDATE_DATE()
    {
        return "updated_at";
    }

    public function fld_VALIDATION_USER_ID()
    {
        return "validated_by";
    }

    public function fld_VALIDATION_DATE()
    {
        return "validated_at";
    }

    public function fld_VERSION()
    {
        return "version";
    }

    public function fld_ACTIVE()
    {
        return  "active";
    }

    public function isTechField($attribute)
    {
        return (($attribute == "created_by") or ($attribute == "created_at") or ($attribute == "updated_by") or ($attribute == "updated_at") or ($attribute == "validated_by") or ($attribute == "validated_at") or ($attribute == "version"));
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


    public function genereName($lang = "ar", $which = "all", $commit = true)
    {
        if (($which == "all") or ($which == "ar")) {
            $num = $this->getVal("session_num");
            if (!$num) $num = 1;
            $new_name = "كرة الفرز رقم $num";
            $this->set("name_ar", $new_name);
        }

        if (($which == "all") or ($which == "en")) {
            $num = $this->getVal("session_num");
            if (!$num) $num = 1;
            $new_name = "sorting session number $num";
            $this->set("name_en", $new_name);
        }

        // $this->set("gender_enum", $tunitObj->getVal("gender_enum"));

        if ($commit) $this->commit();

        return ["", "تم تصفير مسمى كرة الفرز بنجاح"];
    }

    public function beforeMaj($id, $fields_updated)
    {
        if ($fields_updated["session_num"]) {
            if (!$this->getVal("name_ar") or ($this->getVal("name_ar") == "--")) {
                $this->genereName("ar", "ar", false);
            }

            if (!$this->getVal("name_en") or ($this->getVal("name_en") == "--")) {
                $this->genereName("en", "en", false);
            }
        }


        return true;
    }


    public function validate($lang = "ar", $commit = true)
    {
        $err_arr = [];
        $inf_arr = [];
        $war_arr = [];
        $tech_arr = [];
        
        $this->set("validated", "Y");
        // $validate_date = date("Y-m-d");
        // $this->set("validate_date", $validate_date);
        // $days_between_validate_and_publish_sorting = AfwSession::config("days_between_validate_and_publish_sorting", 2);
        // $publish_date = AfwDateHelper::shiftGregDate($validate_date, $days_between_validate_and_publish_sorting);
        // $this->set("publish_date", $publish_date);
        $this->set("published", "N");
        // $days_between_publish_sorting_and_last_approve = AfwSession::config("days_between_publish_sorting_and_last_approve", 3);
        // $last_approve_date = AfwDateHelper::shiftGregDate($publish_date, $days_between_publish_sorting_and_last_approve);
        // $this->set("last_approve_date", $last_approve_date);
        $this->set("upgraded", "N");
        

        if ($commit) $this->commit();
        $inf_arr[] = $this->tm("the sorting session has been successfully published");

        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
    }

    public function unvalidate($lang = "ar", $commit = true)
    {
        $err_arr = [];
        $inf_arr = [];
        $war_arr = [];
        $tech_arr = [];

        $this->set("validated", "N");
        if ($commit) $this->commit();
        $inf_arr[] = $this->tm("the sorting session has been successfully unvalidated");

        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
    }

    public function publish($lang = "ar", $commit = true)
    {
        $err_arr = [];
        $inf_arr = [];
        $war_arr = [];
        $tech_arr = [];

        $this->set("published", "Y");
        // $publish_date = date("Y-m-d");
        // $this->set("publish_date", $publish_date);
        // $days_between_publish_sorting_and_last_approve = AfwSession::config("days_between_publish_sorting_and_last_approve", 3);
        // $last_approve_date = AfwDateHelper::shiftGregDate($publish_date, $days_between_publish_sorting_and_last_approve);
        // $this->set("last_approve_date", $last_approve_date);
        $this->set("upgraded", "N");
        

        if ($commit) $this->commit();
        $inf_arr[] = $this->tm("the sorting session has been successfully published");

        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
    }

    public function unpublish($lang = "ar", $commit = true)
    {
        $err_arr = [];
        $inf_arr = [];
        $war_arr = [];
        $tech_arr = [];

        $this->set("published", "N");
        if ($commit) $this->commit();
        $inf_arr[] = $this->tm("the sorting session has been successfully unpublished");

        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
    }

    

    public function attributeIsApplicable($attribute)
    {
            if(($attribute=="published") or ($attribute=="upgraded")) 
            {
                return ($this->sureIs("validated"));
            }

            if(($attribute=="name_ar") or ($attribute=="name_en")) 
            {
                return ($this->id>0);
            }
            

            return true;
    }


    public function calcApplication_ongoing($what = "value")
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        list($yes , $no, $euh) = $this->translateMyYesNo("application_ongoing", $what, $lang);
        $applicationSimulationObj = $this->het("application_simulation_id");
        if(!$applicationSimulationObj) return $euh;


        $sorting_start_date = $this->getVal("start_date");
        $sorting_end_date = $this->getVal("end_date"); 
        $now = date("Y-m-d");

        $period_of_sorting = (($now>=$sorting_start_date) and ($now<=$sorting_end_date));

        if($applicationSimulationObj->id==2) // reelle not simulation
        {
            return $period_of_sorting ? $no : $yes;
        }

        if($applicationSimulationObj->isRunning() or (!$period_of_sorting)) return $yes;
        return $no;
    }

    public function calcSorting_step_id($what = "value")
    {
        $planObj = $this->het("application_plan_id");
        if(!$planObj) return -1;
        
        $application_model_id = $planObj->getVal("application_model_id");
        if(!$application_model_id) return -2;

        $sortingStep = ApplicationStep::loadSortingStep($application_model_id);

        return $sortingStep->id;
        
    }

    
    public function calcNb_desires($what = "value")
    {
        return $this->getRelation("applicationDesireList")->count();
    }

    /**
     * @todo implement this method ASAP
     */
    public function isExecuted()
    {
        return false;
    }

    /**
     * @todo implement this method ASAP
     */
    public function sortingHasStarted()
    {
        return $this->sureIs("started_ind");
    }

    protected function getPublicMethods()
    {
        
        $pbms = array();

        if($this->sureIs("validated"))
        {
            if($this->sureIs("published"))
            {
                $methodConfirmationWarningEn = "You formally agree that the sorting results are not correct and you want to unpublish them";
                $methodConfirmationWarning = $this->tm($methodConfirmationWarningEn, "ar");
                $methodConfirmationQuestionEn = "Are you sure you want to do this action ?";
                $methodConfirmationQuestion = $this->tm($methodConfirmationQuestionEn, "ar");
                            
                $color = "orange";
                $title_ar = "الغاء نشر الفرز";
                $methodName = "unpublish";
                $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, 
                                                "ADMIN-ONLY" => true, "BF-ID" => "", 
                                                'CONFIRMATION_NEEDED' => true,
                                                'CONFIRMATION_WARNING' => array('ar' => $methodConfirmationWarning, 'en' => $methodConfirmationWarningEn),
                                                'CONFIRMATION_QUESTION' => array('ar' => $methodConfirmationQuestion, 'en' => $methodConfirmationQuestionEn),
                                                'STEP' => $this->stepOfAttribute("published"));
            }    
            else
            {
                $methodConfirmationWarningEn = "You formally agree that the sorting results are correct and ready for publish";
                $methodConfirmationWarning = $this->tm($methodConfirmationWarningEn, "ar");
                $methodConfirmationQuestionEn = "Are you sure you want to do this action ?";
                $methodConfirmationQuestion = $this->tm($methodConfirmationQuestionEn, "ar");
                
                $color = "green";
                $title_ar = "نشر الفرز";
                $methodName = "publish";
                $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, 
                                                    "ADMIN-ONLY" => true, "BF-ID" => "", 
                                                    'CONFIRMATION_NEEDED' => true,
                                                    'CONFIRMATION_WARNING' => array('ar' => $methodConfirmationWarning, 'en' => $methodConfirmationWarningEn),
                                                    'CONFIRMATION_QUESTION' => array('ar' => $methodConfirmationQuestion, 'en' => $methodConfirmationQuestionEn),
                                                    'STEP' => $this->stepOfAttribute("published"));



                $methodConfirmationWarningEn = "You formally agree that the sorting results are not correct and you want to unpublish them";
                $methodConfirmationWarning = $this->tm($methodConfirmationWarningEn, "ar");
                $methodConfirmationQuestionEn = "Are you sure you want to do this action ?";
                $methodConfirmationQuestion = $this->tm($methodConfirmationQuestionEn, "ar");
                            
                $color = "orange";
                $title_ar = "الغاء اعتماد الفرز";
                $methodName = "unvalidate";
                $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, 
                                                "ADMIN-ONLY" => true, "BF-ID" => "", 
                                                'CONFIRMATION_NEEDED' => true,
                                                'CONFIRMATION_WARNING' => array('ar' => $methodConfirmationWarning, 'en' => $methodConfirmationWarningEn),
                                                'CONFIRMATION_QUESTION' => array('ar' => $methodConfirmationQuestion, 'en' => $methodConfirmationQuestionEn),
                                                'STEP' => $this->stepOfAttribute("published"));
            }
        }    
        elseif($this->isExecuted())
        {
            $methodConfirmationWarningEn = "You formally agree that the sorting results are correct and ready for publish";
            $methodConfirmationWarning = $this->tm($methodConfirmationWarningEn, "ar");
            $methodConfirmationQuestionEn = "Are you sure you want to do this action ?";
            $methodConfirmationQuestion = $this->tm($methodConfirmationQuestionEn, "ar");
            
            $color = "green";
            $title_ar = "اعتماد الفرز";
            $methodName = "validate";
            $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, 
                                                "ADMIN-ONLY" => true, "BF-ID" => "", 
                                                'CONFIRMATION_NEEDED' => true,
                                                'CONFIRMATION_WARNING' => array('ar' => $methodConfirmationWarning, 'en' => $methodConfirmationWarningEn),
                                                'CONFIRMATION_QUESTION' => array('ar' => $methodConfirmationQuestion, 'en' => $methodConfirmationQuestionEn),
                                                'STEP' => $this->stepOfAttribute("published"));
        }
        elseif(!$this->sureIs("application_ongoing"))
        {
            $methodConfirmationWarningEn = "You agree that the application data and desires are correct and ready for sorting";
            $methodConfirmationWarning = $this->tm($methodConfirmationWarningEn, "ar");
            $methodConfirmationQuestionEn = "Are you sure you want to do this action ?";
            $methodConfirmationQuestion = $this->tm($methodConfirmationQuestionEn, "ar");
            
            $color = "blue";
            $title_ar = "تنفيذ الفرز";
            $title_en = "Run the sorting";
            $methodName = "runSorting";
            $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "LABEL_EN" => $title_en, 
                                                "ADMIN-ONLY" => true, "BF-ID" => "", 
                                                'CONFIRMATION_NEEDED' => true,
                                                'CONFIRMATION_WARNING' => array('ar' => $methodConfirmationWarning, 'en' => $methodConfirmationWarningEn),
                                                'CONFIRMATION_QUESTION' => array('ar' => $methodConfirmationQuestion, 'en' => $methodConfirmationQuestionEn),
                                                'STEP' => $this->stepOfAttribute("nb_desires"));
        }

        
        

        return $pbms;
    }

    public function postSortingStats($arrDataMinAccepted)    
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        $application_simulation_id = $this->getVal("application_simulation_id");
        $applicationPlanObj = $this->het("application_plan_id");
        $application_plan_id = $this->getVal("application_plan_id");
        $session_num = $this->getVal("session_num");
        $application_model_id = ApplicationPlan::getApplicationModelId($application_plan_id);

        $statsData = [];
        
        $applicationPlanBranchList = $applicationPlanObj->get("applicationPlanBranchList");

        $maxPaths = SortingPath::nbPaths($application_model_id);
        /*
        $pathData = [];
        for ($spath = 1; $spath <= $maxPaths; $spath++) 
        {
            $pathData[$spath]["ar"] = SortingPath::trackTranslation($application_model_id, $spath, "ar");
            $pathData[$spath]["en"] = SortingPath::trackTranslation($application_model_id, $spath, "en");
        }*/

        /**
         * @var ApplicationPlanBranch $applicationPlanBranchItem
         */
        foreach($applicationPlanBranchList as $applicationPlanBranchItem)
        {
            // foreach($pathData as $spath => $spathLabel)
            for ($spath = 1; $spath <= $maxPaths; $spath++) 
            {
                if($applicationPlanBranchItem->attributeIsApplicable("capacity_track$spath"))
                {

                    $rowData = $arrDataMinAccepted[$applicationPlanBranchItem->id];
                    $rowData["application_plan_branch_id"] = $applicationPlanBranchItem->id;
                    // $rowData["tunit_ar"] = $applicationPlanBranchItem->showAttribute("training_unit_id",null,true,"ar");
                    // $rowData["tunit_en"] = $applicationPlanBranchItem->showAttribute("training_unit_id",null,true,"en");
                    // $rowData["program_ar"] = $applicationPlanBranchItem->showAttribute("program_id",null,true,"ar");
                    // $rowData["program_en"] = $applicationPlanBranchItem->showAttribute("program_id",null,true,"en");
                    // $rowData["gender_ar"] = $applicationPlanBranchItem->showAttribute("gender_enum",null,true,"ar");
                    // $rowData["gender_en"] = $applicationPlanBranchItem->showAttribute("gender_enum",null,true,"en");
                    $rowData["track_num"] = $spath;
                    // $rowData["track_ar"] = $spathLabel["ar"];
                    // $rowData["track_ar"] = $spathLabel["en"];
                    $rowData["capacity"] = $applicationPlanBranchItem->getVal("capacity_track$spath");
                    list($rowData["min_app_score1"], $rowData["min_app_score2"], $rowData["min_app_score3"]) = $applicationPlanBranchItem->getMinAppliedScore($application_simulation_id, $application_model_id);
                    $statsData[] = $rowData;
                    // $rowData["nb_free"] = $rowData["capacity"] - $rowData["nb_acc"];

                    $obStat = SortingSessionStat::loadByMainIndex($application_plan_id,$session_num,$application_simulation_id,$applicationPlanBranchItem->id,$spath, true);
                    $obStat->set("capacity", $rowData["capacity"]);
                    $obStat->set("nb_accepted", $rowData["nb_accepted"]);
                    $obStat->set("min_app_score1", $rowData["min_app_score1"]);
                    $obStat->set("min_app_score2", $rowData["min_app_score2"]);
                    $obStat->set("min_app_score3", $rowData["min_app_score3"]);
                    $obStat->set("min_acc_score1", $rowData["min_acc_score1"]);
                    $obStat->set("min_acc_score2", $rowData["min_acc_score2"]);
                    $obStat->set("min_acc_score3", $rowData["min_acc_score3"]);
                    $obStat->commit();
                    
                    


                }
            }
        }


        
    }


    public function calcStatsPanel($what = "value")
    {
        $application_simulation_id = $this->getVal("application_simulation_id");
        $application_plan_id = $this->getVal("application_plan_id");
        $application_model_id = ApplicationPlan::getApplicationModelId($application_plan_id);

        $sorting_step_id = $this->calc("sorting_step_id");
        $lang = AfwLanguageHelper::getGlobalLanguage();
        
        $html = "<div class='sorting-panel'>";  
        $html .= "<div class='stats-panel'>";  
        $html .= "   <div id=\"stats_panel\" class=\"stats panel\" >";
        $server_db_prefix = AfwSession::config("db_prefix", "default_db_");

        $sortingGroupList = $this->get("sortingGroupList");
        $keyDecodeArr = [];
        foreach($sortingGroupList as $sortingGroupId => $sortingGroupItem)
        {
            $keyDecodeArr[$sortingGroupId] = $sortingGroupItem->getDisplay($lang);
        }
        // die("keyDecodeArr = ".var_export($keyDecodeArr,true));
        $sql_nb_by_sorting_group = "SELECT sorting_group_id, count(*) as nb FROM ".$server_db_prefix."adm.`application_desire` WHERE `application_simulation_id`=$application_simulation_id and application_step_id=$sorting_step_id and active = 'Y' group by sorting_group_id";
        $rows_by_sorting_group = AfwDatabase::db_recup_index($sql_nb_by_sorting_group,"sorting_group_id","nb");
        $html .= "<h1>".$this->translate("sorting group stats", $lang)."</h1>";
        $html .= AfwHtmlHelper::arrayToHtml($rows_by_sorting_group, $keyDecodeArr);

        unset($keyDecodeArr);
        $keyDecodeArr = [];
        $maxPaths = SortingPath::nbPaths($application_model_id);
        for ($spath = 1; $spath <= $maxPaths; $spath++) 
        {
            $keyDecodeArr[$spath] = SortingPath::trackTranslation($application_model_id, $spath, $lang);
        }
        
        
        $sql_nb_by_sorting_path = "SELECT track_num, count(*) as nb FROM ".$server_db_prefix."adm.`application_desire` WHERE `application_simulation_id`=$application_simulation_id and application_step_id=$sorting_step_id and active = 'Y' group by track_num";
        $rows_by_sorting_path = AfwDatabase::db_recup_index($sql_nb_by_sorting_path,"track_num","nb");
        $html .= "<h1>".$this->translate("sorting path stats", $lang)."</h1>";
        $html .= AfwHtmlHelper::arrayToHtml($rows_by_sorting_path, $keyDecodeArr);
        
        $html .= "   </div> <!-- stats_panel -->";   
        $html .= "</div> <!-- stats-panel -->";
        $html .= "</div> <!-- sorting-panel -->";
        return $html;
    }

    public static function isSameScore($new_score, $old_score, $field_name_1, $field_name_2, $field_name_3)
    {
        if(!$old_score) return false;
            // @todo make it parametrable
            $ignored_epsilon1 = 0.0001;
            $ignored_epsilon2 = 0.0001;
            $ignored_epsilon3 = 0.0001;
            list($nv1, $nv2, $nv3) = $new_score;
            list($bv1, $bv2, $bv3) = $old_score;
            return ((abs($nv1-$bv1)<$ignored_epsilon1) and (abs($nv2-$bv2)<$ignored_epsilon2) and (abs($nv3-$bv3)<$ignored_epsilon3));

    }

    


    public function runSorting($lang = "ar", $preSorting = true)
    {
        global $MODE_BATCH_LOURD;
        $old_MODE_BATCH_LOURD = $MODE_BATCH_LOURD;
        $MODE_BATCH_LOURD = true;

        $session_num = $this->getVal("session_num");
        $sortingGroupList = $this->get("sortingGroupList");
        $application_plan_id = $this->getVal("application_plan_id");
        $application_simulation_id = $this->getVal("application_simulation_id");

        $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
        
        if(!$session_num) return ["Please define session num for this sorting session", ""];
        if(!$application_plan_id) return ["Please define application plan for this sorting session", ""];
        if(!$application_simulation_id) return ["Please define application simulation type for this sorting session", ""];
        
        $application_model_id = ApplicationPlan::getApplicationModelId($application_plan_id);
        // $appModelObj = ApplicationModel::loadById($application_model_id);
        // $split_sorting_by_enum = $appModelObj->getVal("split_sorting_by_enum");
        // $academic_program_id = $this->getVal("program_id");
        $maxPaths = SortingPath::nbPaths($application_model_id);
        // die("$maxPaths = SortingPath::nbPaths($application_model_id);");

        $this->set("started_ind", "Y");
        $this->commit();

        // @todo : bring from aparameter value
        $MAX_DESIRES = 50;

        if($preSorting)
        {
            $sorting_path_tmp_table = $server_db_prefix."adm.`farz_ap".$application_plan_id."_as".$application_simulation_id."_k".$session_num."_sorting_path`";
            $sorting_path_tmp_sql_drop = "DROP TABLE IF EXISTS $sorting_path_tmp_table;";
            AfwDatabase::db_query($sorting_path_tmp_sql_drop);

            $sorting_path_tmp_sql_create = "CREATE TABLE IF NOT EXISTS $sorting_path_tmp_table as select * from ".$server_db_prefix."adm.sorting_path where application_model_id=$application_model_id";
            AfwDatabase::db_query($sorting_path_tmp_sql_create);


            $sorting_group_tmp_table = $server_db_prefix."adm.`farz_ap".$application_plan_id."_as".$application_simulation_id."_k".$session_num."_sorting_group`";
            $sorting_group_tmp_sql_drop = "DROP TABLE IF EXISTS $sorting_group_tmp_table;";
            AfwDatabase::db_query($sorting_group_tmp_sql_drop);

            $sorting_group_tmp_sql_create = "CREATE TABLE IF NOT EXISTS $sorting_group_tmp_table as select * from ".$server_db_prefix."adm.sorting_group where 1";
            AfwDatabase::db_query($sorting_group_tmp_sql_create);
        }

        $arrDataMinAccepted = [];
        

        foreach($sortingGroupList as $sortingGroupId => $sortingGroupItem)
        {            
            list($sortingCriterea,
            $sf1,$sf1_order_sens,$sf1_sql,$sf1_insert,$sf1_order,
            $sf2,$sf2_order_sens,$sf2_sql,$sf2_insert,$sf2_order,
            $sf3,$sf3_order_sens,$sf3_sql,$sf3_insert,$sf3_order) = SortingGroup::getSortingCriterea($sortingGroupId);

            for ($spath = 1; $spath <= $maxPaths; $spath++) 
            {
                $branchsCapacityMatrix = ApplicationPlanBranch::getBranchsCapacityMatrix($sortingGroupId, $spath);
                $branchsLastScoreMatrix = [];
                $applicantsDesiresMatrix = ApplicationDesire::getApplicantsDesiresMatrix($application_plan_id, $application_simulation_id, $sortingGroupId, $spath);
                $sorting_table_without_prefix = "farz_ap".$application_plan_id."_as".$application_simulation_id."_k".$session_num."_sg$sortingGroupId"."_pth$spath";
                $sorting_table = $server_db_prefix."adm.".$sorting_table_without_prefix;
                AfwSession::setConfig("$sorting_table_without_prefix-sql-analysis-max-calls",80000000);
                if($preSorting)
                {
                    
                    $ff_sql = "";
                    $ff_insert = "";
                    for($f=1;$f<=9;$f++)
                    {
                        $ff = $sortingCriterea["f$f"];
                        $ff_sql .= $ff ? "formula_value_$f float NOT NULL, " : "";
                        $ff_insert .= $ff ? "formula_value_$f, " : "";
                    }

                    
                    $sql_drop = "DROP TABLE IF EXISTS $sorting_table;";

                    AfwDatabase::db_query($sql_drop);

                    $sql_create = "CREATE TABLE $sorting_table (
                    `applicant_id` bigint(20) NOT NULL,
                    $sf1_sql  
                    $sf2_sql
                    $sf3_sql

                    $ff_sql
                    sorting_num smallint DEFAULT NULL, 
                    assigned_desire_num smallint DEFAULT NULL, 
                    desire_status smallint DEFAULT 0, 
                    application_plan_branch_id int(11) NULL, 
                    PRIMARY KEY (`applicant_id`)
                    ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;";

                    AfwDatabase::db_query($sql_create);


                    $sql_insert = "INSERT INTO $sorting_table 
                                    (applicant_id, $sf1_insert $sf2_insert $sf3_insert $ff_insert assigned_desire_num)".
                                "SELECT applicant_id, $sf1_insert $sf2_insert $sf3_insert $ff_insert min(desire_num) as assigned_desire_num
                                    FROM ".$server_db_prefix."adm.application_desire
                                    WHERE application_plan_id = $application_plan_id 
                                    AND application_simulation_id = $application_simulation_id 
                                    AND sorting_group_id = $sortingGroupId
                                    AND track_num = $spath
                                    AND active = 'Y'
                                    GROUP BY applicant_id, $sf1_insert $sf2_insert $sf3_insert active  
                                    ";


                    AfwDatabase::db_query($sql_insert);
                }

                $sql_farz = "SELECT * FROM $sorting_table order by $sf1_order $sf2_order $sf3_order applicant_id asc";

                $farzRows = AfwDatabase::db_recup_rows($sql_farz);
                $sorting_num = 0;
                $nb_desire_assigned = 0;
                $nb_desire_assign_failed = 0;
                $applicant_assign_failed = "";
                $old_score = null;
                foreach($farzRows as $farzRow)
                {
                    $applicant_id = $farzRow["applicant_id"];
                    $new_score = [$farzRow["sorting_value_1"], $farzRow["sorting_value_2"], $farzRow["sorting_value_3"] ];
                    if(!self::isSameScore($new_score, $old_score, $sf1["field_name"], $sf2["field_name"], $sf3["field_name"]))
                    {
                        $sorting_num++;
                        $old_score = $new_score;
                    }

                    // try yo assign him the best desire possible
                    $desire_num_to_assign = 0;
                    $desire_assigned = 0;
                    $application_plan_branch_id_assigned = 0;
                    while((!$desire_assigned) and ($desire_num_to_assign<$MAX_DESIRES))
                    {
                        $desire_num_to_assign++;
                        $application_plan_branch_id_to_assign = $applicantsDesiresMatrix[$applicant_id][$desire_num_to_assign];
                        $mandatoryToGiveAsPreviouslyGivedForSameScore = false;
                        if(self::isSameScore($new_score, $branchsLastScoreMatrix[$application_plan_branch_id_to_assign], $sf1["field_name"], $sf2["field_name"], $sf3["field_name"]))
                        {
                            $mandatoryToGiveAsPreviouslyGivedForSameScore = true;
                        }
                        
                        if($mandatoryToGiveAsPreviouslyGivedForSameScore or ($branchsCapacityMatrix[$application_plan_branch_id_to_assign]>0))
                        {
                            $desire_assigned = $desire_num_to_assign;
                            $application_plan_branch_id_assigned = $application_plan_branch_id_to_assign;
                            $branchsLastScoreMatrix[$application_plan_branch_id_assigned] = $new_score;
                            
                            unset($rowDataMinAccepted);
                            $rowDataMinAccepted = [];

                            list($rowDataMinAccepted["min_acc_score1"], 
                                    $rowDataMinAccepted["min_acc_score2"],
                                    $rowDataMinAccepted["min_acc_score3"]) = $new_score;
                            $arrDataMinAccepted[$application_plan_branch_id_assigned] = $rowDataMinAccepted;
                            // decrease seats available as one seat is assigned
                            $branchsCapacityMatrix[$application_plan_branch_id_assigned]--;
                            if(!$arrDataMinAccepted[$application_plan_branch_id_assigned]["nb_accepted"])
                            {
                                $arrDataMinAccepted[$application_plan_branch_id_assigned]["nb_accepted"] = 1;
                            }
                            else
                            {
                                $arrDataMinAccepted[$application_plan_branch_id_assigned]["nb_accepted"]++;
                            }
                            break;
                        }
                    }

                    if($desire_assigned)
                    {
                        $nb_desire_assigned++;
                    }
                    else
                    {
                        $nb_desire_assign_failed++;
                        $applicant_assign_failed = $applicant_id;
                    }

                    $sql_sorting_applicant = "UPDATE $sorting_table set sorting_num=$sorting_num, assigned_desire_num=$desire_assigned, application_plan_branch_id=$application_plan_branch_id_assigned where applicant_id=$applicant_id";
                    AfwDatabase::db_query($sql_sorting_applicant);
                }
            }
                
        }

        $this->postSortingStats($arrDataMinAccepted);


        $MODE_BATCH_LOURD = $old_MODE_BATCH_LOURD;

        AfwQueryAnalyzer::resetQueriesExecuted();

        return ["", "Nb applicants assigned = $nb_desire_assigned, Nb applicants can not assign = $nb_desire_assign_failed, [example applicant failed to assign $applicant_assign_failed]"];

    }


}



// errors 
