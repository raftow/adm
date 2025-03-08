<?php


$file_dir_name = dirname(__FILE__);

// require_once("$file_dir_name/../afw/afw.php");

class ApplicantFile extends AFWObject
{

    public static $MY_ATABLE_ID = 13947;

    public static $DATABASE        = "pmu_adm";
    public static $MODULE                = "adm";
    public static $TABLE            = "applicant_file";

    public static $DB_STRUCTURE = null;

    public function __construct()
    {
        parent::__construct("applicant_file", "id", "adm");
        AdmApplicantFileAfwStructure::initInstance($this);
    }

    public static function loadById($id)
    {
        $obj = new ApplicantFile();
        $obj->select_visibilite_horizontale();
        if ($obj->load($id)) {
            return $obj;
        } else return null;
    }

    public static function loadByMainIndex($applicant_id, $workflow_file_id, $idn, $create_obj_if_not_found = false)
    {
        $obj = new ApplicantFile();
        $obj->select("applicant_id", $applicant_id);
        $obj->select("workflow_file_id", $workflow_file_id);
        if ($obj->load()) {
            if ($create_obj_if_not_found and $idn) 
            {
                $obj->set("idn", $idn);
                $obj->activate();
            }
            return $obj;
        } elseif ($create_obj_if_not_found and $idn) {
            $obj->set("applicant_id", $applicant_id);
            $obj->set("workflow_file_id", $workflow_file_id);
            $obj->set("idn", $idn);

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

    protected function getPublicMethods()
    {

        $pbms = array();

        $color = "green";
        $title_ar = "xxxxxxxxxxxxxxxxxxxx";
        $methodName = "mmmmmmmmmmmmmmmmmmmmmmm";
        //$pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("xxyy"));



        return $pbms;
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
        $server_db_prefix = AfwSession::config("db_prefix", "pmu_");

        if (!$id) {
            $id = $this->getId();
            $simul = true;
        } else {
            $simul = false;
        }

        if ($id) {

            // as the workflow file is used only by me (OneToOneU) delete it
            $wfObj = $this->het("workflow_file_id");
            if($wfObj and ($wfObj->id>0))
            {
                $wfObj->delete();
            }

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

    public function shouldBeCalculatedField($attribute)
    {
        if ($attribute == "download_light") return true;
        if ($attribute == "afile_ext") return true;
        return false;
    }


    public function afterMaj($id, $fields_updated)
    {
        if ($fields_updated["doc_type_id"]) {
            $wfObj = $this->het("workflow_file_id");
            $wfObj->set("doc_type_id", $this->v("doc_type_id"));
            $wfObj->commit();
        }
    }
}



// errors 
