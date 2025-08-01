<?php
class ApplicationPlan extends AdmObject
{

    public static $DATABASE        = "";
    public static $MODULE            = "adm";
    public static $TABLE            = "application_plan";
    public static $DB_STRUCTURE = null;
    private static $arrApplicationPlan = [];
    private static $arrApplicationModelIdByPlanId = [];
    
    // public static $copypast = true;

    /**
     * @var ApplicationModel $objApplicationModel
     */
    private $objApplicationModel = null;


    private $mbToPb = [];

    public function __construct()
    {
        parent::__construct("application_plan", "id", "adm");
        AdmApplicationPlanAfwStructure::initInstance($this);
    }

    public function getApplicationModel()
    {
        if (!$this->objApplicationModel) $this->objApplicationModel = $this->het("application_model_id");
        return $this->objApplicationModel;
    }


    

    public static function getApplicationModelId($aplan_id)
    {
        if (!self::$arrApplicationModelIdByPlanId[$aplan_id]) {
            $objAppPlan = new ApplicationPlan();
            if ($objAppPlan->load($aplan_id)) {
                self::$arrApplicationModelIdByPlanId[$aplan_id] = $objAppPlan->getVal("application_model_id");
            } else self::$arrApplicationModelIdByPlanId[$aplan_id] = "NOT-FOUND";
        }
        if (self::$arrApplicationModelIdByPlanId[$aplan_id] == "NOT-FOUND") return 0;

        return self::$arrApplicationModelIdByPlanId[$aplan_id];
    }


    

    public static function loadById($id)
    {
        if (!self::$arrApplicationPlan[$id]) {
            $obj = new ApplicationPlan();
            if ($obj->load($id)) {
                self::$arrApplicationPlan[$id] = &$obj;
            } else self::$arrApplicationPlan[$id] = "NOT-FOUND";
        }
        if (self::$arrApplicationPlan[$id] == "NOT-FOUND") return null;

        return self::$arrApplicationPlan[$id];
    }


    public static function nextPlans($application_model_id, $academic_level_id)
    {         
        $obj = new ApplicationPlan();
        $obj->select("application_model_id", $application_model_id);
        $ids = implode(",",AcademicTerm::getComingTermsIds($academic_level_id));
        $obj->where("term_id in ($ids)");

        return $obj->loadMany();
    }

    public static function loadByMainIndex($application_model_id, $term_id, $create_obj_if_not_found = false)
    {
        if (!$application_model_id) throw new AfwRuntimeException("loadByMainIndex : application_model_id is mandatory field");
        if (!$term_id) throw new AfwRuntimeException("loadByMainIndex : term_id is mandatory field");


        $obj = new ApplicationPlan();
        $obj->select("application_model_id", $application_model_id);
        $obj->select("term_id", $term_id);

        if ($obj->load()) {
            if ($create_obj_if_not_found) $obj->activate();
            return $obj;
        } elseif ($create_obj_if_not_found) {
            $obj->set("application_model_id", $application_model_id);
            $obj->set("term_id", $term_id);

            $obj->insertNew();
            if (!$obj->id) return null; // means beforeInsert rejected insert operation
            $obj->is_new = true;
            return $obj;
        } else return null;
    }

    

    

    public static function getStepData($input_arr, $debugg=0, $method="", $whereiam="")
    {
        $application_plan_id = $input_arr['plan_id'];
        $applicant_id = $input_arr['applicant_id'];
        $step_num = $input_arr['step_num'];
        $lang = $input_arr['lang'];
        $uncomplete = $input_arr['uncomplete'];
        $deleteapp = $input_arr['deleteapp'];
        $application_simulation_id = $input_arr['application_simulation_id'];
        if(!$application_simulation_id)
        {
                $application_simulation_id = self::currentApplicationSimulation();
        }
        list($application_model_id, $attributes, $error_message) = ApplicationStep::getStepData($applicant_id, $application_plan_id, $step_num, $lang, $debugg,0,$application_simulation_id,0, $method, $whereiam, $uncomplete, $deleteapp);
        
        $data = ['attributes' => $attributes,
                 'apis' => ApplicationModel::getStepApis($applicant_id, $application_model_id, $step_num, $lang, $debugg),                 
        ];

        $status = $error_message ? "error" : "success";
        return [$status, $error_message, $data]; 
    }

