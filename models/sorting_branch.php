<?php


$file_dir_name = dirname(__FILE__);

// require_once("$file_dir_name/../afw/afw.php");

class SortingBranch extends AFWObject
{

    public static $MY_ATABLE_ID = 13947;

    public static $DATABASE        = "uoh_adm";
    public static $MODULE                = "adm";
    public static $TABLE            = "sorting_branch";

    public static $DB_STRUCTURE = null;

    public function __construct()
    {
        parent::__construct("sorting_branch", "id", "adm");
        AdmSortingBranchAfwStructure::initInstance($this);
    }

    public static function loadById($id)
    {
        $obj = new SortingBranch();
        $obj->select_visibilite_horizontale();
        if ($obj->load($id)) {
            return $obj;
        } else return null;
    }

    public static function loadByMainIndex($application_plan_branch_id, $sorting_branch_code,
                    $name_ar="", $desc_ar="", $name_en="", $desc_en="", $capacity=0,
                    $create_obj_if_not_found=false)
    {
       if(!$application_plan_branch_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_branch_id is mandatory field");
       if(!$sorting_branch_code) throw new AfwRuntimeException("loadByMainIndex : sorting_branch_code is mandatory field");

       $obj = new SortingBranch();
       $obj->select("application_plan_branch_id",$application_plan_branch_id);
       $obj->select("sorting_branch_code",$sorting_branch_code);

       if($obj->load())
       {
            if($create_obj_if_not_found)
            {
                if($name_ar) $obj->set("name_ar", $name_ar);
                if($desc_ar) $obj->set("desc_ar", $desc_ar);
                if($name_en) $obj->set("name_en", $name_en);
                if($desc_en) $obj->set("desc_en", $desc_en);
                if($capacity) $obj->set("capacity", $capacity);
                $obj->activate();
            } 
            return $obj;
       }
       elseif($create_obj_if_not_found)
       {
            if(!$name_ar) throw new AfwRuntimeException("loadByMainIndex to create new record : name_ar is mandatory field");
            if(!$name_en) throw new AfwRuntimeException("loadByMainIndex to create new record : name_en is mandatory field");
            $obj->set("application_plan_branch_id",$application_plan_branch_id);
            $obj->set("sorting_branch_code",$sorting_branch_code);
            $obj->set("name_ar", $name_ar);
            $obj->set("desc_ar", $desc_ar);
            $obj->set("name_en", $name_en);
            $obj->set("desc_en", $desc_en);
            $obj->set("capacity", $capacity);
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
