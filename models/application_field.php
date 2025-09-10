<?php

global $enum_tables, $lookup_tables, $count_here;

class ApplicationField extends AdmObject
{

     public function __construct()
     {
          parent::__construct("application_field", "id", "adm");
          AdmApplicationFieldAfwStructure::initInstance($this);
     }

     public function af_manager($field_name, $col_struct)
     {
          $application_table_id = $this->getVal("application_table_id");
          if ($application_table_id == 1) {
               $classField = "Applicant";
          } elseif ($application_table_id == 3) {
               $classField = "Application";
          } elseif ($application_table_id == 2) {
               $classField = "ApplicationDesire";
          }
          $attribute = $this->getVal("field_name");
          $attribute_prop = strtoupper($field_name);
          $id = $this->id;
          // if(!$classField) throw new AfwRuntimeException("$attribute application field (id=$id) has stange table-id = ($application_table_id)");
          // ex $field_name=qsearch , $col_struct = READONLY => $attribute_prop = QSEARCH
          if($col_struct == "READONLY")
          {
               
               if(($attribute=="country_id") and ($field_name=="qsearch"))
               {
                    if(!$classField) throw new AfwRuntimeException("$attribute application field (for object=".var_export($this, true).") <br> has strange table-id = ($application_table_id)");
               }
               if(!$classField) return false;
               $structField = $classField::getDbStructure($return_type = 'structure',
                         $attribute,'all',null, null, $repare=false);
               if(($attribute=="country_id") and ($field_name=="qsearch"))
               {
                    throw new AfwRuntimeException("$attribute application field has not repared struct as following : ".var_export($structField, true));
               }
               return ($structField[$attribute_prop] !== "::fields_manager");
          }
          
          return null;
     }



     public static $enum_tables;

     public static $lookup_tables;

     public static $DATABASE          = "";
     public static $MODULE              = "adm";
     public static $TABLE               = "";
     public static $DB_STRUCTURE = null;

     public static $arr_switchable_cols = [
          "qsearch" => [true, "", ""],
          "retrieve" => [true, "", ""],
          "edit" => [true, "", ""],
          "qedit" => [true, "", ""],
          "readonly" => [true, "", ""],
          "mandatory" => [true, "", ""],
          "usable_in_conditions" => [true, "", "", "no-reverse"],

     ];
     public static $appFieldByIndex = [];


     public static function loadById($id)
     {
          $obj = new ApplicationField();
          $obj->select_visibilite_horizontale();
          if ($obj->load($id)) {
               return $obj;
          } else return null;
     }

     public static function fieldNameToCode($field_name, $application_table_id)
     {
          $params = [];
          if ($application_table_id == 1) $params = Applicant::getAdditionalFieldParams($field_name);
          if ($application_table_id == 3) $params = Application::getApplicationAdditionalFieldParams($field_name);
          //if($application_table_id==2) $params = ApplicationDesire::getApplicationDesireAdditionalFieldParams($field_name);

          $field_code = $params["field_code"];
          if (!$field_code) $field_code = $field_name;

          return $field_code;
     }

     public static function genereClientFieldsManager($lang = "ar", $onlyIfNotDone = false, $throwError = false)
     {
          try {
               $main_company = AfwSession::currentCompany();
               $parent_project_path = AfwSession::config("parent_project_path", "");
               if (!$parent_project_path) return ["please define parent_project_path system config parameter", ""];

               $file_path = $parent_project_path . "/cache";
               $fileName = $main_company . "_fields_manager.php";
               $fileFullName = $file_path . "/" . $fileName;
               if ($onlyIfNotDone and file_exists($fileFullName)) {
                    return ["", "already generated file $fileFullName"];
               }

               $php = self::calcPhp(false);
               AfwFileSystem::write($fileFullName, $php, 'erase', true);
               return array("", "$fileFullName created successfully");
          } catch (Exception $e) {
               if ($throwError) throw $e;
               return array($e->getMessage(), '');
          }
     }

     public static function getApplicantOriginalFieldsMatrix()
     {
          return self::getFieldsMatrix("applicant", $additional=false, $original=true);
     }

