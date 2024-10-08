<?php
class ApplicationModelCondition extends AdmObject
{

    public static $DATABASE        = "";
    public static $MODULE            = "adm";
    public static $TABLE            = "application_model_condition";
    public static $DB_STRUCTURE = null;
    // public static $copypast = true;

    public function __construct()
    {
        parent::__construct("application_model_condition", "id", "adm");
        AdmApplicationModelConditionAfwStructure::initInstance($this);
    }

    public static function loadById($id)
    {
        $obj = new ApplicationModelCondition();

        if ($obj->load($id)) {
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

    public static function loadByMainIndex($application_model_id, $acondition_id, $acondition_origin_id=0, $general="W", $create_obj_if_not_found = false)
    {
        if (!$application_model_id) throw new AfwRuntimeException("loadByMainIndex : application_model_id is mandatory field");
        if (!$acondition_id) throw new AfwRuntimeException("loadByMainIndex : acondition_id is mandatory field");


        $obj = new ApplicationModelCondition();
        $obj->select("application_model_id", $application_model_id);
        $obj->select("acondition_id", $acondition_id);

        if ($obj->load()) 
        {            
            if ($create_obj_if_not_found) 
            {
                $obj->set("acondition_origin_id", $acondition_origin_id);
                $obj->set("general", $general);
                $obj->activate();
            }
            return $obj;
        } 
        elseif ($create_obj_if_not_found) 
        {
            $obj->set("application_model_id", $application_model_id);
            $obj->set("acondition_id", $acondition_id);

            $obj->set("acondition_origin_id", $acondition_origin_id);
            $obj->set("general", $general);

            $obj->insertNew();
            if (!$obj->id) return null; // means beforeInsert rejected insert operation
            $obj->is_new = true;
            return $obj;
        } else return null;
    }
}
