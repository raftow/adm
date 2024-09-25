<?php
/*
rafik 16/9/2024

CREATE TABLE IF NOT EXISTS c0adm.`aparameter_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `created_at`   datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `validated_by` int(11) DEFAULT NULL,
  `validated_at` datetime DEFAULT NULL,
  `active` char(1) NOT NULL,
  `draft` char(1) NOT NULL default 'Y',
  `version` int(4) DEFAULT NULL,
  `update_groups_mfk` varchar(255) DEFAULT NULL,
  `delete_groups_mfk` varchar(255) DEFAULT NULL,
  `display_groups_mfk` varchar(255) DEFAULT NULL,
  `sci_id` int(11) DEFAULT NULL,
  
    
   aparameter_id int(11) DEFAULT NULL , 
   application_model_id int(11) DEFAULT NULL , 
   application_plan_id int(11) DEFAULT NULL , 
   training_unit_id int(11) DEFAULT NULL , 
   department_id int(11) DEFAULT NULL , 
   application_model_branch_id int(11) DEFAULT NULL , 
   value varchar(255)  DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;

create unique index uk_aparameter_value on c0adm.aparameter_value(aparameter_id,application_model_id,application_plan_id,training_unit_id,department_id,application_model_branch_id);


*/

// rafik 18/9/2024
// ALTER TABLE `aparameter_value` CHANGE `application_model_id` `application_model_id` INT(11) NOT NULL DEFAULT 0;
// ALTER TABLE `aparameter_value` CHANGE `application_plan_id` `application_plan_id` INT(11) NOT NULL DEFAULT 0;
// ALTER TABLE `aparameter_value` CHANGE `training_unit_id` `training_unit_id` INT(11) NOT NULL DEFAULT 0;
// ALTER TABLE `aparameter_value` CHANGE `department_id` `department_id` INT(11) NOT NULL DEFAULT 0;
// ALTER TABLE `aparameter_value` CHANGE application_model_branch_id application_model_branch_id INT(11) NOT NULL DEFAULT 0;

// update `aparameter_value` set `application_model_id` = 0 where `application_model_id` is null;
// update `aparameter_value` set `application_plan_id` = 0 where `application_plan_id` is null;
// update `aparameter_value` set `training_unit_id` = 0 where `training_unit_id` is null;
// update `aparameter_value` set `department_id` = 0 where `department_id` is null;
// update `aparameter_value` set `application_model_branch_id` = 0 where `application_model_branch_id` is null;