     public static function getApplicationOriginalFieldsMatrix()
     {
          return self::getFieldsMatrix("application", $additional=false, $original=true);
     }

     public static function getApplicationDesireOriginalFieldsMatrix()
     {
          return self::getFieldsMatrix("adesire", $additional=false, $original=true);
     }

     public static function getFieldsMatrix($tableId, $additional, $original)
     {
          $matrix = [];
          $apf = new ApplicationField();
          if((!is_numeric($tableId)) and is_string($tableId))
          {
               $application_table = $tableId;
               $tableId = self::application_table_id($application_table);
          }

          $apf->select("application_table_id", $tableId);
          $apf->select("active", "Y");
          if($additional and !$original)
          {
               $apf->select("additional", "Y");
          }
          elseif(!$additional and $original)
          {
               $apf->select("additional", "N");
          }
          elseif(!$additional and !$original)
          {
               $apf->select("additional", "W");
          }

          $apfList = $apf->loadMany();

          foreach($apfList as $apfItem)
          {
               $matrix[$apfItem->getVal("field_name")] = $apfItem->getMyMatrix();     
          }

          return $matrix;
     }

     public function getMyMatrix()
     {
          $matrix_item = [];
          foreach (self::$arr_switchable_cols as $switchable_col => $switchable_col_settings) {
               if ($switchable_col_settings[3] != "no-reverse") {
                    $matrix_item[$switchable_col] = $this->sureIs($switchable_col);
               }
          }
          
          $matrix_item["step"] = intval($this->getVal("step"));
          if(!$matrix_item["step"]) $matrix_item["step"] = 1;
          $matrix_item["css"] = "width_pct_".$this->getVal("width_pct");
          
          return $matrix_item;
     }

     public static function calcPhp($text_area = true)
     {
          $source_php = "";
          if ($text_area) $source_php .= "<textarea cols='120' rows='30' style='width:100% !important;direction:ltr;text-align:left'>";
          $source_php .= "<?php\n"; // ";
          $applicant_fields = self::getApplicantOriginalFieldsMatrix();
          $application_fields = self::getApplicationOriginalFieldsMatrix();
          $application_desire_fields = self::getApplicationDesireOriginalFieldsMatrix();
          

          $source_php .= "\n\t\$applicant = " . var_export($applicant_fields, true) . ";";

          $source_php .= "\n\t\$application = " . var_export($application_fields, true) . ";";

          $source_php .= "\n\t\$application_desire = " . var_export($application_desire_fields, true) . ";";

          $source_php .= "\n ?>";

          if ($text_area) $source_php .= "</textarea>"; // 

          return $source_php;
     }

     public static function loadByMainIndex($field_name, $application_table_id, $create_obj_if_not_found = false)
     {

          if (self::$appFieldByIndex["at$application_table_id.$field_name"]) {
               if (self::$appFieldByIndex["at$application_table_id.$field_name"] == "NOT-FOUND") {
                    return null;
               }
               return self::$appFieldByIndex["at$application_table_id.$field_name"];
          }
          $obj = new ApplicationField();
          $obj->select("field_name", $field_name);
          $obj->select("application_table_id", $application_table_id);

          if ($obj->load()) {
               if ($create_obj_if_not_found) $obj->activate();
          } elseif ($create_obj_if_not_found) {
               $obj->set("field_name", $field_name);
               $obj->set("application_table_id", $application_table_id);

               $obj->insertNew();
               if (!$obj->id) return null; // means beforeInsert rejected insert operation
               $obj->is_new = true;
          } else $obj = null;
          if ($obj) {
               self::$appFieldByIndex["at$application_table_id.$field_name"] = $obj;
               self::$appFieldByIndex["at$application_table_id.$field_name"]->is_new = null;
          } else {
               self::$appFieldByIndex["at$application_table_id.$field_name"] = "NOT-FOUND";
          }


          return $obj;
     }


