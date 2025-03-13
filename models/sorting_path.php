<?php


$file_dir_name = dirname(__FILE__);

// require_once("$file_dir_name/../afw/afw.php");

class SortingPath extends AFWObject
{

    public static $MY_ATABLE_ID = 13947;

    public static $DATABASE        = "uoh_adm";
    public static $MODULE                = "adm";
    public static $TABLE            = "sorting_path";

    public static $DB_STRUCTURE = null;

    public function __construct()
    {
        parent::__construct("sorting_path", "id", "adm");
        AdmSortingPathAfwStructure::initInstance($this);
    }

    public static function loadById($id)
    {
        $obj = new SortingPath();
        $obj->select_visibilite_horizontale();
        if ($obj->load($id)) {
            return $obj;
        } else return null;
    }

    public static function loadByMainIndex($application_model_id, $sorting_path_code,
                    $name_ar="", $desc_ar="", $name_en="", $desc_en="", $capacity_pct=0,
                    $create_obj_if_not_found=false)
    {
       if(!$application_model_id) throw new AfwRuntimeException("loadByMainIndex : application_model_id is mandatory field");
       if(!$sorting_path_code) throw new AfwRuntimeException("loadByMainIndex : sorting_path_code is mandatory field");

       $obj = new SortingPath();
       $obj->select("application_model_id",$application_model_id);
       $obj->select("sorting_path_code",$sorting_path_code);

       if($obj->load())
       {
            if($create_obj_if_not_found)
            {
                if($name_ar) $obj->set("name_ar", $name_ar);
                if($desc_ar) $obj->set("desc_ar", $desc_ar);
                if($name_en) $obj->set("name_en", $name_en);
                if($desc_en) $obj->set("desc_en", $desc_en);
                if($capacity_pct) $obj->set("capacity_pct", $capacity_pct);
                $obj->activate();
            } 
            return $obj;
       }
       elseif($create_obj_if_not_found)
       {
            if(!$name_ar) throw new AfwRuntimeException("loadByMainIndex to create new record : name_ar is mandatory field");
            if(!$name_en) throw new AfwRuntimeException("loadByMainIndex to create new record : name_en is mandatory field");
            $obj->set("application_model_id",$application_model_id);
            $obj->set("sorting_path_code",$sorting_path_code);
            $obj->set("name_ar", $name_ar);
            $obj->set("desc_ar", $desc_ar);
            $obj->set("name_en", $name_en);
            $obj->set("desc_en", $desc_en);
            $obj->set("capacity_pct", $capacity_pct);
            $obj->insertNew();
            if(!$obj->id) return null; // means beforeInsert rejected insert operation
            $obj->is_new = true;
            return $obj;
       }
       else return null;
       
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
        $server_db_prefix = AfwSession::config("db_prefix", "uoh_");

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



// errors 
