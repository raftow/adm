<?php
// rafik 18/9/2024 : ALTER TABLE `applicant` CHANGE `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT;

class Applicant extends AdmObject
{

        public static $DATABASE        = "";
        public static $MODULE            = "adm";
        public static $TABLE            = "applicant";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;


        // big_photo - صورة تعريفية  
        public static $doc_type_big_photo = 13;

        // small_photo -   صورة صغيرة  
        public static $doc_type_small_photo = 12;

        // attachement - مرفق توضيحي
        public static $doc_type_attachement = 7;

        private $secondary_cumulative_pct = null; // do not removed it is used with $$xxx way
        private $secondary_major_path = null; // do not removed it is used with $$xxx way
        private $secondary_program_track = null; // do not removed it is used with $$xxx way
        private $aptitude_Score = null;
        private $achievement_Score = null;
        private $objSQ = null;
        private $applicantQualificationList = null;

        public $update_date = [];

        public function __construct()
        {
                parent::__construct("applicant", "id", "adm");
                AdmApplicantAfwStructure::initInstance($this);
        }


        public static function tryConvertIdnToID($value)
        {
                $idn = $value;
                list($idn_correct, $idn_type_id) = AfwFormatHelper::getIdnTypeId($idn);
                $id = null;
                if (($idn_type_id == 1) or ($idn_type_id == 2)) {
                        if (is_numeric($idn) and $idn_correct) $id = $idn;
                } 

                return $id;
        }


        public function convertIdnToID($value)
        {
                $idn = $value;
                if(!$idn) return 0;
                list($idn_correct, $idn_type_id) = AfwFormatHelper::getIdnTypeId($idn);
                if(!$idn_type_id) $idn_type_id = $this->getVal("idn_type_id");
                if(!$idn_type_id) return 0;
                
                $id = 0;
                if (($idn_type_id == 1) or ($idn_type_id == 2)) {
                        if (is_numeric($idn) and $idn_correct) $id = $idn;
                } else {
                        $country_id = $this->getSelectedValueForAttribute("country_id");
                        if(!$country_id) $country_id = $this->getVal("country_id");
                        if ($country_id) {
                                $id = IdnToId::convertToID('adm', $country_id, $idn_type_id, $idn);
                        } else {
                                // we can not optimize query and select the id while passport number entered without country specified
                                $id = 0;
                        }
                }

                return $id;
        }
        public function afterSelect($attribute, $value)
        {
                // As we have a partion by ID and ID = IDN,
                // when we select IDN we select ID also to use the partionning concept
                if ($attribute == "idn") {
                        $id = $this->convertIdnToID($value);
                        if ($id > 0) $this->select("id", $id);
                }
        }