     public function getDisplay($lang = "ar")
     {
          if ($this->getVal("field_title_$lang")) return $this->getVal("field_title_$lang");
          if ($lang != "ar") throw new AfwRuntimeException("getDisplay failed for lang= $lang : this=" . var_export($this, true));
          return $this->getVal("field_name") . " [" . $this->id . " / " . $this->getVal("application_table_id") . "]";
     }

     public function getDropDownDisplay($lang = "ar")
     {
          return $this->getVal("shortname") . "-" . $this->getVal("field_name") . "-" . $this->getVal("field_title_$lang");
     }

     /*
        public function dynamicHelpCondition($attribute)
        {
             if($attribute=="titre_short") return ($this->getVal("titre_short") != $this->getVal("titre"));
             
             return true; 
        }*/

     public function select_visibilite_horizontale($dropdown = false)
     {
          $server_db_prefix = AfwSession::currentDBPrefix();
          $objme = AfwSession::getUserConnected();
          $me = ($objme) ? $objme->id : 0;
          $this->select_visibilite_horizontale_default();
          if (!$objme->isSuperAdmin()) {
               $this->select("active", 'Y');
          }
     }




     public function needAnswerTable()
     {
          if (in_array($this->getVal("application_field_type_id"), array(12, 15))) {
               return (!$this->lookupListWithoutLookupTable());
          }

          return (in_array($this->getVal("application_field_type_id"), array(5, 6, 17)));
     }





     public function getNextFieldOrder()
     {

          $this->select("application_table_id", $this->getVal("application_table_id"));
          $this->select("reel", 'Y');
          $this->select("avail", 'Y');
          return $this->func("IF(ISNULL(max(field_order)), 0, max(field_order))+10");
     }

     public function isFK()
     {
          return ($this->getVal("application_field_type_id") == 5);
     }

     public function isMFK()
     {
          return ($this->getVal("application_field_type_id") == 6);
     }

     public function getScenarioItemId($currstep)
     {
          if ($currstep == 1) return 463;
          if ($currstep == 2) return 464;
          if ($currstep == 3) return 465;
          return 0;
     }

