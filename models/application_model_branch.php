<?php
class ApplicationModelBranch extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "application_model_branch";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("application_model_branch", "id", "adm");
                AdmApplicationModelBranchAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new ApplicationModelBranch();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }



        public static function loadByMainIndex($program_offering_id, $application_model_id, $seats_capacity = 0, $create_obj_if_not_found = false)
        {
                $obj = new ApplicationModelBranch();
                $obj->select("program_offering_id", $program_offering_id);
                $obj->select("application_model_id", $application_model_id);

                if ($obj->load()) {
                        if ($create_obj_if_not_found) {
                                $obj->set("seats_capacity", $seats_capacity);
                                $obj->activate();
                        }
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        $obj->set("program_offering_id", $program_offering_id);
                        $obj->set("application_model_id", $application_model_id);
                        $obj->set("seats_capacity", $seats_capacity);
                        $obj->set("confirmation_days", 3);
                        //@todo calculate direct_adm_capacity from pct
                        $direct_adm_capacity_pct = 0.1;
                        $obj->set("direct_adm_capacity", round($seats_capacity * $direct_adm_capacity_pct));
                        $obj->insertNew();
                        if (!$obj->id) return null; // means beforeInsert rejected insert operation
                        $obj->is_new = true;
                        return $obj;
                } else return null;
        }

        public function getDisplay($lang = 'ar')
        {
                return $this->getVal("branch_name_$lang");
        }

        public function stepsAreOrdered()
        {
                return true;
        }


        public function beforeMaj($id, $fields_updated)
        {
                if ($fields_updated["program_offering_id"]) {
                        $po = $this->het("program_offering_id");
                        if ($po) {
                                $this->set("training_unit_id", $po->getVal("training_unit_id"));
                                $this->set("department_id", $po->getVal("department_id"));
                        } else {
                                $this->set("training_unit_id", 0);
                                $this->set("department_id", 0);
                        }
                }

                return true;
        }

        public function getShortDisplay($lang = "ar")
        {
                $progOffr = $this->het("program_offering_id");
                if (!$progOffr) return $this->tm("Incorrect branch settings", $lang);
                return $progOffr->getDisplay($lang);
        }

        public function genereName($lang = "ar", $which = "all", $commit = true)
        {
                $progOffr = $this->het("program_offering_id");
                if (!$progOffr) return ["لم يتم تحديد البرنامج المتاح", ""];
                $appModelObj = $this->het("application_model_id");
                if (!$appModelObj) return ["لم يتم تحديد نموذج القبول", ""];

                if (($which == "all") or ($which == "ar")) {
                        $new_name_ar = $appModelObj->getDisplay("ar") . "-" . $progOffr->getDisplay("ar");
                        $this->set("branch_name_ar", $new_name_ar);
                        // die("reset name to : ".$new_name);
                }

                if (($which == "all") or ($which == "en")) {
                        $new_name_en = $appModelObj->getDisplay("en") . "-" . $progOffr->getDisplay("en");
                        $this->set("branch_name_en", $new_name_en);
                }

                // $this->set("gender_enum", $tunitObj->getVal("gender_enum"));

                if ($commit) $this->commit();

                return ["", "تم تصفير مسمى الفرع إلى $new_name_ar بنجاح"];
        }

        public static function genereAllNames($lang = "ar")
        {
                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];

                $obj = new ApplicationModelBranch();
                // $obj->select_visibilite_horizontale();
                $objList = $obj->loadMany();

                foreach ($objList as $objItem) {
                        list($err, $inf) = $objItem->genereName($lang);
                        if ($err) $err_arr[] = $err;
                        if ($inf) $inf_arr[] = $inf;
                }

                return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
        }


        public function afterMaj($id, $fields_updated)
        {
                if ($fields_updated["sorting_group_id"]) {
                        $sets = [];
                        $sets["sorting_group_id"] = $this->getVal("sorting_group_id");
                        $application_model_branch_id = $this->id;
                        ApplicationDesire::updateWhere($sets,"application_model_branch_id = $application_model_branch_id");
                }


                /* obsolete amjed asked to remove seats_capacity_1 and seats_capacity_2 from AcademicProgramOffering
                        if($fields_updated["seats_capacity"])
                        {
                             $amObj = $this->het("application_model_id");   
                             $poObj = $this->het("program_offering_id");   
                             if($amObj and $poObj)
                             {
                                $period = $amObj->getVal("training_period_enum");
                                $poObj->set("seats_capacity_$period", $this->getVal("seats_capacity"));
                                $poObj->commit();
                             }
                        }*/
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
}
