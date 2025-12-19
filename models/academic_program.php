<?php
class AcademicProgram extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "academic_program";
        public static $DB_STRUCTURE = null;
        public static $copypast = true;

        public function __construct()
        {
                parent::__construct("academic_program", "id", "adm");
                AdmAcademicProgramAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new AcademicProgram();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public function getDisplay($lang = "ar")
        {
                $data = [];
                list($data[0], $link) = $this->displayAttribute("academic_level_id", false, $lang);
                $data[1] = $this->getVal("program_name_$lang");
                return implode("-", $data);
        }

        public function getShortDisplay($lang = "ar")
        {
                $return = $this->getVal("program_name_$lang");
                return $return;
        }

        public function stepsAreOrdered()
        {
                return false;
        }

        protected function getOtherLinksArray($mode, $genereLog = false, $step = "all")
        {
                $lang = AfwLanguageHelper::getGlobalLanguage();
                // $objme = AfwSession::getUserConnected();
                // $me = ($objme) ? $objme->id : 0;

                $otherLinksArray = $this->getOtherLinksArrayStandard($mode, $genereLog, $step);
                $my_id = $this->getId();
                $displ = $this->getDisplay($lang);
                /*
                        if($mode=="mode_academicProgramOfferingList")
                        {
                                unset($link);
                                $link = array();
                                $title = "إضافة منشأة منفذة جديدة";
                                $title_detailed = $title ."لـ : ". $displ;
                                $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=AcademicProgramOffering&currmod=adm&sel_academic_program_id=$my_id";
                                $link["TITLE"] = $title;
                                $link["UGROUPS"] = array();
                                $otherLinksArray[] = $link;
                        }*/

                if ($mode == "mode_programQualificationList") {
                        unset($link);
                        $link = array();
                        $title = "إضافة مسار برنامج اكاديمي جديد";
                        $title_detailed = $title . "لـ : " . $displ;
                        $level_id = $this->getVal("academic_level_id");
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=ProgramQualification&currmod=adm&sel_academic_program_id=$my_id&sel_academic_level_id=$level_id";
                        $link["TITLE"] = $title;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                }



                // check errors on all steps (by default no for optimization)
                // rafik don't know why this : \//  = false;

                return $otherLinksArray;
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
                                // adm.academic_program_offering-Academic program	academic_program_id  OneToMany
                                if (!$simul) {
                                        // require_once "../adm/academic_program_offering.php";
                                        AcademicProgramOffering::removeWhere("academic_program_id='$id'");
                                        // $this->execQuery("delete from ${server_db_prefix}adm.academic_program_offering where academic_program_id = '$id' ");

                                }


                                // adm.program_qualification-Program	academic_program_id  OneToMany
                                if (!$simul) {
                                        // require_once "../adm/program_qualification.php";
                                        ProgramQualification::removeWhere("academic_program_id='$id'");
                                        // $this->execQuery("delete from ${server_db_prefix}adm.program_qualification where academic_program_id = '$id' ");

                                }


                                // adm.application_plan_branch-Program	program_id  ManyToOne
                                if (!$simul) {
                                        // require_once "../adm/application_plan_branch.php";
                                        ApplicationPlanBranch::removeWhere("program_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.application_plan_branch set program_id='$id_replace' where program_id='$id' ");
                                }




                                // FK not part of me - replaceable 




                                // MFK

                        } else {
                                // FK on me 
                                // adm.academic_program_offering-Academic program	academic_program_id  OneToMany
                                if (!$simul) {
                                        // require_once "../adm/academic_program_offering.php";
                                        AcademicProgramOffering::updateWhere(array('academic_program_id' => $id_replace), "academic_program_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.academic_program_offering set academic_program_id='$id_replace' where academic_program_id='$id' ");

                                }

                                // adm.program_qualification-Program	academic_program_id  OneToMany
                                if (!$simul) {
                                        // require_once "../adm/program_qualification.php";
                                        ProgramQualification::updateWhere(array('academic_program_id' => $id_replace), "academic_program_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.program_qualification set academic_program_id='$id_replace' where academic_program_id='$id' ");

                                }

                                // adm.application_plan_branch-Program	program_id  ManyToOne
                                if (!$simul) {
                                        // require_once "../adm/application_plan_branch.php";
                                        ApplicationPlanBranch::updateWhere(array('program_id' => $id_replace), "program_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.application_plan_branch set program_id='$id_replace' where program_id='$id' ");
                                }


                                // MFK


                        }
                        return true;
                }
        }

        // academic_program 
        public function getScenarioItemId($currstep)
        {
                if ($currstep == 1) return 402;
                if ($currstep == 2) return 403;

                return 0;
        }

        public function shouldBeCalculatedField($attribute){
                if($attribute=="pic_view") return true;
                return false;
        }

        public function afterMaj($id, $fields_updated)
        {
                if ($fields_updated["program_track_id"] or $fields_updated["academic_level_id"] or $fields_updated["degree_id"]) {
                        $academicProgramOfferingList = $this->get("academicProgramOfferingList");
                        foreach ($academicProgramOfferingList as $academicProgramOfferingItem) {
                                if ($fields_updated["program_track_id"])
                                {
                                        $programTrackObj = $this->het("program_track_id");
                                        if ($programTrackObj) {
                                                $sorting_group_id = $programTrackObj->getVal("sorting_group_id");
                                                $academicProgramOfferingItem->set("sorting_group_id", $sorting_group_id);
                                        }
                                }
                                
                                $program_track_id = $this->getVal("program_track_id");
                                $academicProgramOfferingItem->set("program_track_id", $program_track_id);
                                
                                $academic_level_id = $this->getVal("academic_level_id");
                                $academicProgramOfferingItem->set("academic_level_id", $academic_level_id);
                                
                                $degree_id = $this->getVal("degree_id");
                                $academicProgramOfferingItem->set("degree_id", $degree_id);
                               
                                $academicProgramOfferingItem->commit();
                        }
                }
        }

        public function synchronizeWithWorkflow($module_id, $lang = "ar")
        {
                $wsObj = WorkflowScope::loadByMainIndex($module_id, $this->getVal("program_code"), true);       
                $wsObj->set("workflow_module_id", $module_id);
                $wsObj->set("lookup_code", $this->getVal("program_code"));
                $wsObj->set("scope_name_ar", $this->getVal("program_name_ar"));
                $wsObj->set("scope_name_en", $this->getVal("program_name_en"));
                $wsObj->set("scope_description_ar", $this->getVal("program_name_ar"));
                $wsObj->set("scope_description_en", $this->getVal("program_name_en"));
                $wsObj->commit();
        }
}
