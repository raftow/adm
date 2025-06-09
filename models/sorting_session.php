<?php


$file_dir_name = dirname(__FILE__);

// require_once("$file_dir_name/../afw/afw.php");

class SortingSession extends AFWObject
{
    private $nb_desires = null;
    private $nb_applications = null;
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



    public static function loadScheduled()
    {
        $obj = new SortingSession();
        $obj->select_visibilite_horizontale();
        $obj->where("settings like 'SCHEDULE=%'");
        if($obj->load()) return $obj;
        else return null;
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
            $new_name = "تنفيذ الفرز رقم $num";
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

        return ["", "تم تصفير مسمى تنفيذ الفرز بنجاح"];
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

            if(($attribute=="colors_legend") or 
               ($attribute=="statList") or
               ($attribute=="validate_date") or
               ($attribute=="publish_date") or
               ($attribute=="last_approve_date") or
               ($attribute=="validated") or
               ($attribute=="published") or
               ($attribute=="upgraded")) 
            {      
                return $this->sortingHasStarted();
            }
            

            return true;
    }



    public function calcSorting_ready_details($what = "value")
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();

        $hours = AfwDateHelper::timeDiffInHours(date("Y-m-d H:i:s"), $this->getVal("stats_date"));
        if($hours>4) return $this->tm("Please update ready indicators because they are old", $lang). " ($hours h)";

        if($this->mayBe("application_ongoing")) return $this->tm("Application process should be closed before start sorting", $lang);
        
        if($this->getVal("data_date")>=$this->getVal("stats_date")) return $this->tm("Please update ready indicators because they are old", $lang);
        
        $applicants_nb = $this->getVal("applicants_nb");
        $applicants_min = $this->getOptions("APPLICANTS_COUNT_MIN",true);
        if(!$applicants_min) $applicants_min = 500;
        if($applicants_nb<$applicants_min) return $this->tm("Few number of applicants, please check", $lang)."<!-- $applicants_min -->";
        
        
        $min_desires_by_applicant = $this->getOptions("MIN_DESIRES_BY_APPLICANT",true);
        if(!$min_desires_by_applicant) $min_desires_by_applicant = 10;
        $desires_nb = $this->getVal("desires_nb");
        $desires_nb_min = $min_desires_by_applicant * $applicants_nb;
        if($desires_nb<$desires_nb_min) return $this->tm("Few number of applied branchs, please check", $lang)."<!-- $desires_nb_min -->";


        $errors_nb_max = $this->getOptions("ERRORS_NB_MAX",true);
        $pct_errors_max = $this->getOptions("MAX_ERRORS_IN_THOUSAND_APPLICANTS",true);
        $errors_nb = $this->getVal("errors_nb");
        if(!$errors_nb_max) $errors_nb_max = round($applicants_nb * $pct_errors_max / 1000);
        if($errors_nb>$errors_nb_max) return $this->tm("Too much erroned cases, please fix before run sorting", $lang)."<!-- $errors_nb_max -->";

