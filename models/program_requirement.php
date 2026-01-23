<?php

$file_dir_name = dirname(__FILE__);

// require_once("$file_dir_name/../afw/afw.php");

class ProgramRequirement extends AdmObject
{
    public static $MY_ATABLE_ID = 14032;

    public static $DATABASE = 'nauss_adm';

    public static $MODULE = 'adm';

    public static $TABLE = 'program_requirement';

    public static $DB_STRUCTURE = null;

    public function __construct()
    {
        parent::__construct('program_requirement', 'id', 'adm');
        AdmProgramRequirementAfwStructure::initInstance($this);
    }

    public static function loadById($id)
    {
        $obj = new ProgramRequirement();
        $obj->select_visibilite_horizontale();
        if ($obj->load($id)) {
            return $obj;
        } else
            return null;
    }

    public static function loadByMainIndex($academic_program_id, $application_category_enum, $application_class_enum, $create_obj_if_not_found = false)
    {
        $obj = new ProgramRequirement();
        $obj->select("academic_program_id", $academic_program_id);
        $obj->select("application_category_enum", $application_category_enum);
        $obj->select("application_class_enum", $application_class_enum);

        if ($obj->load()) {
            if ($create_obj_if_not_found) $obj->activate();
            return $obj;
        } elseif ($create_obj_if_not_found) {
            $obj->set("academic_program_id", $academic_program_id);
            $obj->set("application_category_enum", $application_category_enum);
            $obj->set("application_class_enum", $application_class_enum);

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

    public function getDisplay($lang = 'ar') {}

    /*
     * public function list_of_application_category_enum() {
     *          $list_of_items = array();
     *          $list_of_items[1] = "FUNCTION";  //     code : ... not defined ...
     *         return  $list_of_items;
     *      }
     */
    /*
     * public function list_of_application_class_enum() {
     *        $list_of_items = array();
     *        $list_of_items[1] = "";  //     code : ... not defined ...
     *       return  $list_of_items;
     *    }
     */

    protected function getOtherLinksArray($mode, $genereLog = false, $step = 'all')
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

    protected function getPublicMethods()
    {
        $pbms = array();

        $color = 'green';
        $title_ar = 'xxxxxxxxxxxxxxxxxxxx';
        $methodName = 'mmmmmmmmmmmmmmmmmmmmmmm';
        // $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("xxyy"));

        return $pbms;
    }

    public function fld_CREATION_USER_ID()
    {
        return 'created_by';
    }

    public function fld_CREATION_DATE()
    {
        return 'created_at';
    }

    public function fld_UPDATE_USER_ID()
    {
        return 'updated_by';
    }

    public function fld_UPDATE_DATE()
    {
        return 'updated_at';
    }

    public function fld_VALIDATION_USER_ID()
    {
        return 'validated_by';
    }

    public function fld_VALIDATION_DATE()
    {
        return 'validated_at';
    }

    public function fld_VERSION()
    {
        return 'version';
    }

    public function fld_ACTIVE()
    {
        return 'active';
    }

    public function beforeMaj($id, $fields_updated)
    {
        return true;
    }

    public function beforeDelete($id, $id_replace)
    {
        $server_db_prefix = AfwSession::config('db_prefix', 'nauss_');

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


    public static function requirementFoundIn($application_requirement_id, $academic_program_id, $workflow_category_enum, $application_class_enum)
    {
        $objPR = null;
        if (!$objPR) {
            $objPR = self::loadByMainIndex($academic_program_id, $workflow_category_enum, $application_class_enum);
        }
        if (!$objPR) {
            $objPR = self::loadByMainIndex($academic_program_id, 0, $application_class_enum);
        }
        if (!$objPR) {
            $objPR = self::loadByMainIndex($academic_program_id, $workflow_category_enum, 0);
        }
        if (!$objPR) {
            $objPR = self::loadByMainIndex($academic_program_id, 0, 0);
        }

        if (!$objPR) {
            $objPR = self::loadByMainIndex(0, $workflow_category_enum, $application_class_enum);
        }
        if (!$objPR) {
            $objPR = self::loadByMainIndex(0, 0, $application_class_enum);
        }
        if (!$objPR) {
            $objPR = self::loadByMainIndex(0, $workflow_category_enum, 0);
        }

        if (!$objPR) {
            $objPR = self::loadByMainIndex(0, 0, 0);
        }


        if (!$objPR) return false;
        return $objPR->findInMfk("application_requirement_mfk", $application_requirement_id);
    }
}

// errors