        public function hasEvaluation()
        {
                return 'Y'; // @todo
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
                        //$obj->set("xxid", $idn);
                        $obj->insertNew();
                        if (!$obj->id) return null; // means beforeInsert rejected insert operation
                        $obj->is_new = true;
                        return $obj;
                } else return null;
        }

        public function getMissedDocument($lang)
        {
                $aqObj = ApplicantQualification::getMyQualificationNeedingFileAttachment($this->id);
                if ($aqObj) return [DocType::$DOC_TYPE_DIPLOMA, $aqObj->id, $aqObj->getDisplay($lang)];

                $aeObj = ApplicantEvaluation::getMyEvaluationNeedingFileAttachment($this->id);
                if ($aeObj) return [DocType::$DOC_TYPE_EXAM, $aeObj->id, $aeObj->getDisplay($lang)];

                return [0, 0, ''];
        }

        public function getDisplay($lang = 'ar')
        {
                $return = trim($this->getDefaultDisplay($lang));
                if (!$return) return $this->tm("identity", $lang) . " : " . $this->getVal("idn");
                else return $return;
        }

        public function getWideDisplay($lang = 'ar')
        {
                $return = trim($this->getDefaultDisplay($lang));
                $return .= " " . $this->tm("identity") . " : " . $this->getVal("idn");
                return $return;
        }



        public function stepsAreOrdered()
        {
                return false;
        }


        public function updateSortingData($lang="ar", $force=true, $echo=false, $ignorePublish = false)
        {
                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];
                $api_runner_class = self::loadApiRunner();
                if ($this->id) 
                {                        
                        $sorting_apis = $api_runner_class::sorting_apis();
                        // create register apis call requests to be done by applicant-api-request-job                        
                        foreach ($sorting_apis as $sorting_api) {
                                $aepObj = ApiEndpoint::loadByMainIndex($sorting_api);
                                if (!$aepObj) throw new AfwRuntimeException("the register API $sorting_api is not found in DB");
                                $applicantApiRequestObject = ApplicantApiRequest::loadByMainIndex($this->id, $aepObj->id, true);
                                list($err, $inf, $war, $tech) = $applicantApiRequestObject->runMe($aepObj, $this, $lang, $force, $echo, $ignorePublish);
                                if ($err) $err_arr[] = $err;
                                if ($inf) $inf_arr[] = $inf;
                                if ($war) $war_arr[] = $war;
                                if ($tech) $tech_arr[] = $tech;
                        }
                }

                return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
        }
        

        public function beforeMaj($id, $fields_updated)
        {
                //die("beforeMaj fields_updated = ".var_export($fields_updated,true)." id= $id");
                $lang = AfwLanguageHelper::getGlobalLanguage();
                $birth_gdate = $this->getVal("birth_gdate");
                $birth_date = $this->getVal("birth_date");

                if ((!$birth_gdate) and $birth_date) {
                        $birth_gdate = AfwDateHelper::hijriToGreg($birth_date);
                        $this->set("birth_gdate", $birth_gdate);
                }

                if ((!$birth_date) and $birth_gdate) {
                        $birth_date = AfwDateHelper::to_hijri($birth_gdate);
                        $this->set("birth_date", $birth_date);
                }

                $idn = $this->getVal("idn");
                $idn_type_id = $this->getVal("idn_type_id");
                if(!$idn_type_id) list($idn_correct, $idn_type_id) = AfwFormatHelper::getIdnTypeId($idn);
                if ((!$idn) or (!$idn_type_id)) // should never happen but ...
                {
                        throw new  AfwBusinessException("BAD DATA For IDN=$idn IDN-TYPE=$idn_type_id");
                }

                if (($idn_type_id == 4) and (!trim($this->getVal("passeport_num")))) {
                        $this->set("passeport_num", $idn);
                }
                $first_register = false;
                // throw new AfwRuntimeException("For IDN=$idn beforeMaj($id, fields_updated=".var_export($fields_updated,true).") before set id=".var_export($id,true));

                if (!$id) // the ID of an applicant is his IDN
                {
                        if ($idn_type_id == 3) $idn_type_id = 2;
                        if (($idn_type_id == 1) or ($idn_type_id == 2)) {
                                
                                
                                if (!is_numeric($idn)) throw new AfwBusinessException("The identity type is not correctly entered",$lang,"","","index.php","IDN $idn of TYPE $idn_type_id SHOULD BE NUMERIC", "adm"); // 
                                list($idn_correct, $type) = AfwFormatHelper::getIdnTypeId($idn);
                                if ($type != $idn_type_id) throw new AfwBusinessException("The identity type is incorrect",$lang,"","","index.php","IDN $idn is not of type $idn_type_id but of type $type", "adm"); // 
                                if (!$idn_correct) throw new AfwBusinessException("The identity number is not correctly entered",$lang,"","","index.php","IDN $idn of TYPE $idn_type_id HAVE BAD FORMAT", "adm"); //  
                                $this->set("id", $idn);
                        } else {
                                $country_id = $this->getVal("country_id");
                                if (!$country_id) throw new  AfwBusinessException("The country/nationalty is required",$lang,"","","index.php","For IDN=$idn IDN-TYPE=$idn_type_id COUNTRY IS REQUIRED", "adm");
                                $id = IdnToId::convertToID('adm', $country_id, $idn_type_id, $idn);
                                if (!$id) throw new  AfwBusinessException("Failed IDN conversion IdnToId::convertToID('adm', $country_id, $idn_type_id, $idn)");
                                $this->set("id", $id);
                        }



                        $id = $this->id;
                        $first_register = true;
                        // throw new AfwRuntimeException("For IDN=$idn beforeMaj($id, fields_updated=".var_export($fields_updated,true).") after set id=".var_export($id,true));
                } elseif (($idn_type_id == 1) or ($idn_type_id == 2) or ($idn_type_id == 3)) {
                        if ($id != $idn) throw new AfwBusinessException("beforeMaj Contact admin please because IDN=$idn != id=$id when idn_type_id == $idn_type_id");
                }

                
                // $register_apis_need_refresh = AfwSession::config("register_apis_need_refresh", false);
                $api_runner_class = self::loadApiRunner();
                if ($this->id and $first_register) {
                        
                        $register_apis = $api_runner_class::register_apis();
                        // create register apis call requests to be done by applicant-api-request-job                        
                        foreach ($register_apis as $register_api) {
                                $aepObj = ApiEndpoint::loadByMainIndex($register_api);
                                if (!$aepObj) throw new AfwRuntimeException("the register API $register_api is not found in DB");
                                ApplicantApiRequest::loadByMainIndex($this->id, $aepObj->id, true);
                        }
                }
                $file_dir_name = dirname(__FILE__);
                
                $eval_settings = require("$file_dir_name/../extra/eval_settings.php");
                // die("from $file_dir_name/../extra/eval_settings.php eval_settings=".var_export($eval_settings,true));
                foreach($eval_settings as $eval_type => $eval_setting_row)
                {
                        foreach($eval_setting_row as $categ => $eval_setting_case)
                        {
                                $eval_id = $eval_setting_case["id"];
                                $eval_attribute = "qiyas_".$eval_type."_".$categ;
                                $eval_date_attribute = $eval_attribute . "_date"; 

                                if($fields_updated[$eval_date_attribute] or $fields_updated[$eval_attribute]) 
                                {
                                        $eval_date = $this->getVal($eval_date_attribute);
                                        if(!$eval_date) $eval_date = "2025-01-01";
                                        $eval_result = $this->getVal($eval_attribute);
                                        if($eval_date and $eval_result)
                                        {
                                                $objEval = ApplicantEvaluation::loadByMainIndex($eval_id, $this->id, $eval_date, $eval_result, true, true);
                                        }
                                        
                                }
                                else
                                {
                                        // die("fields_updated = ".var_export($fields_updated,true));
                                }
                        }       
                }
                
                

                return true;
        }

        public function afterMaj($id, $fields_updated)
        {
                if((!$this->getVal("first_name_ar")) or (!$this->getVal("father_name_ar")) or (!$this->getVal("last_name_ar")))
                {
                        $this->runNeededApis();
                }
        }


        


        public static function getAdditionalFieldParams($field_name)
        {
                global $additional_fields;
                if (!$additional_fields) {
                        $main_company = AfwSession::currentCompany();
                        $file_dir_name = dirname(__FILE__);
                        require_once($file_dir_name . "/../../client-$main_company/extra/applicant_additional_fields-$main_company.php");
                }

                $return = $additional_fields[$field_name];

                //if(!$return) die("no params for getAdditionalFieldParams($field_name) look additional_fields[$field_name] in additional_fields=".var_export($additional_fields,true));

                return $return;
        }

        public function fields_manager($field_name, $col_struct)
        {
                $matrix = self::getFieldsManagerMatrix("applicant", $field_name);
                // if($field_name=="country_id") die("getFieldsManagerMatrix(applicant, $field_name) = ".var_export($matrix, true));
                $col_struct = strtolower($col_struct);
                $return = $matrix[$col_struct];
                if ($col_struct == "obsolete") $return = (!$matrix["type"]);
                if ($col_struct == "css") {
                        if (!$return) $return = 'width_pct_50';
                }
                return $return;
        }


        public function additional($field_name, $col_struct)
        {
                // if (($field_name == "dragDropDiv") and ($col_struct == "step")) return 11;
                $params = self::getAdditionalFieldParams($field_name);

                $col_struct = strtolower($col_struct);
                if ($col_struct == "obsolete") return (!$params["type"]);
                if ($col_struct == "show") return ($params["type"] != "");
                if ($col_struct == "edit") return ($params["type"] != "");
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


        protected function paggableAttribute($attribute, $structure)
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
                        $main_company = AfwSession::currentCompany();
                        $file_dir_name = dirname(__FILE__);
                        require_once($file_dir_name . "/../../client-$main_company/extra/applicant_additional_fields-$main_company.php");
                }

                if ($additional_fields) {
                        foreach ($additional_fields as $attribute_reel => $paramAF) {
                                $field_code = strtolower($paramAF["field_code"]);
                                if ($field_code == $attribute) return $attribute_reel;
                        }
                }

                return $attribute;
        }

        public function getAlreadyPlanIds($application_simulation_id, $implode=",")
        {
                $already_plan_ids_arr = [];
                $applicationList = $this->get("applicationList");
                foreach($applicationList as $applicationItem)
                {
                        if($applicationItem->getVal("application_simulation_id") == $application_simulation_id) 
                        {
                                $already_plan_ids_arr[] = $applicationItem->getVal("application_plan_id");
                        }
                        
                }

                if(!$implode) return $already_plan_ids_arr;
                else return implode($implode, $already_plan_ids_arr);

        }

        protected function getOtherLinksArray($mode, $genereLog = false, $step = "all")
        {
                $lang = AfwLanguageHelper::getGlobalLanguage();
                // $objme = AfwSession::getUserConnected();
                // $me = ($objme) ? $objme->id : 0;

                $otherLinksArray = $this->getOtherLinksArrayStandard($mode, $genereLog, $step);
                $my_id = $this->getId();
                $idn = $this->getVal("idn");
                $displ = $this->getDisplay($lang);

                if ($mode == "mode_applicantQualificationList") {
                        unset($link);
                        $link = array();
                        $title = "إضافة مؤهل جديد";
                        // $title_detailed = $title . "لـ : " . $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=ApplicantQualification&currmod=adm&sel_applicant_id=$my_id";
                        $link["TITLE"] = $title;
                        // tempo for demo @todo
                        $link["PUBLIC"] = true;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                }

                if ($mode == "mode_applicationList") {
                        $already_plan_ids = $this->getAlreadyPlanIds(2);
                        $aplanList = ApplicationPlan::getCurrentApplicationPlans($already_plan_ids);
                        $color = 'blue';
                        foreach ($aplanList as $aplanItem) {
                                $application_plan_id = $aplanItem->id;
                                $application_model_id = $aplanItem->getVal("application_model_id");
                                unset($link);
                                $link = array();
                                $title = "التقديم على " . $aplanItem->getShortDisplay($lang);
                                // $title_detailed = $title . "لـ : " . $displ;
                                $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=Application&currmod=adm&sel_applicant_id=$my_id&sel_idn=$idn&sel_application_plan_id=$application_plan_id&sel_application_simulation_id=2&sel_application_model_id=$application_model_id";
                                $link["TITLE"] = $title;
                                $link["COLOR"] = $color;
                                $link["UGROUPS"] = array();
                                $otherLinksArray[] = $link;
                                if ($color == 'yellow') $color = 'blue';
                                elseif ($color == 'green') $color = 'yellow';
                                elseif ($color == 'blue') $color = 'green';
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
                        // tempo for demo @todo
                        $link["PUBLIC"] = true;
                        $otherLinksArray[] = $link;
                }




                // check errors on all steps (by default no for optimization)
                // rafik don't know why this : \//  = false;

                return $otherLinksArray;
        }


        public function attributeIsApplicable($attribute)
        {

                if (($attribute == "mother_birth_date") or ($attribute == "mother_idn")) {
                        return ($this->getVal("idn_type_id") == 3);
                }

                if ($attribute == "applicantQualificationsNoFile") {
                        return ($this->getRelation("applicantQualificationsNoFile")->count() > 0);
                }

                if ($attribute == "applicantEvaluationsNoFile") {
                        return ($this->getRelation("applicantEvaluationsNoFile")->count() > 0);
                }

                return true;
        }


        public function idnFormat($field_name, $col_struct)
        {
                if ($field_name == "idn") {
                        return ($this->getVal("idn_type_id") <= 3) ? 'SA-IDN' : 'ALPHA-NUMERIC';
                }
                return '';
        }

        public function disableOrReadonlyForInput($field_name, $col_struct)
        {
                if (($field_name == "mother_birth_date") or ($field_name == "mother_idn")) {
                        return ($this->getVal("idn_type_id") == 3) ? '' : 'disabled';
                }
                return '';
        }

        protected function getSpecificDataErrors(
                $lang = 'ar',
                $show_val = true,
                $step = 'all',
                $erroned_attribute = null,
                $stop_on_first_error = false,
                $start_step = null,
                $end_step = null
        ) {
                global $objme;
                $sp_errors = [];
                $birth_gdate_show = $this->showOfAttribute('birth_gdate');
                $birth_gdate_step = $this->stepOfAttribute('birth_gdate');
                $birth_gdate_is_in_step = $this->stepContainAttribute($step, 'birth_gdate');
                $no_step_scope = ($birth_gdate_step and (!$start_step and !$end_step));
                $step_in_scope = ($birth_gdate_step and ($birth_gdate_step >= $start_step) and ($birth_gdate_step <= $end_step));
                $birth_gdate_is_in_steps_scope = (($no_step_scope or $birth_gdate_is_in_step) and ($no_step_scope or $step_in_scope));


                if ($birth_gdate_is_in_steps_scope) {
                        $birth_gdate = $this->getVal('birth_gdate');
                        $birth_date = $this->getVal('birth_date');

                        if (!$birth_gdate and !$birth_date) {
                                $sp_errors['birth_gdate'] = $this->translateMessage('birth date gregorian or hijri should be defined');
                                $sp_errors['birth_gdate'] .= "<pre dir='ltr'> dbg : birth_gdate_is_in_steps_scope = ((no_step_scope or birth_gdate_is_in_step) and (no_step_scope or step_in_scope)) \n<br> step=$step \n<br> 
                                                birth_gdate_step=$birth_gdate_step <br>\n
                                                step_in_scope=($birth_gdate_step and ($birth_gdate_step >= $start_step) and ($birth_gdate_step <= $end_step)) <br>\n
                                                birth_gdate_is_in_step=this->stepContainAttribute($step, 'birth_gdate')=$birth_gdate_is_in_step
                                                         $birth_gdate_is_in_steps_scope = (($no_step_scope or $birth_gdate_is_in_step) and ($no_step_scope or $step_in_scope))</pre>";
                        }
                }

                return $sp_errors;
        }


        public function beforeDelete($id,$id_replace) 
        {
            $server_db_prefix = AfwSession::config("db_prefix","tvtc_");
            
            if(!$id)
            {
                $id = $this->getId();
                $simul = true;
            }
            else
            {
                $simul = false;
            }
            
            if($id)
            {   
               if($id_replace==0)
               {
                   // FK part of me - not deletable 
                       // adm.application-المتقدم	applicant_id  أنا تفاصيل لها (required field)
                        // require_once "../adm/application.php";
                        $obj = new Application();
                        $obj->where("applicant_id = '$id' and active='Y' ");
                        $nbRecords = $obj->count();
                        // check if there's no record that block the delete operation
                        if($nbRecords>0)
                        {
                            $this->deleteNotAllowedReason = "Some related application(s) exists";
                            return false;
                        }
                        // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                        if(!$simul) $obj->deleteWhere("applicant_id = '$id' and active='N'");

                       // adm.application_desire-المتفدم	applicant_id  حقل يفلتر به (required field)
                        // require_once "../adm/application_desire.php";
                        $obj = new ApplicationDesire();
                        $obj->where("applicant_id = '$id' and active='Y' ");
                        $nbRecords = $obj->count();
                        // check if there's no record that block the delete operation
                        if($nbRecords>0)
                        {
                            $this->deleteNotAllowedReason = "Some related desire(s) exists";
                            return false;
                        }
                        // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                        if(!$simul) $obj->deleteWhere("applicant_id = '$id' and active='N'");

                       // adm.applicant_file-المتقدم	applicant_id  أنا تفاصيل لها (required field)
                        // require_once "../adm/applicant_file.php";
                        $obj = new ApplicantFile();
                        $obj->where("applicant_id = '$id' and active='Y' ");
                        $nbRecords = $obj->count();
                        // check if there's no record that block the delete operation
                        if($nbRecords>0)
                        {
                            $this->deleteNotAllowedReason = "Some related file(s) exists";
                            return false;
                        }
                        // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                        if(!$simul) $obj->deleteWhere("applicant_id = '$id' and active='N'");


                        
                   // FK part of me - deletable 
                       // adm.applicant_qualification-المتقدم	applicant_id  أنا تفاصيل لها
                        if(!$simul)
                        {
                            // require_once "../adm/applicant_qualification.php";
                            ApplicantQualification::removeWhere("applicant_id='$id'");
                            // $this->execQuery("delete from ${server_db_prefix}adm.applicant_qualification where applicant_id = '$id' ");
                            
                        } 
                        
                        
                       // adm.applicant_evaluation-المتقدم	applicant_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/applicant_evaluation.php";
                            ApplicantEvaluation::removeWhere("applicant_id='$id'");
                            // $this->execQuery("delete from ${server_db_prefix}adm.applicant_evaluation where applicant_id = '$id' ");
                            
                        } 
                        
                        
                       // adm.applicant_api_request-المتقدم	applicant_id  أنا تفاصيل لها
                        if(!$simul)
                        {
                            // require_once "../adm/applicant_api_request.php";
                            ApplicantApiRequest::removeWhere("applicant_id='$id'");
                            // $this->execQuery("delete from ${server_db_prefix}adm.applicant_api_request where applicant_id = '$id' ");
                            
                        } 
                        
                        

                   
                   // FK not part of me - replaceable 

                        
                   
                   // MFK

               }
               else
               {
                        // FK on me 
 

                        // adm.application-المتقدم	applicant_id  أنا تفاصيل لها (required field)
                        if(!$simul)
                        {
                            // require_once "../adm/application.php";
                            Application::updateWhere(array('applicant_id'=>$id_replace), "applicant_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.application set applicant_id='$id_replace' where applicant_id='$id' ");
                            
                        } 
                        

 

                        // adm.application_desire-المتفدم	applicant_id  حقل يفلتر به (required field)
                        if(!$simul)
                        {
                            // require_once "../adm/application_desire.php";
                            ApplicationDesire::updateWhere(array('applicant_id'=>$id_replace), "applicant_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.application_desire set applicant_id='$id_replace' where applicant_id='$id' ");
                            
                        } 
                        

 

                        // adm.applicant_file-المتقدم	applicant_id  أنا تفاصيل لها (required field)
                        if(!$simul)
                        {
                            // require_once "../adm/applicant_file.php";
                            ApplicantFile::updateWhere(array('applicant_id'=>$id_replace), "applicant_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.applicant_file set applicant_id='$id_replace' where applicant_id='$id' ");
                            
                        } 
                        

                       // adm.applicant_qualification-المتقدم	applicant_id  أنا تفاصيل لها
                        if(!$simul)
                        {
                            // require_once "../adm/applicant_qualification.php";
                            ApplicantQualification::updateWhere(array('applicant_id'=>$id_replace), "applicant_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.applicant_qualification set applicant_id='$id_replace' where applicant_id='$id' ");
                            
                        }
                        
                       // adm.applicant_evaluation-المتقدم	applicant_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/applicant_evaluation.php";
                            ApplicantEvaluation::updateWhere(array('applicant_id'=>$id_replace), "applicant_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.applicant_evaluation set applicant_id='$id_replace' where applicant_id='$id' ");
                            
                        }
                        
                       // adm.applicant_api_request-المتقدم	applicant_id  أنا تفاصيل لها
                        if(!$simul)
                        {
                            // require_once "../adm/applicant_api_request.php";
                            ApplicantApiRequest::updateWhere(array('applicant_id'=>$id_replace), "applicant_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.applicant_api_request set applicant_id='$id_replace' where applicant_id='$id' ");
                            
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

        public function getQualificationList()
        {
                if(!$this->applicantQualificationList) $this->applicantQualificationList = $this->get("applicantQualificationList");
        }

        public function updateQualificationLevelFields()
        {
                $main_company = AfwSession::currentCompany();
                $file_dir_name = dirname(__FILE__);
                require_once($file_dir_name . "/../../client-$main_company/extra/qualification_level-$main_company.php");
                // $lookup
                foreach ($lookup as $lookup_level => $lookupItem) {
                        foreach ($lookupItem["attributes"] as $attributeConfig) {
                                $this->set($attributeConfig["attribute"], "N");
                        }
                }

                $this->getQualificationList();

                foreach ($this->applicantQualificationList as $applicantQualificationItem) {
                        $qualif_level_enum = $applicantQualificationItem->calc("level_enum");
                        foreach ($lookup as $lookup_level => $lookupItem) {
                                foreach ($lookupItem["attributes"] as $attributeConfig) {
                                        if (($attributeConfig["operator"] == "=") and ($qualif_level_enum == $lookup_level)) {
                                                $this->set($attributeConfig["attribute"], "Y");
                                        }

                                        if (($attributeConfig["operator"] == ">=") and ($qualif_level_enum >= $lookup_level)) {
                                                $this->set($attributeConfig["attribute"], "Y");
                                        }
                                }
                        }
                }

                $this->commit();
        }

        public function getSecondaryQualification()
        {
                $obj = new ApplicantQualification();
                $obj->select("applicant_id", $this->id);
                $obj->select("qualification_id", 49);
                $obj->select("active", "Y");

                if ($obj->load()) {
                        return $obj;
                } else return null;
        }

        public function getLastQualification()
        {
                $obj = new ApplicantQualification();
                $obj->select("applicant_id", $this->id);
                $obj->select("active", "Y");

                if ($obj->load()) {
                        return $obj;
                } else return null;
        }

        public function qsearchByTextEnabled()
        {
                return false;
        }

        protected function getPublicMethods()
        {

                $pbms = array();



                $color = "orange";
                $title_en = "Verify enrollment at another university";
                $title_ar = $this->tm($title_en, 'ar');                
                $methodName = "verifyEnrollment";
                $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, 
                                        "LABEL_AR" => $title_ar, 
                                        "LABEL_EN" => $title_en, 
                                        "PUBLIC" => true, "BF-ID" => "", 'STEPS' => 'all');
                $color = "grey";
                $title_en = "Verify enrollment at UOH university";
                $title_ar = $this->tm($title_en, 'ar');                
                $methodName = "verifyEnrollmentUOH";
                $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, 
                                        "LABEL_AR" => $title_ar, 
                                        "LABEL_EN" => $title_en, 
                                        "PUBLIC" => true, "BF-ID" => "", 'STEPS' => 'all');

                //@todo
                // checkOtherUniversityAcceptance
                $color = "blue";
                $title_en = "Force updating data via electronic services";
                $title_ar = $this->tm($title_en, 'ar');                
                $methodName = "runNeededApis";
                $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, 
                                        "LABEL_AR" => $title_ar, 
                                        "LABEL_EN" => $title_en, 
                                        "PUBLIC" => true, "BF-ID" => "", 'STEPS' => 'all');

                $color = "green";
                $title_ar = $this->tm("Updating data via electronic services", 'ar');
                $title_en = $this->tm("Updating data via electronic services", 'en');
                $methodName = "runOnlyNeedUpdateApis";
                $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, 
                                        "LABEL_AR" => $title_ar, 
                                        "LABEL_EN" => $title_en, 
                                        "PUBLIC" => true, "BF-ID" => "", 'STEPS' => 'all');


                $color = "red";
                $title_en = "Reset Applicant";
                $title_ar = $this->tm($title_en, 'ar');
                
                $methodName = "resetApplicant";
                $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, 
                                        "LABEL_AR" => $title_ar, 
                                        "LABEL_EN" => $title_en, 
                                        "PUBLIC" => true, "BF-ID" => "", 'STEPS' => 'all');                                        


                return $pbms;
        }


        protected function afterSetAttribute($attribute)
        {
                if($attribute=="idn") // and (!$this->getVal("idn_type_id"))) 
                {
                        list($idn_correct, $idn_type_id) = AfwFormatHelper::getIdnTypeId($this->getVal("idn"));
                        if($idn_correct)
                        { 
                                $this->set("idn_type_id", $idn_type_id);                                
                        }  
                }

                if($attribute=="idn_type_id") // and (!$this->getVal("idn_type_id"))) 
                {
                        if($this->getVal("idn_type_id")==1)
                        { 
                                $this->set("country_id", 183);                                
                        }  
                }
        }
        

        public function resetApplicant($lang="ar")
        {
                $id = $this->id;

                $objApp = new Application();
                $objDes = new ApplicationDesire();
                $objFle = new ApplicantFile();
                
                $objDes->where("applicant_id = '$id' and active='Y' and desire_status_enum in (2,3)");
                $nbRecordsCritical = $objDes->count();

                
                if(!$nbRecordsCritical)
                {
                        $objApp->deleteWhere("applicant_id = '$id'");
                        $objDes->deleteWhere("applicant_id = '$id'");
                        $objFle->deleteWhere("applicant_id = '$id'");
                        return ["", "The applicant has been reset and can be deleted"];
                }
                else
                {
                        return ["The applicant has some accepted desires and can't be deleted", ""];
                }

                
        }

        public function runOnlyNeedUpdateApis($lang = "ar")
        {
                return $this->runNeededApis($lang, false);
        }

        public function verifyEnrollment($lang = "ar")
        {
                $idn = $this->getVal("idn");
                return self::verifyEnrollmentForIdn($idn, $lang = "ar");
        }

        public static function verifyEnrollmentForIdn($idn, $lang = "ar")
        {                
                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];  
                $result = [];  

                try {
                        // medali to implement your code of mourakaba
                        // ...
                        $token = self::getToken();        
                        $request = [
                                "idn"=>$idn,       
                        ];
                        $gsb_api_manager_enpoint = AfwSession::config("gsb_api_manager_enpoint", "http://212.138.86.196/api");
                        $ch = curl_init("$gsb_api_manager_enpoint/morakaba?idn=".$idn);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Authorization: Bearer ' . $token,
                        'Accept: application/json'
                        ]);
                
                        $dataResponse = curl_exec($ch);
                        if (curl_errno($ch)) {
                        $err_arr[] = 'Curl error: ' . curl_error($ch);
                        }
                        curl_close($ch);
                
                        // تحليل الاستجابة
                        $data = json_decode($dataResponse, true);
                        $nb_univ = 0;
                        $universities_arr = [];
                        //$inf_arr[] = $dataResponse;
                        foreach($data as $row){
                                if($row["Universities_Graduated_ind"]==true){
                                        $nb_univ++;
                                        $universities_arr["ar"][] = $row["UniversityNameAr"];
                                        $universities_arr["en"][] = $row["UniversityNameEn"];
                                        $war_arr[] = "المتقدم مقبول في جامعة ".$row["UniversityNameAr"]." (".$row["UniversityID"].")";
                                        //$this->errorResponse(null, __("messages.applicant_has_other_admission",["univ"=>$row["UniversityNameAr"],"univEn"=>$row["UniversityID"]]));
                                }
                        }

                        if($nb_univ==0){
                                $inf_arr[] = "لا توجد سجلات للمتقدم في الجامعات السعودية";
                        }

                        $result["universities"] = $nb_univ;
                        $result["universities_arr"] = $universities_arr;
                        // if you find error that happened
                        //$err_arr[] = "your error text here";
                        // if you want to show info as result
                        // if you find warning that you want to show to administrator
                        //$war_arr[] = "your warning text here";

                } catch (Exception $e) {
                        $err_arr[] = $e->getMessage();
                } catch (Error $e) {
                        $err_arr[] = $e->__toString();
                }
                return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr,$result);
        }

        
        
        public function verifyEnrollmentUOH($lang = "ar")
        {
                $idn = $this->getVal("idn");
                return self::verifyEnrollmentUOHForIdn($idn, $lang = "ar");
        }

        public static function verifyEnrollmentUOHForIdn($idn, $lang = "ar")
        {                
                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];  
                $result = [];  

                try {
                        // medali to implement your code of mourakaba
                        // ...
                        $token = self::getTokenUOH();        
                        
                        $request = [
                                "idn"=>$idn,       
                        ];
                        $ch = curl_init("https://apis.uoh.edu.sa/uoh/StuProfileADM/GetStu/".$idn);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Authorization: Bearer ' . $token,
                        'Accept: application/json'
                        ]);
                
                        $dataResponse = curl_exec($ch);
                        if (curl_errno($ch)) {
                        $err_arr[] = 'Curl error: ' . curl_error($ch);
                        }
                        curl_close($ch);
                        //$inf_arr[] = "token : ".$dataResponse;
                
                        // تحليل الاستجابة
                        $data = json_decode($dataResponse, true);
                        $nb_univ = 0;
                        $universities_arr = [];
                        if($data["AdmissionStatusAr"]!=""){
                                $war_arr[] = "المتقدم ".$data["AdmissionStatusAr"]." في جامعة حائل ";
                                //$this->errorResponse(null, __("messages.applicant_has_other_admission",["univ"=>$row["UniversityNameAr"],"univEn"=>$row["UniversityID"]]));
                        }else{
                                $inf_arr[] = "لا توجد سجلات للمتقدم في جامعة حائل";
                        }
                        

                        /*$result["universities"] = $nb_univ;
                        $result["universities_arr"] = $universities_arr;*/
                        // if you find error that happened
                        //$err_arr[] = "your error text here";
                        // if you want to show info as result
                        // if you find warning that you want to show to administrator
                        //$war_arr[] = "your warning text here";

                } catch (Exception $e) {
                        $err_arr[] = $e->getMessage();
                } catch (Error $e) {
                        $err_arr[] = $e->__toString();
                }
                return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr,$result);
        }
        public function runNeededApis($lang = "ar", $force=true, $echo=false, $stopMethod="")
        {
                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];

                // $app_name = $this->getShortDisplay($lang);


                try {
                        $applicantApiRequestList = $this->get("applicantApiRequestList");
                        /**
                         * @var ApplicantApiRequest $applicantApiRequestItem
                         */
                        foreach ($applicantApiRequestList as $applicantApiRequestItem) {

                                if($stopMethod)
                                {
                                        $war_arr[] = "Stopped by stop method = $stopMethod";
                                        if($this->$stopMethod()) break;
                                }

                                list($err, $inf, $war, $tech) = $applicantApiRequestItem->runMe(null, $this, $lang, $force, $echo);
                                if ($err) $err_arr[] = $err;
                                if ($inf) $inf_arr[] = $inf;
                                if ($war) $war_arr[] = $war;
                                if ($tech) $tech_arr[] = $tech;
                        }
                } catch (Exception $e) {
                        $err_arr[] = $e->getMessage();
                } catch (Error $e) {
                        $err_arr[] = $e->__toString();
                }
                // die("war_arr=".var_export($war_arr));
                return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
        }

        public function getFieldApiEndpoint($field_name)
        {
                $application_fieldObj = ApplicationField::loadByMainIndex($field_name, 1);
                if(!$application_fieldObj) return null;

                $arr = ApiEndpoint::findAllApiEndpointForField($application_fieldObj->id,1);
                return $arr[0];
        }

        public function getFieldUpdateDate($field_name)
        {
                $apiEndpoint = $this->getFieldApiEndpoint($field_name);
                if ($apiEndpoint) [$field_value_datetime, $api] = $this->getApiUpdateDate($apiEndpoint);
                if (!$field_value_datetime) $field_value_datetime = $this->getVal($field_name . "_update_date");
                return [$field_value_datetime, $api];
        }


        

        public function simulateApplication(&$applicationPlanObj, &$applicationSimulationObj, $offlineDesiresRow, $lang='ar', $only_reset=false)
        {
                $err_arr = [];
                $inf_arr = [];
                $war_arr = [];
                $tech_arr = [];
                /*
                if(!$applicationModelObj or !$applicationModelObj->id) throw new AfwRuntimeException("simulateApplication : No Application Model Defined for this simulation");
                else*/
                
                $reason = $this->tm("reason",$lang);

                if(!$applicationSimulationObj or !$applicationSimulationObj->id) throw new AfwRuntimeException("simulateApplication : No Application Simulation ID Defined to do this simulation");
                elseif(!$applicationPlanObj or !$applicationPlanObj->id) throw new AfwRuntimeException("simulateApplication : No Application Plan Defined for this simulation");
                $applicant_id = $this->id;
                $application_plan_id = $applicationPlanObj->id;
                $application_model_id = $applicationPlanObj->getVal("application_model_id");
                $application_simulation_id = $applicationSimulationObj->id; 
                $options = $applicationSimulationObj->getOptions();
                $skipConditionsApply = (strtolower($options["SKIP-CONDITIONS-APPLY"]) == "on");
                $reComputeSortingCriterea = (strtolower($options["RE-COMPUTE-SORTING-CRITEREA-VALUES"]) == "on");
                $idn = $this->getVal("idn");
                $bootstraps = 0;
                $desire_bootstraps = 0;
                $blocked = false;
                if($only_reset or (strtolower($options["ERASE-EXISTING-APPLICATIONS"])=="on"))
                {
                        list($result, $row_count, $affected_row_count) = Application::deleteWhere("applicant_id = $applicant_id and application_plan_id=$application_plan_id and application_simulation_id=$application_simulation_id");     
                        if($affected_row_count) $tech_arr[]  = "$affected_row_count ".$this->tm("application(s) already existing deleted", $lang)."<br>\n";
                        list($result, $row_count, $affected_row_count) = ApplicationDesire::deleteWhere("applicant_id = $applicant_id and application_plan_id=$application_plan_id and application_simulation_id=$application_simulation_id");     
                        if($affected_row_count) $tech_arr[]  = "$affected_row_count ".$this->tm("desire(s) already existing deleted", $lang)."<br>\n";
                }
                
                if(!$only_reset)
                {
                        $appObj = Application::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id, $idn, true);
                        if($appObj)
                        {
                                $appObj->setApplicantObject($this);
                                if($skipConditionsApply)
                                {
                                        list($err, $inf, $war, $tech, $result) = $appObj->forceGotoDesireStep($lang);
                                        if ($err) $err_arr[] = $err; 
                                        if ($inf) $inf_arr[] = $inf;
                                        if ($war) $war_arr[] = $war;
                                        if ($tech) $tech_arr[] = $tech;
                                        if (!$err)
                                        {
                                                $stepCode = $result["STEP_CODE"];
                                                $bootstrapAppResult = "forceGotoDesireStep";
                                                $bootstrapAppResultDetails = "no-error";
                                        }
                                        else
                                        {
                                                $stepCode = $result["STEP_CODE"];
                                                $bootstrapAppResult = "forceGotoDesireStep-failed";
                                                $bootstrapAppResultDetails = $err;
                                        }
                                        
                                }
                                else
                                {
                                        list($stepCode, $resPbm, $tentatives1, $bootstrapAppResult, $bootstrapAppResultDetails) = $appObj->bootstrapApplication($lang, true, $options);
                                        $bootstraps += $tentatives1;
                                        list($err, $inf, $war, $tech) = $resPbm;
                                }
                                
                                
                                
                                if ($err) $err_arr[] = $err; 
                                if ($inf) $inf_arr[] = $inf;
                                if ($war) $war_arr[] = $war;
                                if ($tech) $tech_arr[] = $tech;
                                $stepCodeTile = self::standard_application_step_title_by_code($stepCode);
                                if($stepCode=="DSR")
                                {
                                        
                                        $inf_arr[] = $this->tm("Application",$lang) ." ". $this->tm("reached step",$lang) . " : $stepCodeTile <!-- $stepCode -->";
                                        list($appDesireList, $log, $nb_desires_gen, $nb_desires_mfk) = $appObj->simulateDesires($applicationSimulationObj, $applicationPlanObj, $lang, $offlineDesiresRow);
                                        $tech_arr[] = $log;
                                        $appDesireListCount = count($appDesireList);
                                        
                                        $appDesireIdList = array_keys($appDesireList);
                                        /**
                                         * @var ApplicationDesire $appDesireItem
                                         */
                                        $oneDesireAtLeastIsBlocked = false;
                                        foreach($appDesireIdList as $appDesireId)
                                        {
                                                $appDesireItem =& $appDesireList[$appDesireId];
                                                $disp = $appDesireItem->getDisplay($lang);
                                                if($skipConditionsApply)
                                                {
                                                        list($err, $inf, $war, $tech) = $appDesireItem->forceGotoSortingStep($lang);
                                                        $desireStepCode = "SRT";
                                                        $bootstrapDesireResult = "no-bootstrap but forceGotoSortingStep";
                                                }
                                                else
                                                {
                                                        list($desireStepCode, $resPbm, $tentatives2, $bootstrapDesireResult) = $appDesireItem->bootstrapDesire($lang, true, $options);
                                                        $desire_bootstraps += $tentatives2;
                                                        list($err, $inf, $war, $tech) = $resPbm;
                                                }                                                
                                                if ($err) $err_arr[] = $err; 
                                                if ($inf) $inf_arr[] = $inf;
                                                if ($war) $war_arr[] = $war;
                                                if ($tech) $tech_arr[] = $tech;
                                                $desireStepTile = self::standard_application_step_title_by_code($desireStepCode);
                                                if($desireStepCode=="SRT")
                                                {
                                                        
                                                        if($reComputeSortingCriterea or $appDesireItem->sortingCritereaNeedRefresh())
                                                        {
                                                                $appDesireItem->reComputeSortingCriterea($lang);
                                                        }
                                                        
                                                        $inf_arr[] = $this->tm("Application desire",$lang) ." [$disp] ". $this->tm("reached step",$lang) . " : $desireStepTile <!-- $desireStepCode -->"; 
                                                }
                                                else
                                                {
                                                        $war_arr[] = $this->tm("Application desire",$lang) ." [$disp] ". $this->tm("faltered at step",$lang) . " : $desireStepTile <!-- $desireStepCode --> , $reason : ". $appDesireItem->statusExplanations(); 
                                                } 
                                                if($bootstrapDesireResult == "standby")
                                                {
                                                        $oneDesireAtLeastIsBlocked = $appDesireId;
                                                }
                                                        
        
                                                unset($appDesireItem);
                                                unset($appDesireList[$appDesireId]);                                                
                                        }

                                        if($appDesireListCount>0)
                                        {
                                                $appObj->set("application_status_enum", self::application_status_enum_by_code('complete'));
                                                $appObj->set("comments", $this->tm("application is complete",$lang));
                                                $appObj->commit();
                                        }
        
                                        // the minimum nb of desires authorized by application model
                                        $minDesires = Aparameter::getParameterValueForContext(15, $application_model_id, $application_plan_id, $this);
                                        if(!$minDesires) $minDesires = 1;
                                        // check if nb of desires is less than the minimum authorized by application model so consider we are blocked                                        
                                        // also check if at least one desire is blocked so here also consider we are blocked

                                        if($oneDesireAtLeastIsBlocked) 
                                        {
                                                $blocked = true;
                                                $blocked_reason = "Desire $oneDesireAtLeastIsBlocked is blocked";
                                        }  
                                        
                                        if($appDesireListCount<$minDesires)
                                        {
                                                $blocked = true;
                                                $blocked_reason = "Desire count $appDesireListCount is less the minimum required ($minDesires)";
                                        }

                                        if($nb_desires_gen != $nb_desires_mfk)
                                        {
                                                $blocked = true;
                                                $blocked_reason = "Desires generated count $nb_desires_gen is not equal Desires mfk setted count $nb_desires_mfk";
                                        }
                                }
                                else
                                {
                                        // if the bootstrap failed (one condition failed) or passed (all conditions succeeded) or done (passed and reached last step) 
                                        // then it is not blocked (only standby bootstrap status is considered blocked and need try later)
                                        if($bootstrapAppResult=="standby")
                                        {
                                                $blocked = true;  
                                                $blocked_reason = $bootstrapAppResultDetails;   
                                        }
                                        $war_arr[] = $this->tm("Application",$lang) ." ". $this->tm("faltered at step",$lang). " : $stepCodeTile <!-- $stepCode --> / ". $appObj->statusExplanations(); 
                                }
                        }
                        else
                        {
                                $blocked = true;
                                $blocked_reason = "Application creation failed app=$applicant_id, plan=$application_plan_id, sim=$application_simulation_id, idn=$idn";
                                $err_arr[] = $blocked_reason;
                        }
                }
                

                unset($appObj);
                $tech_result = [
                        'bootstraps'=>$bootstraps,
                        'desire_bootstraps'=>$desire_bootstraps,
                        'blocked'=>$blocked,
                        'blocked_reason'=>$blocked_reason
                ];
                $pbm_result = AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "\n", $tech_arr);

                return [$pbm_result, $tech_result];
        }

        /**
         * @param Application $applicationObj
         * 
         */
        public function getFieldsMatrix($applicantFieldsArr, $lang = "ar", &$applicationObj = null, $onlyIfTheyAreUpdated = false, $technical_infos=true)
        {

                $matrix = [];
                $theyAreUpdated = true;
                $not_avail = [];
                $not_avail_reason = [];
                // $this->updateCalculatedFields();
                foreach ($applicantFieldsArr as $field_name => $applicantFieldObj) {
                        $row_matrix = [];
                        $field_reel = $applicantFieldObj->_isReel();
                        $row_matrix['reel'] = $field_reel;
                        $field_title = $applicantFieldObj->getDisplay($lang);
                        if($technical_infos) $field_title .= "<!-- $field_name -->";
                        $row_matrix['title'] = $field_title;
                        if ($field_reel) {
                                $field_value = $this->getVal($field_name);
                                $field_value_case = "getVal";
                        } else {
                                $field_value = $this->calc($field_name);
                                $field_value_case = "calc";
                        }
                        $field_decode = $this->decode($field_name);
                        if($technical_infos) $field_decode .= "<!-- $field_value -->";
                        $row_matrix['decode'] = $field_decode;

                        $row_matrix['value'] = $field_value;
                        $row_matrix['case'] = $field_value_case;

                        $field_empty = ((!$field_value) or ($field_value === "W"));
                        $row_matrix['empty'] = $field_empty;
                        $row_matrix['error'] = AfwDataQualityHelper::getAttributeError($this, $field_name);
                        $field_value_datetime = "";
                        $default_update_date_of_field_is_api_run_date = false; /* @todo should be in settings */
                        if($default_update_date_of_field_is_api_run_date)
                        {
                                if ($applicationObj) list($field_value_datetime, $api) = $applicationObj->getApplicantFieldUpdateDate($field_name, $lang);
                                else $api = "no-applicationObj";        
                        }
                        else
                        {
                                // @todo : in this case how to know the field update datetime
                                $field_value_datetime = date("Y-m-d");
                                $api = "الخدمات الالكترونية";
                        }
                        
                        if ($row_matrix['empty']) {
                                $api .= " ".$applicationObj->tm("can not find the field value", $lang);
                                $field_value_datetime = "";
                        }

                        if ($row_matrix['error']) {
                                $api .= " ".$row_matrix['error'];
                                $not_avail[] = $field_title;
                                $not_avail_reason[] = $field_title . " " . $row_matrix['error'];
                        }
                        else
                        {
                                $row_matrix['datetime'] = $field_value_datetime;
                                $row_matrix['api'] = $api;
        
                                if ($field_value_datetime) {
                                        if ($applicationObj) {
                                                $duration_expiry = $applicationObj->getFieldExpiryDuration($field_name);
                                                $expiry_date = AfwDateHelper::shiftGregDate('', -$duration_expiry);
                                                if ($field_value_datetime < $expiry_date) {
                                                        $need_update_message = $api . " updated=$field_value_datetime < expiry=$expiry_date  (duration_expiry=$duration_expiry)";
                                                        $row_matrix['status'] = self::needUpdateIcon($need_update_message);
                                                        $theyAreUpdated = false;
                                                        $not_avail[] = $field_title;
                                                        $not_avail_reason[] = $field_title . " " . $need_update_message;
                                                } 
                                                else 
                                                {
                                                        
                                                        $row_matrix['status'] = self::updatedIcon($api);
                                                }
                                        } 
                                        else 
                                        {
                                                $need_update_message = $api . " no application Object";
                                                $row_matrix['status'] = self::needUpdateIcon($need_update_message);
                                                $not_avail_reason[] = $need_update_message;
                                        }
                                } 
                                else 
                                {
                                        $need_update_message = $api . " => never updated";
                                        $row_matrix['status'] = self::needUpdateIcon($need_update_message);
                                        $theyAreUpdated = false;
                                        $not_avail[] = $field_title;
                                        $not_avail_reason[] = $field_title . " " . $need_update_message;
                                }
                        }


                        

                        $matrix[] = $row_matrix;
                }

                if ($onlyIfTheyAreUpdated === true) return $theyAreUpdated;
                if ($onlyIfTheyAreUpdated === "list-fields-not-available") return implode(",", $not_avail);
                if ($onlyIfTheyAreUpdated === "reason-fields-not-available") return implode(",", $not_avail_reason);

                return $matrix;
        }


        public function getApiUpdateDate($apiEndpoint)
        {
                
                

                if (!$this->update_date[$apiEndpoint->id]) {

                        /*global $dbg_counter;
                        if($apiEndpoint->id==6)
                        {                        
                                if(!$dbg_counter) $dbg_counter = 1;
                                else $dbg_counter++;
                        }*/

                        $aarList = $this->getRelation("applicantApiRequestList")->resetWhere("api_endpoint_id=" . $apiEndpoint->id)->getList();
                        $this->update_date[$apiEndpoint->id] = "1900-01-01";
                        foreach ($aarList as $aarItem) {
                                if ($aarItem and $aarItem->getVal("run_date")) $this->update_date[$apiEndpoint->id] = $aarItem->getVal("run_date");
                        }
                }

                /*if($apiEndpoint->id==6)
                {
                        if($dbg_counter>5) die("dbg counter exceeded :: this->update_date => ".var_export($this->update_date,true));
                }*/

                return $this->update_date[$apiEndpoint->id];
        }

        public function getFormuleResult($attribute, $what = "value")
        {
                if (AfwStringHelper::stringStartsWith($attribute, "attribute_")) {
                        $params = self::getAdditionalFieldParams($attribute);
                        $formulaMethod = $params["formula"];
                        if ($formulaMethod) {
                                $main_company = AfwSession::currentCompany();
                                $classFM = AfwStringHelper::firstCharUpper($main_company) . "ApplicantFormulaManager";
                                if (!class_exists($classFM)) {
                                        $file_dir_name = dirname(__FILE__);
                                        require_once($file_dir_name . "/../../client-$main_company/extra/applicant_additional_fields-$main_company.php");
                                }
                                return $classFM::$formulaMethod($this, $what);
                        }
                }
                return AfwFormulaHelper::calculateFormulaResult($this, $attribute, $what);
        }

        public function canUploadFiles()
        {
                return [true, ""];
        }

        public function calcSecondary_major_path($what = "value")
        {
                return $this->calcSecondary_info($info = "secondary_major_path", $what);
        }

        public function calcAptitude_score($what = "value")
        {
                if($this->aptitude_Score===null)
                {
                       $this->aptitude_Score = ApplicantEvaluation::loadMaxScoreFor($this->id, $eval_id_list = "1,2");    
                       if(!$this->aptitude_Score) $this->aptitude_Score = 0;
                }
                return $this->aptitude_Score;
        }

        public function calcAchievement_score($what = "value")
        {
                if($this->achievement_Score===null)
                {
                        $this->achievement_Score = ApplicantEvaluation::loadMaxScoreFor($this->id, $eval_id_list = "3,4");
                        if(!$this->achievement_Score) $this->achievement_Score = 0;
                }
                return $this->achievement_Score;
        }

        public function calcSecondary_cumulative_pct($what = "value", $objSQ = null)
        {
                return $this->calcSecondary_info($info = "secondary_cumulative_pct", $what, $objSQ);
        }


