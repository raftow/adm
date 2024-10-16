<?php
// rafik 18/9/2024 : ALTER TABLE `applicant` CHANGE `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT;
/*
$main_company = AfwSession::config("main_company", "all");
$file_dir_name = dirname(__FILE__);
require_once($file_dir_name . "/../extra/applicant_additional_fields-$main_company.php");*/

class Applicant extends AdmObject
{

    public static $DATABASE        = "";
    public static $MODULE            = "adm";
    public static $TABLE            = "applicant";
    public static $DB_STRUCTURE = null;
    // public static $copypast = true;

    public function __construct()
    {
        parent::__construct("applicant", "id", "adm");
        AdmApplicantAfwStructure::initInstance($this);
    }

    public function afterSelect($attribute, $value)
    {
        // As we have a partion by ID and ID = IDN,
        // when we select IDN we select ID also to use the partionning concept
        if($attribute=="idn")
        {
            $this->select("id", $value);
        }
    }

    public static function loadById($id)
    {
        $obj = new Applicant();

        if ($obj->load($id)) {
            return $obj;
        } else return null;
    }

    public static function loadByMainIndex($idn, $create_obj_if_not_found = false)
    {
        if (!$idn) throw new AfwRuntimeException("loadByMainIndex : idn is mandatory field");


        $obj = new Applicant();
        $obj->select("idn", $idn);

        if ($obj->load()) {
            if ($create_obj_if_not_found) $obj->activate();
            return $obj;
        } elseif ($create_obj_if_not_found) {
            $obj->set("idn", $idn);
            $obj->set("id", $idn);
            $obj->insertNew();
            if (!$obj->id) return null; // means beforeInsert rejected insert operation
            $obj->is_new = true;
            return $obj;
        } else return null;
    }

    public function getDisplay($lang = 'ar')
    {
        $return = trim($this->getDefaultDisplay($lang));
        if(!$return) return $this->tm("identity")." : ".$this->id;
        else return $return;
    }

    public function getWideDisplay($lang = 'ar')
    {
        $return = trim($this->getDefaultDisplay($lang));
        $return .= " ".$this->tm("identity")." : ".$this->id;
        return $return;
    }

    

    public function stepsAreOrdered()
    {
        return false;
    }

    public function beforeMaj($id, $fields_updated)
    {
        $idn = $this->getVal("idn");

        if (!$idn) // should never happen but ....                    
        {
            return false;
        }

        
        
        // throw new AfwRuntimeException("For IDN=$idn beforeMaj($id, fields_updated=".var_export($fields_updated,true).") before set id=".var_export($id,true));

        if (!$id) // the ID of an applicant is his IDN
        {
            $this->set("id", $idn);
            $id = $this->id;
            // throw new AfwRuntimeException("For IDN=$idn beforeMaj($id, fields_updated=".var_export($fields_updated,true).") after set id=".var_export($id,true));
        }
        else
        {
            if($id != $idn) throw new AfwRuntimeException("beforeMaj Contact admin please because IDN=$idn != id=$id");
        }

        return true;
    }



    public static function getAdditionalFieldParams($field_name)
    {
        global $additional_fields;
        if (!$additional_fields) {
            $main_company = AfwSession::config("main_company", "all");
            $file_dir_name = dirname(__FILE__);
            require_once($file_dir_name . "/../extra/applicant_additional_fields-$main_company.php");
        }

        $return = $additional_fields[$field_name];

        //if(!$return) die("no params for getAdditionalFieldParams($field_name) look additional_fields[$field_name] in additional_fields=".var_export($additional_fields,true));

        return $return;
    }