    public function getDisplay($lang = "ar")
    {
        return $this->getVal("application_model_name_$lang");
    }

    public function stepsAreOrdered()
    {
        return true;
    }


    public function shouldBeCalculatedField($attribute)
    {
        if ($attribute == "academic_level_id") return true;
        if ($attribute == "gender_enum") return true;
        if ($attribute == "training_period_enum") return true;
        if ($attribute == "language_enum") return true;
        if ($attribute == "academic_year_id") return true;
        if ($attribute == "start_date") return true;
        if ($attribute == "end_date") return true;
        if ($attribute == "application_start_date") return true;
        if ($attribute == "application_start_time") return true;
        if ($attribute == "application_end_date") return true;
        if ($attribute == "application_end_time") return true;
        if ($attribute == "sorting_start_date") return true;
        if ($attribute == "sorting_end_date") return true;
        if ($attribute == "admission_start_date") return true;
        if ($attribute == "admission_end_date") return true;
        if ($attribute == "direct_adm_start_date") return true;
        if ($attribute == "direct_adm_end_date") return true;
        if ($attribute == "seats_update_start_date") return true;
        if ($attribute == "seats_update_end_date") return true;
        if ($attribute == "migration_start_date") return true;
        if ($attribute == "migration_end_date") return true;
        return false;
    }


    public function canApply()
    {
        // @todo
        return true;
    }

    public function reorderBranchsFromAppModel($lang="ar")
    {
        return $this->reorderBranchs($lang, $fromAppModel=true);
    }

    public function reorderBranchs($lang="ar", $fromAppModel=false)
    {
            $applicationPlanBranchList = $this->get("applicationPlanBranchList");   
            $branch_order = 0;
            $log_arr = [];
            foreach($applicationPlanBranchList as $applicationPlanBranchItem)
            {
                
                if($fromAppModel)
                {
                    $applicationModelBranchItem = $applicationPlanBranchItem->het("application_model_branch_id");
                    if($applicationModelBranchItem) $old_branch_order = $applicationModelBranchItem->getVal("branch_order"); 
                    else $old_branch_order = 0;
                    if(!$old_branch_order) $fromAppModel=false;
                }
                
                if(!$fromAppModel) $old_branch_order = $applicationPlanBranchItem->getVal("branch_order"); 
                    if($branch_order<=0) {
                            $branch_order = $old_branch_order; 
                            if($branch_order<=0) $branch_order = 1;
                            if($branch_order>1) $branch_order = 1;
                            $step_from = $branch_order;
                    }
                    else $branch_order++;
                    
                    $log_arr[] = "from $old_branch_order to $branch_order";
                    
                    $applicationPlanBranchItem->set("branch_order", $branch_order);  
                    $applicationPlanBranchItem->commit();
                    $step_to = $branch_order;
            }

            return ["", "reordered from $step_from to $step_to : <br>\n".implode("<br>\n", $log_arr)];
    }

    protected function getPublicMethods()
    {

        $pbms = array();

        $color = "green";
        $title_ar = "اعتماد الخطة";
        $methodName = "validate";
        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN-ONLY" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("valid"));

        $color = "orange";
        $title_ar = "نشر الخطة";
        $methodName = "publish";
        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN-ONLY" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("valid"));

        $color = "blue";
        $title_ar = "غلق الخطة";
        $methodName = "close";
        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN-ONLY" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("valid"));

        if ($this->sureIs("active")) {
            $color = "red";
            $title_ar = "تعطيل الخطة";
            $methodName = "disable";
        } else {
            $color = "red";
            $title_ar = "تفعيل الخطة";
            $methodName = "enable";
        }
        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN-ONLY" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("valid"));


        $color = "gray";
        $title_ar = "تصفير مسمى الخطة";
        $methodName = "resetNames";
        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN-ONLY" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("application_model_name_ar"));


        $methodConfirmationWarningEn = "You agree that you want to cancel capacity planning for different sorting paths";
        $methodConfirmationWarningAr = $this->tm($methodConfirmationWarningEn, "ar");
        $methodConfirmationQuestionEn = "Are you sure you want to do this approve ?";
        $methodConfirmationQuestionAr = $this->tm($methodConfirmationQuestionEn, "ar");
        $color = "orange";
        $title_ar = "تجميع الطاقة الاستيعابية"; 
        $methodName = "resetCapacitiesToFirstMajorPath";
        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, 
                        "LABEL_AR"=>$title_ar, "PUBLIC"=>true, "BF-ID"=>"", 
                        'STEP' =>$this->stepOfAttribute("applicationPlanBranchList"),
                        'CONFIRMATION_NEEDED' => true,
                        'CONFIRMATION_WARNING' => array('ar' => $methodConfirmationWarningAr, 'en' => $methodConfirmationWarningEn),
                        'CONFIRMATION_QUESTION' => array('ar' => $methodConfirmationQuestionAr, 'en' => $methodConfirmationQuestionEn),
                );