public function updateEvaluationFields($lang="ar", $evaluation_id="all")
{
        /*
                1	اختبار القدرات العامة	اختبار القدرات العامة للتخصصات العلمية
                2	اختبار القدرات العامة	اختبار القدرات العامة للتخصصات النظرية
                3	اختبار التحصيل الدراسي	اختبار التحصيل الدراسي للتخصصات العلمي
                4	اختبار التحصيل الدراسي	اختبار التحصيل الدراسي للتخصصات النظري

        */
        $arr_types = ["qiyas_aptitude_sc"=>1,
                      "qiyas_aptitude_th"=>2,
                      "qiyas_achievement_sc"=>3,
                      "qiyas_achievement_th"=>4,
                      
                      
        ];

        if($evaluation_id=="all")
        {
                // الأصل أنه ليس لديه لا قدرات ولا تحصيلي
                $this->set("attribute_27", "N");
                $this->set("attribute_28", "N");
        }
        
        foreach($arr_types as $attribute => $eval_id)
        {
                if(($evaluation_id=="all") or ($evaluation_id==$eval_id))
                {
                        $score = ApplicantEvaluation::loadMaxScoreFor($this->id, $eval_id_list = $eval_id);
                        $this->set($attribute, $score);

                        if(($score>0) and (($eval_id==1) or ($eval_id==2)))
                        {
                                $this->set("attribute_27", "Y");
                        }

                        if(($score>0) and (($eval_id==3) or ($eval_id==4)))
                        {
                                $this->set("attribute_28", "Y");
                        }
                }
        }
        $this->commit();

        return ["done", ""];
}
        

        public function calcSecondary_info($info, $what = "value", $objSQ = null)
        {
                if ($this->$info===null) {
                        if (!$this->objSQ) $this->objSQ = $objSQ;
                        if (!$this->objSQ) $this->objSQ = $this->getSecondaryQualification();
                        if ($this->objSQ) $this->$info = $this->objSQ->getInfo($info);
                        // die("this->objSQ->id = ".$this->objSQ->id);
                        if(!$this->$info) $this->$info = '';
                        // if($info=="secondary_cumulative_pct") die("this->$info = ".$this->$info);
                }
                return $this->$info;
        }

        public function calcWeighted_percentage_details($what = "value")
        {
                return $this->weighted_percentage("details");
        }

        public function calcWeighted_percentage($what = "value")
        {
                return $this->weighted_percentage($what);
        }

        public function readyWeighted_percentage()
        {
                if($this->calcWeighted_percentage()>=60.0)
                {
                        return true;
                }
        }

        public function weighted_percentage($what = "value", $program_track_id = null, $major_path_id = null, $objSQ = null)
        {
                try {
                        $sub_context_log = "preferred_program_track_id amd secondary_major_path of applicant";
                        if ($program_track_id === null) $program_track_id = $this->getVal("preferred_program_track_id");
                        /* incorrect the weighted_percentage in level of application doesn't contain track and can be calculated
            if(!$program_track_id) 
            {
                if($what=="details") return $this->tm("select your preferred program track", "ar");
                else return -999;
            }*/
                        if ($major_path_id === null) $major_path_id = $this->calcSecondary_major_path();
                        if (!$major_path_id) {
                                if ($what == "details") return $this->tm("No major path defined", "ar");
                                else return -888;
                        }

                        $coef_cumulative_pct_aparameter_id = 19;
                        $coef_aptitude_aparameter_id = 20;
                        $coef_achievement_aparameter_id = 21;


                        $a = $this->calcSecondary_cumulative_pct("value", $objSQ);
                        if (!$a) $a = "0.0";
                        $b = $this->calcAptitude_score();
                        if (!$b) $b = "0.0";
                        $c = $this->calcAchievement_score();
                        if (!$c) $c = "0.0";

                         
                        list($coefAPct, $coefAPctSubContext) = Aparameter::getMyValueForSubContext($coef_cumulative_pct_aparameter_id, $major_path_id, $program_track_id, $sub_context_log, $application_model_id = 0, $application_plan_id = 0, $training_unit_id = 0, $department_id = 0, $application_model_branch_id = 0, false, true);
                        list($coefBPct, $coefBPctSubContext) = Aparameter::getMyValueForSubContext($coef_aptitude_aparameter_id, $major_path_id, $program_track_id, $sub_context_log, $application_model_id = 0, $application_plan_id = 0, $training_unit_id = 0, $department_id = 0, $application_model_branch_id = 0, false, true);
                        list($coefCPct, $coefCPctSubContext) = Aparameter::getMyValueForSubContext($coef_achievement_aparameter_id, $major_path_id, $program_track_id, $sub_context_log, $application_model_id = 0, $application_plan_id = 0, $training_unit_id = 0, $department_id = 0, $application_model_branch_id = 0, false, true);

                        $coefA = $coefAPct / 100;
                        $coefB = $coefBPct / 100;
                        $coefC = $coefCPct / 100;
                        $pct = ($coefA * $a + $coefB * $b + $coefC * $c);
                        if ($what == "details") return "$pct = $coefAPct% x $a + $coefBPct% x $b + $coefCPct% x $c<br>\n
                                                a=$a : cumulative percentage<br>\n
                                                b=$b : aptitude score <br>\n
                                                c=$c : achievement score <br>\n
                                                coefAPct=$coefAPct% <!-- coefAPct for sub-context $coefAPctSubContext --><br>\n
                                                coefBPct=$coefBPct% <!-- coefBPct for sub-context $coefBPctSubContext --><br>\n
                                                coefCPct=$coefCPct% <!-- coefCPct for sub-context $coefCPctSubContext --><br>\n";
                        else return $pct;
                } catch (Exception $e) {
                        $err_message = "";
                        $devMode = AfwSession::config("MODE_DEVELOPMENT", false);
                        if ($devMode) $err_message = $e->getMessage() . "<br> trace is : <br>" . $e->getTraceAsString();
                        if ($what == "details") return $this->tm("error happened <!-- $err_message -->", "ar");
                        else return -99;
                }
        }

        public function calcDragDropDiv($what = "value")
        {
                $lang = AfwSession::getSessionVar("current_lang");
                if (!$lang) $lang = "ar";
                $adm_file_types = AfwSession::config("adm_file_types", "0");
                $allowed_upload_size = AfwSession::config("allowed_upload_size", "0");
                $objme = AfwSession::getUserConnected();

                // $practice_employee_id = $this->getVal("employee_id");
                // $connected_employee_id = ($objme) ? $objme->getEmployeeId() : 0;
                // role 341 is admin of bpractice platform
                // $connected_employee_is_admin = ($objme) ? ($objme->isAdmin() or $objme->hasRole("bpractice", 341)) : false;

                $this_id = $this->getId();

                $file_dir_name = dirname(__FILE__);

                list($ext_arr, $ft_arr) = DocType::getExentionsAllowed($adm_file_types);
                $ext_list = implode(", ", $ext_arr);
                $ft_list = implode(", ", $ft_arr);

                $dtList = DocType::loadAll($adm_file_types);

                $module_doc_types = array();

                foreach ($dtList as $dtId => $dtObject) {
                        $module_doc_types[$dtId] = array('name' => $dtObject->getVal("titre_short"), 'mandatory' => "لا", 'desc' => $dtObject->getVal("titre"), 'extentions' => $dtObject->getVal("extentions"));
                }

                //$module_doc_types[7]["mandatory"] = "نعم";
                //$module_doc_types[13]["mandatory"] = "نعم";
                $module_doc_types_header = array('name' => "صنف المستند", 'mandatory' => "إجباري؟", 'desc' => "الوصف", 'extentions' => "أنواع الملفات المسموح بها");

                list($html_doc_types,  $f_ids) = AfwHtmlHelper::tableToHtml($module_doc_types, $module_doc_types_header);
                $details_title = $this->tm("Files upload conditions details", $lang);
                $help_instruction = $this->tm("Click on [Select file] or drag and drop it directly to this area to upload it", $lang);
                $file_select = $this->tm("Select the file", $lang);
                $file_size_condition = $this->tm("Can't upload files if size exceed", $lang);
                $MB = $this->tm("Mega Bytes", $lang);
                list($can, $message_upload_blocked_reason) = $this->canUploadFiles();
                if ($can) {


                        list($doc_type_id, $doc_attach_id, $doc_attach_name) = $this->getMissedDocument($lang);
                        // die("(doc_type_id, doc_attach_id, doc_attach_name) = ($doc_type_id, $doc_attach_id, , $doc_attach_name)")
                        if ($doc_type_id) {
                                $whendone = "submit";
                                $drop_class = "dc-$doc_type_id";
                                $please_mess = $this->tm("Please upload the following document", $lang);
                                $htmlDiv = "<div id='fg-doc_type_id' class='attrib-doc_type_id form-group width_pct_100 '>
  <label for='doc_type_id' class='hzm_label hzm_label_doc_type_id'>$please_mess :</label>
  <input type='hidden' name='doc_type_id' id='doc_type_id' value='$doc_type_id' />
  <input type='hidden' name='doc_attach_id' id='doc_attach_id' value='$doc_attach_id' />
  <div id='div_doc_type_name' class='btn btn-full col-doc_type_id btn-primary'>$doc_attach_name</div>
</div>";
                        } else {
                                $obj = new ApplicantFile();
                                $col = "doc_type_id";
                                $col_structure = $obj->getMyDbStructure('structure', $col);
                                $col_structure["NO-FGROUP"] = true;
                                $openedInGroupDiv = false;
                                list($htmlDiv, $openedInGroupDiv, $fgroup) = AfwEditMotor::attributeEditDiv($obj, $col, $col_structure, "", $lang, $openedInGroupDiv);
                                $whendone = "hide";
                                $drop_class = "hide";
                        }

                        // die("htmlDiv start here :".$htmlDiv);
                        return "
                             </form>
                             <link href='../lib/assets/css/style.css' rel='stylesheet' />
                             <form id='upload' method='post' action='afw_my_upload.php' enctype='multipart/form-data'>
                    $htmlDiv          
        			<div id='drop' whendone='$whendone' class='$drop_class'>
        				$help_instruction
                                        <br>
        				<a>$file_select</a>
                                        <input type='hidden' name='module' value='adm' />
                                        <input type='hidden' name='afup' value='applicant' />
                                        <input type='hidden' name='afup_objid' value='$this_id' />
        				                <input type='file' name='upl' multiple />
                                        <br><div class='file_space'><br></div><br>
                                        <div class='ft_h'>$details_title</div>
                                        <div class='ft_table'>$html_doc_types</div>
                                        <div class='fc_size'>$file_size_condition <span>$allowed_upload_size</span> $MB</div>
        			</div>
        
        			<ul>
        				<!-- The file uploads will be shown here -->
        			</ul>
        
        		</form>
                        <!-- JavaScript Includes -->
        		<script src='../lib/assets/js/jquery.knob.js'></script>
        
        		<!-- jQuery File Upload Dependencies -->
        		<script src='../lib/assets/js/jquery.ui.widget.js'></script>
        		<script src='../lib/assets/js/jquery.iframe-transport.js'></script>
        		<script src='../lib/assets/js/jquery.fileupload.js'></script>
        		
        		<!-- Our main JS file -->
        		<script src='../lib/assets/js/script-whs.js'></script>
                        ";
                } else {


                        return "
                             </form>
        			<div id='drop'>
        				<div class='ft_h upload_blocked'>$message_upload_blocked_reason</div>
                        <div class='ft_h'>$details_title</div>
                        <div class='ft_table'>$html_doc_types</div>
                        <div class='fc_size'>$file_size_condition <span>$allowed_upload_size</span> $MB</div>
        			</div>
                        ";
                }
        }

        public function getAvailableDocTypes()
        {
                $doc_type_arr = array();
                // بترتيب الأولوية

                // big_photo - صورة تعريفية كبيرة  
                $pho = null; // $this->getPhoto();
                if (!$pho or $pho->isEmpty()) $doc_type_arr[] = self::$doc_type_big_photo;

                // small_photo - صورة صغيرة
                $sph = null; // $this->getSmall_photo();
                if (!$sph or $sph->isEmpty()) $doc_type_arr[] = self::$doc_type_small_photo;

                /*
        // banner - بنر  
        $bnn = $this->getBanner();
        if(!$bnn or $bnn->isEmpty()) $doc_type_arr[] = self::$doc_type_banner;
        */
                // attachement - مرفق توضيحي
                $doc_type_arr[] = self::$doc_type_attachement;

                return $doc_type_arr;
        }

        public function myNeedEvaluationIds($from_name)
        {
                // parse the file name of qualification may be we find a meaning that
                // allow us to deduce qualification id
                // @todo
                // otherwise  we take the default configured for the academic institute

                $usedEvaluationIds = explode(",", AfwSession::config("used_evaluation_ids", "1,2"));

                return $usedEvaluationIds;
        }


        public function mySuggestedEvaluationId($from_name)
        {
                $usedEvaluationIds = $this->myNeedEvaluationIds($from_name);

                // depending on my applications that miss some Evaluation Ids decide which one to take
                // @todo

                // or take the first one

                return $usedEvaluationIds[0];
        }


        public function mySuggestedMajorCategoryId($qualification_id, $from_name)
        {
                // @todo
                return 0;
        }

        ///////////////////////////////////////////////////////////////////////////////////////////

        public function myNeedQualficationIds($from_name)
        {
                // parse the file name of qualification may be we find a meaning that
                // allow us to deduce qualification id
                // @todo
                // otherwise  we take the default configured for the academic institute

                $usedQualficationIds = explode(",", AfwSession::config("used_qualfication_ids", "49,75"));

                return $usedQualficationIds;
        }


        public function mySuggestedQualficationId($from_name)
        {
                $usedQualficationIds = $this->myNeedQualficationIds($from_name);

                // depending on my applications that miss some Qualfication Ids decide which one to take
                // @todo

                // or take the first one

                return $usedQualficationIds[0];
        }

        public function parseEvalDate($qualification_id, $from_name)
        {
                // parse the file name of qualification may be we find a meaning that 
                // allow us to deduce Eval Date
                // @todo

                // if not return null
                return null;
        }

        /**
         * @param WorkflowFile $wf
         */

        public function attach_file($wf, $doc_type_id = 0, $doc_attach_id = 0)
        {

                $afObj = ApplicantFile::loadByMainIndex($this->getId(), $wf->getId(), $this->getVal("idn"), $create_obj_if_not_found = true);

                if (!$doc_type_id) $doc_type_id = $wf->getVal("doc_type_id");
                $afObj->set("doc_type_id", $doc_type_id);
                $afObj->set("name_ar", $afObj->showAttribute("doc_type_id", null, true, 'ar'));
                $afObj->set("name_en", $afObj->showAttribute("doc_type_id", null, true, 'en'));
                $afObj->set("desc_ar", $afObj->showAttribute("doc_type_id", null, true, 'ar') . " : " . $wf->getVal("afile_name"));
                $afObj->set("desc_en", $afObj->showAttribute("doc_type_id", null, true, 'en') . " : " . $wf->getVal("afile_name"));
                //$afObj->set("afile_ext",$af->getVal("afile_ext"));
                //$objme = AfwSession::getUserConnected();
                // "تم تحميله من طرف ".$objme->getDisplay($lang)." بتاريخ ".date("d/m/Y")
                $afObj->commit();

                $dtObj = $afObj->het("doc_type_id");
                $doc_type_lookup_code = $dtObj->getVal("lookup_code");
                if (!$doc_type_lookup_code) $doc_type_lookup_code = "other";
                $from_name = $wf->getVal("afile_name") . " " . $wf->getVal("original_name") . " " . $wf->getParsedText();
                if ($doc_type_id == DocType::$DOC_TYPE_DIPLOMA) {
                        if ($doc_attach_id) {
                                $myQualObj = ApplicantQualification::loadById($doc_attach_id);
                                if ($myQualObj) {
                                        $myQualObj->set("adm_file_id", $wf->id);
                                        $myQualObj->commit();
                                        $afObj->set("name_ar", $myQualObj->getShortDisplay('ar'));
                                        $afObj->set("name_en", $myQualObj->getShortDisplay('en'));
                                        $afObj->set("desc_ar", $myQualObj->getDisplay('ar'));
                                        $afObj->set("desc_en", $myQualObj->getDisplay('en'));
                                        $afObj->commit();
                                }
                        } else {
                                $qualification_id = $this->mySuggestedQualficationId($from_name);
                                $major_category_id = $this->mySuggestedMajorCategoryId($qualification_id, $from_name);
                                $myQualObj = ApplicantQualification::getMyQualificationNeedingFileAttachment($this->id, $wf, $qualification_id, $major_category_id);
                        }
                } elseif ($doc_type_id == DocType::$DOC_TYPE_EXAM) {
                        if ($doc_attach_id) {
                                $myEvalObj = ApplicantEvaluation::loadById($doc_attach_id);
                                if ($myEvalObj) {
                                        $myEvalObj->set("workflow_file_id", $wf->id);
                                        $myEvalObj->commit();
                                }
                        } else {
                                $evaluation_id = $this->mySuggestedEvaluationId($from_name);
                                $eval_date = $this->parseEvalDate($evaluation_id, $from_name);
                                $myEvalObj = ApplicantEvaluation::getMyEvaluationNeedingFileAttachment($this->id, $wf, $evaluation_id, $eval_date);
                        }
                } else {
                }

                $afile_name = $doc_type_lookup_code . "-" . $afObj->id;

                return $afile_name;
        }

        public function getAttachedFileWithType($type)
        {
                $file_dir_name = dirname(__FILE__);
                $afObj = new ApplicantFile();
                $afObj->select("applicant_id", $this->getId());
                $afObj->select("doc_type_id", $type);
                $afObj->select("active", "Y");
                $afObj->load();
                //if($afObj->getId()<=0) die("pfObj($type) = ".var_export($afObj,true));
                return $afObj;
        }
}

