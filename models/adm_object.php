<?php

class AdmObject extends AfwMomkenObject
{
    // lookup Value List codes 

    // BACHELORS - شهادة البكالوريوس  
    public static $DOC_TYPE_BACHELORS = 34; 

    // CV - سيرة ذاتية  
    public static $DOC_TYPE_CV = 20; 

    // DIPLOMA - شهادة الدبلوم  
    public static $DOC_TYPE_DIPLOMA = 35; 

    // EMPLOYMENT - شهادة توظيف  
    public static $DOC_TYPE_EMPLOYMENT = 19; 

    // IDN_PHOTO - صورة الهوية  
    public static $DOC_TYPE_IDN_PHOTO = 18; 

    // MASTER - شهادة الماجستير  
    public static $DOC_TYPE_MASTER = 33; 

    // SEJEL - السجل الأكاديمي  
    public static $DOC_TYPE_SEJEL = 29; 

    // TAFRIGH - تفريغ من جهة العمل  
    public static $DOC_TYPE_TAFRIGH = 28; 

    // TAWSIA - توصية علمية  
    public static $DOC_TYPE_TAWSIA = 27; 

    private static $fields_manager_matrix = null;
    public static function getFieldsManagerMatrix($table_name, $field_name)
    {
        if (!self::$fields_manager_matrix) {
            $main_company = AfwSession::currentCompany();
            $file_dir_name = dirname(__FILE__);
            $fields_manager_full_file_name = $file_dir_name . "/../../cache/$main_company" . "_fields_manager.php";
            if (file_exists($fields_manager_full_file_name)) {
                self::$fields_manager_matrix = include_once($fields_manager_full_file_name);
            } else {
                throw new AfwBusinessException("Fields Manager File $fields_manager_full_file_name has not been already generated");
            }
        }



        $return = self::$fields_manager_matrix[$table_name][$field_name];

        // if(($field_name=="xxxxx") and (!$return)) throw new AfwBusinessException("no Fields Manager Matrix found for [$table_name.$field_name] : fields_manager_matrix=".var_export(self::$fields_manager_matrix, true));

        return $return;
    }

    public static function currentApplicationSimulation()
    {
        $devMode = AfwSession::config("MODE_DEVELOPMENT", false);
        $application_simulation_id = 2;
        if ($devMode) {
            $instObj = Institution::loadSingleton();
            $application_simulation_id = $instObj->getVal("application_simulation_id");
            if (!$application_simulation_id) $application_simulation_id = 2;
        }


        return $application_simulation_id;
    }

    public function getMyPlanBranchArr()
    {
        $application_model_branch_liste = trim(trim($this->getVal("application_model_branch_mfk")), ",");
        return explode(",", $application_model_branch_liste);
    }

    public function calcAdm_orgunit_id($what = "value")
    {
        $orgunit_id = $this->getVal("orgunit_id");
        if (!$orgunit_id) return ($what == "value") ? 0 : null;
        $returnObj = AdmOrgunit::loadByMainIndex($orgunit_id, true);

        $return =  ($what == "value") ? $returnObj->id : $returnObj;
        // throw new AfwRuntimeException("calcAdm_orgunit_id($what) = $return");
        return $return;
    }

    public static function getAuthenticatedUserScopeList($objme = null)
    {
        $scopeList = [];

        if (!$objme) $objme = AfwSession::getUserConnected();
        if ($objme) {
            $employee_id = $objme->getEmployeeId();
            if ($employee_id) {
                $empAccountList = AdmEmployee::loadMyEmployeeAccounts($employee_id);
                foreach ($empAccountList as $empAccountItem) {
                    $tmpScopes = $empAccountItem->getMyScopes();
                    $scopeList = array_merge($scopeList, $tmpScopes);
                }
            }
        }

        return $scopeList;
    }

    public static function userIsSupervisor($objme = null)
    {
        if (!$objme) $objme = AfwSession::getUserConnected();
        if (!$objme) return 0;

        $employee_id = $objme->getEmployeeId();
        if (!$employee_id) return 0;

        return AdmEmployee::isAdmin($employee_id);
    }

    public static function userIsGeneralSupervisor($objme = null)
    {
        if (!$objme) $objme = AfwSession::getUserConnected();
        if (!$objme) return 0;

        $employee_id = $objme->getEmployeeId();
        if (!$employee_id) return 0;

        return AdmEmployee::isGeneralAdmin($employee_id);
    }