class AparameterValue extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "aparameter_value";
        public static $DB_STRUCTURE = null;

        public function __construct()
        {
                parent::__construct("aparameter_value", "id", "adm");
                AdmAparameterValueAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new AparameterValue();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public static function loadByMainIndex($aparameter_id, $application_model_id=0, 
                         $application_plan_id=0, $training_unit_id=0, 
                         $department_id=0, $application_model_branch_id=0, $create_obj_if_not_found = false)
        {
                $obj = new AparameterValue();
                $obj->select("aparameter_id", $aparameter_id);
                $obj->select("application_model_id", $application_model_id);
                $obj->select("application_plan_id", $application_plan_id);
                $obj->select("training_unit_id", $training_unit_id);
                $obj->select("department_id", $department_id);
                $obj->select("application_model_branch_id", $application_model_branch_id);

                if ($obj->load()) {
                        if ($create_obj_if_not_found) $obj->activate();
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        $obj->set("aparameter_id", $aparameter_id);
                        $obj->set("application_model_id", $application_model_id);
                        $obj->set("application_plan_id", $application_plan_id);
                        $obj->set("training_unit_id", $training_unit_id);
                        $obj->set("department_id", $department_id);
                        $obj->set("application_model_branch_id", $application_model_branch_id);

                        $obj->insertNew();
                        if (!$obj->id) return null; // means beforeInsert rejected insert operation
                        $obj->is_new = true;
                        return $obj;
                } else return null;
        }

        public function getDisplay($lang = 'ar')
        {

                $application_model_id = $this->getVal("application_model_id");
                $application_plan_id  = $this->getVal("application_plan_id");
                $training_unit_id     = $this->getVal("training_unit_id");
                $department_id        = $this->getVal("department_id");
                $application_model_branch_id = $this->getVal("application_model_branch_id");

                if (!$application_model_id and !$application_plan_id and !$training_unit_id and !$department_id and !$application_model_branch_id) {
                        return $this->tr("no customization", $lang);
                }


                return $this->getDefaultDisplay($lang, "-");
        }



        public static function list_of_aparam_use_scope_id()
        {
                global $lang;
                return self::aparam_use_scope()[$lang];
        }

        public static function aparam_use_scope()
        {
                $arr_list_of_aparam_use_scope = array();


                $arr_list_of_aparam_use_scope["en"][1] = "Admission condition";
                $arr_list_of_aparam_use_scope["ar"][1] = "شرط قبول";

                $arr_list_of_aparam_use_scope["en"][2] = "Selective condition";
                $arr_list_of_aparam_use_scope["ar"][2] = "شرط تصنيف";

                $arr_list_of_aparam_use_scope["en"][3] = "Ratios Category";
                $arr_list_of_aparam_use_scope["ar"][3] = "نسب التصنيف";

                $arr_list_of_aparam_use_scope["en"][4] = "Fixed value";
                $arr_list_of_aparam_use_scope["ar"][4] = "قيمة ثابتة";

                $arr_list_of_aparam_use_scope["en"][99] = "Other use";
                $arr_list_of_aparam_use_scope["ar"][99] = "استعمال آخر";

                $arr_list_of_aparam_use_scope["en"][5] = "Plan param";
                $arr_list_of_aparam_use_scope["ar"][5] = "إعدادات حملات القبول";




                return $arr_list_of_aparam_use_scope;
        }

        public function attributeIsApplicable($attribute)
        {
                /*
                        for($d=1;$d<=3;$d++)
                        {
                                if($attribute == "seats_capacity_$d")
                                {
                                        return $this->findInMfk("training_period_menum",$d, $mfk_empty_so_found=false);
                                }
                        }*/

                if ($attribute == "answer_table_id") {
                        $af_type_id = $this->getVal("afield_type_id");
                        return (($af_type_id == 5) or ($af_type_id == 6));
                }

                if ($attribute == "measurement_unit_en") {
                        $af_type_id = $this->getVal("afield_type_id");
                        return self::afield_type()["numeric"][$af_type_id];
                }

                if ($attribute == "measurement_unit_ar") {
                        $af_type_id = $this->getVal("afield_type_id");
                        return (self::afield_type()["numeric"][$af_type_id] or ($af_type_id == 12) or ($af_type_id == 15));
                }




                return true;
        }

        public function getAttributeLabel($attribute, $lang = 'ar', $short = false)
        {
                $af_type_id = $this->getVal("afield_type_id");

                if (($attribute == "measurement_unit_ar") and (($af_type_id == 12) or ($af_type_id == 15))) {
                        return AfwLanguageHelper::getAttributeTranslation($this, "short enum list name", $lang, $short);
                }
                // die("calling getAttributeLabel($attribute, $lang, short=$short)");
                return AfwLanguageHelper::getAttributeTranslation($this, $attribute, $lang, $short);
        }

        public function dynamic($field_name, $col_struct)
        {
                $return = null;
                $aparamObj = $this->het("aparameter_id");
                if ($aparamObj) {
                        $af_type_id = $aparamObj->getVal("afield_type_id");
                        // if($field_name=="value" and ($col_struct=="TYPE") ) die("dynamic log : af_type_id=$af_type_id aparamObj=".var_export($aparamObj,true));
                }

                if (!$af_type_id) $af_type_id = 10;

                $col_struct = strtoupper($col_struct);

                if ($col_struct == "TYPE") {
                        $return = AfwUmsPagHelper::afieldTypeToAfwType($af_type_id);
                        // die("I am here dynamic(field_name=$field_name, col_struct=$col_struct) => return = $return = AfwUmsPagHelper::afieldTypeToAfwType(af_type_id=$af_type_id)");
                        return $return;
                }

                if ($col_struct == "ANSMODULE") {
                        if (($af_type_id == 5) or ($af_type_id == 6)) {
                                $ansTabId = $aparamObj->getVal("answer_table_id");
                                $ansTabModule = self::answer_table_module($ansTabId);

                                return $ansTabModule;
                        }
                }

                if ($col_struct == "ANSWER") {
                        if (($af_type_id == 5) or ($af_type_id == 6)) {
                                $ansTabId = $aparamObj->getVal("answer_table_id");
                                $ansTabCode = self::answer_table_code($ansTabId);
                                /*
                                $ansTabModule = self::answer_table_module($ansTabId)  ; 
                                $ansMod = Module::loadByMainIndex($ansTabModule);
                                if(!$ansMod) return "no-module-[$ansTabModule]-for-ansTabId-[$ansTabId]";
                                $ansModId = $ansMod->id;

                                
                                if(!$ansTab) return "no-ansTabId-[$ansTabId]";*/
                                return $ansTabCode;
                        }

                        if (($af_type_id == 12) or ($af_type_id == 15)) {
                                return "FUNCTION";
                        }
                }

                if ($col_struct == 'FUNCTION_COL_NAME') {
                        if (($af_type_id == 12) or ($af_type_id == 15)) {
                                $field_name_for_function = $aparamObj->getVal("measurement_unit_ar");
                                if ($field_name_for_function) return $field_name_for_function;
                                else return $field_name;
                        }
                }

                //die("I am here dynamic(field_name=$field_name, col_struct=$col_struct) => return = $return");

                return $return;
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


                                // FK not part of me - replaceable 



                                // MFK

                        } else {
                                // FK on me 


                                // MFK


                        }
                        return true;
                }
        }

        // aparameter_value 
        public function getScenarioItemId($currstep)
        {
                if ($currstep == 1) return 474;
                if ($currstep == 2) return 475;

                return 0;
        }

        public function cloneInParameter($newParamId, $erase_existing=true)
        {
                $application_model_id = $this->getVal('application_model_id');
                $application_plan_id = $this->getVal('application_plan_id');
                $training_unit_id = $this->getVal('training_unit_id');
                $department_id = $this->getVal('department_id');
                $application_model_branch_id = $this->getVal('application_model_branch_id');

                $pvObj = AparameterValue::loadByMainIndex($newParamId,$application_model_id, 
                                                $application_plan_id, $training_unit_id, 
                                                $department_id, $application_model_branch_id, $create_obj_if_not_found =true);

                if($erase_existing or $pvObj->is_new)
                {
                        $pvObj->set("value", $this->getVal('value'));  
                        $pvObj->commit();
                }
        }

}
