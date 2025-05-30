<?php
class TrainingUnit extends AdmObject
{

    public static $DATABASE        = "";
    public static $MODULE            = "adm";
    public static $TABLE            = "training_unit";
    public static $DB_STRUCTURE = null;
    // public static $copypast = true;

    public function __construct()
    {
        parent::__construct("training_unit", "id", "adm");
        AdmTrainingUnitAfwStructure::initInstance($this);
    }

    public function stepsAreOrdered()
    {
        return true;
    }

    public static function loadById($id)
    {
        $obj = new TrainingUnit();

        if ($obj->load($id)) {
            return $obj;
        } else return null;
    }

    public static function loadByMainIndex($institution_id, $training_unit_code, $create_obj_if_not_found = false)
    {


        $obj = new TrainingUnit();
        $obj->select("institution_id", $institution_id);
        $obj->select("training_unit_code", $training_unit_code);

        if ($obj->load()) {
            if ($create_obj_if_not_found) $obj->activate();
            return $obj;
        } elseif ($create_obj_if_not_found) {
            $obj->set("institution_id", $institution_id);
            $obj->set("training_unit_code", $training_unit_code);

            $obj->insertNew();
            if (!$obj->id) return null; // means beforeInsert rejected insert operation
            $obj->is_new = true;
            return $obj;
        } else return null;
    }


    public function getDisplay($lang = "ar")
    {
        return $this->getVal("training_unit_name_$lang");
    }


    protected function getOtherLinksArray($mode, $genereLog = false, $step = "all")
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        // $objme = AfwSession::getUserConnected();
        // $me = ($objme) ? $objme->id : 0;

        $otherLinksArray = $this->getOtherLinksArrayStandard($mode, $genereLog, $step);
        $my_id = $this->getId();
        $displ = $this->getDisplay($lang);