    public function additional($field_name, $col_struct)
    {
        $params = self::getAdditionalFieldParams($field_name);

        $col_struct = strtolower($col_struct);
        if ($col_struct == "mandatory") return (!$params["optional"]);
        if ($col_struct == "required") return (!$params["optional"]);

        if ($col_struct == "css") {
            if (!$params["css"]) $params["css"] = 'width_pct_50';
        }


        if ($col_struct == "step") {
            $step =  $params["step"] + 2;
            //if($col_struct=="step" and $field_name=="attribute_1") throw new AfwRuntimeException("step additional for $field_name =".$step);
            return $step;
        }

        $return = $params[$col_struct];
        if ($col_struct == "css") {
            // if($field_name=="attribute_18") throw new AfwRuntimeException("css additional for $field_name params=".var_export($params,true)." return=".$return);
        }


        //if($col_struct=="fgroup" and $return == "") throw new AfwRuntimeException("fgroup additional return = $return params=".var_export($params,true));

        //if(!$return) die("no param for additional($field_name, $col_struct) params=".var_export($params,true));

        return $return;
    }


    protected function paggableAttribute($attribute)
    {
        if (AfwStringHelper::stringStartsWith($attribute, "attribute_")) {
            $params = self::getAdditionalFieldParams($attribute);
            if (!$params) {
                return [false, "no params defined for this additional attribute"];
            }
        }
        // can be overridden in subclasses
        return [true, ""];
    }


    public function getAttributeLabel($attribute, $lang = 'ar', $short = false)
    {
        if (AfwStringHelper::stringStartsWith($attribute, "attribute_")) {
            $params = self::getAdditionalFieldParams($attribute);
            if ($params) {
                $return = $params["title_$lang"];
                if ($return) return $return;
            }
        }
        // die("calling getAttributeLabel($attribute, $lang, short=$short)");
        return AfwLanguageHelper::getAttributeTranslation($this, $attribute, $lang, $short);
    }


    public function myShortNameToAttributeName($attribute)
    {
        global $additional_fields;
        if (!$additional_fields) {
            $main_company = AfwSession::config("main_company", "all");
            $file_dir_name = dirname(__FILE__);
            require_once($file_dir_name . "/../extra/applicant_additional_fields-$main_company.php");
        }

        if ($additional_fields) {
            foreach ($additional_fields as $attribute_reel => $paramAF) {
                $field_code = strtolower($paramAF["field_code"]);
                if ($field_code == $attribute) return $attribute_reel;
            }
        }

        return $attribute;
    }

    protected function getOtherLinksArray($mode, $genereLog = false, $step = "all")
    {
        global $lang;
        // $objme = AfwSession::getUserConnected();
        // $me = ($objme) ? $objme->id : 0;

        $otherLinksArray = $this->getOtherLinksArrayStandard($mode, $genereLog, $step);
        $my_id = $this->getId();
        $displ = $this->getDisplay($lang);

        if ($mode == "mode_applicantQualificationList") {
            unset($link);
            $link = array();
            $title = "إضافة مؤهل جديد";
            // $title_detailed = $title . "لـ : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=ApplicantQualification&currmod=adm&sel_applicant_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }

        if ($mode == "mode_applicationList") {
            $aplanList = ApplicationPlan::getCurrentApplicationPlans();
            $color = 'blue';
            foreach($aplanList as $aplanItem)
            {
                $application_plan_id = $aplanItem->id;
                $application_model_id = $aplanItem->getVal("application_model_id");
                unset($link);
                $link = array();
                $title = "التقديم على ".$aplanItem->getShortDisplay($lang);
                // $title_detailed = $title . "لـ : " . $displ;
                $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=Application&currmod=adm&sel_applicant_id=$my_id&sel_application_plan_id=$application_plan_id&sel_application_model_id=$application_model_id";
                $link["TITLE"] = $title;
                $link["COLOR"] = $color;
                $link["UGROUPS"] = array();
                $otherLinksArray[] = $link;
                if($color == 'yellow') $color = 'blue';
                elseif($color == 'green') $color = 'yellow';
                elseif($color == 'blue') $color = 'green';
                
            }
            
            
        }

        if ($mode == "mode_applicantEvaluationList") {
            unset($link);
            $link = array();
            $title = "إضافة اختبار جديد";
            // $title_detailed = $title . "لـ : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=ApplicantEvaluation&currmod=adm&sel_applicant_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }
       



        // check errors on all steps (by default no for optimization)
        // rafik don't know why this : \//  = false;

        return $otherLinksArray;
    }


    public function attributeIsApplicable($attribute)
    {
        /* 
        if(($attribute == "mother_birth_date") or ($attribute == "mother_idn"))
        {
            return ($this->getVal("idn_type_id")==3);
        }*/


        return true;
    }

    public function disableOrReadonlyForInput ($field_name, $col_struct)
    {
        if(($field_name == "mother_birth_date") or ($field_name == "mother_idn"))
        {
            return ($this->getVal("idn_type_id")==3) ? '' : 'disabled';
        }
        return '';
    }

    protected function getSpecificDataErrors(
        $lang = 'ar',
        $show_val = true,
        $step = 'all', 
        $erroned_attribute = null,
        $stop_on_first_error = false, $start_step=null, $end_step=null
    ) {
        global $objme;
        $sp_errors = [];

        $birth_gdate = $this->getVal('birth_gdate');
        $birth_date = $this->getVal('birth_date');

        if (!$birth_gdate and !$birth_date) {
            $sp_errors['birth_gdate'] = $this->translateMessage('birth date gregorian or hijri should be defined');
        }

        return $sp_errors;
    }


    public function beforeDelete($id, $id_replace)
    {
        $server_db_prefix = AfwSession::config("db_prefix", "c0");

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
                // adm.applicant_qualification-Applicant	applicant_id  OneToMany
                if (!$simul) {
                    // require_once "../adm/applicant_qualification.php";
                    ApplicantQualification::removeWhere("applicant_id='$id'");
                    // $this->execQuery("delete from ${server_db_prefix}adm.applicant_qualification where applicant_id = '$id' ");

                }




                // FK not part of me - replaceable 



                // MFK

            } else {
                // FK on me 
                // adm.applicant_qualification-Applicant	applicant_id  OneToMany
                if (!$simul) {
                    // require_once "../adm/applicant_qualification.php";
                    ApplicantQualification::updateWhere(array('applicant_id' => $id_replace), "applicant_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}adm.applicant_qualification set applicant_id='$id_replace' where applicant_id='$id' ");

                }



                // MFK


            }
            return true;
        }
    }