        if(!$this->sureIs("closed"))
        {
            $color = "green";
            $title_ar = "جلب الطاقة الاستيعابية الاصلية لجميع فروع القبول";
            $methodName = "inheritBranchsCapacities";
            $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN-ONLY" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("applicationPlanBranchList"));


            $color = "orange";
            $title_ar = "اعادة ترتيب جميع الفروع وفقا للنموذج"; 
            $methodName = "inheritBranchsOrder";
            $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "PUBLIC"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("applicationPlanBranchList"));
                        
            $color = "red";
            $title_ar = "اعادة ترتيب جميع الفروع"; 
            $methodName = "reorderBranchs";
            $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "PUBLIC"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("applicationPlanBranchList"));
            
            $color = "orange";
            $title_ar = "اعادة ترتيب جميع الفروع من النموذج"; 
            $methodName = "reorderBranchsFromAppModel";
            $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "PUBLIC"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("applicationPlanBranchList"));
            


            $color = "yellow";
            $title_ar = "جلب النسبة الموزونة الدنيا لجميع فروع القبول";
            $methodName = "inheritBranchsMinWeightedPercentage";
            $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN-ONLY" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("applicationPlanBranchList"));


        }

        if (!$this->currentSortingSession()) {
            $color = "blue";
            $title_ar = "اضافة جميع فروع القبول المفتوحة في النموذج";
            $methodName = "addPossibleBranchs";
            $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN-ONLY" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("applicationPlanBranchList"));

            $color = "red";
            $title_ar = "تصفير جميع فروع القبول المفتوحة في النموذج";
            $methodName = "resetPossibleBranchs";
            $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN-ONLY" => true, "BF-ID" => "", 'STEP' => $this->stepOfAttribute("applicationPlanBranchList"));
        }

        return $pbms;
    }

    public function repareAllHijriApplicationEndDate($lang = "ar")
    {
        $obj = new ApplicationPlanBranch();
        $obj->select("application_plan_id", $this->id);
        $obj->where("hijri_application_end_date is null or hijri_application_end_date='' or hijri_application_end_date='0000-00-00'");
        $objList = $obj->loadMany();
        foreach ($objList as $objItem) {
            $objItem->repareHijriApplicationEndDate($lang);
        }
    }

    public function getApplicationPlanBranchId($application_model_branch_id)
    {
        if ($this->mbToPb[$application_model_branch_id] == "NOT-FOUND") return 0;
        if (!$this->mbToPb[$application_model_branch_id]) {
            $this->mbToPb[$application_model_branch_id] = "NOT-FOUND";
            $ambObj = ApplicationModelBranch::loadById($application_model_branch_id);
            if (!$ambObj) return 0;
            $program_offering_id = $ambObj->getVal("program_offering_id");
            $obj = ApplicationPlanBranch::loadByMainIndex($this->id, $program_offering_id);
            if (!$obj) return 0;
            // if($obj->id==65) throw new AfwRuntimeException("Here got a strange value pbid=65 from plan= $this->id and program_offering_id=$program_offering_id ");
            $this->mbToPb[$application_model_branch_id] = $obj->id;
        }

        return $this->mbToPb[$application_model_branch_id];
    }
    

    public function inheritBranchsOrder($lang = "ar")
    {
        $err_arr = [];
        $inf_arr = [];
        $war_arr = [];
        $tech_arr = [];

        $applicationPlanBranchList = $this->get("applicationPlanBranchList");
        foreach ($applicationPlanBranchList as $applicationPlanBranchItem) {
            list($err, $inf, $war, $tech) = $applicationPlanBranchItem->inheritBranchOrder($lang);

            if ($err) $err_arr[] = $err;
            if ($inf) $inf_arr[] = $inf;
            if ($war) $war_arr[] = $war;
        }

        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
    }

    public function inheritBranchsCapacities($lang = "ar")
    {
        $err_arr = [];
        $inf_arr = [];
        $war_arr = [];
        $tech_arr = [];
        /**
         * @var ApplicationPlanBranch $applicationPlanBranchItem
         */
        $applicationPlanBranchList = $this->get("applicationPlanBranchList");
        foreach ($applicationPlanBranchList as $applicationPlanBranchItem) {
            list($err, $inf, $war, $tech) = $applicationPlanBranchItem->inheritBranchsCapacities($lang);

            if ($err) $err_arr[] = $err;
            if ($inf) $inf_arr[] = $inf;
            if ($war) $war_arr[] = $war;
        }

        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
    }


    public function flagBranchsCapacitiesToParent($lang = "ar")
    {
        $err_arr = [];
        $inf_arr = [];
        $war_arr = [];
        $tech_arr = [];
        /**
         * @var ApplicationPlanBranch $applicationPlanBranchItem
         */
        $applicationPlanBranchList = $this->get("applicationPlanBranchList");
        foreach ($applicationPlanBranchList as $applicationPlanBranchItem) {
            list($err, $inf, $war, $tech) = $applicationPlanBranchItem->flagBranchsCapacitiesToParent($lang);

            if ($err) $err_arr[] = $err;
            if ($inf) $inf_arr[] = $inf;
            if ($war) $war_arr[] = $war;
        }

        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
    }

    public function resetPossibleBranchs($lang = "ar")
    {
        return $this->addPossibleBranchs($lang, true);
    }

    public function addPossibleBranchs($lang = "ar", $reset = false)
    {
        $err_arr = [];
        $inf_arr = [];
        $war_arr = [];
        $tech_arr = [];

        $db = $this->getDatabase();
        $this_id = $this->id;

        if ($reset) {
            $sql_delete = "delete from $db.application_plan_branch 
                        where application_plan_id=$this_id";

            list($result, $row_count, $affected_row_count) = self::executeQuery($sql_delete);
            $info_mess_arr[] = $this->tm('عدد سجلات فروع التقديم التي تم مسحها : ', $lang) . $affected_row_count;
        }

        $me = AfwSession::getUserIdActing();

        $academic_level_id = $this->getVal("academic_level_id");
        $application_model_id = $this->getVal("application_model_id");

        $gender_enum = $this->getVal("gender_enum");
        $gender_enum_decoded = $this->decode("gender_enum");
        $term_id = $this->getVal("term_id");


        list($application_start_date, $application_start_time) = explode(" ", $this->getVal("application_start_date"));
        list($application_end_date, $application_end_time) = explode(" ", $this->getVal("application_end_date"));
        if ($application_end_date and ($application_end_date != "0000-00-00")) {
            $hijri_application_end_date = AfwDateHelper::gregToHijri($application_end_date);
        } else {
            $hijri_application_end_date = "";
        }


        $sql_insert = "insert into $db.application_plan_branch(created_by,  created_at, updated_by,updated_at, active, version, sci_id,
                                academic_level_id,gender_enum,term_id,application_plan_id,
                                program_id,training_unit_id,department_id,major_id,
                                program_offering_id,application_model_branch_id,
                                name_ar, name_en, branch_order,
                                seats_capacity, direct_adm_capacity, deaf_specialty,is_open,allow_direct_adm,
                                capacity_track1, capacity_track2, capacity_track3, capacity_track4, sorting_group_id,
                                confirmation_days, application_end_date, hijri_application_end_date)
                                select $me, now(), $me, now(), amb.active, 0 as version, 431 as sci_id,
                                        $academic_level_id, amb.gender_enum, $term_id, $this_id, 
                                        amb.academic_program_id, amb.training_unit_id, amb.department_id, amb.major_id,  
                                        amb.program_offering_id, amb.id,
                                        amb.branch_name_ar, amb.branch_name_en, amb.branch_order,
                                        amb.seats_capacity, amb.direct_adm_capacity, amb.deaf_specialty, amb.is_open, IF(amb.direct_adm_capacity>0, 'Y','N') as allow_direct_adm,
                                        amb.capacity_track1, amb.capacity_track2, amb.capacity_track3, amb.capacity_track4, amb.sorting_group_id,
                                        amb.confirmation_days, '$application_end_date' as application_end_date, '$hijri_application_end_date' as hijri_application_end_date
                                from $db.application_model_branch amb  
                                        left join $db.application_plan_branch apb on
                                                apb.program_offering_id = amb.program_offering_id and
                                                apb.application_plan_id = $this_id                                                        
                                where amb.application_model_id = $application_model_id
                                  and (amb.gender_enum = $gender_enum or $gender_enum > 2)
                                  and amb.active = 'Y'
                                  and amb.seats_capacity > 0
                                  and apb.id is null";


        list($result, $row_count, $affected_row_count) = self::executeQuery($sql_insert);

        $this->repareAllHijriApplicationEndDate($lang);

        if ($affected_row_count > 0) {
            $inf_arr[] = $this->getDisplay($lang) . " : " . $this->tm('عدد سجلات فروع التقديم التي تم توليدها : ', $lang) . $affected_row_count;
        } else {
            $war_arr[] = "في نموذج القبول " . $this->getDisplay($lang) . " لا يوجد فروع قبول مفتوحة بطاقة استيعابية محددة على جنس الطلاب : $gender_enum_decoded";
        }


        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
    }




    public function validate($lang = "ar", $commit = true)
    {
        $err_arr = [];
        $inf_arr = [];
        $war_arr = [];
        $tech_arr = [];

        $this->set("valid", "Y");
        if ($commit) $this->commit();

        $inf_arr[] = $this->tm("the application plan has been successfully validated");

        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
    }

    public function unvalidate($lang = "ar", $commit = true)
    {
        $err_arr = [];
        $inf_arr = [];
        $war_arr = [];
        $tech_arr = [];

        $this->set("valid", "N");
        if ($commit) $this->commit();

        $inf_arr[] = $this->tm("the application plan has been successfully unvalidated");

        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
    }

    public function publish($lang = "ar", $commit = true)
    {
        $err_arr = [];
        $inf_arr = [];
        $war_arr = [];
        $tech_arr = [];
        $this->flagBranchsCapacitiesToParent($lang);
        $this->set("published", "Y");
        if ($commit) $this->commit();
        $inf_arr[] = $this->tm("the application plan has been successfully published");

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
        $inf_arr[] = $this->tm("the application plan has been successfully unpublished");

        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
    }

    public function close($lang = "ar", $commit = true)
    {
        $err_arr = [];
        $inf_arr = [];
        $war_arr = [];
        $tech_arr = [];

        $this->set("closed", "Y");
        if ($commit) $this->commit();
        $inf_arr[] = $this->tm("the application plan has been successfully closed");

        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
    }

    public function open($lang = "ar", $commit = true)
    {
        $err_arr = [];
        $inf_arr = [];
        $war_arr = [];
        $tech_arr = [];

        $this->set("closed", "N");
        if ($commit) $this->commit();
        $inf_arr[] = $this->tm("the application plan has been successfully opened");

        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
    }

    public function enable($lang = "ar", $commit = true)
    {
        $err_arr = [];
        $inf_arr = [];
        $war_arr = [];
        $tech_arr = [];

        $this->set("active", "Y");
        if ($commit) $this->commit();
        $inf_arr[] = $this->tm("the application plan has been successfully enabled");

        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
    }

    public function disable($lang = "ar", $commit = true)
    {
        $err_arr = [];
        $inf_arr = [];
        $war_arr = [];
        $tech_arr = [];

        $this->set("active", "N");
        if ($commit) $this->commit();
        $inf_arr[] = $this->tm("the application plan has been successfully disabled");

        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
    }

    public function resetNames($lang = "ar", $which = "all", $commit = true)
    {
        $appModel = $this->het("application_model_id");
        if (!$appModel) return ["لم يتم تحديد نموذج القبول", ""];
        if (!$this->getVal("term_id")) return ["لم يتم تحديد الفصل التدريبي", ""];
        if (($which == "all") or ($which == "ar")) {
            $new_name = $this->decode("term_id") . "-" . $appModel->getDisplay("ar");
            $this->set("application_model_name_ar", $new_name);
            // die("reset name to : ".$new_name);
        }

        if (($which == "all") or ($which == "en")) {
            $new_name = $this->decode("term_id") . "-" . $appModel->getDisplay("en");
            $this->set("application_model_name_en", $new_name);
        }

        if ($commit) $this->commit();

        return ["", "تم تصفير مسمى الخطة بنجاح"];
    }

    public function beforeMaj($id, $fields_updated)
    {
        if ($fields_updated["application_model_id"] or $fields_updated["term_id"]) {
            if ($this->getVal("term_id") and $this->getVal("application_model_id")) {
                // if we change application_model_id or term_id name should be changed automqtically if not manually
                if (!$fields_updated["application_model_name_ar"]) //  or (!$this->getVal("application_model_name_ar")) or ($this->getVal("application_model_name_ar")=="--")
                {
                    // die("resetNames-ar");
                    $this->resetNames("ar", "ar", false);
                }
                // else throw new RuntimeException("what Majed : fields_updated=".var_export($fields_updated,true)." term_id=".$this->getVal("term_id")." application_model_id=".$this->getVal("application_model_id"));
                // if we change application_model_id or term_id name should be changed automqtically if not manually
                if (!$fields_updated["application_model_name_en"]) //  or (!$this->getVal("application_model_name_en")) or ($this->getVal("application_model_name_en")=="--")
                {
                    // die("resetNames-en");
                    $this->resetNames("en", "en", false);
                }
                // else throw new RuntimeException("what Majed : fields_updated=".var_export($fields_updated,true)." term_id=".$this->getVal("term_id")." application_model_id=".$this->getVal("application_model_id"));
            }
            // else throw new RuntimeException("what Majed : fields_updated=".var_export($fields_updated,true)."term_id=".$this->getVal("term_id")." application_model_id=".$this->getVal("application_model_id"));
        }
        // else throw new RuntimeException("what Majed : fields_updated=".var_export($fields_updated,true)." term_id=".$this->getVal("term_id")." application_model_id=".$this->getVal("application_model_id"));




        return true;
    }


    /**
     *  the sorting is considered  started for the application plan if one of its sorting sessions has started
     *  */
    public function sortingHasStarted()
    {
        $sortingSessionList = $this->get("sortingSessionList");
        /**
         * @var SortingSession $sortingSessionItem
         */
        foreach ($sortingSessionList as $sortingSessionItem) {
            if ($sortingSessionItem->sortingHasStarted()) return true;
        }

        return false;
    }

    public function resetCapacitiesToFirstMajorPath($lang="ar")
    {
            $coefs = [1=>100, 2=>0, 3=>0, 4=>0];
            $this->resetCapacitiesAsMajorPath($coefs);

            return ["", "done"];
    }

    public function resetCapacitiesAsMajorPath($coefs)
    {
            foreach($coefs as $c => $cv) ${"coef_$c"} = $cv/100.0;
            $sets_arr = ['capacity_track1'=>"round(seats_capacity*$coef_1)",
                            'capacity_track2'=>"round(seats_capacity*$coef_2)",
                            'capacity_track3'=>"round(seats_capacity*$coef_3)",
                            'capacity_track4'=>"seats_capacity-capacity_track1-capacity_track2-capacity_track3",                                                     
                    ];
            $where_clause = "application_plan_id = ".$this->id;
            ApplicationPlanBranch::updateWhere($sets_arr, $where_clause, true);
    }


    protected function getOtherLinksArray($mode, $genereLog = false, $step = "all")
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        // $objme = AfwSession::getUserConnected();
        // $me = ($objme) ? $objme->id : 0;

        $otherLinksArray = $this->getOtherLinksArrayStandard($mode, $genereLog, $step);
        $my_id = $this->getId();
        $displ = $this->getDisplay($lang);

        if ($mode == "mode_applicationPlanBranchList") {
            unset($link);
            $link = array();
            $title = "إضافة فرع تقديم يدويا";
            $title_detailed = $title . "لـ : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=ApplicationPlanBranch&currmod=adm&sel_application_plan_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;


            unset($link);
            $link = array();
            $title = "ترتيب الفروع يدويا";
            $title_detailed = $title . "لـ : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=ApplicationPlanBranch&currmod=adm&fixm=application_plan_id=$my_id&sel_application_plan_id=$my_id&id_origin=$my_id&class_origin=ApplicationPlan&module_origin=adm&step_origin=5&newo=-1";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }

        if ($mode == "mode_sortingSessionList") {
            $simList = ApplicationSimulation::loadAllLookupObjects();
            foreach($simList as $sim_id => $simItem)
            {
                $displ_sim = $simItem->getDisplay($lang);
                unset($link);
                $link = array();
                $title = "إضافة تنفيذ فرز جديد";
                $title_detailed = $title . "لـ : " . $displ_sim;
                $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=SortingSession&currmod=adm&sel_application_plan_id=$my_id&sel_application_simulation_id=$sim_id";
                $link["TITLE"] = $title_detailed;
                $link["UGROUPS"] = array();
                $otherLinksArray[] = $link;
            }
            
        }

        /*
                if($mode=="mode_applicationList")
                {
                        unset($link);
                        $link = array();
                        $title = "إضافة تقديم يدوي";
                        $title_detailed = $title ."لـ : ". $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=AcademicLevelOffering&currmod=adm&sel_academic_level_id=$my_id";
                        $link["TITLE"] = $title;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                }*/



        // check errors on all steps (by default no for optimization)
        // rafik don't know why this : \//  = false;

        return $otherLinksArray;
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
                // adm.application_plan_branch-Application Plan	application_plan_id  OneToMany (required field)
                // require_once "../adm/application_plan_branch.php";
                $obj = new ApplicationPlanBranch();
                $obj->where("application_plan_id = '$id' and active='Y' ");
                $nbRecords = $obj->count();
                // check if there's no record that block the delete operation
                if ($nbRecords > 0) {
                    $this->deleteNotAllowedReason = "Used in some Application plan branchs(s) as Application plan";
                    return false;
                }
                // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                if (!$simul) $obj->deleteWhere("application_plan_id = '$id' and active='N'");



                // FK part of me - deletable 


                // FK not part of me - replaceable 



                // MFK

            } else {
                // FK on me 


                // adm.application_plan_branch-Application Plan	application_plan_id  OneToMany (required field)
                if (!$simul) {
                    // require_once "../adm/application_plan_branch.php";
                    ApplicationPlanBranch::updateWhere(array('application_plan_id' => $id_replace), "application_plan_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}adm.application_plan_branch set application_plan_id='$id_replace' where application_plan_id='$id' ");

                }




                // MFK


            }
            return true;
        }
    }

    public function getScenarioItemId($currstep)
    {
        if ($currstep == 1) return 428;
        if ($currstep == 2) return 429;
        if ($currstep == 3) return 432;
        if ($currstep == 4) return 433;
        if ($currstep == 5) return 480;

        return 0;
    }

    public static function getCurrentApplicationPlans($except_already_applied_plan_ids = "")
    {
        $obj = new ApplicationPlan();
        $obj->select("published", "Y");
        $obj->select("active", "Y");
        $obj->select("closed", "N");

        if ($except_already_applied_plan_ids) {
            $obj->where("id not in ($except_already_applied_plan_ids)");
        }

        return $obj->loadMany();
    }


    public function currentSortingSession()
    {
        return $this->getRelation("sortingSessionList")->resetWhere("started_ind='Y'")->orderBy("session_num asc")->getFirst();
    }
}