    public static function code_of_grade_scale_enum($lkp_id = null)
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        if ($lkp_id) return self::grade_scale()['code'][$lkp_id];
        else return self::grade_scale()['code'];
    }

    public static function name_of_grade_scale_enum($grade_scale_enum, $lang = "ar")
    {
        return self::grade_scale()[$lang][$grade_scale_enum];
    }

    public static function list_of_grade_scale_enum($lang = null)
    {
        if (!$lang) $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::grade_scale()[$lang];
    }

    public static function grade_scale()
    {
        $arr_list_of_grade_scale = array();

        $objList = GradingScale::loadAllLookupObjects();
        foreach ($objList as $objItem) {
            $arr_list_of_grade_scale["code"][$objItem->getVal("level")] = $objItem->getVal("grade_ar");
            $arr_list_of_grade_scale["ar"][$objItem->getVal("level")] = $objItem->getVal("value_ar");
            $arr_list_of_grade_scale["en"][$objItem->getVal("level")] = $objItem->getVal("value_en");
        }


        return $arr_list_of_grade_scale;
    }

    public static function code_of_applicant_decision_enum($lkp_id = null)
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        if ($lkp_id) return self::applicant_decision()['code'][$lkp_id];
        else return self::applicant_decision()['code'];
    }

    public static function name_of_applicant_decision_enum($applicant_decision_enum, $lang = "ar")
    {
        return self::applicant_decision()[$lang][$applicant_decision_enum];
    }

    public static function list_of_applicant_decision_enum($lang = null)
    {
        if (!$lang) $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::applicant_decision()[$lang];
    }

    public static function applicant_decision()
    {
        $arr_list_of_applicant_decision = array();


        $arr_list_of_applicant_decision["code"][1] = "AA";
        $arr_list_of_applicant_decision["ar"][1] = "تأكيد القبول";
        $arr_list_of_applicant_decision["en"][1] = "Admission accepted";

        $arr_list_of_applicant_decision["code"][2] = "AAUR";
        $arr_list_of_applicant_decision["ar"][2] = "تأكيد القبول مع طلب ترقية";
        $arr_list_of_applicant_decision["en"][2] = "Admission accepted with Upgrade Request";

        $arr_list_of_applicant_decision["code"][3] = "ARJ";
        $arr_list_of_applicant_decision["en"][3] = "Admission rejected";
        $arr_list_of_applicant_decision["ar"][3] = "رفض القبول";

        $arr_list_of_applicant_decision["code"][4] = "WAD";
        $arr_list_of_applicant_decision["en"][4] = "Waiting applicant decision";
        $arr_list_of_applicant_decision["ar"][4] = "في انتظار قرار المتقدم";



        return $arr_list_of_applicant_decision;
    }

    public static function code_of_notification_channel_enum($lkp_id = null)
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        if ($lkp_id) return self::notification_channel()['code'][$lkp_id];
        else return self::notification_channel()['code'];
    }

    public static function name_of_notification_channel_enum($notification_channel_enum, $lang = "ar")
    {
        return self::notification_channel()[$lang][$notification_channel_enum];
    }

    public static function list_of_notification_channel_enum($lang = null)
    {
        if (!$lang) $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::notification_channel()[$lang];
    }

    public static function notification_channel()
    {
        $arr_list_of_notification_channel = array();


        $arr_list_of_notification_channel["code"][1] = "SMS";
        $arr_list_of_notification_channel["ar"][1] = "رسالة قصيرة";
        $arr_list_of_notification_channel["en"][1] = "Admission accepted";

        $arr_list_of_notification_channel["code"][2] = "EMAIL";
        $arr_list_of_notification_channel["ar"][2] = "بريد الكتروني";
        $arr_list_of_notification_channel["en"][2] = "Email";

        $arr_list_of_notification_channel["code"][3] = "WHATSAPP";
        $arr_list_of_notification_channel["ar"][3] = "واتساب";
        $arr_list_of_notification_channel["en"][3] = "Whatsapp";




        return $arr_list_of_notification_channel;
    }

    public static function code_of_split_sorting_by_enum($lkp_id = null)
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        if ($lkp_id) return self::split_sorting_by()['code'][$lkp_id];
        else return self::split_sorting_by()['code'];
    }

    public static function name_of_split_sorting_by_enum($split_sorting_by_enum, $lang = "ar")
    {
        return self::split_sorting_by()[$lang][$split_sorting_by_enum];
    }

    public static function list_of_split_sorting_by_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::split_sorting_by()[$lang];
    }

    public static function split_sorting_by()
    {
        $arr_list_of_split_sorting_by = array();


        $arr_list_of_split_sorting_by["code"][1] = "NS";
        $arr_list_of_split_sorting_by["ar"][1] = "بدون تقسيم";
        $arr_list_of_split_sorting_by["en"][1] = "No split";

        $arr_list_of_split_sorting_by["code"][2] = "MPS";
        $arr_list_of_split_sorting_by["ar"][2] = "تقسيم حسب مجموعة التأهيل";
        $arr_list_of_split_sorting_by["en"][2] = "Split with major path";

        /* for later may be
                $arr_list_of_split_sorting_by["en"][3] = "Split with gender";
                $arr_list_of_split_sorting_by["ar"][3] = "تقسيم حسب الجنس";
                $arr_list_of_split_sorting_by["code"][3] = "GND";

                $arr_list_of_split_sorting_by["en"][4] = "Split with gender and major path";
                $arr_list_of_split_sorting_by["ar"][4] = "تقسيم حسب الجنس ومجموعة التأهيل";
                $arr_list_of_split_sorting_by["code"][4] = "GNDMP";*/


        return $arr_list_of_split_sorting_by;
    }



    public static function code_of_apply_simul_method_enum($lkp_id = null)
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        if ($lkp_id) return self::apply_simul_method()['code'][$lkp_id];
        else return self::apply_simul_method()['code'];
    }

    public static function name_of_apply_simul_method_enum($apply_simul_method_enum, $lang = "ar")
    {
        return self::apply_simul_method()[$lang][$apply_simul_method_enum];
    }

    public static function list_of_apply_simul_method_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::apply_simul_method()[$lang];
    }

    public static function apply_simul_method()
    {
        $arr_list_of_apply_simul_method = array();


        $arr_list_of_apply_simul_method["code"][1] = "ALL";
        $arr_list_of_apply_simul_method["ar"][1] = "جميع الفروع المختارة";
        $arr_list_of_apply_simul_method["en"][1] = "All selected branches";

        $arr_list_of_apply_simul_method["code"][2] = "RANDOM";
        $arr_list_of_apply_simul_method["ar"][2] = "عشوائيا من الفروع المختارة";
        $arr_list_of_apply_simul_method["en"][2] = "Randomly from selected branches";


        $arr_list_of_apply_simul_method["code"][3] = "FAVORITE";
        $arr_list_of_apply_simul_method["ar"][3] = "الفروع المفضلة لكل متقدم";
        $arr_list_of_apply_simul_method["en"][3] = "Favorite branchs for each applicant";

        $arr_list_of_apply_simul_method["code"][4] = "PROSPECT";
        $arr_list_of_apply_simul_method["ar"][4] = "الفروع المدخلة في البيانات الجاهزة للمتقدم";
        $arr_list_of_apply_simul_method["en"][4] = "Entered branchs in applicant prospect off-line data";


        return $arr_list_of_apply_simul_method;
    }


    public static function code_of_training_period_enum($lkp_id = null)
    {
        if ($lkp_id) return self::training_period()['code'][$lkp_id];
        else return self::training_period()['code'];
    }


    public static function name_of_training_period_enum($training_period_enum, $lang = "ar")
    {
        return self::training_period()[$lang][$training_period_enum];
    }

    public static function list_of_training_period_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::training_period()[$lang];
    }

    public static function training_period()
    {
        $arr_list_of_training_period = array();


        $arr_list_of_training_period["en"][1] = "Morning";
        $arr_list_of_training_period["ar"][1] = "صباحي";
        $arr_list_of_training_period["code"][1] = "Morning";

        $arr_list_of_training_period["en"][2] = "Evening";
        $arr_list_of_training_period["ar"][2] = "مسائي";
        $arr_list_of_training_period["code"][2] = "Evening";

        $arr_list_of_training_period["en"][3] = "Morning & Evening";
        $arr_list_of_training_period["ar"][3] = "صباحي ومسائي";
        $arr_list_of_training_period["code"][3] = "Both";


        return $arr_list_of_training_period;
    }


    public static function splitTrainingPeriods($tp)
    {
        if($tp!=3) return [$tp];
        return [1,2];
    }

    public static function code_of_sorting_sens_enum($lkp_id = null)
    {
        if ($lkp_id) return self::sorting_sens()['code'][$lkp_id];
        else return self::sorting_sens()['code'];
    }

    public static function name_of_sorting_sens_enum($sorting_sens_enum, $lang = "ar")
    {
        return self::sorting_sens()[$lang][$sorting_sens_enum];
    }

    public static function list_of_sorting_sens_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::sorting_sens()[$lang];
    }

    public static function sorting_sens()
    {
        $arr_list_of_sorting_sens = array();


        $arr_list_of_sorting_sens["en"][1] = "Priority for biggest value";
        $arr_list_of_sorting_sens["ar"][1] = "الأولوية للقيمة الأكبر";
        $arr_list_of_sorting_sens["code"][1] = "desc";

        $arr_list_of_sorting_sens["en"][2] = "Priority for smallest value";
        $arr_list_of_sorting_sens["ar"][2] = "الأولوية للقيمة الأصغر";
        $arr_list_of_sorting_sens["code"][2] = "asc";

        return $arr_list_of_sorting_sens;
    }

    public function settings($field_name, $col_struct)
    {
        $col_struct = strtolower($col_struct);
        $table_name = $this->getTableName();
        return AfwSession::config("setting-$table_name-$field_name-$col_struct", null);
    }


    /*

        public static function list_of_qualification_track_enum()
        {
            $lang = AfwLanguageHelper::getGlobalLanguage();
            return self::qualification_track()[$lang];
        }

        
        public static function qualification_track()
        {
                $arr_list_of_qualification_track = array();
                
                        
                $arr_list_of_qualification_track["en"][1] = "literary";
                $arr_list_of_qualification_track["ar"][1] = "أدبي";
                $arr_list_of_qualification_track["code"][1] = "literary";

                $arr_list_of_qualification_track["en"][2] = "";
                $arr_list_of_qualification_track["ar"][2] = "علمي";
                $arr_list_of_qualification_track["code"][2] = "Book";

                return $arr_list_of_qualification_track;
        } */




    public static function list_of_religion_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::religion_enum()[$lang];
    }

    public static function religion_enum()
    {
        $arr_list_of_religion_enum = array();


        $arr_list_of_religion_enum["en"][1] = "Islam";
        $arr_list_of_religion_enum["ar"][1] = "الإسلام";
        $arr_list_of_religion_enum["code"][1] = "Islam";

        $arr_list_of_religion_enum["en"][2] = "People of book";
        $arr_list_of_religion_enum["ar"][2] = "أهل الكتاب";
        $arr_list_of_religion_enum["code"][2] = "Book";


        $arr_list_of_religion_enum["en"][3] = "Other religion";
        $arr_list_of_religion_enum["ar"][3] = "دين آخر";
        $arr_list_of_religion_enum["code"][3] = "Other";


        return $arr_list_of_religion_enum;
    }

    public static function standard_application_step_title_by_code($the_code)
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        $arr = self::standard_application_step_enum();
        foreach ($arr['code'] as $eid => $code) {
            if ($the_code == $code) return $arr[$lang][$eid];
        }


        return $the_code;
    }



    public static function list_of_standard_application_step_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::standard_application_step_enum()[$lang];
    }

    public static function standard_application_step_enum()
    {
        $arr_list_of_standard_application_step_enum = array();


        $arr_list_of_standard_application_step_enum["en"][1] = "select desires";
        $arr_list_of_standard_application_step_enum["ar"][1] = "اختيار الرغبات";
        $arr_list_of_standard_application_step_enum["code"][1] = "DSR";

        $arr_list_of_standard_application_step_enum["en"][2] = "sorting";
        $arr_list_of_standard_application_step_enum["ar"][2] = "الفرز";
        $arr_list_of_standard_application_step_enum["code"][2] = "SRT";

        $arr_list_of_standard_application_step_enum["en"][3] = "Final admission";
        $arr_list_of_standard_application_step_enum["ar"][3] = "القبول النهائي";
        $arr_list_of_standard_application_step_enum["code"][3] = "FNL";

        return $arr_list_of_standard_application_step_enum;
    }

    public static function application_status_code($application_status_enum)
    {
        $arr = self::application_status_enum();
        foreach ($arr['code'] as $eid => $code) {
            if ($application_status_enum == $eid) return $code;
        }

        return "??";
    }

    public static function application_status_enum_by_code($the_code = null)
    {
        $result = [];
        $arr = self::application_status_enum();
        foreach ($arr['code'] as $eid => $code) {
            if ($the_code and ($the_code == $code)) return $eid;
            elseif (!$the_code) $result[$code] = $eid;
        }


        if ($the_code) return 0;
        else return $result;
    }



    public static function list_of_application_status_enum($lang = null)
    {
        if (!$lang) $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::application_status_enum()[$lang];
    }

    public static function application_status_enum()
    {
        $arr_list_of_application_status_enum = array();


        $arr_list_of_application_status_enum["en"][1] = "application pending";
        $arr_list_of_application_status_enum["ar"][1] = "جاري التقديم";
        $arr_list_of_application_status_enum["code"][1] = "pending";

        $arr_list_of_application_status_enum["en"][2] = "application complete";
        $arr_list_of_application_status_enum["ar"][2] = "تقديم مكتمل";
        $arr_list_of_application_status_enum["code"][2] = "complete";

        $arr_list_of_application_status_enum["en"][3] = "withdrawn";
        $arr_list_of_application_status_enum["ar"][3] = "منسحب";
        $arr_list_of_application_status_enum["code"][3] = "withdrawn";

        $arr_list_of_application_status_enum["en"][4] = "data review";
        $arr_list_of_application_status_enum["ar"][4] = "مراجعة البيانات";
        $arr_list_of_application_status_enum["code"][4] = "data-review";

        $arr_list_of_application_status_enum["en"][5] = "accepted";
        $arr_list_of_application_status_enum["ar"][5] = "مقبول";
        $arr_list_of_application_status_enum["code"][5] = "accepted";

        $arr_list_of_application_status_enum["en"][6] = "excluded";
        $arr_list_of_application_status_enum["ar"][6] = "مستبعد";
        $arr_list_of_application_status_enum["code"][6] = "excluded";

        return $arr_list_of_application_status_enum;
    }

    public static function list_of_desire_status_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::desire_status_enum()[$lang];
    }

    public static function desire_status_enum()
    {
        $arr_list_of_desire_status_enum = array();


        $arr_list_of_desire_status_enum["en"][1] = "candidate";
        $arr_list_of_desire_status_enum["ar"][1] = "مترشح";
        $arr_list_of_desire_status_enum["code"][1] = "candidate";

        $arr_list_of_desire_status_enum["en"][2] = "initial acceptance";
        $arr_list_of_desire_status_enum["ar"][2] = "قبول مبدئي";
        $arr_list_of_desire_status_enum["code"][2] = "initial-acceptance";

        $arr_list_of_desire_status_enum["en"][3] = "final acceptance";
        $arr_list_of_desire_status_enum["ar"][3] = "قبول نهائي";
        $arr_list_of_desire_status_enum["code"][3] = "final-acceptance";

        $arr_list_of_desire_status_enum["en"][4] = "data review";
        $arr_list_of_desire_status_enum["ar"][4] = "مراجعة البيانات";
        $arr_list_of_desire_status_enum["code"][4] = "data-review";

        $arr_list_of_desire_status_enum["en"][5] = "accepted in higher desire";
        $arr_list_of_desire_status_enum["ar"][5] = "قبول في رغبة أعلى";
        $arr_list_of_desire_status_enum["code"][5] = "higher-desire";

        $arr_list_of_desire_status_enum["en"][6] = "rejected acceptance";
        $arr_list_of_desire_status_enum["ar"][6] = "عرض قبول مرفوض";
        $arr_list_of_desire_status_enum["code"][6] = "rejected-acceptance";

        $arr_list_of_desire_status_enum["en"][7] = "Did not achieve the required percentage";
        $arr_list_of_desire_status_enum["ar"][7] = "لم يحقق النسبة المطلوبة";
        $arr_list_of_desire_status_enum["code"][7] = "not-achieved";

        $arr_list_of_desire_status_enum["en"][8] = "excluded";
        $arr_list_of_desire_status_enum["ar"][8] = "مستبعد";
        $arr_list_of_desire_status_enum["code"][8] = "excluded";

        $arr_list_of_desire_status_enum["en"][9] = "withdrawn";
        $arr_list_of_desire_status_enum["ar"][9] = "منسحب";
        $arr_list_of_desire_status_enum["code"][9] = "withdrawn";

        $arr_list_of_desire_status_enum["en"][10] = "disclaimer";
        $arr_list_of_desire_status_enum["ar"][10] = "إخلاء طرف";
        $arr_list_of_desire_status_enum["code"][10] = "disclaimer";



        return $arr_list_of_desire_status_enum;
    }

    public static function desire_status_enum_by_code($the_code = null)
    {
        $result = [];
        $arr = self::desire_status_enum();
        foreach ($arr['code'] as $eid => $code) {
            if ($the_code and ($the_code == $code)) return $eid;
            elseif (!$the_code) $result[$code] = $eid;
        }


        if ($the_code) return 0;
        else return $result;
    }




    public static function list_of_need_evaluation_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::need_evaluation_enum()[$lang];
    }

    public static function need_evaluation_enum()
    {
        $arr_list_of_application_admission_enum = array();


        $arr_list_of_application_admission_enum["en"][1] = "needs updates";
        $arr_list_of_application_admission_enum["ar"][1] = "بحاجة للتحديث";
        $arr_list_of_application_admission_enum["code"][1] = "NED";

        $arr_list_of_application_admission_enum["en"][2] = "update done";
        $arr_list_of_application_admission_enum["ar"][2] = "تم التحديث";
        $arr_list_of_application_admission_enum["code"][2] = "UPDATED";

        $arr_list_of_application_admission_enum["en"][0] = "don't need update";
        $arr_list_of_application_admission_enum["ar"][2] = "لا حاجة للتحديث";
        $arr_list_of_application_admission_enum["code"][2] = "NOUPDATE";


        return $arr_list_of_application_admission_enum;
    }
    public static function list_of_application_admission_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::application_admission_enum()[$lang];
    }

    public static function application_admission_enum()
    {
        $arr_list_of_application_admission_enum = array();


        $arr_list_of_application_admission_enum["en"][1] = "Application";
        $arr_list_of_application_admission_enum["ar"][1] = "تقديم";
        $arr_list_of_application_admission_enum["code"][1] = "APP";

        $arr_list_of_application_admission_enum["en"][2] = "Admission";
        $arr_list_of_application_admission_enum["ar"][2] = "قبول";
        $arr_list_of_application_admission_enum["code"][2] = "ADM";


        return $arr_list_of_application_admission_enum;
    }









    public static function list_of_agreement_scope_type_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::agreement_scope_type_enum()[$lang];
    }

    public static function agreement_scope_type_enum()
    {
        $arr_list_of_agreement_scope_type_enum = array();


        $arr_list_of_agreement_scope_type_enum["en"][1] = "general";
        $arr_list_of_agreement_scope_type_enum["ar"][1] = "عام";

        $arr_list_of_agreement_scope_type_enum["en"][2] = "private";
        $arr_list_of_agreement_scope_type_enum["ar"][2] = "خاص";



        return $arr_list_of_agreement_scope_type_enum;
    }







    public static function list_of_marital_status_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::marital_status_enum()[$lang];
    }

    public static function marital_status_enum()
    {
        $arr_list_of_marital_status_enum = array();


        $arr_list_of_marital_status_enum["en"][1] = "Single";
        $arr_list_of_marital_status_enum["ar"][1] = "أعزب - عزباء";
        $arr_list_of_marital_status_enum["code"][1] = "Single";

        $arr_list_of_marital_status_enum["en"][2] = "Married";
        $arr_list_of_marital_status_enum["ar"][2] = "متزوج(ة)";
        $arr_list_of_marital_status_enum["code"][2] = "Married";


        $arr_list_of_marital_status_enum["en"][3] = "Widow";
        $arr_list_of_marital_status_enum["ar"][3] = "أرملة";
        $arr_list_of_marital_status_enum["code"][3] = "Widow";

        $arr_list_of_marital_status_enum["en"][4] = "Divorced";
        $arr_list_of_marital_status_enum["ar"][4] = "مطلقة";
        $arr_list_of_marital_status_enum["code"][4] = "Divorced";


        return $arr_list_of_marital_status_enum;
    }







    public static function list_of_address_type_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::address_type_enum()[$lang];
    }

    public static function address_type_enum()
    {
        $arr_list_of_address_type_enum = array();

        $arr_list_of_address_type_enum["en"][1] = "National Address";
        $arr_list_of_address_type_enum["ar"][1] = "العنوان الوطني";
        $arr_list_of_address_type_enum["code"][1] = "NA";

        $arr_list_of_address_type_enum["en"][2] = "Parent Address";
        $arr_list_of_address_type_enum["ar"][2] = "ولي الامر";
        $arr_list_of_address_type_enum["code"][2] = "PA";

        $arr_list_of_address_type_enum["en"][3] = "Work Address";
        $arr_list_of_address_type_enum["ar"][3] = "عنوان العمل";
        $arr_list_of_address_type_enum["code"][3] = "BU";


        $arr_list_of_address_type_enum["en"][4] = "Permanent Address";
        $arr_list_of_address_type_enum["ar"][4] = "دائمة";
        $arr_list_of_address_type_enum["code"][4] = "PR";

        $arr_list_of_address_type_enum["en"][4] = "Billing Address";
        $arr_list_of_address_type_enum["ar"][4] = "اصدار الفواتير";
        $arr_list_of_address_type_enum["code"][4] = "BI";


        return $arr_list_of_address_type_enum;
    }







    public static function list_of_employer_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::employer_enum()[$lang];
    }

    public static function employer_enum()
    {
        $arr_list_of_employer_enum = array();

        $arr_list_of_employer_enum["en"][1] = "Government sector";
        $arr_list_of_employer_enum["ar"][1] = "قطاع حكومي";
        $arr_list_of_employer_enum["code"][1] = "Government";

        $arr_list_of_employer_enum["en"][2] = "Private sector";
        $arr_list_of_employer_enum["ar"][2] = "قطاع خاص";
        $arr_list_of_employer_enum["code"][2] = "Private";

        return $arr_list_of_employer_enum;
    }











    public static function list_of_relationship_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::relationship_enum()[$lang];
    }

    public static function relationship_enum()
    {
        $arr_list_of_relationship_enum = array();

        $arr_list_of_relationship_enum["en"][1] = "Parent";
        $arr_list_of_relationship_enum["ar"][1] = "والد(ة)";
        $arr_list_of_relationship_enum["code"][1] = "P";

        $arr_list_of_relationship_enum["en"][2] = "Hasband/wife";
        $arr_list_of_relationship_enum["ar"][2] = "زوج(ة)";
        $arr_list_of_relationship_enum["code"][2] = "H";

        $arr_list_of_relationship_enum["en"][3] = "Friend";
        $arr_list_of_relationship_enum["ar"][3] = "صديق";
        $arr_list_of_relationship_enum["code"][3] = "F";


        $arr_list_of_relationship_enum["en"][4] = "Son";
        $arr_list_of_relationship_enum["ar"][4] = "الابن";
        $arr_list_of_relationship_enum["code"][4] = "S";

        $arr_list_of_relationship_enum["en"][5] = "Brother/Sister";
        $arr_list_of_relationship_enum["ar"][5] = "الاخ-ت";
        $arr_list_of_relationship_enum["code"][5] = "B";

        $arr_list_of_relationship_enum["en"][6] = "Grandpa";
        $arr_list_of_relationship_enum["ar"][6] = "الجد";
        $arr_list_of_relationship_enum["code"][6] = "G";

        $arr_list_of_relationship_enum["en"][7] = "Neighbor";
        $arr_list_of_relationship_enum["ar"][7] = "الجار";
        $arr_list_of_relationship_enum["code"][7] = "N";

        $arr_list_of_relationship_enum["en"][8] = "Guardian";
        $arr_list_of_relationship_enum["ar"][8] = "ولي الامر";
        $arr_list_of_relationship_enum["code"][8] = "G";


        return $arr_list_of_relationship_enum;
    }









    public static function list_of_level_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::level()[$lang];
    }

    public static function level()
    {
        $arr_list_of_level = array();

        $main_company = AfwSession::currentCompany();
        $file_dir_name = dirname(__FILE__);
        include($file_dir_name . "/../../client-$main_company/extra/qualification_level-$main_company.php");

        foreach ($lookup as $id => $lookup_row) {
            $arr_list_of_level["ar"][$id] = $lookup_row["ar"];
            $arr_list_of_level["en"][$id] = $lookup_row["en"];
        }


        return $arr_list_of_level;
    }









    public static function list_of_job_status_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::job_status()[$lang];
    }

    public static function job_status()
    {
        $arr_list_of_job_status = array();


        $arr_list_of_job_status["en"][1] = "Employee";
        $arr_list_of_job_status["ar"][1] = "موظف";
        $arr_list_of_job_status["code"][1] = "E";

        $arr_list_of_job_status["en"][2] = "Not Employee";
        $arr_list_of_job_status["ar"][2] = "غير موظف";
        $arr_list_of_job_status["code"][2] = "N";


        return $arr_list_of_job_status;
    }

    public static function list_of_sex_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::sex()[$lang];
    }

    public static function sex()
    {
        $arr_list_of_gender = array();


        $arr_list_of_gender["en"][1] = "Male";
        $arr_list_of_gender["ar"][1] = "ذكر";
        $arr_list_of_gender["code"][1] = "M";

        $arr_list_of_gender["en"][2] = "Female";
        $arr_list_of_gender["ar"][2] = "أنثى";
        $arr_list_of_gender["code"][2] = "F";


        return $arr_list_of_gender;
    }


    public static function list_of_genre_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::genre()[$lang];
    }

    public static function genre()
    {
        $arr_list_of_gender = array();


        $arr_list_of_gender["en"][1] = "Male";
        $arr_list_of_gender["ar"][1] = "طالب";
        $arr_list_of_gender["code"][1] = "M";

        $arr_list_of_gender["en"][2] = "Female";
        $arr_list_of_gender["ar"][2] = "طالبة";
        $arr_list_of_gender["code"][2] = "F";


        return $arr_list_of_gender;
    }


    public static function list_of_gender_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::gender()[$lang];
    }

    public static function gender($multi_gender=false)
    {
        // في البلدان التي فيها اختلاط الجنسين مثل بلدنا 
        // الله يرحم حال بلدنا يجب وضع 
        // gender-separed = false in config file
        $gender_separed = AfwSession::config("gender-separed", true);
        $arr_list_of_gender = array();


        $arr_list_of_gender["en"][1] = "Male Students";
        $arr_list_of_gender["ar"][1] = "طلاب";
        $arr_list_of_gender["code"][1] = "M";

        $arr_list_of_gender["en"][2] = "Female Students";
        $arr_list_of_gender["ar"][2] = "طالبات";
        $arr_list_of_gender["code"][2] = "F";

        if($multi_gender)
        {
            $suffix_to_explain_ar = "";
            $suffix_to_explain_en = "";
            // throw new AfwRuntimeException("multi_gender=true good");
            if(!$gender_separed)
            {
                $suffix_to_explain_ar = " منفصل";
                $suffix_to_explain_en = " separed";
            }    
            $arr_list_of_gender["en"][3] = "Male & Female".$suffix_to_explain_en;            
            $arr_list_of_gender["ar"][3] = "طلاب و طالبات".$suffix_to_explain_ar;
            $arr_list_of_gender["code"][3] = "MF";
        }
        // else throw new AfwRuntimeException("multi_gender=false ???");


        if(!$gender_separed)
        {
            $arr_list_of_gender["en"][4] = "Male & Female Students";
            $arr_list_of_gender["ar"][4] = "طلاب وطالبات مختلط";
            $arr_list_of_gender["code"][4] = "X";
        }
        

        return $arr_list_of_gender;
    }

    public static function list_of_genders_enum()
    {
        // throw new AfwRuntimeException("list_of_genders_enum here entered");
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::genders()[$lang];
    }

    public static function genders()
    {
        return self::gender(true);
    }


    public static function list_of_training_mode_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::training_mode()[$lang];
    }

    public static function training_mode()
    {
        $arr_list_of_training_mode = array();


        $arr_list_of_training_mode["en"][1] = "Presence";
        $arr_list_of_training_mode["ar"][1] = "حضوري";
        $arr_list_of_training_mode["code"][1] = "P";

        $arr_list_of_training_mode["en"][2] = "Online";
        $arr_list_of_training_mode["ar"][2] = "عن بعد";
        $arr_list_of_training_mode["code"][2] = "O";

        $arr_list_of_training_mode["en"][3] = "Mixed";
        $arr_list_of_training_mode["ar"][3] = "مدمج";
        $arr_list_of_training_mode["code"][3] = "X";


        return $arr_list_of_training_mode;
    }

    public static function list_of_lor_status_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::lor_status()[$lang];
    }

    public static function lor_status()
    {
        $arr_list_of_training_mode = array();


        $arr_list_of_training_mode["en"][1] = "For review";
        $arr_list_of_training_mode["ar"][1] = "للمراجعة";

        $arr_list_of_training_mode["en"][2] = "Rejected";
        $arr_list_of_training_mode["ar"][2] = "مرفوضة";

        $arr_list_of_training_mode["en"][3] = "Approved";
        $arr_list_of_training_mode["ar"][3] = "معتمدة";

        $arr_list_of_training_mode["en"][4] = "Under review";
        $arr_list_of_training_mode["ar"][4] = "قيد المراجعة";

        return $arr_list_of_training_mode;
    }


    public static function list_of_notification_type_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::notification_type()[$lang];
    }

    public static function notification_type()
    {
        $arr_list_of_training_mode = array();


        $arr_list_of_training_mode["en"][1] = "email";
        $arr_list_of_training_mode["ar"][1] = "بريد الكتروني";

        $arr_list_of_training_mode["en"][2] = "sms";
        $arr_list_of_training_mode["ar"][2] = "رسالة نصية";

        $arr_list_of_training_mode["en"][3] = "phone call";
        $arr_list_of_training_mode["ar"][3] = "اتصال هاتفي";

        $arr_list_of_training_mode["en"][4] = "direct contact";
        $arr_list_of_training_mode["ar"][4] = "اتصال مباشر";

        return $arr_list_of_training_mode;
    }

    public static function code_of_term_mode_enum($lkp_id = null)
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        if ($lkp_id) return self::term_mode()['code'][$lkp_id];
        else return self::term_mode()['code'];
    }


    public static function list_of_term_mode_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::term_mode()[$lang];
    }

    public static function term_mode()
    {
        $arr_list_of_term_mode = array();

        $arr_list_of_term_mode["en"][1] = "Annual";
        $arr_list_of_term_mode["ar"][1] = "سنوي";
        $arr_list_of_term_mode["code"][1] = "";

        $arr_list_of_term_mode["en"][2] = "Semester";
        $arr_list_of_term_mode["ar"][2] = "نصفي";
        $arr_list_of_term_mode["code"][2] = "";

        $arr_list_of_term_mode["en"][3] = "Trimester";
        $arr_list_of_term_mode["ar"][3] = "ثلثي";
        $arr_list_of_term_mode["code"][3] = "";

        $arr_list_of_term_mode["en"][4] = "Quarter";
        $arr_list_of_term_mode["ar"][4] = "ربعي";
        $arr_list_of_term_mode["code"][4] = "";




        return $arr_list_of_term_mode;
    }

    public static function list_of_afield_set_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::afield_set()[$lang];
    }

    public static function afield_set()
    {
        $arr_list_of_afield_set = array();

        $arr_list_of_afield_set["en"][1] = "";
        $arr_list_of_afield_set["ar"][1] = "نتائج الإختبارت";
        $arr_list_of_afield_set["code"][1] = "1";

        $arr_list_of_afield_set["en"][2] = "";
        $arr_list_of_afield_set["ar"][2] = "الحصول على الشهادات العلمية";
        $arr_list_of_afield_set["code"][2] = "2";

        $arr_list_of_afield_set["en"][3] = "";
        $arr_list_of_afield_set["ar"][3] = "معدلات الشهادات العلمية";
        $arr_list_of_afield_set["code"][3] = "3";

        $arr_list_of_afield_set["en"][4] = "";
        $arr_list_of_afield_set["ar"][4] = "تواريخ الشهادات العلمية";
        $arr_list_of_afield_set["code"][4] = "4";

        $arr_list_of_afield_set["en"][5] = "";
        $arr_list_of_afield_set["ar"][5] = "درجات في اختبار أو مؤهل علمي";
        $arr_list_of_afield_set["code"][5] = "5";



        return $arr_list_of_afield_set;
    }





    public static function list_of_entry_type_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::entry_type()[$lang];
    }

    public static function entry_type()
    {
        $arr_list_of_entry_type = array();

        $arr_list_of_entry_type["en"][1] = "Manual";
        $arr_list_of_entry_type["ar"][1] = "يدويا";
        $arr_list_of_entry_type["code"][1] = "";

        $arr_list_of_entry_type["en"][2] = "API";
        $arr_list_of_entry_type["ar"][2] = "واجهة برمجة التطبيقات";
        $arr_list_of_entry_type["code"][2] = "";

        $arr_list_of_entry_type["en"][3] = "Semi-Automatic";
        $arr_list_of_entry_type["ar"][3] = "آلي/يدوي";
        $arr_list_of_entry_type["code"][3] = "";

        $arr_list_of_entry_type["en"][4] = "Computed";
        $arr_list_of_entry_type["ar"][4] = "محسوب غير مدخل";
        $arr_list_of_entry_type["code"][4] = "";

        $arr_list_of_entry_type["en"][5] = "Web service";
        $arr_list_of_entry_type["ar"][5] = "خدمة واب";
        $arr_list_of_entry_type["code"][5] = "";



        return $arr_list_of_entry_type;
    }

    public static function list_of_payment_status_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::payment_status()[$lang];
    }

    public static function payment_status()
    {
        $arr_list_of_Payment_Status = array();

        $arr_list_of_Payment_Status["en"][1] = "Not Paid";
        $arr_list_of_Payment_Status["ar"][1] = "غير مدفوع";
        $arr_list_of_Payment_Status["code"][1] = "";

        $arr_list_of_Payment_Status["en"][2] = "Totally Paid";
        $arr_list_of_Payment_Status["ar"][2] = "تم الدفع كليا";
        $arr_list_of_Payment_Status["code"][2] = "";

        $arr_list_of_Payment_Status["en"][3] = "Partially Paid";
        $arr_list_of_Payment_Status["ar"][3] = "تم الدفع جزئيا";
        $arr_list_of_Payment_Status["code"][3] = "";

        $arr_list_of_Payment_Status["en"][4] = "Exempt from payment";
        $arr_list_of_Payment_Status["ar"][4] = "معفي من الدفع";
        $arr_list_of_Payment_Status["code"][4] = "";




        return $arr_list_of_Payment_Status;
    }
    public static function list_of_payment_method_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::payment_method()[$lang];
    }

    public static function payment_method()
    {
        $arr_list_of_payment_method = array();

        $arr_list_of_payment_method["en"][1] = "Electronic payment";
        $arr_list_of_payment_method["ar"][1] = "دفع الكتروني";
        $arr_list_of_payment_method["code"][1] = "";

        $arr_list_of_payment_method["en"][2] = "Sadadd";
        $arr_list_of_payment_method["ar"][2] = "سداد";
        $arr_list_of_payment_method["code"][2] = "";

        $arr_list_of_payment_method["en"][3] = "Cash";
        $arr_list_of_payment_method["ar"][3] = "نقدا";
        $arr_list_of_payment_method["code"][3] = "";




        return $arr_list_of_payment_method;
    }

    public static function list_of_phase_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::phase()[$lang];
    }

    public static function phase()
    {
        $arr_list_of_phase = array();


        $arr_list_of_phase["en"][1] = "Application";
        $arr_list_of_phase["ar"][1] = "التقديم";
        $arr_list_of_phase["code"][1] = "APP";

        $arr_list_of_phase["en"][2] = "Admission";
        $arr_list_of_phase["ar"][2] = "القبول";
        $arr_list_of_phase["code"][2] = "ADM";



        return $arr_list_of_phase;
    }

    public static function list_of_residency_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::residency_enum()[$lang];
    }

    public static function residency_enum()
    {
        $arr_list_of_phase = array();


        $arr_list_of_phase["en"][1] = "Domestic";
        $arr_list_of_phase["ar"][1] = "داخلي";
        $arr_list_of_phase["code"][1] = "DOM";

        $arr_list_of_phase["en"][2] = "International";
        $arr_list_of_phase["ar"][2] = "خارجي";
        $arr_list_of_phase["code"][2] = "INT";



        return $arr_list_of_phase;
    }
    public static function list_of_semester_type()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::semester_type()[$lang];
    }

    public static function semester_type()
    {
        $arr_list_of_phase = array();


        $arr_list_of_phase["en"][1] = "Fall";
        $arr_list_of_phase["ar"][1] = "الفصل الخريفي";
        $arr_list_of_phase["code"][1] = "FALL";

        $arr_list_of_phase["en"][2] = "Spring";
        $arr_list_of_phase["ar"][2] = "الفصل الربيعي";
        $arr_list_of_phase["code"][2] = "SPRING";

        $arr_list_of_phase["en"][3] = "Summer";
        $arr_list_of_phase["ar"][3] = "الفصل الصيفي";
        $arr_list_of_phase["code"][3] = "SUMMER";



        return $arr_list_of_phase;
    }

    public static function list_of_tuition_model()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::tuition_model()[$lang];
    }

    public static function tuition_model()
    {
        $arr_list_of_phase = array();


        $arr_list_of_phase["en"][1] = "Flat Per Term";
        $arr_list_of_phase["ar"][1] = "لكل فصل";
        $arr_list_of_phase["code"][1] = "TERM";

        $arr_list_of_phase["en"][2] = "Per Credit Hour";
        $arr_list_of_phase["ar"][2] = "لكل ساعة معتمدة";
        $arr_list_of_phase["code"][2] = "HOUR";



        return $arr_list_of_phase;
    }

    public static function executeIndicator($object, $indicator, $normal_class, $arrObjectsRelated, $sens = "asc", $default_red_pct = 0, $default_orange_pct = 0)
    {
        global $MODE_SQL_PROCESS_LOURD, $nb_queries_executed;
        $old_nb_queries_executed = $nb_queries_executed;
        $old_MODE_SQL_PROCESS_LOURD = $MODE_SQL_PROCESS_LOURD;
        $MODE_SQL_PROCESS_LOURD = true;

        if (!$normal_class) $normal_class = "vert";
        $methodIndicator = "get" . $indicator . "Indicator";
        list($objective, $value) = $object->$methodIndicator($arrObjectsRelated);

        $objective_red_pct = $object->getVal(strtolower($indicator) . "_red_pct");
        if (!$objective_red_pct) $objective_red_pct = $default_red_pct;
        if (!$objective_red_pct) $objective_red_pct = ($sens == "asc") ? 80.0 : 120.0;

        $objective_red = $objective_red_pct * $objective / 100.0;

        $orange_pct = $object->getVal("orange_pct");

        if (!$orange_pct) $orange_pct = $default_orange_pct;
        if (!$orange_pct) $orange_pct = ($sens == "asc") ? 90.0 : 110.0; // %
        $objective_orange_pct = round($objective_red_pct * 100.0 / $orange_pct);
        $objective_orange = $objective_orange_pct * $objective / 100.0;

        if (($sens == "asc")) {
            if ($value < $objective_red) $value_class = "$indicator rouge";
            elseif ($value < $objective_orange) $value_class = "orange";
            else $value_class = $normal_class;
        } else {
            if ($value > $objective_red) $value_class = "$indicator rouge";
            elseif ($value > $objective_orange) $value_class = "orange";
            else $value_class = $normal_class;
        }

        $MODE_SQL_PROCESS_LOURD = $old_MODE_SQL_PROCESS_LOURD;
        $nb_queries_executed = $old_nb_queries_executed;


        // die("$objective, $value, $value_class, $objective_red, $objective_orange");
        return [$objective, $value, $value_class, $objective_red, $objective_orange];
    }

    public static function application_table_id($application_table)
    {
        $arr = self::application_table()["code"];
        foreach ($arr as $eid => $table) {
            if ($application_table == $table) return $eid;
        }

        return 0;
    }

    public static function code_of_application_table_id($lkp_id = null)
    {
        if ($lkp_id) return self::application_table()['code'][$lkp_id];
        else return self::application_table()['code'];
    }

    public static function list_of_application_table_id()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::application_table()[$lang];
    }

    public static function application_table()
    {
        $arr_list_of_application_table = array();

        $arr_list_of_application_table["ar"][1] = "المتقدمون";
        $arr_list_of_application_table["en"][1] = "Applicants";
        $arr_list_of_application_table["code"][1] = "applicant";

        $arr_list_of_application_table["ar"][2] = "رغبات المتقدم";
        $arr_list_of_application_table["en"][2] = "Applicant desires";
        $arr_list_of_application_table["code"][2] = "adesire";

        $arr_list_of_application_table["ar"][3] = "طلبات التقديم";
        $arr_list_of_application_table["en"][3] = "Applications";
        $arr_list_of_application_table["code"][3] = "application";



        return $arr_list_of_application_table;
    }




    public static function answer_table()
    {
        $arr_list_of_answer_table = array();

        $arr_list_of_answer_table["ar"][1] = "أنواع الهويات";
        $arr_list_of_answer_table["en"][1] = "identity type";
        $arr_list_of_answer_table["code"][1] = "identity_type";
        $arr_list_of_answer_table["module"][1] = "adm";

        /*
                $arr_list_of_answer_table["ar"][2] = "xxxx";
                $arr_list_of_answer_table["en"][2] = "xxxx xxxx";
                $arr_list_of_answer_table["code"][2] = "xxxx";*/


        return $arr_list_of_answer_table;
    }



    public static function list_of_period_type()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::period_type()[$lang];
    }

    public static function period_type()
    {
        $arr_period_type = array();


        $arr_period_type["en"][1] = "principal period";
        $arr_period_type["ar"][1] = "الفترة الأساسية";

        $arr_period_type["en"][2] = "The subsequent period";
        $arr_period_type["ar"][2] = "الفترة الالحاقية";




        return $arr_period_type;
    }
    public static function list_of_financial_element_unit_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::financial_element_unit()[$lang];
    }

    public static function financial_element_unit()
    {
        $arr_list_of_unit = array();


        $arr_list_of_unit["en"][1] = "credit hours";
        $arr_list_of_unit["ar"][1] = "الساعة المعتمدة";

        $arr_list_of_unit["en"][2] = "courses";
        $arr_list_of_unit["ar"][2] = "المقرر";

        $arr_list_of_unit["en"][3] = "terms";
        $arr_list_of_unit["ar"][3] = "الفصل الدراسي";

        $arr_list_of_unit["en"][4] = "one-time payment";
        $arr_list_of_unit["ar"][5] = "الدفع مرة واحدة";


        return $arr_list_of_unit;
    }

    public function calcHijri_current()
    {
        return AfwDateHelper::currentHijriDate();
    }


    public static function needUpdateIcon($help)
    {
        return "<img data-toggle='tooltip' data-placement='top' title='$help' width='32' height='32' src=\"pic/need-update.png\" alt=\"\" title=\"\">";
    }

    public static function updatedIcon($help)
    {
        return "<img data-toggle='tooltip' data-placement='top' title='$help' width='32' height='32' src=\"pic/updated.png\" alt=\"\" title=\"\">";
    }

    public function getCssClassName()
    {
        return $this->getTableName();
    }

    public static function loadApiRunner()
    {
        $main_company = AfwSession::currentCompany();
        $api_runner_file = $main_company . "_api_runner";
        $api_runner_class = AfwStringHelper::tableToClass($api_runner_file);
        if (!class_exists($api_runner_class, false)) {
            $file_dir_name = dirname(__FILE__);
            require($file_dir_name . "/../../client-$main_company/extra/$api_runner_file.php");
        }

        return $api_runner_class;
    }

    public static function loadUnitManager()
    {
        $main_company = AfwSession::currentCompany();
        $tunit_to_orgunit_file = $main_company . "_tunit_to_orgunit";
        $tunit_to_orgunit_class = AfwStringHelper::tableToClass($tunit_to_orgunit_file);
        if (!class_exists($tunit_to_orgunit_class, false)) {
            $file_dir_name = dirname(__FILE__);
            require($file_dir_name . "/../../client-$main_company/extra/$tunit_to_orgunit_file.php");
        }

        return $tunit_to_orgunit_class;
    }

    public static function list_of_hierarchy_level_enum()
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        return self::hierarchy_level()[$lang];
    }

    public static function hierarchy_level()
    {
        $arr_list_of_hierarchy_level = array();

        $main_company = AfwSession::currentCompany();
        $current_domain = 25;
        $file_dir_name = dirname(__FILE__);
        include($file_dir_name . "/../../client-$main_company/extra/hierarchy_level-$main_company.php");

        foreach ($hierarchy_level as $id => $lookup_row) {
            $arr_list_of_hierarchy_level["ar"][$id] = $lookup_row["ar"];
            $arr_list_of_hierarchy_level["en"][$id] = $lookup_row["en"];
        }


        return $arr_list_of_hierarchy_level;
    }

    /***** added by medali */
    public static function getToken()
    {
        $authUrl = 'http://212.138.86.196/api/apilogin';
        $credentials = [
            "email" => 'admission@uoh.com',
            "password" => 'admin102030'
        ];

        $ch = curl_init($authUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($credentials));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            //die('Auth Error: ' . curl_error($ch));
            return false;
        }
        curl_close($ch);

        // استخراج التوكن
        $result = json_decode($response, true);
        $token = $result['token'] ?? null;

        if (!$token) {
            return false;
        }
        return $token;
    }

    public static function getTokenUOH()
    {
        $authUrl = 'https://apis.uoh.edu.sa/uoh/Token';
        $credentials = [

            "grant_type" => "password",
            "username" => "Anurag",
            "password" => 'H2$6aNd2023',
        ];

        $ch = curl_init($authUrl . "?" . http_build_query($credentials));
        //die($authUrl."?". http_build_query($credentials));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        // Attach the parameters to the request body
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($credentials));
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        //curl_setopt($ch, CURLOPT_POST, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($credentials));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded'
        ]);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // ⬅️ لعرض التفاصيل

        $response = curl_exec($ch);
        //return $response;
        //$info = curl_getinfo($ch);
        $requestHeaders = curl_getinfo($ch, CURLINFO_HEADER_OUT);
        //die($requestHeaders."\n".$response);
        //return false;
        if (curl_errno($ch)) {
            //die('Auth Error: ' . curl_error($ch));
            return false;
        }
        curl_close($ch);

        // استخراج التوكن
        $result = json_decode($response, true);
        $token = $result['access_token'] ?? null;
        if (!$token) {
            return false;
        }
        return $token;
    }

    /*** end medali code */

    public function calcDoc_type_allowed_list($what = "value")
    {
            return "18,19,20,27,28,29,33,34";
    }


    public static function trainingPeriodContainOther($one_training_period_enum, $other_training_period_enum)
    {
        if(!$one_training_period_enum) return true;
        if($one_training_period_enum==3) return true;
        if($one_training_period_enum==$other_training_period_enum) return true;

        return false;
    }
}