     public function beforeDelete($id, $id_replace)
     {
          $server_db_prefix = AfwSession::config("db_prefix", "default_db_");

          if (!$id) {
               $id = $this->getId();
               $simul = true;
          } else {
               $simul = false;
          }

          if ($id) {
               if ($id_replace == 0) {
                    // FK part of me - not deletable 
                    // adm.acondition-الحقل	afield_id  حقل يفلتر به (required field)
                    // require_once "../adm/acondition.php";
                    $obj = new Acondition();
                    $obj->where("afield_id = '$id' and active='Y' ");
                    $nbRecords = $obj->count();
                    // check if there's no record that block the delete operation
                    if ($nbRecords > 0) {
                         $this->deleteNotAllowedReason = "Used in some application condition(s) as the condition field";
                         return false;
                    }
                    // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                    if (!$simul) $obj->deleteWhere("afield_id = '$id' and active='N'");

                    // adm.application_model_field-الحقل	application_field_id  أنا تفاصيل لها (required field)
                    // require_once "../adm/application_model_field.php";
                    $obj = new ApplicationModelField();
                    $obj->where("application_field_id = '$id' and active='Y' ");
                    $nbRecords = $obj->count();
                    // check if there's no record that block the delete operation
                    if ($nbRecords > 0) {
                         $this->deleteNotAllowedReason = "Used in some application model field(s) as The field";
                         return false;
                    }
                    // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                    if (!$simul) $obj->deleteWhere("application_field_id = '$id' and active='N'");



                    // FK part of me - deletable 


                    // FK not part of me - replaceable 



                    // MFK
                    // adm.api_endpoint-الحقول المتوفرة	application_field_mfk  حقل يفلتر به
                    if (!$simul) {
                         // require_once "../adm/api_endpoint.php";
                         ApiEndpoint::updateWhere(array('application_field_mfk' => "REPLACE(application_field_mfk, ',$id,', ',')"), "application_field_mfk like '%,$id,%'");
                         // $this->execQuery("update ${server_db_prefix}adm.api_endpoint set application_field_mfk=REPLACE(application_field_mfk, ',$id,', ',') where application_field_mfk like '%,$id,%' ");
                    }

                    // adm.app_model_api-الحقول المستعملة	application_field_mfk  حقل يفلتر به
                    if (!$simul) {
                         // require_once "../adm/app_model_api.php";
                         AppModelApi::updateWhere(array('application_field_mfk' => "REPLACE(application_field_mfk, ',$id,', ',')"), "application_field_mfk like '%,$id,%'");
                         // $this->execQuery("update ${server_db_prefix}adm.app_model_api set application_field_mfk=REPLACE(application_field_mfk, ',$id,', ',') where application_field_mfk like '%,$id,%' ");
                    }

                    // adm.application_step-إظهار الحقول التالية	show_field_mfk  حقل يفلتر به
                    if (!$simul) {
                         // require_once "../adm/application_step.php";
                         ApplicationStep::updateWhere(array('show_field_mfk' => "REPLACE(show_field_mfk, ',$id,', ',')"), "show_field_mfk like '%,$id,%'");
                         // $this->execQuery("update ${server_db_prefix}adm.application_step set show_field_mfk=REPLACE(show_field_mfk, ',$id,', ',') where show_field_mfk like '%,$id,%' ");
                    }

                    // adm.screen_model-الحقول المتوفرة في الشاشة	application_field_mfk  حقل يفلتر به
                    if (!$simul) {
                         // require_once "../adm/screen_model.php";
                         ScreenModel::updateWhere(array('application_field_mfk' => "REPLACE(application_field_mfk, ',$id,', ',')"), "application_field_mfk like '%,$id,%'");
                         // $this->execQuery("update ${server_db_prefix}adm.screen_model set application_field_mfk=REPLACE(application_field_mfk, ',$id,', ',') where application_field_mfk like '%,$id,%' ");
                    }
               } else {
                    // FK on me 


                    // adm.acondition-الحقل	afield_id  حقل يفلتر به (required field)
                    if (!$simul) {
                         // require_once "../adm/acondition.php";
                         Acondition::updateWhere(array('afield_id' => $id_replace), "afield_id='$id'");
                         // $this->execQuery("update ${server_db_prefix}adm.acondition set afield_id='$id_replace' where afield_id='$id' ");

                    }




                    // adm.application_model_field-الحقل	application_field_id  أنا تفاصيل لها (required field)
                    if (!$simul) {
                         // require_once "../adm/application_model_field.php";
                         ApplicationModelField::updateWhere(array('application_field_id' => $id_replace), "application_field_id='$id'");
                         // $this->execQuery("update ${server_db_prefix}adm.application_model_field set application_field_id='$id_replace' where application_field_id='$id' ");

                    }




                    // MFK
                    // adm.api_endpoint-الحقول المتوفرة	application_field_mfk  حقل يفلتر به
                    if (!$simul) {
                         // require_once "../adm/api_endpoint.php";
                         ApiEndpoint::updateWhere(array('application_field_mfk' => "REPLACE(application_field_mfk, ',$id,', ',$id_replace,')"), "application_field_mfk like '%,$id,%'");
                         // $this->execQuery("update ${server_db_prefix}adm.api_endpoint set application_field_mfk=REPLACE(application_field_mfk, ',$id,', ',$id_replace,') where application_field_mfk like '%,$id,%' ");
                    }
                    // adm.app_model_api-الحقول المستعملة	application_field_mfk  حقل يفلتر به
                    if (!$simul) {
                         // require_once "../adm/app_model_api.php";
                         AppModelApi::updateWhere(array('application_field_mfk' => "REPLACE(application_field_mfk, ',$id,', ',$id_replace,')"), "application_field_mfk like '%,$id,%'");
                         // $this->execQuery("update ${server_db_prefix}adm.app_model_api set application_field_mfk=REPLACE(application_field_mfk, ',$id,', ',$id_replace,') where application_field_mfk like '%,$id,%' ");
                    }
                    // adm.application_step-إظهار الحقول التالية	show_field_mfk  حقل يفلتر به
                    if (!$simul) {
                         // require_once "../adm/application_step.php";
                         ApplicationStep::updateWhere(array('show_field_mfk' => "REPLACE(show_field_mfk, ',$id,', ',$id_replace,')"), "show_field_mfk like '%,$id,%'");
                         // $this->execQuery("update ${server_db_prefix}adm.application_step set show_field_mfk=REPLACE(show_field_mfk, ',$id,', ',$id_replace,') where show_field_mfk like '%,$id,%' ");
                    }
                    // adm.screen_model-الحقول المتوفرة في الشاشة	application_field_mfk  حقل يفلتر به
                    if (!$simul) {
                         // require_once "../adm/screen_model.php";
                         ScreenModel::updateWhere(array('application_field_mfk' => "REPLACE(application_field_mfk, ',$id,', ',$id_replace,')"), "application_field_mfk like '%,$id,%'");
                         // $this->execQuery("update ${server_db_prefix}adm.screen_model set application_field_mfk=REPLACE(application_field_mfk, ',$id,', ',$id_replace,') where application_field_mfk like '%,$id,%' ");
                    }
               }
               return true;
          }
     }

