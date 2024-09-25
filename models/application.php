<?php
/*
         medali 19/9/2024
         CREATE TABLE IF NOT EXISTS c0adm.`application` (
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
  
    
   applicant_id int(11) NOT NULL , 
   application_plan_id int(11) NOT NULL , 
   application_model_id int(11) NOT NULL , 
   step_num smallint DEFAULT NULL , 
   application_step_id int(11) DEFAULT NULL , 
   application_status_enum smallint NOT NULL , 
   applicant_qualification_id int(11) DEFAULT NULL , 
   qualification_id int(11) DEFAULT NULL , 
   major_category_id int(11) DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;

ALTER TABLE c0adm.application CHANGE `applicant_id` `applicant_id` BIGINT(20) NOT NULL;
alter table c0adm.application add   attribute_1 smallint DEFAULT NULL  after major_category_id;
alter table c0adm.application add   attribute_2 smallint DEFAULT NULL  after attribute_1;


         */
class Application extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "application";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("application", "id", "adm");
                AdmApplicationAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new Application();

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

        public static function getApplicationAdditionalFieldParams($field_name)
        {
                global $application_additional_fields;
                if (!$application_additional_fields) {
                        $main_company = AfwSession::config("main_company", "all");
                        $file_dir_name = dirname(__FILE__);
                        require_once($file_dir_name . "/../../external/application_additional_fields-$main_company.php");
                }

                $return = $application_additional_fields[$field_name];

                //if(!$return) die("no params for getAdditionalFieldParams($field_name) look additional_fields[$field_name] in additional_fields=".var_export($additional_fields,true));

                return $return;
        }

        public function additional($field_name, $col_struct)
        {
                $params = self::getApplicationAdditionalFieldParams($field_name);

                $col_struct = strtolower($col_struct);
                if ($col_struct == "mandatory") return (!$params["optional"]);
                if ($col_struct == "required") return (!$params["optional"]);

                if ($col_struct == "css") {
                        if (!$params["css"]) $params["css"] = 'width_pct_50';
                }


                if ($col_struct == "step") {
                        $step =  $params["step"] + 3;
                        //if($col_struct=="step" and $field_name=="attribute_1") throw new AfwRuntimeException("step additional for $field_name =".$step);
                        return $step;
                }

                $return = $params[$col_struct];
                if ($col_struct == "css") {
                        // if($field_name=="attribute_18") throw new AfwRuntimeException("css additional for $field_name params=".var_export($params,true)." return=".$return);
                }


                if($col_struct=="type" and $return != "INT") throw new AfwRuntimeException("debugg additional field $field_name col_struct=$col_struct return = $return params=".var_export($params,true));

                //if(!$return) die("no param for additional($field_name, $col_struct) params=".var_export($params,true));

                return $return;
        }

        public function getFormuleResult($attribute, $what = "value")
        {
                if(AfwStringHelper::stringStartsWith($attribute,"attribute_"))
                {
                        $params = self::getApplicationAdditionalFieldParams($attribute); 
                        $formulaMethod = $params["formula"];
                        if(!class_exists('ApplicationFormulaManager'))
                        {
                                $main_company = AfwSession::config("main_company", "all");
                                $file_dir_name = dirname(__FILE__);
                                require_once($file_dir_name . "/../../external/application_additional_fields-$main_company.php");  
                        }
                        if($formulaMethod)
                        {
                                return ApplicationFormulaManager::$formulaMethod($this);
                        }
                }
                return AfwFormulaHelper::calculateFormulaResult($this,$attribute, $what);
        }

        protected function paggableAttribute($attribute)
        {
                if (AfwStringHelper::stringStartsWith($attribute, "attribute_")) {
                $params = self::getApplicationAdditionalFieldParams($attribute);
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
                $params = self::getApplicationAdditionalFieldParams($attribute);
                if ($params) {
                        $return = $params["title_$lang"];
                        if ($return) return $return;
                }
                }
                // die("calling getAttributeLabel($attribute, $lang, short=$short)");
                return AfwLanguageHelper::getAttributeTranslation($this, $attribute, $lang, $short);
        }
}
