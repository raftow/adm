<?php


$file_dir_name = dirname(__FILE__);

// require_once("$file_dir_name/../afw/afw.php");

class NominationLetter extends AdmObject
{

    public static $MY_ATABLE_ID = 13997;

    public static $DATABASE        = "nauss_adm";
    public static $MODULE                = "adm";
    public static $TABLE            = "nomination_letter";

    public static $DB_STRUCTURE = null;

    public function __construct()
    {
        parent::__construct("nomination_letter", "id", "adm");
        AdmNominationLetterAfwStructure::initInstance($this);
    }

    public static function loadById($id)
    {
        $obj = new NominationLetter();
        $obj->select_visibilite_horizontale();
        if ($obj->load($id)) {
            return $obj;
        } else return null;
    }



    public function getScenarioItemId($currstep)
    {

        return 0;
    }

    public function getDisplay($lang = "ar")
    {
        $data = array();
        $link = array();

        list($data[0], $link[0]) = $this->displayAttribute("nominating_authority_id", false, $lang);
        list($data[1], $link[1]) = $this->displayAttribute("application_plan_id", false, $lang);
        list($data[2], $link[2]) = $this->displayAttribute("letter_code", false, $lang);


        return implode(" - ", $data);
    }



    /*        public function list_of_nominating_authority_source_enum() { 
            $list_of_items = array(); 
            $list_of_items[1] = "";  //     code : ... not defined ... 
           return  $list_of_items;
        } 


*/
    public function afterMaj($id, $fields_updated)
    {
        if ($fields_updated["application_plan_id"] or $fields_updated["application_simulation_id"]) {
            $nominationCandidateList = $this->het("nominationCandidateList");
            foreach ($nominationCandidateList as $nominationCandidateItem) {
                $nominationCandidateItem->set("application_plan_id", $this->getVal("application_plan_id"));
                $nominationCandidateItem->set("application_simulation_id", $this->getVal("application_simulation_id"));
                $nominationCandidateItem->commit();
            }
        }
    }


    protected function getOtherLinksArray($mode, $genereLog = false, $step = "all")
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        // $objme = AfwSession::getUserConnected();
        // $me = ($objme) ? $objme->id : 0;

        $otherLinksArray = $this->getOtherLinksArrayStandard($mode, $genereLog, $step);
        $my_id = $this->getId();
        $displ = $this->getDisplay($lang);

        if ($mode == "mode_nominationCandidateList") {
            unset($link);
            $link = array();
            $title = "إضافة مرشح";
            $title_detailed = $title . "لـ : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=NominatingCandidates&currmod=adm&sel_nomination_letter_id=$my_id";
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

    public function shouldBeCalculatedField($attribute)
    {
        if ($attribute == "pic_view") return true;
        if ($attribute == "download_light") return true;
        return false;
    }
}



// errors 
