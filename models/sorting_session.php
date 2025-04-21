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
        global $lang;
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

    public function isExecuted()
    {
        return false;
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
        else
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


    public function calcStatsPanel($what = "value")
    {
        $application_simulation_id = $this->getVal("application_simulation_id");
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
        $html .= "<h1>".$this->translate("sortingGroupList", $lang)."</h1>";
        $html .= AfwHtmlHelper::arrayToHtml($rows_by_sorting_group, $keyDecodeArr);
        
        $html .= "   </div> <!-- stats_panel -->";   
        $html .= "</div> <!-- stats-panel -->";
        $html .= "</div> <!-- sorting-panel -->";
        return $html;
    }


    public function runSorting($lang = "ar")
    {
        $session_num = $this->getVal("session_num");
        $sortingGroupList = $this->get("sortingGroupList");
        $application_plan_id = $this->getVal("application_plan_id");
        $application_simulation_id = $this->getVal("application_simulation_id");
         
        
        foreach($sortingGroupList as $sortingGroupId => $sortingGroupItem)
        {
            $sf1 = $sortingGroupItem->het("sorting_field_1_id");
            $sf1_sql = $sf1 ? "sf1_val float NOT NULL, " : "";
            $sf2 = $sortingGroupItem->het("sorting_field_2_id");
            $sf2_sql = $sf2 ? "sf2_val float NOT NULL, " : "";
            $sf3 = $sortingGroupItem->het("sorting_field_3_id");
            $sf3_sql = $sf3 ? "sf3_val float NOT NULL, " : "";

            $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
            
            $sql_drop = "DROP TABLE IF EXISTS ".$server_db_prefix."adm.`farz_ap".$application_plan_id."_as".$application_simulation_id."_k".$session_num."_sg$sortingGroupId`;";

            AfwDatabase::db_query($sql_drop);

            $sql_create = "CREATE TABLE ".$server_db_prefix."adm.`farz_ap".$application_plan_id."_as".$application_simulation_id."_k".$session_num."_sg$sortingGroupId` (
              `applicant_id` bigint(20) NOT NULL,
               $sf1_sql  
               $sf2_sql
               $sf3_sql
               sorting_num smallint DEFAULT NULL, 
               assigned_desire_num smallint DEFAULT NULL, 
               application_plan_branch_id int(11) NULL, 
               PRIMARY KEY (`applicant_id`)
            ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;";

            AfwDatabase::db_query($sql_create);
                
        }


        $applicationDesireList = $this->get("applicationDesireList");

        

    }


}



// errors 