        if ($mode == "mode_trainingUnitDepartmentList") {
            unset($link);
            $link = array();
            $title = "إضافة علاقة بقسم جديد";
            $title_detailed = $title . "لـ : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=TrainingUnitDepartment&currmod=adm&sel_training_unit_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }
        

        if ($mode == "mode_academicLevelOfferingList") {
            unset($link);
            $link = array();
            $title = "إضافة تنفيذ مرحلة أكاديمية جديدة";
            $title_detailed = $title . "لـ : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=AcademicLevelOffering&currmod=adm&sel_training_unit_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }

        /* all colleges are inserted active = N just you need to active/disactive what you want
        if ($mode == "mode_trainingUnitCollegeList") {
            unset($link);
            $link = array();
            $title = "تفعيل كلية جديدة";
            $title_detailed = $title . "لـ : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=TrainingUnitCollege&currmod=adm&sel_training_unit_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }*/


        if ($mode == "mode_academicProgramOfferingList") {
            unset($link);
            $link = array();
            $title = "إضافة برنامج متاح جديد";
            $title_detailed = $title . "لـ : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=AcademicProgramOffering&currmod=adm&sel_training_unit_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }



        // check errors on all steps (by default no for optimization)
        // rafik don't know why this : \//  = false;

        return $otherLinksArray;
    }

    protected function getPublicMethods()
    {

        $pbms = array();

        $color = "blue";
        $title_ar = "تصحيح البيانات";
        $methodName = "fixMyData";
        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "PUBLIC"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("academicProgramOfferingList"));

        $color = "green";
        $title_ar = "احداث/تحديث عنصر الموارد البشرية"; 
        $methodName = "updateOrgunit";
        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "PUBLIC"=>true, "BF-ID"=>"", 'STEP' =>1);
        



        return $pbms;
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
                // adm.training_unit_department-Training unit	training_unit_id  نوع علاقة بين كيانين ← 1
                if (!$simul) {
                    // require_once "../adm/training_unit_department.php";
                    TrainingUnitDepartment::removeWhere("training_unit_id='$id'");
                    // $this->execQuery("delete from ${server_db_prefix}adm.training_unit_department where training_unit_id = '$id' ");

                }


                // adm.training_unit_college-Training unit	training_unit_id  نوع علاقة بين كيانين ← 1
                if (!$simul) {
                    // require_once "../adm/training_unit_college.php";
                    TrainingUnitCollege::removeWhere("training_unit_id='$id'");
                    // $this->execQuery("delete from ${server_db_prefix}adm.training_unit_college where training_unit_id = '$id' ");

                }


                // adm.academic_level_offering-Training unit	training_unit_id  نوع علاقة بين كيانين ← 1
                if (!$simul) {
                    // require_once "../adm/academic_level_offering.php";
                    AcademicLevelOffering::removeWhere("training_unit_id='$id'");
                    // $this->execQuery("delete from ${server_db_prefix}adm.academic_level_offering where training_unit_id = '$id' ");

                }


                // adm.academic_program_offering-Training unit	training_unit_id  نوع علاقة بين كيانين ← 1
                if (!$simul) {
                    // require_once "../adm/academic_program_offering.php";
                    AcademicProgramOffering::removeWhere("training_unit_id='$id'");
                    // $this->execQuery("delete from ${server_db_prefix}adm.academic_program_offering where training_unit_id = '$id' ");

                }




                // FK not part of me - replaceable 



                // MFK

            } else {
                // FK on me 
                // adm.training_unit_department-Training unit	training_unit_id  نوع علاقة بين كيانين ← 1
                if (!$simul) {
                    // require_once "../adm/training_unit_department.php";
                    TrainingUnitDepartment::updateWhere(array('training_unit_id' => $id_replace), "training_unit_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}adm.training_unit_department set training_unit_id='$id_replace' where training_unit_id='$id' ");

                }

                // adm.training_unit_college-Training unit	training_unit_id  نوع علاقة بين كيانين ← 1
                if (!$simul) {
                    // require_once "../adm/training_unit_college.php";
                    TrainingUnitCollege::updateWhere(array('training_unit_id' => $id_replace), "training_unit_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}adm.training_unit_college set training_unit_id='$id_replace' where training_unit_id='$id' ");

                }

                // adm.academic_level_offering-Training unit	training_unit_id  نوع علاقة بين كيانين ← 1
                if (!$simul) {
                    // require_once "../adm/academic_level_offering.php";
                    AcademicLevelOffering::updateWhere(array('training_unit_id' => $id_replace), "training_unit_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}adm.academic_level_offering set training_unit_id='$id_replace' where training_unit_id='$id' ");

                }

                // adm.academic_program_offering-Training unit	training_unit_id  نوع علاقة بين كيانين ← 1
                if (!$simul) {
                    // require_once "../adm/academic_program_offering.php";
                    AcademicProgramOffering::updateWhere(array('training_unit_id' => $id_replace), "training_unit_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}adm.academic_program_offering set training_unit_id='$id_replace' where training_unit_id='$id' ");

                }



                // MFK


            }
            return true;
        }
    }

    public function applicable($field_name, $col_struct)
    {
        return $this->attributeIsApplicable($field_name);
    }

    public function attributeIsApplicable($attribute)
    {
        if($attribute=="training_unit_type_id")
        {
            $amd_options = AfwSession::config("amd_options",[]);
            return ($amd_options["tu_college"] == "one");
        }

        if($attribute=="trainingUnitCollegeList")
        {
            $amd_options = AfwSession::config("amd_options",[]);
            return ($amd_options["tu_college"] == "many");
        }
            

        return true;
    }
    /*
    public function initMyCollege($active="Y")
    {
        $tut_id = $this->getVal("training_unit_type_id");
        if($tut_id>0)
        {
            $tucObj = TrainingUnitCollege::loadByMainIndex($this->id, $tut_id, true);
            if($tucObj->is_new)
            {
                $tucObj->set("active", $active);
                $tucObj->commit();
            }
        }
        
    }*/

    public function initAllColleges($active="N")
    {
        $allColleges = TrainingUnitType::loadAllLookupObjects();
        foreach($allColleges as $oneCollege)
        {
            $tucObj = TrainingUnitCollege::loadByMainIndex($this->id,$oneCollege->id, true);
            if($tucObj->is_new)
            {
                $tucObj->set("active", $active);
                $tucObj->commit();
            }
            
        }
    }

    public function initMyCollege($active="N")
    {
        // @what to do ?
    }

    public function afterMaj($id, $fields_updated)
    {
            if(true)
            {
                $amd_options = AfwSession::config("amd_options",[]);
                if($amd_options["tu_college"] == "one")
                {
                    $this->initMyCollege();
                }
                else
                {
                    $this->initAllColleges();
                }
                

                $this->fixMyData("ar");
            }

            return true;
    }

    public function fixMyData($lang="ar")
    {
        $academicProgramOfferingList = $this->get("academicProgramOfferingList");
        foreach($academicProgramOfferingList as $academicProgramOfferingItem)
        {
            $academicProgramOfferingItem->fixMyData($lang);
        }

        return ["", "done"];
    }

    // training_unit 
    public function getScenarioItemId($currstep)
    {
        if ($currstep == 1) return 396;
        if ($currstep == 2) return 397;
        if ($currstep == 3) return 411;
        if ($currstep == 4) return 420;
        if ($currstep == 5) return 421;

        return 0;
    }

    

    


    public function updateOrgunit($lang = "ar")
    {
            $hrm_code = $this->getVal("training_unit_code");
            if(!$hrm_code) return ["please define training unit code before and if the training unit is already in HRM system use the same hrm-code to avoid create a duplicated orgunit"];

            $institutionObj = $this->het("institution_id");
            $parent_orgunit_id = 0;
            if($institutionObj) $parent_orgunit_id = $institutionObj->getVal("orgunit_id");;
            $UnitManager = self::loadUnitManager();
            $id_sh_org = 0;
            $tu_type = $this->getVal("training_unit_type_id");
            $id_sh_type = 0;
            if($UnitManager::convertTunitTypeToOrgunitType($tu_type) == "college") $id_sh_type = OrgunitType::$ORGUNIT_TYPE_COLLEGE;
            if($UnitManager::convertTunitTypeToOrgunitType($tu_type) == "institute") $id_sh_type = OrgunitType::$ORGUNIT_TYPE_INSTITUTE;
            $id_domain = Domain::$DOMAIN_ADMISSION;
            
            
            $titre_short_ar = $titre_ar = $this->getVal("training_unit_name_ar");
            $titre_short_en = $titre_en = $this->getVal("training_unit_name_en");
            $orgunitObj = Orgunit::findOrgunit($id_sh_type, $id_sh_org, $hrm_code, 
                            $titre_short_ar, $titre_ar, $titre_short_en, $titre_en, $id_domain, $hrm_crm = "crm", $create_obj_if_not_found = false);
            if(!$orgunitObj)
            {
                    $orgunitObj = Orgunit::findOrgunit($id_sh_type, $id_sh_org, $hrm_code, 
                            $titre_short_ar, $titre_ar, $titre_short_en, $titre_en, $id_domain, $hrm_crm = "hrm", $create_obj_if_not_found = true);
            }
            
            $orgunitObj->set("gender_id", $this->getVal("gender_enum"));
            $orgunitObj->set("id_sh_parent", $parent_orgunit_id);
            $orgunitObj->set("addresse", $this->getVal("adress")); 
            $city_id = $this->getVal("city_id");
            if ($city_id > 0) $city_name = $this->get("city_id")->getDisplay($lang);
            else $city_name = "";
            $orgunitObj->set("city_name", $city_name);
            $orgunitObj->set("cp", $this->getVal("postal_code"));
            $orgunitObj->set("quarter", $this->getVal("quarter"));
            $orgunitObj->commit();
            $this->set("orgunit_id", $orgunitObj->getId());
            $this->commit();

            AdmOrgunit::loadByMainIndex($orgunitObj->id, true);

            $return = $orgunitObj->is_new ? "New HRM Organization created" : "Existing HRM Organization found ";
            $return .= " with ID = ".$orgunitObj->id;

            return ["", $return];
    }

    public function shouldBeCalculatedField($attribute){
        if($attribute=="adm_orgunit_id") return true;
        return false;
     }
}