        return "";
    }

    public function calcSorting_ready($what = "value")
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        list($yes , $no, $euh) = $this->translateMyYesNo("sorting_ready", $what, $lang);

        $details = $this->calcSorting_ready_details();

        return ($details=="") ?  $yes : $no;
    }

    /**
     * @todo : academic_term.start_date start_time
     * 
     */
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


    public function runTheSchedule($lang)
    {
        $schedMethod = $this->getOptions("SCHEDULE",true);
        return $this->$schedMethod($lang);
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
        if(!$this->nb_desires)
        {
            $this->nb_desires = $this->getRelation("applicationDesireList")->count();
        }
        return $this->nb_desires; 
    }

    public function calcStamp_desires($what = "value")
    {
        return $this->getRelation("applicationDesireList")->func('max(updated_at)');
    }


    public function getOptions($option = "all", $value = false)
    {
        $options_arr = [];
        // $options_arr["KARRA-ID"] = $this->id;
        // $options_arr["KARRA-NUM"] = $this->getVal("session_num");
        $settings_arr = explode("\n", $this->getVal("settings"));
        foreach ($settings_arr as $settings_item) {
            $settings_item = trim($settings_item);
            list($optionItem, $optionVal) = explode("=", $settings_item);
            if ($option == "all" or $option == $optionItem) {
                if ($value) {
                    // return "($option==all or $option=$optionItem) $settings_item => optionVal=$optionVal";
                    return $optionVal;
                }
                $options_arr[$optionItem] = $optionVal;
            }
        }
        if ($value) return null;
        return $options_arr;
    }

    public function calcErrors_desire_wp($what = "value")
    {
        $applicants_nb = $this->getVal("applicants_nb");    
        // $pct_errors_max = $this->getOptions("MAX_ERRORS_IN_THOUSAND_APPLICANTS",true);
        $echantillon_nb = round($applicants_nb / 100);
        if($echantillon_nb>1000) $echantillon_nb = 1000;
        if($echantillon_nb<100) $echantillon_nb = 100;
        if($echantillon_nb>$applicants_nb) $echantillon_nb = $applicants_nb;
        
        $echantillon_pct = round($echantillon_nb * 100 / $applicants_nb);
        $application_plan_id = $this->getVal("application_plan_id");
        $application_simulation_id = $this->getVal("application_simulation_id");
        if($what == "value")
        {
            $nb_err = ApplicationDesire::checkWeightedPercentageErrors($application_plan_id, $application_simulation_id, $echantillon_pct,"value");
            $nb_err = round($nb_err * 100 / $echantillon_pct);
            return $nb_err;
        }
        else
        {
            $examples = ApplicationDesire::checkWeightedPercentageErrors($application_plan_id, $application_simulation_id, $echantillon_pct,"examples");
            return $examples;
        }
        
    }

    public function calcErrors_wp($what = "value")
    {
        $applicants_nb = $this->getVal("applicants_nb");    
        // $pct_errors_max = $this->getOptions("MAX_ERRORS_IN_THOUSAND_APPLICANTS",true);
        $echantillon_nb = round($applicants_nb / 10);
        if($echantillon_nb>1000) $echantillon_nb = 1000;
        if($echantillon_nb<100) $echantillon_nb = 100;
        if($echantillon_nb>$applicants_nb) $echantillon_nb = $applicants_nb;
        
        $echantillon_pct = round($echantillon_nb * 100 / $applicants_nb);
        $application_plan_id = $this->getVal("application_plan_id");
        $application_simulation_id = $this->getVal("application_simulation_id");
        if($what == "value")
        {
            $nb_err = Application::checkWeightedPercentageErrors($application_plan_id, $application_simulation_id, $echantillon_pct, "value");
            $nb_err = round($nb_err * 100 / $echantillon_pct);
            return $nb_err;
        }
        else
        {
            $examples = Application::checkWeightedPercentageErrors($application_plan_id, $application_simulation_id, $echantillon_pct,"examples");
            return $examples;
        }
    }

    public function calcErrors_nb($what = "value")
    {
        $vmin = $this->getOptions("SORTING_VALUE_MIN", true);
        if(!$vmin) $vmin = 0.0;
        if($what == "value")
        {
            if($this->sortingCase()=="wp")
            {
                return $this->getRelation("applicationList")->resetWhere("weighted_pctg is null or weighted_pctg < $vmin")->count();
            }
            else
            {
                return $this->getRelation("applicationDesireList")->resetWhere("sorting_value_1 is null or sorting_value_1 < $vmin")->count();
            }
        }
        else
        {
            if($this->sortingCase()=="wp")
            {
                return "APP-".$this->getRelation("applicationList")->resetWhere("weighted_pctg is null or weighted_pctg < $vmin")->func("min(applicant_id)");
            }
            else
            {
                return "DSR-".$this->getRelation("applicationDesireList")->resetWhere("sorting_value_1 is null or sorting_value_1 < $vmin")->func("min(applicant_id)");
            }
        }
        
    }

    

    public function calcNb_applications($what = "value")
    {
        if(!$this->nb_applications)
        {
            $this->nb_applications = $this->getRelation("applicationList")->count();
        }
        return $this->nb_applications; 
    }

    public function calcStamp_applications($what = "value")
    {
        return $this->getRelation("applicationList")->func('max(updated_at)');
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

        $color = "gray";
        $title_ar = "تحديث مؤشرات الجاهزية";
        $methodName = "updateReadyIndicators";
        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, 
                                        "ADMIN-ONLY" => true, "BF-ID" => "", 
                                        'STEP' => $this->stepOfAttribute("data_date"));

        $color = "blue";
        $title_ar = "إعادة حساب النسبة الموزونة";
        $methodName = "recomputeWP";
        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, 
                                        "ADMIN-ONLY" => true, "BF-ID" => "", 
                                        'STEP' => $this->stepOfAttribute("data_date"));                                        


        $methodConfirmationWarningEn = "You agree that the sorting data are not correct and you want to update it";
        $methodConfirmationWarning = $this->tm($methodConfirmationWarningEn, "ar");
        $methodConfirmationQuestionEn = "Are you sure you want to do this action ?";
        $methodConfirmationQuestion = $this->tm($methodConfirmationQuestionEn, "ar");
                    
        /* method need review
        $color = "orange";
        $title_ar = "معالجة البيانات وإعادة جلبها إذا دعت الحاجة";
        $methodName = "updateFarzData";
        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, 
                                        "ADMIN-ONLY" => true, "BF-ID" => "", 
                                        'CONFIRMATION_NEEDED' => true,
                                        'CONFIRMATION_WARNING' => array('ar' => $methodConfirmationWarning, 'en' => $methodConfirmationWarningEn),
                                        'CONFIRMATION_QUESTION' => array('ar' => $methodConfirmationQuestion, 'en' => $methodConfirmationQuestionEn),
                                        'STEP' => $this->stepOfAttribute("statsPanel"));
        */

        /* can only be scheduled */
        $color = "orange";
        $title_ar = "إعادة استيراد البيانات لحساب النسبة الموزونة";
        $methodName = "reloadSortingData";
        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, 
                                        "ADMIN-ONLY" => true, "BF-ID" => "", 
                                        'CONFIRMATION_NEEDED' => true,
                                        'CONFIRMATION_WARNING' => array('ar' => $methodConfirmationWarning, 'en' => $methodConfirmationWarningEn),
                                        'CONFIRMATION_QUESTION' => array('ar' => $methodConfirmationQuestion, 'en' => $methodConfirmationQuestionEn),
                                        'STEP' => $this->stepOfAttribute("statsPanel"));
        

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
        elseif($this->sureIs("sorting_ready"))
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
                                                'STEPS' => 'all');


            $recompute_weighted_pctg = "";//strtolower($this->getOptions("RECOM PUTE_WEIGHTED_PCTG",true));
            // because if we need recompute of weighted percentage the lightSorting is not 
            // sufficient we should do hard sorting
            if(((!$recompute_weighted_pctg) or ($recompute_weighted_pctg=="off")) and ($this->sortingHasStarted()))
            {
                    $color = "green";
                    $title_ar = "تحديث الفرز";
                    $title_en = "Update the sorting";
                    $methodName = "lightSorting";
                    $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "LABEL_EN" => $title_en, 
                                                        "ADMIN-ONLY" => true, "BF-ID" => "", 
                                                        'STEPS' => 'all');
            }
            


                                                                                                
        }

        
        

        return $pbms;
    }

    public function postSortingStats($sorting_group_id, $track_num, $arrDataMinAccepted, $branchsWaitingMatrix)    
    {
        $objme = AfwSession::getUserConnected();
        if(!$objme) throw new AfwBusinessException("Please login before");
        $me = $objme->id;
        // $lang = AfwLanguageHelper::getGlobalLanguage();
        $application_simulation_id = $this->getVal("application_simulation_id");
        $applicationPlanObj = $this->het("application_plan_id");
        $application_plan_id = $this->getVal("application_plan_id");
        $session_num = $this->getVal("session_num");
        // $application_model_id = ApplicationPlan::getApplicationModelId($application_plan_id);
        $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
        $db_insert_bloc = AfwSession::config("db_insert_bloc", 500);
        // $statsData = [];
        
        $applicationPlanBranchList = $applicationPlanObj->get("applicationPlanBranchList");

        // $maxPaths = SortingPath::nbPaths($application_model_id);
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

        

        SortingSessionStat::deleteWhere("application_plan_id=$application_plan_id and session_num=$session_num and application_simulation_id=$application_simulation_id and track_num = $track_num");

        $sql_insert_into = "INSERT INTO ".$server_db_prefix."adm.sorting_session_stat 
                       (`created_by`, `updated_by`, `created_at`, `updated_at`, active, version,
                        `application_plan_id`, `session_num`, `application_simulation_id`, `track_num`,
                        `application_plan_branch_id`, `branch_order`, `original_capacity`, `capacity`, `execo`, min_weighted_percentage,
                        `min_app_score1`, `min_app_score2`, `min_app_score3`, min_show_score , max_show_score, 
                        nb_accepted, min_acc_score1, min_acc_score2, min_acc_score3, waiting) VALUES ";

        $sql_values = "";
        $count_values = 0;
        $now = date("Y-m-d H:i:s");
        foreach($applicationPlanBranchList as $applicationPlanBranchItem)
        {
            $applicationModelBranchItem = $applicationPlanBranchItem->het("application_model_branch_id");
            $waiting = $branchsWaitingMatrix[$applicationPlanBranchItem->id];
            // foreach($pathData as $spath => $spathLabel)
            // for ($spath = $track_num; $spath <= $track_num; $spath++) 
            $spath = $track_num;
            if($track_num>0)
            {
                if($applicationPlanBranchItem->attributeIsApplicable("capacity_track$spath"))
                {
                    $rowData = $arrDataMinAccepted[$applicationPlanBranchItem->id];
                    foreach($rowData as $rowCol => $rowVal) $$rowCol = $rowVal;
                    // if(!$rowData["nb_accepted"]) die("rowData=".var_export($rowData,true));
                    $application_plan_branch_id = $applicationPlanBranchItem->id;
                    $min_app_score1 = $applicationPlanBranchItem->getVal("min_app_score1");
                    $capacity = $applicationPlanBranchItem->getVal("capacity_track$spath");
                    $original_capacity = $applicationModelBranchItem->getVal("capacity_track$spath");
                    $branch_order = $applicationPlanBranchItem->getVal("branch_order");
                    $min_app_score2 = $applicationPlanBranchItem->getVal("min_app_score2");
                    $min_app_score3 = $applicationPlanBranchItem->getVal("min_app_score3");
                    $min_weighted_percentage = $applicationPlanBranchItem->getVal("min_weighted_percentage");
                    if(!$execo) $execo = 0;
                    if(!$min_weighted_percentage) $min_weighted_percentage = 0;
                    if(!$min_acc_score1) $min_acc_score1 = 0;
                    if(!$min_acc_score2) $min_acc_score2 = 0;
                    if(!$min_acc_score3) $min_acc_score3 = 0;
                    if(!$nb_accepted) $nb_accepted = 0;

                    if(!$min_app_score1) $min_app_score1 = 0;
                    if(!$min_app_score2) $min_app_score2 = 0;
                    if(!$min_app_score3) $min_app_score3 = 0;

                    $min_show_score = (100.0+$min_acc_score1)/2;
                    $max_show_score = 100.0;


                    $sql_values .= "($me,$me,'$now','$now', 'Y', 0,
                    $application_plan_id, $session_num, $application_simulation_id, $track_num, 
                    $application_plan_branch_id, $branch_order, $original_capacity, $capacity, $execo, $min_weighted_percentage,
                    $min_app_score1, $min_app_score2, $min_app_score3, $min_show_score , $max_show_score,
                    $nb_accepted, $min_acc_score1, $min_acc_score2, $min_acc_score3, $waiting),\n";
                    
                    $count_values++;

                    if($count_values>=$db_insert_bloc)
                    {
                        $sql_values = trim($sql_values);
                        $sql_values = trim($sql_values,",");
                        
                        $sql_total = $sql_insert_into.$sql_values.";";
                        // die("sql_total=$sql_total");
                        AfwDatabase::db_query($sql_total);

                        $sql_values = "";
                        $count_values=0;
                    }
                }
            }
        }

        if($count_values>0)
        {
            $sql_values = trim($sql_values);
            $sql_values = trim($sql_values,",");
            
            AfwDatabase::db_query($sql_insert_into.$sql_values.";");

            $sql_values = "";
            $count_values=0;
        }

        return self::execoAutoDecisionForSortingStats($application_plan_id,$application_simulation_id,$session_num,$track_num);
        
    }

    public function execoAutoDecisionForSortingStats($application_plan_id,$application_simulation_id,$session_num,$track_num)
    {
        $objSSS = new SortingSessionStat();
        $objSSS->where("application_plan_id=$application_plan_id and session_num=$session_num and application_simulation_id=$application_simulation_id and track_num = $track_num");
        $objSSSList = $objSSS->loadMany();
        $upg = 0;
        $downg = 0;
        foreach($objSSSList as $objSSSItem)
        {
            $nb_accepted = $objSSSItem->getVal("nb_accepted");
            $original_capacity = $objSSSItem->getVal("original_capacity");
            $execo = $objSSSItem->getVal("execo");
            $new_capacity = null;
            // auto accept execo ?
            $max_capacity_auto_upgrade = $this->getOptions("MAX_CAPACITY_AUTO_UPGRADE",true);
            if(!$max_capacity_auto_upgrade) $max_capacity_auto_upgrade = 0;
            $execo_suggested_upgrade = $nb_accepted - $original_capacity;
            if(($execo_suggested_upgrade>0) and ($execo_suggested_upgrade<=$max_capacity_auto_upgrade))
            {
                $new_capacity = $nb_accepted;
                $upg+=$execo_suggested_upgrade;
            }

            if(!$new_capacity)
            {
                // auto reject execo ?
                $max_capacity_auto_downgrade = $this->getOptions("MAX_CAPACITY_AUTO_DOWNGRADE",true);
                if(!$max_capacity_auto_downgrade) $max_capacity_auto_downgrade = 0;
                $execo_suggested_downgrade = $original_capacity + $execo - $nb_accepted;   
                if(($execo_suggested_downgrade>0) and ($execo_suggested_downgrade<=$max_capacity_auto_downgrade))
                {
                    $new_capacity = $nb_accepted - $execo;
                    $downg+=$execo_suggested_downgrade;
                }
            }
            
            if($new_capacity)
            {
                $objSSSItem->set("capacity", $new_capacity);
                $objSSSItem->commit();
            }

        }

        return [$upg, $downg];
                    
    }

    public function calcControlPanel($what = "value")
    {
        return "جاري التطوير ...";
    }


    public function reloadSortingData($lang="ar", $origin_partition = "SCHEDULE", $force=true, $echo=false)
    {
        global $MODE_BATCH_LOURD;
        $old_MODE_BATCH_LOURD = $MODE_BATCH_LOURD;
        $MODE_BATCH_LOURD = true;

        if(!$origin_partition) return ["partition not defined to do reloadSortingData", ""];
        if($origin_partition=="SCHEDULE")
        {
            $partition = intval($this->getVal("task_pct"));
            $partition = AfwStringHelper::left_complete_len($partition,3,"0") ;
        }
        else $partition = $origin_partition;
        $err_arr = [];
        $inf_arr = [];
        $war_arr = [];
        $tech_arr = [];
        $ignorePublish = (strtolower($this->getOptions("IGNORE-SCHEDULED-API-PUBLISH",true))=="on");
        $application_plan_id = $this->getVal("application_plan_id");
        $application_simulation_id = $this->getVal("application_simulation_id");
        $sorting_step_id = $this->calc("sorting_step_id");
        $obj = new ApplicationDesire();
        $obj->where("`application_plan_id`=$application_plan_id and `application_simulation_id`=$application_simulation_id and application_step_id=$sorting_step_id and applicant_id like '%$partition' and active = 'Y' and desire_num = 1");
        $applicantIdsArr = $obj->loadCol("applicant_id", true);
        foreach($applicantIdsArr as $applicantId)
        {
            if($applicantId)
            {
                $objApplicant = Applicant::loadById($applicantId);
                list($err, $inf, $war, $tech) = $objApplicant->updateSortingData($lang, $force, $echo, $ignorePublish);
                if ($err) $err_arr[] = $err;
                if ($inf) $inf_arr[] = $inf;
                if ($war) $war_arr[] = $war;
                if ($tech) $tech_arr[] = $tech;
                unset($objApplicant);
            }
            
        }

        if($origin_partition=="SCHEDULE")
        {
            $this->set("task_pct", intval($this->getVal("task_pct"))+1);
            $this->commit();
        }

        $MODE_BATCH_LOURD = $old_MODE_BATCH_LOURD;
        AfwQueryAnalyzer::resetQueriesExecuted();

        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr, [], 50);
    }

    

    public function recomputeWP($lang="ar")
    {
        $sortingCase = $this->sortingCase();
        $sortingCaseIsWP = ($sortingCase=="wp");
        $indicators_update_date = $this->getVal("stats_date");
        $application_plan_id = $this->getVal("application_plan_id");
        $application_simulation_id = $this->getVal("application_simulation_id");
        list($done, $found, $total) = Application::recomputeWeightedPercentage($application_plan_id, $application_simulation_id, $indicators_update_date,null,$sortingCaseIsWP);

        $this->set("started_ind", "N");
        $this->commit();

        return ["", $this->tm("done", $lang)." : $done ".$this->tm("found", $lang)." : $found ".$this->tm("total", $lang)." : $total (sortingCase=$sortingCase)"];
    }

    public function updateReadyIndicators($lang="ar")
    {
        $now = date("Y-m-d H:i:s");
        $this->set("desires_nb", $this->calcNb_desires());
        $this->set("applicants_nb", $this->calcNb_applications());
        $errors_nb = $this->calcErrors_nb() + $this->calcErrors_wp() + $this->calcErrors_desire_wp();
        $this->set("errors_nb", $errors_nb);
        $stmp_des = $this->calcStamp_desires();
        $stmp_app = $this->calcStamp_applications();

        $examples = $this->calcErrors_nb("examples") . " >> " . $this->calcErrors_wp("examples") . " >> " . $this->calcErrors_desire_wp("examples");

        $stmp = ($stmp_app>$stmp_des) ? $stmp_app : $stmp_des;
        $this->set("data_date", $stmp);        
        $this->set("stats_date", $now);
        $this->commit();


        $message = $this->tm("done", $lang);
        if($errors_nb>0) $message .= " : $errors_nb error(s), example(s) : $examples";

        return ["", $message];
    }

    

    public function calcTask_html($what = "value")    
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        $simulation_progress_task = $this->tm($this->getOptions("SCHEDULE",true),$lang);
        if(!$simulation_progress_task) return "";
        $progress_value = $this->getVal("task_pct");
        if(!$progress_value) $progress_value = 0;
        $simulation_progress_value = 5 * intval(floor($progress_value / 5));
        $simulation_real_progress = intval(floor($progress_value * 100)) / 100.0;
        if ($simulation_progress_value > 0) {
            $simulation_progress_value_pct = "$simulation_real_progress%";
        } else {
            $simulation_progress_value_pct = "";
        }
        
        
        
        $html = "<div class='simulation-panel'>";
        $html .= "  <div id=\"simulation_progress_bar\" class=\"simulation_progress bar\" >
                        <div id=\"simulation_progress_value\" class=\"simulation_progress value-$simulation_progress_value\" >&nbsp</div>
                    </div>";
        $html .= "  <div id=\"simulation_progress_task\" class=\"simulation_progress task\" >$simulation_progress_value_pct - $simulation_progress_task</div>";
        $html .= "</div> <!-- simulation-panel -->";

        return $html;
    }

    public function calcStatsPanel($what = "value")
    {
        $amin = 60;
        $application_simulation_id = $this->getVal("application_simulation_id");
        $application_plan_id = $this->getVal("application_plan_id");
        $application_model_id = ApplicationPlan::getApplicationModelId($application_plan_id);

        $sorting_step_id = $this->calc("sorting_step_id");
        $lang = AfwLanguageHelper::getGlobalLanguage();
        
        $html = "<div class='sorting-panel'>";  
        $html .= "<div class='stats-panel'>";  
        $html .= "   <div id=\"stats_panel\" class=\"stats panel\" >";
        $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
        /*
        $sortingGroupList = $this->get("sortingGroupList");
        $keyDecodeArr = [];
        foreach($sortingGroupList as $sortingGroupId => $sortingGroupItem)
        {
            $keyDecodeArr[$sortingGroupId] = $sortingGroupItem->getDisplay($lang);
        }
        // die("keyDecodeArr = ".var_export($keyDecodeArr,true));
        //  and (sorting_value_1>=$amin)
        // sorting_group_id, 
        
        $sql_nb_by_sorting_group = "SELECT 1 as sorting_group_id, count(*) as nb FROM ".$server_db_prefix."adm.`application_desire` WHERE `application_plan_id`=$application_plan_id and `application_simulation_id`=$application_simulation_id and application_step_id=$sorting_step_id and active = 'Y'";
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
        
        //  and (sorting_value_1>=$amin)
        //  group by track_num
        $sql_nb_by_sorting_path = "SELECT 1 as track_num, count(*) as nb FROM ".$server_db_prefix."adm.`application_desire` WHERE `application_plan_id`=$application_plan_id and `application_simulation_id`=$application_simulation_id and application_step_id=$sorting_step_id and active = 'Y'";
        $rows_by_sorting_path = AfwDatabase::db_recup_index($sql_nb_by_sorting_path,"track_num","nb");
        $html .= "<h1>".$this->translate("sorting path stats", $lang)."</h1>";
        $html .= AfwHtmlHelper::arrayToHtml($rows_by_sorting_path, $keyDecodeArr);
        */
        /*
        $keyDecodeArr = [];
        $keyDecodeArr["badw"] = "اقل نسبة موزونة";
        $keyDecodeArr["count"] = "عدد الحالات";
        $vmin = 40;
        
        $html .= "<h1>".$this->tm("need recalculations", $lang)."</h1>";
        $sql_nb_by_sorting_path = "SELECT 'badw' as categ, min(sorting_value_1) as vvv FROM ".$server_db_prefix."adm.`application_desire` WHERE `application_plan_id`=$application_plan_id and `application_simulation_id`=$application_simulation_id and application_step_id=$sorting_step_id and active = 'Y' and (sorting_value_1 is null or sorting_value_1 < $vmin)";
        $rows_by_sorting_path = AfwDatabase::db_recup_index($sql_nb_by_sorting_path,"categ","vvv");
        $html .= AfwHtmlHelper::arrayToHtml($rows_by_sorting_path, $keyDecodeArr);
        $sql_nb_by_sorting_path = "SELECT 'count' as categ, count(*) as vvv FROM ".$server_db_prefix."adm.`application_desire` WHERE `application_plan_id`=$application_plan_id and `application_simulation_id`=$application_simulation_id and application_step_id=$sorting_step_id and active = 'Y' and (sorting_value_1 is null or sorting_value_1 < $vmin)";
        $rows_by_sorting_path = AfwDatabase::db_recup_index($sql_nb_by_sorting_path,"categ","vvv");
        $html .= AfwHtmlHelper::arrayToHtml($rows_by_sorting_path, $keyDecodeArr);*/

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

    public function lightSorting($lang = "ar")
    {
        return $this->runSorting($lang, $preSorting = false);
    }
    
    /* because need too much optimization it has bloqued the server 
    public function updateFarzData($lang = "ar", $echo=false)
    {
        global $MODE_BATCH_LOURD, $boucle_loadObjectFK;
            $old_MODE_BATCH_LOURD = $MODE_BATCH_LOURD;
            $MODE_BATCH_LOURD = true;
            $old_boucle_loadObjectFK = $boucle_loadObjectFK;
        set_time_limit(1800); 

        AfwSession::setConfig("_sql_analysis_seuil_calls",70000);
        AfwSession::setConfig("applicant_api_request-sql-analysis-max-calls",100000);
        AfwSession::setConfig("applicant-sql-analysis-max-calls",80000);
        AfwSession::setConfig("application_desire-sql-analysis-max-calls",100000);
        AfwSession::setConfig('MAX_INSTANCES_BY_REQUEST',250000);

        $err_arr = [];
        $inf_arr = [];
        $war_arr = [];
        $tech_arr = [];
        $log_arr = [];
        $result_arr = [];

        $vmin = $this->getOptions("MIN_ACCEPTED_WEIGHTED_PCTG",true);
        $application_plan_id = $this->getVal("application_plan_id");
        $application_simulation_id = $this->getVal("application_simulation_id");
        $sorting_step_id = $this->calc("sorting_step_id");

        
        $obj = new ApplicationDesire();
        $obj->where("`application_plan_id`=$application_plan_id and `application_simulation_id`=$application_simulation_id and application_step_id=$sorting_step_id and active = 'Y' and (sorting_value_1 is null or sorting_value_1 < $vmin)");
        $desireList = $obj->loadMany(1500);
        $desireListCount = count($desireList);
        if($echo) AfwBatch::print_info("found to repare : ".$desireListCount);
        $total = 0;
        /**
         * @var ApplicationDesire $desireItem
         */
/*
         
        foreach($desireList as $desireItem)
        {
            $total ++; 
            if($echo) AfwBatch::print_info("repare case $total / $desireListCount");
            $desireItem->repareData($lang, true, $echo);            
        }

        $this->set("started_ind", "N");
        $this->commit();

        $result_arr["total"] = $total;

        $inf_arr[] = "done";
        $boucle_loadObjectFK = $old_boucle_loadObjectFK;
        $MODE_BATCH_LOURD = $old_MODE_BATCH_LOURD;
        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr, $result_arr);
    }*/

    public function sortingCase()
    {
        $sortingGroupList = $this->get("sortingGroupList");
        $sortingGroupCount = count($sortingGroupList);
        if($sortingGroupCount>1) return "complex";
        if($sortingGroupCount<=0) return "not-ready";
        $sf1Obj = null;
        $sf2Obj = null;
        $sf3Obj = null;
        foreach($sortingGroupList as $sortingGroupId => $sortingGroupItem)
        {
            $sf1Obj = $sortingGroupItem->het("sorting_field_1_id");
            $sf2Obj = $sortingGroupItem->het("sorting_field_2_id");
            $sf3Obj = $sortingGroupItem->het("sorting_field_3_id");
        }
        if(!$sf1Obj) return "not-defined";
        if($sf2Obj) return "complex";
        if($sf3Obj) return "complex";
        

        if($sf1Obj->getVal("field_name")=="weighted_percentage")
        {
            return "wp";
        }
        else return $sf1Obj->getVal("field_name");
    }
    

    public function runSorting($lang = "ar", $preSorting = true)
    {

        /*@todo

        just to be able to do queries like :
 
        INSERT INTO uoh_adm.application_plan_branch(id,min_app_score1) VALUES (81,-88),(86,-88),(87,-88),(88,-88),(89,-88),(90,-88),(91,-88),(92,-88),(82,-88),(83,-88),(128,-88),(115,-88),(80,-88),(117,-88),(126,-88),(116,-88),(121,-88),(118,-88),(124,-88),(123,-88),(122,-88),(119,-88),(58,-88),(57,-88),(59,-88),(62,-88),(64,-88),(127,-88),(129,-88),(125,-88),(120,-88),(60,-88),(61,-88),(72,-88),(105,-88),(78,-88),(77,-88),(73,-88),(63,-88),(67,-88),(93,-88),(96,-88),(133,-88),(84,-88),(130,-88),(66,-88),(70,-88),(68,-88),(71,-88),(65,-88),(113,-88),(111,-88),(97,-88),(112,-88),(106,-88),(94,-88),(95,-88),(103,-88),(108,-88),(102,-88),(99,-88),(110,-88),(131,-88),(132,-88),(101,-88),(79,-88),(76,-88),(75,-88),(74,-88),(85,-88),(114,-88),(135,-88),(134,-88),(104,-88),(69,-88),(107,-88),(100,-88),(98,-88),(109,-88) ON DUPLICATE KEY UPDATE min_app_score1=VALUES(min_app_score1)

        we need :

        ALTER TABLE `application_plan_branch`
            CHANGE `created_by` `created_by` int NULL AFTER `id`,
            CHANGE `created_at` `created_at` datetime NULL AFTER `created_by`,
            CHANGE `updated_by` `updated_by` int NULL AFTER `created_at`,
            CHANGE `updated_at` `updated_at` datetime NULL AFTER `updated_by`,
            CHANGE `active` `active` char(1) COLLATE 'utf8mb3_unicode_ci' NULL AFTER `validated_at`,
            CHANGE `draft` `draft` char(1) COLLATE 'utf8mb3_unicode_ci' NULL DEFAULT 'Y' AFTER `active`,
            CHANGE `application_model_branch_id` `application_model_branch_id` int NULL DEFAULT '0' AFTER `program_offering_id`,
            CHANGE `branch_order` `branch_order` smallint NULL AFTER `application_model_branch_id`,
            CHANGE `min_weighted_percentage` `min_weighted_percentage` decimal(5,2) NULL DEFAULT '0.00' AFTER `sorting_group_id`;

         */
        global $MODE_BATCH_LOURD;
        $old_MODE_BATCH_LOURD = $MODE_BATCH_LOURD;
        $MODE_BATCH_LOURD = true;
        $object_id_for_audit = $this->getVal("applicant_id");
        $session_num = $this->getVal("session_num");
        $sortingGroupList = $this->get("sortingGroupList");
        $application_plan_id = $this->getVal("application_plan_id");
        $application_simulation_id = $this->getVal("application_simulation_id");

        $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
        $db_insert_bloc = AfwSession::config("db_insert_bloc", 500);
        
        if(!$session_num) return ["Please define session num for this sorting session", ""];
        if(!$application_plan_id) return ["Please define application plan for this sorting session", ""];
        if(!$application_simulation_id) return ["Please define application simulation type for this sorting session", ""];
        
        $application_model_id = ApplicationPlan::getApplicationModelId($application_plan_id);
        // $appModelObj = ApplicationModel::loadById($application_model_id);
        // $split_sorting_by_enum = $appModelObj->getVal("split_sorting_by_enum");
        // $academic_program_id = $this->getVal("program_id");
        $maxPaths = SortingPath::nbPaths($application_model_id);
        // die("$maxPaths = SortingPath::nbPaths($application_model_id);");


        // @todo below should be dynamic min(xx) from application_plan_branch ...etc
        $sorting_value_1_min = 60;

        $this->set("started_ind", "Y");
        $this->commit();

        // @todo : bring from aparameter value
        $MAX_DESIRES = 50;
        // $recompute_weighted_pctg = null;
        // $recompute_weighted_pctg_done = false;
        if($preSorting)
        {

            // $recompute_weighted_pctg = strtolower($this->getOptions("RECOM PUTE_WEIGHTED_PCTG",true));

            

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

        $war_arr = [];
        $info_arr = [];
        $err_arr = [];
        $applicantsDesiresMatrix = null;
        $sortingGroupCount = count($sortingGroupList);
        foreach($sortingGroupList as $sortingGroupId => $sortingGroupItem)
        {
            $sf1Obj = $sortingGroupItem->het("sorting_field_1_id");
            $sf2Obj = $sortingGroupItem->het("sorting_field_2_id");
            $sf3Obj = $sortingGroupItem->het("sorting_field_3_id");

            $sorting_with_only_weighted_percentage = (($sortingGroupCount==1) and (!$sf2Obj) and (!$sf3Obj) and ($sf1Obj->getVal("field_name")=="weighted_percentage"));

            if($sorting_with_only_weighted_percentage and (!$applicantsDesiresMatrix))
            {
                $applicantsDesiresMatrix = ApplicationDesire::getSimpleApplicantsDesiresMatrix($application_plan_id, $application_simulation_id);
            }

            /*
            if($recompute_weighted_pctg and ($recompute_weighted_pctg!="off") and (!$recompute_weighted_pctg_done))
            {
                if($sorting_with_only_weighted_percentage)
                {                    
                    Application::recomputeWeightedPercentage($application_plan_id, $application_simulation_id);
                    $recompute_weighted_pctg_done = true;
                }
                else
                {
                    throw new AfwBusinessException("recompute weighted pctg requested (option RECOM PUTE_WEIGHTED_PCTG) when sorting is not only with weighted percentage");
                }
            }
            */

            $info_arr[]  = "For SG{$sortingGroupId} : ";
            if($preSorting)
            {
                list($msf_cols, $dataMinAppliedScore) = ApplicationPlanBranch::getAllMinAppliedScore($sortingGroupId, $application_plan_id, $application_simulation_id, $application_model_id);
                $msf_cols_arr = explode(",",$msf_cols);
                // die("dataMinAppliedScore = ".var_export($dataMinAppliedScore, true));
                $sql_insert_into = "INSERT INTO $server_db_prefix"."adm.application_plan_branch(id,$msf_cols) VALUES ";
                $sql_values_arr = [];
                foreach($dataMinAppliedScore as $apbId => $rowMinAppliedScore)
                {
                    $in_values_arr = [];
                    foreach($msf_cols_arr as $msf_col)
                    {
                        $in_values_arr[] = $rowMinAppliedScore[$msf_col];
                    }
                    $sql_values_arr[] = "($apbId,". implode(",", $in_values_arr).")";                    
                    $sql_values = implode(",", $sql_values_arr);

                    
                }

                $sql_on_dupl = " ON DUPLICATE KEY UPDATE ";
                $sql_on_dupl_cols_arr = [];
                foreach($msf_cols_arr as $msf_col)
                {
                    $sql_on_dupl_cols_arr[] = "$msf_col=VALUES($msf_col)";
                }

                $sql_on_dupl .= implode(",", $sql_on_dupl_cols_arr);


                $sqlMinAppliedScores = $sql_insert_into . $sql_values . $sql_on_dupl;
                // die("sqlMinAppliedScores = $sqlMinAppliedScores");
                AfwDatabase::db_query($sqlMinAppliedScores);

                
            }    
            

            list($sortingCriterea,
            $sf1,$sf1_order_sens,$sf1_sql,$sf1_insert,$sf1_order,
            $sf2,$sf2_order_sens,$sf2_sql,$sf2_insert,$sf2_order,
            $sf3,$sf3_order_sens,$sf3_sql,$sf3_insert,$sf3_order) = SortingGroup::getSortingCriterea($sortingGroupId);
            
            for ($spath = 1; $spath <= $maxPaths; $spath++) 
            {
                $arrDataMinAccepted = [];
                $branchsWaitingMatrix = [];
                $info_arr[]  = "For SPATH{$spath} : ";
                $branchsCapacityMatrix = ApplicationPlanBranch::getBranchsCapacityMatrix($application_plan_id, $sortingGroupId, $spath);
                $branchsCapacityMatrixStart = $branchsCapacityMatrix;
                $branchsLastScoreMatrix = [];
                if(!$sorting_with_only_weighted_percentage) $applicantsDesiresMatrix = ApplicationDesire::getApplicantsDesiresMatrix($application_plan_id, $application_simulation_id, $sortingGroupId, $spath);
                $sorting_table_without_prefix = "farz_ap".$application_plan_id."_as".$application_simulation_id."_k".$session_num."_sg$sortingGroupId"."_pth$spath";
                $sorting_table = $server_db_prefix."adm.".$sorting_table_without_prefix;
                $final_sorting_table = $server_db_prefix."adm.final_".$sorting_table_without_prefix;
                AfwSession::setConfig("$sorting_table_without_prefix-sql-analysis-max-calls",80000000);
                
                $sql_drop_final = "DROP TABLE IF EXISTS $final_sorting_table;";
                AfwDatabase::db_query($sql_drop_final);

                $sql_create_final = "CREATE TABLE $final_sorting_table (
                    applicant_id bigint(20) NOT NULL,
                    sorting_num int DEFAULT NULL, 
                    assigned_desire_num smallint DEFAULT NULL, 
                    application_plan_branch_id int(11) NULL, 
                    PRIMARY KEY (`applicant_id`)
                    ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;";

                
                AfwDatabase::db_query($sql_create_final);

                $sql_insert_final = "INSERT INTO $final_sorting_table (applicant_id, sorting_num, assigned_desire_num, application_plan_branch_id) VALUES";
                

                if($preSorting)
                {
                    
                    $ff_sql = "";
                    $ff_insert = "";
                    for($f=1;$f<=9;$f++)
                    {
                        $ff = $sortingCriterea["f$f"];
                        $ff_sql .= $ff ? "formula_value_$f float NULL, " : "";
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
                            sorting_num int DEFAULT NULL,                             
                            PRIMARY KEY (`applicant_id`)
                            ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;";

                    AfwDatabase::db_query($sql_create);

                    if(!$sorting_with_only_weighted_percentage)
                    {
                        $sql_insert = "INSERT INTO $sorting_table 
                                    (applicant_id, $sf1_insert $sf2_insert $sf3_insert $ff_insert sorting_num)".
                                "SELECT applicant_id, $sf1_insert $sf2_insert $sf3_insert $ff_insert 0
                                    FROM ".$server_db_prefix."adm.application_desire
                                    WHERE application_plan_id = $application_plan_id 
                                      AND application_simulation_id = $application_simulation_id 
                                      AND sorting_group_id = $sortingGroupId
                                      AND track_num = $spath
                                      AND active = 'Y'
                                      AND sorting_value_1 > $sorting_value_1_min
                                    GROUP BY applicant_id, $sf1_insert $sf2_insert $sf3_insert $ff_insert active  
                                    ";


                        AfwDatabase::db_query($sql_insert);
                    }
                    else
                    {
                        $sql_insert = "INSERT INTO $sorting_table 
                                    (applicant_id, sorting_value_1, sorting_num)".
                                "SELECT applicant_id, weighted_pctg, 0
                                    FROM ".$server_db_prefix."adm.application
                                    WHERE application_plan_id = $application_plan_id 
                                      AND application_simulation_id = $application_simulation_id 
                                      AND application_status_enum = 2
                                      AND active = 'Y'
                                      AND weighted_pctg > $sorting_value_1_min";


                        AfwDatabase::db_query($sql_insert);
                    }

                    

                    // die("sorting_table insert for farz : ".$sql_insert);
                }

                $sql_farz = "SELECT * FROM $sorting_table order by $sf1_order $sf2_order $sf3_order applicant_id asc";

                $farzRows = AfwDatabase::db_recup_rows($sql_farz);
                $sorting_num = 0;
                $absolute_sorting_num = 0;
                $nb_applicants = count($farzRows);
                $nb_desire_assigned = 0;
                $nb_desire_assign_failed = 0;
                $applicant_assign_failed = "";
                $old_score = null;
                $farz_rows = 0;
                $farz_rows_sql_values = "";
                
                foreach($farzRows as $farzRow)
                {
                    $applicant_id = $farzRow["applicant_id"];
                    $new_score = [$farzRow["sorting_value_1"], $farzRow["sorting_value_2"], $farzRow["sorting_value_3"] ];
                    $absolute_sorting_num++;
                    if(!self::isSameScore($new_score, $old_score, $sf1["field_name"], $sf2["field_name"], $sf3["field_name"]))
                    {
                        $sorting_num=$absolute_sorting_num;
                        $old_score = $new_score;
                    }
                    $imploded_score = implode("/", $new_score);
                    if($applicant_id == $object_id_for_audit)
                    {
                        $war_arr[] = "audit score = ".$imploded_score;
                        $war_arr[] = "audit rank = $sorting_num";
                    }

                    // try yo assign him the best desire possible
                    $desire_num_to_assign = 0;
                    $desire_assigned = 0;
                    $application_plan_branch_id_assigned = 0;
                    
                    while((!$desire_assigned) and ($desire_num_to_assign<$MAX_DESIRES))
                    {
                        $desire_num_to_assign++;
                        $application_plan_branch_id_to_assign = $applicantsDesiresMatrix[$applicant_id][$desire_num_to_assign];
                        if($application_plan_branch_id_to_assign)
                        {
                            $sameScore = false;
                            if(self::isSameScore($new_score, $branchsLastScoreMatrix[$application_plan_branch_id_to_assign], $sf1["field_name"], $sf2["field_name"], $sf3["field_name"]))
                            {                            
                                $sameScore = true;
                            }
                            
                            // give APB if capacity still > 0
                            // or if it is mandatory to give APB as previously gived for same score
                            if($sameScore or ($branchsCapacityMatrix[$application_plan_branch_id_to_assign]>0))
                            {
                                
                                $desire_assigned = $desire_num_to_assign;
                                $application_plan_branch_id_assigned = $application_plan_branch_id_to_assign;

                                if($sameScore) 
                                {
                                    if($arrDataMinAccepted[$application_plan_branch_id_assigned]["execo"]) $arrDataMinAccepted[$application_plan_branch_id_assigned]["execo"]++;
                                    else $arrDataMinAccepted[$application_plan_branch_id_assigned]["execo"] = 2; // 2 = 1 + 1 : him and his first execo
                                }
                                else
                                {
                                    $arrDataMinAccepted[$application_plan_branch_id_assigned]["execo"] = 0;
                                }

                                if($applicant_id == $object_id_for_audit)
                                {
                                    $war_arr[] = "audit desire num $desire_assigned assigned APB-ID = $application_plan_branch_id_assigned";
                                }

                                
                                $branchsLastScoreMatrix[$application_plan_branch_id_assigned] = $new_score;
                                
                                unset($rowDataMinAccepted);
                                
    
                                list($arrDataMinAccepted[$application_plan_branch_id_assigned]["min_acc_score1"], 
                                        $arrDataMinAccepted[$application_plan_branch_id_assigned]["min_acc_score2"],
                                        $arrDataMinAccepted[$application_plan_branch_id_assigned]["min_acc_score3"]) = $new_score;
                                
                                // decrease seats available as one seat is assigned
                                $branchsCapacityMatrix[$application_plan_branch_id_assigned]--;
                                if($applicant_id == $object_id_for_audit)
                                {
                                    $war_arr[] = "audit after desire assigned, branch capacity = ".$branchsCapacityMatrix[$application_plan_branch_id_assigned]."/".$branchsCapacityMatrixStart[$application_plan_branch_id_assigned];
                                }

                                if($application_plan_branch_id_assigned == $object_id_for_audit)
                                {
                                    $war_arr[] = "audit assigned applicant $applicant_id (score=$imploded_score) capacity become : ".$branchsCapacityMatrix[$application_plan_branch_id_assigned]."/".$branchsCapacityMatrixStart[$application_plan_branch_id_assigned]." execo is now : ".$arrDataMinAccepted[$application_plan_branch_id_assigned]["execo"];
                                }


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
                            else
                            {
                                if($applicant_id == $object_id_for_audit)
                                {
                                    if($branchsCapacityMatrixStart[$application_plan_branch_id_to_assign])
                                    {
                                        $log_not_ass = "branch capacity = ".$branchsCapacityMatrix[$application_plan_branch_id_to_assign]."/".$branchsCapacityMatrixStart[$application_plan_branch_id_to_assign];
                                    }
                                    else
                                    {
                                        $log_not_ass = "<b>branch closed or capacity not defined</b>";
                                    }
                                    $war_arr[] = "audit desire num $desire_num_to_assign (APB-ID=$application_plan_branch_id_to_assign) not assigned, ".$log_not_ass;
                                }
                                if(!$branchsWaitingMatrix[$application_plan_branch_id_to_assign]) $branchsWaitingMatrix[$application_plan_branch_id_to_assign] = 1;
                                else $branchsWaitingMatrix[$application_plan_branch_id_to_assign]++;
                            }
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
                    $farz_rows++;
                    $farz_rows_sql_values .= "($applicant_id, $sorting_num, $desire_assigned, $application_plan_branch_id_assigned),\n";
                    
                    if($farz_rows>=$db_insert_bloc)
                    {
                        $farz_rows_sql_values = trim($farz_rows_sql_values);
                        $farz_rows_sql_values = trim($farz_rows_sql_values,",");
                        AfwDatabase::db_query($sql_insert_final.$farz_rows_sql_values.";");

                        $farz_rows_sql_values = "";
                        $farz_rows=0;
                    }

                    

                }

                if($farz_rows>0)
                {
                    $farz_rows_sql_values = trim($farz_rows_sql_values);
                    $farz_rows_sql_values = trim($farz_rows_sql_values,",");
                    AfwDatabase::db_query($sql_insert_final.$farz_rows_sql_values.";");

                    $farz_rows_sql_values = "";
                    $farz_rows=0;
                }

                list($upg, $downg) = $this->postSortingStats($sortingGroupId, $spath, $arrDataMinAccepted, $branchsWaitingMatrix); 
                $info_arr[] = "Capacity upgraded : $upg, Capacity downgraded : $downg, Nb applicants = $nb_applicants, Nb applicants assigned = $nb_desire_assigned, Nb applicants can not assign = $nb_desire_assign_failed, [example applicant failed to assign $applicant_assign_failed]";
            }
               

            
        }

        


        $MODE_BATCH_LOURD = $old_MODE_BATCH_LOURD;

        AfwQueryAnalyzer::resetQueriesExecuted();

        return AfwFormatHelper::pbm_result($err_arr, $info_arr, $war_arr);

    }

    

    public function notRetrieve($field_name, $col_struct)
    {
            if(($field_name=="statList") and ($col_struct=="DO-NOT-RETRIEVE-COLS"))
            {
                $application_plan_id = $this->getVal("application_plan_id");
                if(!$application_plan_id)
                {
                    return [];
                }
                $application_model_id = ApplicationPlan::getApplicationModelId($application_plan_id);
                $appModelObj = ApplicationModel::loadById($application_model_id);
                $split_sorting_by_enum = $appModelObj->getVal("split_sorting_by_enum");
                if($split_sorting_by_enum==1)
                {
                            return ["track_num", ];
                }
                else return [];
            }

            throw new AfwRuntimeException("SortingSession::notRetrieve($field_name, $col_struct) not implemented");
    }


    public static function hasBeenExecuted($application_plan_id, $application_simulation_id, $session_num, $sortingGroupId, $spath)
    {
        $sorting_table_without_prefix = "farz_ap".$application_plan_id."_as".$application_simulation_id."_k".$session_num."_sg$sortingGroupId"."_pth$spath";
        $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
        //$sorting_table = $server_db_prefix."adm.".$sorting_table_without_prefix;
        $final_sorting_table = $server_db_prefix."adm.final_".$sorting_table_without_prefix;

        try {
            $nb = AfwDatabase::db_recup_value("select count(*) from $final_sorting_table");

            return [$nb, $final_sorting_table];
        }
        catch(Exception $e)
        {
            return [-1, $final_sorting_table];
        }
    }

    public function calcColors_legend($what="value")
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        $title = $this->tm("Colors legend", $lang);
        $Seems_good = $this->tm("Seems good", $lang);
        $need_to_be_fixed = $this->tm("need to be fixed", $lang);
        $need_run_sorting_again = $this->tm("need run sorting again", $lang);
        $need_page_refresh = $this->tm("The page need refresh", $lang);
        $policy_broken = $this->tm("violating university policy", $lang);
        return "<div class='legend'>
                <div class='title'>$title</div>
                <div class='legend_color good_sorting'>$Seems_good</div>
                <div class='legend_color fix_sorting'>$need_to_be_fixed</div>
                <div class='legend_color need_re_sorting'>$need_run_sorting_again</div>
                <div class='legend_color need_page_refresh'>$need_page_refresh</div>
                <div class='legend_color policy_broken'>$policy_broken</div>
        </div>";
    }


}



// errors 
