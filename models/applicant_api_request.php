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
}