    // applicant 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 436;
      if ($currstep == 2) return 437;
      if ($currstep == 3) return 438;
      if ($currstep == 4) return 439;
      if ($currstep == 5) return 440;
      if ($currstep == 6) return 441;
      if ($currstep == 7) return 442;
      if ($currstep == 8) return 443;
      if ($currstep == 9) return 444;
      if ($currstep == 10) return 471;

      return 0;
   }

   public function updateCalculatedFields()
   {
        $this->updateQualificationLevelFields();
   }

   public function updateQualificationLevelFields()
   {
        $main_company = AfwSession::config("main_company", "all");
        $file_dir_name = dirname(__FILE__);
        require_once($file_dir_name . "/../extra/qualification_level-$main_company.php");   
        // $lookup
        foreach($lookup as $lookup_level => $lookupItem)
        {
            foreach($lookupItem["attributes"] as $attributeConfig)
            {
                $this->set($attributeConfig["attribute"], "N");
            }
        }

        $applicantQualificationList = $this->get("applicantQualificationList");
        foreach($applicantQualificationList as $applicantQualificationItem)
        {
            $qualif_level_enum = $applicantQualificationItem->calc("level_enum");
            foreach($lookup as $lookup_level => $lookupItem)
            {
                foreach($lookupItem["attributes"] as $attributeConfig)
                {
                    if(($attributeConfig["operator"] == "=") and ($qualif_level_enum == $lookup_level))
                    {
                        $this->set($attributeConfig["attribute"], "Y");
                    }
    
                    if(($attributeConfig["operator"] == ">=") and ($qualif_level_enum >= $lookup_level))
                    {
                        $this->set($attributeConfig["attribute"], "Y");
                    }
                }
                
            }
        }

        $this->commit();
    }
    

    public function getLastQualification()
    {
        $obj = new ApplicantQualification();
        $obj->select("applicant_id", $this->id);
        $obj->select("active", "Y");
                        
        if($obj->load())
        {
                return $obj;
        }
        else return null;
    }

    public function qsearchByTextEnabled()
    {
        return false;
    }

    
}