     public function calcHtml_description($what = "value")
     {
          $lang = AfwLanguageHelper::getGlobalLanguage();
          $isAdditional = $this->sureIs("additional");

          $titleAdditional = $this->getAttributeLabel("additional");
          $titleOriginal = $this->getAttributeLabel("original");
          $field_name = $this->getVal("field_name");
          $field_type = $this->showAttribute("application_field_type_id", null, true, $lang);
          $field_title = $this->getVal("field_title_$lang");
          $isReel = $this->sureIs("reel");
          $titleReel = $this->getAttributeLabel("reel");

          $titleR = $isReel ? $titleReel : "";
          $titleA = $isAdditional ? $titleAdditional : $titleOriginal;

          $cssRA = $isReel ? "reel" : "virtual";
          $cssRA .= $isAdditional ? " additional" : " original";


          $html = "<div class='field-desc'>";
          $html .= "<h1 class='field-desc'>$field_title</h1>";
          $html .= "<h2 class='field-desc'>$field_name</h2>";
          $html .= "<h3 class='field-desc'>$field_type</h3>";
          $html .= "<p class='field-desc $cssRA'>$titleR | $titleA</p>";
          $html .= "</div>";


          return $html;
     }

     public function calcUsagePanel($what = "value")
     {
          $afield_id = $this->id;
          $lang = AfwLanguageHelper::getGlobalLanguage();
          $html = "";

          // conditions
          $obj = new Acondition();
          $obj->select("afield_id", $afield_id);
          $obj->select("active", "Y");
          $objList = $obj->loadMany();
          if (count($objList) > 0) {
               $title = $obj->transClassPlural($lang) . " - " . $obj->translate("afield_id", $lang);
               $html .= "<h1>* $title</h1>";
               $html .= "<ul>";
               foreach ($objList as $objItem) {
                    $item_title = $objItem->getDisplay($lang);
                    $html .= "<p><li>$item_title</li></p>";
               }
               $html .= "</ul>";
          }
          // Api Endpoints
          $obj = new ApiEndpoint();
          $obj->where("application_field_mfk like '%,$afield_id,%'");
          $obj->select("active", "Y");
          $objList = $obj->loadMany();
          if (count($objList) > 0) {
               $title = $obj->transClassPlural($lang) . " - " . $obj->translate("application_field_mfk", $lang);
               $html .= "<h1>** $title</h1>";
               $html .= "<ul>";
               foreach ($objList as $objItem) {
                    $item_title = $objItem->getDisplay($lang);
                    $html .= "<p><li>$item_title</li></p>";
               }
               $html .= "</ul>";
          }
          // Application Model Apis
          $obj = new AppModelApi();
          $obj->where("application_field_mfk like '%,$afield_id,%'");
          $obj->select("active", "Y");
          $objList = $obj->loadMany();
          if (count($objList) > 0) {
               $title = $obj->transClassPlural($lang) . " - " . $obj->translate("application_field_mfk", $lang);
               $html .= "<h1>*** $title</h1>";
               $html .= "<ul>";
               foreach ($objList as $objItem) {
                    $item_title = $objItem->getDisplay($lang);
                    $html .= "<p><li>$item_title</li></p>";
               }
               $html .= "</ul>";
          }

          // Application Models
          $obj = new ApplicationModel();
          $obj->where("application_field_mfk like '%,$afield_id,%'");
          $obj->select("active", "Y");
          $objList = $obj->loadMany();
          if (count($objList) > 0) {
               $title = $obj->transClassPlural($lang) . " - " . $obj->translate("application_field_mfk", $lang);
               $html .= "<h1>**** $title</h1>";
               $html .= "<ul>";
               foreach ($objList as $objItem) {
                    $item_title = $objItem->getDisplay($lang);
                    $html .= "<p><li>$item_title</li></p>";
               }
               $html .= "</ul>";
          }

          // Application Model Fields
          $obj = new ApplicationModelField();
          $obj->select("application_field_id", $afield_id);
          $obj->select("active", "Y");
          $objList = $obj->loadMany();
          if (count($objList) > 0) {
               $title = $obj->transClassPlural($lang) . " - " . $obj->translate("application_field_id", $lang);
               $html .= "<h1>***** $title</h1>";
               $html .= "<ul>";
               foreach ($objList as $objItem) {
                    $item_title = $objItem->getDisplay($lang);
                    $html .= "<p><li>$item_title</li></p>";
               }
               $html .= "</ul>";
          }

          // Screen Models
          $obj = new ScreenModel();
          $obj->where("application_field_mfk like '%,$afield_id,%'");
          $obj->select("active", "Y");
          $objList = $obj->loadMany();
          if (count($objList) > 0) {
               $title = $obj->transClassPlural($lang) . " - " . $obj->translate("application_field_mfk", $lang);
               $html .= "<h1>****** $title</h1>";
               $html .= "<ul>";
               foreach ($objList as $objItem) {
                    $item_title = $objItem->getDisplay($lang);
                    $html .= "<p><li>$item_title</li></p>";
               }
               $html .= "</ul>";
          }
          // Sorting Groups
          $obj = new SortingGroup();
          $obj->where("sorting_field_1_id = '$afield_id' or sorting_field_2_id = '$afield_id' or sorting_field_3_id = '$afield_id'");
          $obj->select("active", "Y");
          $objList = $obj->loadMany();
          if (count($objList) > 0) {
               $title = $obj->transClassPlural($lang) . " - " . $obj->translate("sorting_fields", $lang);
               $html .= "<h1>******* $title</h1>";
               $html .= "<ul>";
               foreach ($objList as $objItem) {
                    $item_title = $objItem->getDisplay($lang);
                    $html .= "<p><li>$item_title</li></p>";
               }
               $html .= "</ul>";
          }

          if (!$html) $html = $this->tm("Not used", $lang);

          $html = "<div class='usage-panel' id='usage-panel'> $html </div> <!- usage-panel ->";

          return $html;
     }


