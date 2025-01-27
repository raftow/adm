<?php
class ApplicantApiRequest extends AdmObject
{

    public static $DATABASE        = "";
    public static $MODULE            = "adm";
    public static $TABLE            = "applicant_api_request";
    public static $DB_STRUCTURE = null;
    // public static $copypast = true;

    public function __construct()
    {
        parent::__construct("applicant_api_request", "id", "adm");
        AdmApplicantApiRequestAfwStructure::initInstance($this);
    }

    public static function loadById($id)
    {
        $obj = new ApplicantApiRequest();

        if ($obj->load($id)) {
            return $obj;
        } else return null;
    }

    public static function loadByMainIndex($applicant_id, $api_endpoint_id, $create_obj_if_not_found = false)
    {
        if (!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
        if (!$api_endpoint_id) throw new AfwRuntimeException("loadByMainIndex : api_endpoint_id is mandatory field");


        $obj = new ApplicantApiRequest();
        $obj->select("applicant_id", $applicant_id);
        $obj->select("api_endpoint_id", $api_endpoint_id);

        if ($obj->load()) {
            if ($create_obj_if_not_found) $obj->activate();
            return $obj;
        } elseif ($create_obj_if_not_found) {
            $obj->set("applicant_id", $applicant_id);
            $obj->set("api_endpoint_id", $api_endpoint_id);

            $obj->insertNew();
            if (!$obj->id) return null; // means beforeInsert rejected insert operation
            $obj->is_new = true;
            return $obj;
        } else return null;
    }

    public function getDisplay($lang = 'ar')
    {
        return $this->getDefaultDisplay($lang);
    }

    public function stepsAreOrdered()
    {
        return false;
    }

    public function beforeDelete($id,$id_replace)
    {
        return true;
    }

    public function calcExpiry_date($what="value")
    {
        $aepObj = $this->het("api_endpoint_id");
        if(!$aepObj) return "0000-00-00";
        $duration_expiry = $aepObj->getVal("duration_expiry");
        if (!$duration_expiry) $duration_expiry = 15;
        return AfwDateHelper::shiftGregDate('', -$duration_expiry);
    }


    public function calcRefresh_needed($what="value", $lang = "")
    {
        list($yes,$no) = AfwLanguageHelper::translateYesNo($what, $lang);
        if($this->sureIs("need_refresh")) 
        {
            // $need_refresh = $this->getVal("need_refresh");
            // die("calcRefresh_needed => need_refresh=$need_refresh => $yes");
            return $yes;
        }
        $expiry_date = $this->calcExpiry_date();
        $run_date = $this->getVal("run_date");
        // if($run_date<$expiry_date) 
        // die("calcRefresh_needed => ($run_date<$expiry_date) => $yes : $no");
        return ($run_date<$expiry_date) ? $yes : $no;  // run date is too much old
    }

    public function shouldBeCalculatedField($attribute){
        if($attribute=="expiry_date") return true;
        if($attribute=="refresh_needed") return true;
        return false;
    }

    public function switcherConfig($col, $auser = null)
    {
        $switcher_authorized = false;
        $switcher_title = "";
        $switcher_text = "";

        if ($col == "need_refresh") {
            $switcher_authorized = true;
        }

        if ($col == $this->fld_ACTIVE()) {
            $switcher_authorized = true;
        }

        return [$switcher_authorized, $switcher_title, $switcher_text];
    }
}
