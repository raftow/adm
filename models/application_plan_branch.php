<?php
class ApplicationPlanBranch extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "application_plan_branch";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("application_plan_branch", "id", "adm");
                AdmApplicationPlanBranchAfwStructure::initInstance($this);
        }

        public function moveColumn()
        {
                return "branch_order";
        }

        public static function loadById($id)
        {
                $obj = new ApplicationPlanBranch();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public static function loadByMainIndex($application_plan_id, $program_offering_id, $gender_enum, $training_period_enum, $create_obj_if_not_found = false)
        {
                if (!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");
                if (!$gender_enum) throw new AfwRuntimeException("loadByMainIndex : gender_enum is mandatory field");
                if (!$training_period_enum) throw new AfwRuntimeException("loadByMainIndex : training_period_enum is mandatory field");
                if (!$program_offering_id) throw new AfwRuntimeException("loadByMainIndex : program_offering_id is mandatory field");


                $obj = new ApplicationPlanBranch();
                $obj->select("application_plan_id", $application_plan_id);
                $obj->select("gender_enum", $gender_enum);
                $obj->select("training_period_enum", $training_period_enum);
                $obj->select("program_offering_id", $program_offering_id);
                if ($obj->load()) {
                        if ($create_obj_if_not_found) $obj->activate();
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        $obj->set("application_plan_id", $application_plan_id);
                        $obj->set("gender_enum", $gender_enum);
                        $obj->set("training_period_enum", $training_period_enum);
                        $obj->set("program_offering_id", $program_offering_id);

                        $applicationPlanObj = ApplicationPlan::loadById($application_plan_id);
                        $application_model_id = $applicationPlanObj->getVal("application_model_id");
                        $applicationModelBranchObj = ApplicationModelBranch::loadByMainIndex($application_model_id, $program_offering_id, $gender_enum, $training_period_enum);
                        $obj->set("application_model_branch_id", $applicationModelBranchObj->id);

                        $obj->insertNew();
                        if (!$obj->id) return null; // means beforeInsert rejected insert operation
                        $obj->is_new = true;
                        return $obj;
                } else return null;
        }




        public static function getBranchsCondWPMatrix($application_plan_id, $sorting_group_id)
        {
                $server_db_prefix = AfwSession::currentDBPrefix();
                return AfwDatabase::db_recup_index("SELECT id, cond_weighted_percentage from " . $server_db_prefix . "adm.application_plan_branch where application_plan_id=$application_plan_id and sorting_group_id=$sorting_group_id", "id", "cond_weighted_percentage");
        }

        public static function getBranchsCapacityMatrix($application_plan_id, $sorting_group_id, $track, $removeConfirmedSeats = false, $application_simulation_id = 0)
        {
                $server_db_prefix = AfwSession::currentDBPrefix();
                $return = AfwDatabase::db_recup_index("SELECT id, capacity_track$track as capacity from " . $server_db_prefix . "adm.application_plan_branch where application_plan_id=$application_plan_id and sorting_group_id=$sorting_group_id", "id", "capacity");

                if ($removeConfirmedSeats) {

                        // desire_status_enum = 3  below means (accepted or accepted with upgrade)
                        $to_remove = AfwDatabase::db_recup_index("SELECT application_plan_branch_id as id, count(*) as capacity
                                        FROM uoh_adm.application_desire
                                        WHERE application_plan_id = $application_plan_id 
                                        AND application_simulation_id = $application_simulation_id
                                        AND active = 'Y'
                                        AND desire_status_enum = 3 
                                        GROUP BY application_plan_branch_id", "id", "capacity");

                        foreach ($to_remove as $apb_id => $torem) {
                                $return[$apb_id] -= $torem;
                        }
                }



                return $return;
        }

        public function getDisplay($lang = 'ar')
        {
                return $this->getDefaultDisplay($lang);
        }

        public function stepsAreOrdered()
        {
                return true;
        }


        public function inheritBranchOrder($lang = "ar")
        {
                $applicationModelBranchObj = $this->het("application_model_branch_id");

                $this->set("branch_order", $applicationModelBranchObj->getVal("branch_order"));
                $this->commit();

                return ["", "done : " . $this->id, ""];
        }


        public function flagBranchsCapacitiesToParent($lang = "ar")
        {
                $applicationModelBranchObj = $this->het("application_model_branch_id");

                $applicationModelBranchObj->set("direct_adm_capacity", $this->getVal("direct_adm_capacity"));
                $applicationModelBranchObj->set("seats_capacity",  $this->getVal("seats_capacity"));
                $applicationModelBranchObj->set("capacity_track1", $this->getVal("capacity_track1"));
                $applicationModelBranchObj->set("capacity_track2", $this->getVal("capacity_track2"));
                $applicationModelBranchObj->set("capacity_track3", $this->getVal("capacity_track3"));
                $applicationModelBranchObj->set("capacity_track4", $this->getVal("capacity_track4"));
                $applicationModelBranchObj->set("sorting_group_id", $this->getVal("sorting_group_id"));


                $applicationModelBranchObj->commit();

                return ["", "flag done to AMB " . $applicationModelBranchObj->id, ""];
        }

        public function inheritBranchsCapacities($lang = "ar")
        {
                $applicationModelBranchObj = $this->het("application_model_branch_id");

                $this->set("direct_adm_capacity", $applicationModelBranchObj->getVal("direct_adm_capacity"));
                $this->set("seats_capacity",  $applicationModelBranchObj->getVal("seats_capacity"));
                $this->set("capacity_track1", $applicationModelBranchObj->getVal("capacity_track1"));
                $this->set("capacity_track2", $applicationModelBranchObj->getVal("capacity_track2"));
                $this->set("capacity_track3", $applicationModelBranchObj->getVal("capacity_track3"));
                $this->set("capacity_track4", $applicationModelBranchObj->getVal("capacity_track4"));
                $this->set("sorting_group_id", $applicationModelBranchObj->getVal("sorting_group_id"));


                $this->commit();

                return ["", "done : " . $this->id, ""];
        }


        public function beforeMaj($id, $fields_updated)
        {
                $lang = AfwLanguageHelper::getGlobalLanguage();
                $applicationPlanObj = null;
                if ($fields_updated["application_plan_id"] and $this->getVal("application_plan_id")) {
                        $applicationPlanObj = $this->het("application_plan_id");
                        if ($applicationPlanObj) {
                                $this->set("academic_level_id", $applicationPlanObj->calc("academic_level_id"));
                                $this->set("gender_enum", $applicationPlanObj->calc("gender_enum"));
                                $this->set("term_id", $applicationPlanObj->getVal("term_id"));
                        }
                }
                /* je pense que c inutile car on doit remplir tout cela a la creation et ca reste readonly
                if ($fields_updated["program_id"] or $fields_updated["training_unit_id"] or true) {
                        if ($this->getVal("program_id") and $this->getVal("training_unit_id")) {
                                $progOffObj = AcademicProgramOffering::loadByMainIndex($this->getVal("program_id"), $this->getVal("training_unit_id"));
                                if ($progOffObj) {
                                        $this->set("program_offering_id", $progOffObj->id);
                                        if (!$applicationPlanObj) {
                                                $applicationPlanObj = $this->het("application_plan_id");
                                                $applicationModelBranchObj = ApplicationModelBranch::load ByMainIndex($applicationPlanObj->getVal("application_model_id"), $progOffObj->id, );
                                                if ($applicationModelBranchObj) $this->set("application_model_branch_id", $applicationModelBranchObj->id);
                                                $this->genereNames($lang, $progOffObj, false);
                                        }
                                }
                                        
                        }
                }*/

                if ($this->getVal("application_end_date") and $fields_updated["application_end_date"]) {
                        $this->repareHijriApplicationEndDate("ar", false);
                }


                if ($fields_updated["seats_capacity"]) {
                        // calculate the track's capacities try to modify only last ones                       
                        $remain_capacity = $this->getVal("seats_capacity");
                        $application_model_id = ApplicationPlan::getApplicationModelId($this->getVal("application_plan_id"));
                        $maxPaths = SortingPath::nbPaths($application_model_id);
                        for ($t = 1; $t <= 4; $t++) {
                                if (($t >= $maxPaths) or ($remain_capacity < $this->getVal("capacity_track$t"))) {
                                        $this->set("capacity_track$t", $remain_capacity);
                                        $remain_capacity = 0;
                                } else {
                                        $remain_capacity -= $this->getVal("capacity_track$t");
                                }
                        }
                }

                return true;
        }

        public function genereNames($lang = "ar", $progOffObj = null, $commit = true, $force = false)
        {
                if (!$progOffObj) $progOffObj = $this->het("program_offering_id");

                if ($progOffObj) {
                        if (!$this->getVal("name_ar") or ($this->getVal("name_ar") == "--") or $force) {
                                $this->set("name_ar", $progOffObj->getShortDisplay("ar"));
                        }
                        if (!$this->getVal("name_en") or ($this->getVal("name_en") == "--") or $force) {
                                $this->set("name_en", $progOffObj->getShortDisplay("en"));
                        }
                }
                if ($commit) $this->commit();
        }

        public static function genereAllNames($lang = "ar")
        {
                global $MODE_BATCH_LOURD;
                $MODE_BATCH_LOURD = true;
                $obj = new ApplicationPlanBranch();
                // $obj->select_visibilite_horizontale();
                $objList = $obj->loadMany();

                foreach ($objList as $objItem) {
                        $objItem->genereNames($lang);
                }
        }

        public function repareHijriApplicationEndDate($lang = "ar", $commit = true)
        {
                list($application_end_date, $application_end_time) = explode(" ", $this->getVal("application_end_date"));
                if ($application_end_date and ($application_end_date != "0000-00-00")) {
                        $this->set("hijri_application_end_date", AfwDateHelper::gregToHijri($application_end_date));
                } else {
                        $this->set("hijri_application_end_date", "");
                }

                if ($commit) $this->commit();

                return ["", "repareHijriApplicationEndDate done"];
        }


        protected function afterSetAttribute($attribute)
        {
                if (($attribute == "application_plan_id") and $this->getVal("application_plan_id")) {
                        $applicationPlanObj = $this->het("application_plan_id");
                        if ($applicationPlanObj) {
                                $this->set("academic_level_id", $applicationPlanObj->calc("academic_level_id"));
                                $this->set("gender_enum", $applicationPlanObj->calc("gender_enum"));
                                $this->set("term_id", $applicationPlanObj->getVal("term_id"));
                        }
                }
        }


        public function getAttributeLabel($attribute, $lang = 'ar', $short = false)
        {
                $application_plan_id = $this->getVal("application_plan_id");
                $application_model_id = null;


                for ($spath = 1; $spath <= 4; $spath++) {
                        if ($attribute == "capacity_track$spath") {
                                if ($application_plan_id and (!$application_model_id)) {
                                        $application_model_id = ApplicationPlan::getApplicationModelId($application_plan_id);
                                }
                                if ($application_model_id) return SortingPath::trackTranslation($application_model_id, $spath, $lang);
                        }
                }


                // die("calling getAttributeLabel($attribute, $lang, short=$short)");
                return AfwLanguageHelper::getAttributeTranslation($this, $attribute, $lang, $short);
        }

        public function attributeIsApplicable($attribute)
        {
                $split_sorting_by_enum = 99;
                if ($this->getVal("application_plan_id")) {
                        $application_model_id = ApplicationPlan::getApplicationModelId($this->getVal("application_plan_id"));
                        $appModelObj = ApplicationModel::loadById($application_model_id);
                        $split_sorting_by_enum = $appModelObj->getVal("split_sorting_by_enum");
                }

                if ($split_sorting_by_enum == 1) {
                        if ($attribute == "capacity_track1") return true;
                        if ($attribute == "capacity_track2") return false;
                        if ($attribute == "capacity_track3") return false;
                        if ($attribute == "capacity_track4") return false;
                } elseif ($split_sorting_by_enum == 2) {
                        $academic_program_id = $this->getVal("program_id");
                        $maxPaths = SortingPath::nbPaths($application_model_id);
                        // die("$maxPaths = SortingPath::nbPaths($application_model_id);");
                        for ($spath = 1; $spath <= $maxPaths; $spath++) {
                                $majorPathId = SortingPath::trackMajorPathId($application_model_id, $spath);
                                if ($attribute == "capacity_track$spath") {
                                        $return = ProgramQualification::pathExistsFor($academic_program_id, $split_sorting_by_enum, $majorPathId);
                                        // die("ProgramQualification::pathExistsFor(this, $split_sorting_by_enum, $majorPathId) = ".var_export($return,true));
                                        return $return;
                                }
                        }
                        for ($spath = $maxPaths + 1; $spath <= 4; $spath++) {
                                if ($attribute == "capacity_track$spath") {
                                        return false;
                                }
                        }
                } // else return false;

                return true;
        }

        public function whyAttributeIsNotApplicable($attribute, $lang = 'ar')
        {
                if ($this->getVal("application_plan_id")) {
                        $application_model_id = ApplicationPlan::getApplicationModelId($this->getVal("application_plan_id"));
                        // $appModelObj = ApplicationModel::loadById($application_model_id);
                        $maxPaths = SortingPath::nbPaths($application_model_id);
                        for ($spath = 1; $spath <= $maxPaths; $spath++) {
                                $majorPathId = SortingPath::trackMajorPathId($application_model_id, $spath);
                                if ($attribute == "capacity_track$spath") {
                                        $icon = 'N_A.png';
                                        $textReason = $this->translateMessage('This path is not open for this program', $lang);
                                        return [$icon, $textReason, 24, 24];
                                }
                        }
                }


                $icon = 'na20.png';
                $textReason = $this->translateMessage('NA-HERE', $lang);
                return [$icon, $textReason, 20, 20];
        }


        public function beforeDelete($id, $id_replace)
        {
                $server_db_prefix = AfwSession::currentDBPrefix();

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

        // application_plan_branch 
        public function getScenarioItemId($currstep)
        {
                if ($currstep == 1) return 430;
                if ($currstep == 2) return 431;

                return 0;
        }


        public static function getAllMinAppliedScore($sorting_group_id, $application_plan_id, $application_simulation_id, $application_model_id)
        {
                $sorting_step_id = ApplicationModel::getSortingStepId($application_model_id);
                list(
                        $sortingCriterea,
                        $msf1,
                        $sf1_order_sens,
                        $sf1_func,
                        $msf2,
                        $sf2_order_sens,
                        $sf2_func,
                        $msf3,
                        $sf3_order_sens,
                        $sf3_func
                ) = SortingGroup::getGroupingCriterea($sorting_group_id);

                $server_db_prefix = AfwSession::currentDBPrefix();

                // @todo below should be dynamic min(xx) from application_plan_branch ...etc
                $sorting_value_1_min = 60;

                $msf_functions = trim("$sf1_func,$sf2_func,$sf3_func", " ,");
                $msf_cols = trim("$msf1,$msf2,$msf3", " ,");

                $sql = "SELECT application_plan_branch_id, $msf_functions from $server_db_prefix" . "adm.application_desire
                     WHERE application_plan_id = $application_plan_id
                       AND application_simulation_id = $application_simulation_id
                       AND application_step_id = $sorting_step_id
                       AND active = 'Y'
                       AND sorting_value_1 > $sorting_value_1_min
                     GROUP BY application_plan_branch_id  
                ";


                return [$msf_cols, AfwDatabase::db_recup_rows_by_id($sql, "application_plan_branch_id")];
        }

        public function getMinAppliedScore($application_simulation_id, $application_model_id)
        {
                $sorting_group_id = $this->getVal("sorting_group_id");
                list(
                        $sortingCriterea,
                        $sf1,
                        $sf1_order_sens,
                        $sf1_sql,
                        $sf1_insert,
                        $sf1_order,
                        $sf2,
                        $sf2_order_sens,
                        $sf2_sql,
                        $sf2_insert,
                        $sf2_order,
                        $sf3,
                        $sf3_order_sens,
                        $sf3_sql,
                        $sf3_insert,
                        $sf3_order
                ) = SortingGroup::getSortingCriterea($sorting_group_id, true);

                $application_plan_branch_id = $this->id;
                $application_plan_id = $this->getVal("application_plan_id");
                //$application_plan_id = $this->getVal("application_plan_id");                
                $sorting_step_id = ApplicationModel::getSortingStepId($application_model_id);
                $adObj = new ApplicationDesire();
                $adObj->select("application_plan_id", $application_plan_id);
                $adObj->select("application_simulation_id", $application_simulation_id);
                $adObj->select("application_plan_branch_id", $application_plan_branch_id);
                $adObj->select("application_step_id", $sorting_step_id);
                // $sqlMany = $adObj->getSQLMany('', 1, "$sf1_order $sf2_order $sf3_order applicant_id");
                // die("sqlMany is : ".$sqlMany);
                $adObjList = $adObj->loadMany(1, "$sf1_order $sf2_order $sf3_order applicant_id");

                $minArr = [];
                foreach ($adObjList as $adObjItem) {
                        if ($sf1) $minArr[] = $adObjItem->getVal("sorting_value_1");
                        if ($sf2) $minArr[] = $adObjItem->getVal("sorting_value_2");
                        if ($sf3) $minArr[] = $adObjItem->getVal("sorting_value_3");
                }

                return $minArr;
        }
}