     public function attributeIsApplicable($attribute)
     {
          if (($attribute == "formula_field_1_id") or ($attribute == "formula_field_2_id") or ($attribute == "formula_field_3_id")) {
               return (!$this->sureIs("reel"));
          }

          return true;
     }



     public static function code_of_width_pct($lkp_id = null)
     {
          $lang = AfwLanguageHelper::getGlobalLanguage();
          if ($lkp_id) return self::width_pct()['code'][$lkp_id];
          else return self::width_pct()['code'];
     }

     public static function name_of_width_pct($width_pct, $lang = "ar")
     {
          return self::width_pct()[$lang][$width_pct];
     }

     public static function list_of_width_pct($lang = null)
     {
          if (!$lang) $lang = AfwLanguageHelper::getGlobalLanguage();
          return self::width_pct()[$lang];
     }

     public static function width_pct()
     {
          $arr_list_of_width_pct = array();


          $arr_list_of_width_pct["code"][25] = "25";
          $arr_list_of_width_pct["ar"][25] = "25%";
          $arr_list_of_width_pct["en"][25] = "25%";

          $arr_list_of_width_pct["code"][50] = "50";
          $arr_list_of_width_pct["ar"][50] = "50%";
          $arr_list_of_width_pct["en"][50] = "50%";

          $arr_list_of_width_pct["code"][75] = "75";
          $arr_list_of_width_pct["en"][75] = "75%";
          $arr_list_of_width_pct["ar"][75] = "75%";

          $arr_list_of_width_pct["code"][100] = "100";
          $arr_list_of_width_pct["en"][100] = "100%";
          $arr_list_of_width_pct["ar"][100] = "100%";

          $arr_list_of_width_pct["code"][33] = "33";
          $arr_list_of_width_pct["ar"][33] = "33%";
          $arr_list_of_width_pct["en"][33] = "33%";

          $arr_list_of_width_pct["code"][66] = "66";
          $arr_list_of_width_pct["ar"][66] = "66%";
          $arr_list_of_width_pct["en"][66] = "66%";



          return $arr_list_of_width_pct;
     }

