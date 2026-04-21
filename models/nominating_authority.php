<?php


$file_dir_name = dirname(__FILE__);

// require_once("$file_dir_name/../afw/afw.php");

class NominatingAuthority extends AdmObject
{

    public static $MY_ATABLE_ID = 13994;

    public static $DATABASE        = "nauss_adm";
    public static $MODULE                = "adm";
    public static $TABLE            = "nominating_authority";

    public static $DB_STRUCTURE = null;

    public function __construct()
    {
        parent::__construct("nominating_authority", "id", "adm");
        AdmNominatingAuthorityAfwStructure::initInstance($this);
    }

    public static function loadById($id)
    {
        $obj = new NominatingAuthority();
        $obj->select_visibilite_horizontale();
        if ($obj->load($id)) {
            return $obj;
        } else return null;
    }

    public function synchronizeWithWorkflow()
    {
        $module_id = 1;
        $wsObj = WorkflowSource::loadByMainIndex($module_id, "NA-" . $this->id, true);
        $wsObj->set('source_name_ar', $this->getVal('nominating_authority_name_ar'));
        $wsObj->set('source_name_en', $this->getVal('nominating_authority_name_en'));
        $wsObj->set('source_description_ar', $this->getVal('nominating_authority_name_ar'));
        $wsObj->set('source_description_en', $this->getVal('nominating_authority_name_en'));
        $wsObj->commit();

        return $wsObj;
    }



    public function getScenarioItemId($currstep)
    {

        return 0;
    }






    /*        public function list_of_nominating_authority_source_enum() { 
            $list_of_items = array(); 
            $list_of_items[1] = "";  //     code : ... not defined ... 
           return  $list_of_items;
        } 


*/



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
        $title_ar = "تحديث قائمة جهات الترشيح من نظام SIS"; 
        $title_en = "Update Nominating Authorities list from SIS"; 
        $methodName = "syncFromSIS";
        $pbms[AfwStringHelper::hzmEncode($methodName)] = 
                array("METHOD"=>$methodName,
                        "COLOR"=>$color, 
                        "LABEL_AR"=>$title_ar, 
                        "LABEL_EN"=>$title_en,
                        "ADMIN-ONLY"=>true, 
                        "BF-ID"=>"", 
                        'STEP' =>$this->stepOfAttribute("sis_code"));

        return $pbms;
    }
    public function syncFromSIS()
    {
        $res = SisSponsorCode::syncFromSIS();
        
        return $res;
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

    /*
        public function isTechField($attribute) {
            return (($attribute=="created_by") or 
                    ($attribute=="created_at") or 
                    ($attribute=="updated_by") or 
                    ($attribute=="updated_at") or 
                    // ($attribute=="validated_by") or ($attribute=="validated_at") or 
                    ($attribute=="version"));  
        }*/


    public function beforeDelete($id, $id_replace)
    {
        $server_db_prefix = AfwSession::config("db_prefix", "nauss_");

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