     public function switcherConfig($col, $auser = null)
     {
          $lang = AfwLanguageHelper::getGlobalLanguage();

          list($switcher_authorized, $switcher_title, $switcher_text) = self::$arr_switchable_cols[$col];

          $switcher_title = $this->tm($switcher_title, $lang);
          $switcher_text = $this->tm($switcher_text, $lang);

          return [$switcher_authorized, $switcher_title, $switcher_text];
     }

     protected function getPublicMethods()
     {
          $pbms = array();

          $color = "red";
          $title_ar = "الهندسة المعاكسة";
          $methodName = "reverseEngineering";
          $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN-ONLY" => true, "BF-ID" => "", 'STEP' => 3);

          return $pbms;
     }

     public static function reverseEngineeringAll($lang = "ar")
     {
          $err_arr = [];
          $inf_arr = [];
          $war_arr = [];

          $fld = new ApplicationField();
          $fld->select_visibilite_horizontale();
          $fldList = $fld->loadMany();
          foreach ($fldList as $fldItem) {
               list($err, $inf, $war) = $fldItem->reverseEngineering($lang);
               if ($err) $err_arr[] = $err;
               if ($inf) $inf_arr[] = $inf;
               if ($war) $war_arr[] = $war;
          }

          return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr);
     }

     public function reverseEngineering($lang = "ar")
     {
          $application_table_id = $this->getVal("application_table_id");
          if ($application_table_id == 1) {
               $classField = "Applicant";
          } elseif ($application_table_id == 3) {
               $classField = "Application";
          } elseif ($application_table_id == 2) {
               $classField = "ApplicationDesire";
          }
          $attribute = $this->getVal("field_name");

          // $classFieldObject = new Applicant(); 
          $classFieldObject = new $classField();
          $struct = AfwStructureHelper::getStructureOf($classFieldObject, $attribute);

          $reversed = "";

          foreach (self::$arr_switchable_cols as $switchable_col => $switchable_col_settings) {
               $struct_prop = strtoupper($switchable_col);
               if ($switchable_col_settings[3] != "no-reverse") {
                    $switchable_col_value = $struct[$struct_prop] ? "Y" : "N";
                    $this->set($switchable_col, $switchable_col_value);
                    $reversed .= "," . $switchable_col;
               }
          }
          $step_value = $struct["STEP"];
          if (!$step_value) $step_value = 1;
          $this->set("step", $step_value);
          $reversed .= ",step";

          $width_pct_value = intval(substr($struct["CSS"], 10));
          if (!self::name_of_width_pct($width_pct_value, "ar")) $width_pct_value = "";
          if (!$width_pct_value) $width_pct_value = 50;
          $this->set("width_pct", $width_pct_value);
          $reversed .= ",width_pct";
          $this->commit();

          $reversed = trim($reversed, ",");

          return ["", "$attribute : $reversed", ""];
     }


     public function repeatRetrieveHeader()
     {
          return 5;
     }


     /**
      * To do Static public method That execute
      * update pmu_adm.application_field af set af.active = (select f.avail from pmu_pag.afield f where f.id = af.id);

      */
}
