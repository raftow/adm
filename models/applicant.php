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


    // big_photo - صورة تعريفية  
    public static $doc_type_big_photo = 13; 
    
    // small_photo -   صورة صغيرة  
    public static $doc_type_small_photo = 12; 

    // attachement - مرفق توضيحي
    public static $doc_type_attachement = 7;     

    public function __construct()
    {
        parent::__construct("applicant", "id", "adm");
        AdmApplicantAfwStructure::initInstance($this);
    }

    public function afterSelect($attribute, $value)
    {
        // As we have a partion by ID and ID = IDN,
        // when we select IDN we select ID also to use the partionning concept
        if ($attribute == "idn") {
            $idn = $value;
            list($idn_correct, $idn_type_id) = AfwFormatHelper::getIdnTypeId($idn);
            $id = 0;
            if (($idn_type_id == 1) or ($idn_type_id == 2)) {
                if (is_numeric($idn) and $idn_correct) $id = $idn;
            } else {
                $country_id = $this->getSelectedValueForAttribute("country_id");
                if ($country_id) {
                    $id = IdnToId::convertToID('adm', $country_id, $idn_type_id, $idn);
                } else {
                    // we can not optimize query and select the id while passport number entered without country specified
                    $id = 0;
                }
            }
            if ($id > 0) $this->select("id", $id);
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
        if($aqObj) return [DocType::$DOC_TYPE_DIPLOMA, $aqObj->id, $aqObj->getDisplay($lang)];

        $aeObj = ApplicantEvaluation::getMyEvaluationNeedingFileAttachment($this->id);
        if($aeObj) return [DocType::$DOC_TYPE_DIPLOMA, $aeObj->id, $aeObj->getDisplay($lang)];

        return [0, 0, ''];
    }

    public function getDisplay($lang = 'ar')
    {
        $return = trim($this->getDefaultDisplay($lang));
        if (!$return) return $this->tm("identity",$lang) . " : " . $this->id;
        else return $return;
    }

    public function getWideDisplay($lang = 'ar')
    {
        $return = trim($this->getDefaultDisplay($lang));
        $return .= " " . $this->tm("identity") . " : " . $this->id;
        return $return;
    }



    public function stepsAreOrdered()
    {
        return false;
    }

    public static function loadApiRunner()
    {
        $main_company = AfwSession::config("main_company", "all");
        $api_runner_file = $main_company . "_api_runner";
        $api_runner_class = AfwStringHelper::tableToClass($api_runner_file);
        if (!class_exists($api_runner_class, false)) {
            $file_dir_name = dirname(__FILE__);
            require($file_dir_name . "/../extra/$api_runner_file.php");
        }

        return $api_runner_class;
    }

    public function beforeMaj($id, $fields_updated)
    {
        $idn = $this->getVal("idn");
        $idn_type_id = $this->getVal("idn_type_id");
        if ((!$idn) or (!$idn_type_id)) // should never happen but ....                    
        {
            throw new  AfwRuntimeException("BAD DATA For IDN=$idn IDN-TYPE=$idn_type_id");
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
                if (!is_numeric($idn)) throw new AfwRuntimeException("IDN $idn of TYPE $idn_type_id SHOULD BE NUMERIC");
                list($idn_correct, $type) = AfwFormatHelper::getIdnTypeId($idn);
                if ($type != $idn_type_id) throw new AfwRuntimeException("IDN $idn is not of type $idn_type_id but of type $type");
                if (!$idn_correct) throw new AfwRuntimeException("IDN $idn of TYPE $idn_type_id HAVE BAD FORMAT");
                $this->set("id", $idn);
            } else {
                $country_id = $this->getVal("country_id");
                if (!$country_id) throw new  AfwRuntimeException("For IDN=$idn IDN-TYPE=$idn_type_id COUNTRY IS REQUIRED");
                $id = IdnToId::convertToID('adm', $country_id, $idn_type_id, $idn);
                if (!$id) throw new  AfwRuntimeException("Failed IDN conversion IdnToId::convertToID('adm', $country_id, $idn_type_id, $idn)");
                $this->set("id", $id);
            }


            $id = $this->id;
            $first_register = true;
            // throw new AfwRuntimeException("For IDN=$idn beforeMaj($id, fields_updated=".var_export($fields_updated,true).") after set id=".var_export($id,true));
        } elseif (($idn_type_id == 1) or ($idn_type_id == 2) or ($idn_type_id == 3)) {
            if ($id != $idn) throw new AfwRuntimeException("beforeMaj Contact admin please because IDN=$idn != id=$id");
        }

        $register_apis_need_refresh = AfwSession::config("register_apis_need_refresh", true);

        if ($this->id and ($first_register or $register_apis_need_refresh)) {
            $api_runner_class = self::loadApiRunner();

            // create register apis call requests to be done by applicant-api-request-job
            $register_apis = $api_runner_class::register_apis();
            foreach ($register_apis as $register_api) {
                $aepObj = ApiEndpoint::loadByMainIndex($register_api);
                if (!$aepObj) throw new AfwRuntimeException("the register API $register_api is not found in DB");
                ApplicantApiRequest::loadByMainIndex($this->id, $aepObj->id, true);
            }
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
            // tempo for demo @todo
            $link["PUBLIC"] = true;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }

        if ($mode == "mode_applicationList") {
            $aplanList = ApplicationPlan::getCurrentApplicationPlans();
            $color = 'blue';
            foreach ($aplanList as $aplanItem) {
                $application_plan_id = $aplanItem->id;
                $application_model_id = $aplanItem->getVal("application_model_id");
                unset($link);
                $link = array();
                $title = "التقديم على " . $aplanItem->getShortDisplay($lang);
                // $title_detailed = $title . "لـ : " . $displ;
                $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=Application&currmod=adm&sel_applicant_id=$my_id&sel_application_plan_id=$application_plan_id&sel_application_model_id=$application_model_id";
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

        if ($attribute == "applicantQualificationsNoFile")
        {
            return ($this->getRelation("applicantQualificationsNoFile")->count()>0);
        }

        if ($attribute == "applicantEvaluationsNoFile")
        {
            return ($this->getRelation("applicantEvaluationsNoFile")->count()>0);
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
        $birth_gdate_step = $this->stepOfAttribute('birth_gdate');
        $birth_gdate_is_in_step = $this->stepContainAttribute($step, 'birth_gdate');
        $no_step_scope = (!$start_step and !$end_step);
        $step_in_scope = (($birth_gdate_step >= $start_step) and ($birth_gdate_step <= $end_step));
        $birth_gdate_is_in_steps_scope = ($birth_gdate_is_in_step and ($no_step_scope or $step_in_scope));


        if ($birth_gdate_is_in_steps_scope) {
            $birth_gdate = $this->getVal('birth_gdate');
            $birth_date = $this->getVal('birth_date');

            if (!$birth_gdate and !$birth_date) {
                $sp_errors['birth_gdate'] = $this->translateMessage('birth date gregorian or hijri should be defined');
                // $sp_errors['birth_gdate'] .= "<pre dir='ltr'> dbg : birth_gdate_is_in_steps_scope = birth_gdate_is_in_step and (no_step_scope or step_in_scope) \n $birth_gdate_is_in_steps_scope = $birth_gdate_is_in_step and ($no_step_scope or $step_in_scope)</pre>";
            }
        }

        return $sp_errors;
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
        foreach ($lookup as $lookup_level => $lookupItem) {
            foreach ($lookupItem["attributes"] as $attributeConfig) {
                $this->set($attributeConfig["attribute"], "N");
            }
        }

        $applicantQualificationList = $this->get("applicantQualificationList");
        foreach ($applicantQualificationList as $applicantQualificationItem) {
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



        $color = "green";
        $title_ar = "تحديث البيانات من الخدمات الالكترونية";
        $methodName = "runNeededApis";
        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, "LABEL_AR" => $title_ar, "PUBLIC" => true, "BF-ID" => "", 'STEPS' => 'all');




        return $pbms;
    }


    public function runNeededApis($lang = "ar")
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
                /**
                 * @var ApiEndpoint $apiEndPoint
                 */
                $apiEndPoint = $applicantApiRequestItem->het("api_endpoint_id");
                $need_refresh = $applicantApiRequestItem->sureIs("need_refresh");
                if ($apiEndPoint and $apiEndPoint->sureIs("published")) {
                    $run_date = $applicantApiRequestItem->getVal("run_date");
                    if ($run_date == "0000-00-00") $run_date = "";
                    if ($run_date == "0000-00-00 00:00:00") $run_date = "";

                    if (!$need_refresh) {
                        if ($run_date) {
                            $duration_expiry = $apiEndPoint->getVal("duration_expiry");
                            if (!$duration_expiry) $duration_expiry = 15;
                            $expiry_date = AfwDateHelper::shiftGregDate('', -$duration_expiry);
                            $need_refresh = ($expiry_date > $run_date); // run date is very old
                        } else $need_refresh = true;
                    }




                    if ($run_date) $can_refresh = $apiEndPoint->sureIs("can_refresh");
                    else $can_refresh = true;

                    if ($need_refresh and $can_refresh) {
                        $api_name = $apiEndPoint->getShortDisplay($lang);
                        $api_endpoint_code = $apiEndPoint->getVal("api_endpoint_code");
                        $api_runner_method = "run_api_" . $api_endpoint_code;
                        $api_runner_class = self::loadApiRunner();
                        list($err, $inf, $war, $tech) = $api_runner_class::$api_runner_method($this);

                        if ($err) $err_arr[] = "$api_name : " . $err;
                        if ($inf) $inf_arr[] = "$api_name : " . $inf;
                        if ($war) $war_arr[] = "$api_name : " . $war;
                        if ($tech) $tech_arr[] = $tech;

                        if (!$err) {
                            $applicantApiRequestItem->set("run_date", date("Y-m-d H:i:s"));
                            $applicantApiRequestItem->commit();
                        }
                    } elseif (!$need_refresh) $war_arr[] = $apiEndPoint . " doesn't need update as recently updated at $run_date";
                    elseif (!$can_refresh) $war_arr[] = $apiEndPoint . " already called at $run_date and can not be refreshed";
                } else $war_arr[] = $apiEndPoint . " is not published";
            }
        } catch (Exception $e) {
            $err_arr[] = $e->getMessage();
        } catch (Error $e) {
            $err_arr[] = $e->__toString();
        }
        // die("war_arr=".var_export($war_arr));
        return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
    }

    public function getFieldUpdateDate($field_name)
    {
        $apiEndpoint = $this->getFieldApiEndpoint($field_name);
        if ($apiEndpoint) [$field_value_datetime, $api] = $this->applicantObj->getApiUpdateDate($apiEndpoint);
        if (!$field_value_datetime) $field_value_datetime = $this->getVal($field_name . "_update_date");
        return [$field_value_datetime, $api];
    }

    /**
     * @param Application $applicationObj
     * 
     */


    public function getFieldsMatrix($applicantFieldsArr, $lang = "ar", $applicationObj = null)
    {
        $matrix = [];
        // $this->updateCalculatedFields();
        foreach ($applicantFieldsArr as $field_name => $applicantFieldObj) {
            $row_matrix = [];
            $field_reel = $applicantFieldObj->_isReel();
            $row_matrix['reel'] = $field_reel;
            $field_title = $applicantFieldObj->getDisplay($lang) . "<!-- $field_name -->";
            $row_matrix['title'] = $field_title;
            if ($field_reel) {
                $field_value = $this->getVal($field_name);
                $field_value_case = "getVal";
            } else {
                $field_value = $this->calc($field_name);
                $field_value_case = "calc";
            }
            $field_decode = $this->decode($field_name);
            $row_matrix['decode'] = $field_decode . "<!-- $field_value -->";
            $row_matrix['value'] = $field_value;
            $row_matrix['case'] = $field_value_case;

            $field_empty = ((!$field_value) or ($field_value === "W"));
            $row_matrix['empty'] = $field_empty;
            $field_value_datetime = "";
            if (!$field_empty) {
                if ($applicationObj) list($field_value_datetime, $api) = $applicationObj->getApplicantFieldUpdateDate($field_name);
                else $api = "no-applicationObj";
            }


            $row_matrix['datetime'] = $field_value_datetime;
            $row_matrix['api'] = $api;

            if ($field_value_datetime and $applicationObj) {
                $duration_expiry = $applicationObj->getFieldExpiryDuration($field_name);
                $expiry_date = AfwDateHelper::shiftGregDate('', -$duration_expiry);
                if ($field_value_datetime < $expiry_date) $row_matrix['status'] = self::needUpdateIcon($api);
                $row_matrix['status'] = self::updatedIcon($api);
            } else {
                $row_matrix['status'] = self::needUpdateIcon($api);
            }

            $matrix[] = $row_matrix;
        }

        return $matrix;
    }


    public function getApiUpdateDate($apiEndpoint)
    {
        $update_date = "";
        $aarList = $this->getRelation("applicantApiRequestList")->resetWhere("api_endpoint_id=" . $apiEndpoint->id)->getList();
        foreach ($aarList as $aarItem) {
            if ($aarItem) $update_date = $aarItem->getVal("run_date");
        }

        return $update_date;
    }

    public function getFormuleResult($attribute, $what = "value")
    {
        if (AfwStringHelper::stringStartsWith($attribute, "attribute_")) {
            $params = self::getAdditionalFieldParams($attribute);
            $formulaMethod = $params["formula"];
            if ($formulaMethod) {
                $main_company = AfwSession::config("main_company", "all");
                $classFM = AfwStringHelper::firstCharUpper($main_company) . "ApplicantFormulaManager";
                if (!class_exists($classFM)) {
                    $file_dir_name = dirname(__FILE__);
                    require_once($file_dir_name . "/../extra/applicant_additional_fields-$main_company.php");
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

    public function calcDragDropDiv()
    {
        $lang = AfwSession::getSessionVar("current_lang");
        if(!$lang) $lang = "ar";
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
        $help_instruction = $this->tm("Click on [File upload] to select the file or drag and drop it directly to this area to upload it", $lang);
        $files_upload_title = $this->tm("Files upload", $lang);
        $file_size_condition = $this->tm("Can't upload files if size exceed", $lang);
        $MB = $this->tm("Mega Bytes", $lang);
        list($can, $message_upload_blocked_reason) = $this->canUploadFiles();
        if ($can) 
        {
            
            
            list($doc_type_id, $doc_attach_id, $doc_attach_name) = $this->getMissedDocument($lang);
            // die("(doc_type_id, doc_attach_id, doc_attach_name) = ($doc_type_id, $doc_attach_id, , $doc_attach_name)")
            if($doc_type_id)
            {
                $whendone = "submit";
                $drop_class = "dc-$doc_type_id";
                $please_mess = $this->tm("Please upload the following document", $lang);
                $htmlDiv = "<div id='fg-doc_type_id' class='attrib-doc_type_id form-group width_pct_100 '>
  <label for='doc_type_id' class='hzm_label hzm_label_doc_type_id'>$please_mess :</label>
  <input type='hidden' name='doc_type_id' id='doc_type_id' value='$doc_type_id' />
  <input type='hidden' name='doc_attach_id' id='doc_attach_id' value='$doc_attach_id' />
  <div id='div_doc_type_name' class='btn btn-full col-doc_type_id btn-primary'>$doc_attach_name</div>
</div>";
            }
            else
            {
                $obj = new ApplicantFile();
                $col = "doc_type_id";
                $col_structure = $obj->getMyDbStructure('structure', $col);
                $col_structure["NO-FGROUP"] = true;
                $openedInGroupDiv = false;
                list($htmlDiv, $openedInGroupDiv, $fgroup) = attributeEditDiv($obj, $col, $col_structure, "", $lang, $openedInGroupDiv);
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
        				<a>$files_upload_title</a>
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
        } 
        else 
        {
            

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
        if(!$pho or $pho->isEmpty()) $doc_type_arr[] = self::$doc_type_big_photo;
        
        // small_photo - صورة صغيرة
        $sph = null; // $this->getSmall_photo();
        if(!$sph or $sph->isEmpty()) $doc_type_arr[] = self::$doc_type_small_photo;
        
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

    public function attach_file($af, $doc_type_id=0, $doc_attach_id=0)
    {
            
        $afObj = ApplicantFile::loadByMainIndex($this->getId(), $af->getId(), $create_obj_if_not_found=true);
            
        if(!$doc_type_id) $doc_type_id = $af->getVal("doc_type_id");
        $afObj->set("doc_type_id",$doc_type_id);
        $afObj->set("desc_ar",$afObj->showAttribute("doc_type_id")." : ".$af->getVal("afile_name"));
        //$afObj->set("afile_ext",$af->getVal("afile_ext"));
        //$objme = AfwSession::getUserConnected();
        // "تم تحميله من طرف ".$objme->getDisplay($lang)." بتاريخ ".date("d/m/Y")
        $afObj->commit();

        $dtObj = $afObj->het("doc_type_id");
        $doc_type_lookup_code = $dtObj->getVal("lookup_code");
        if(!$doc_type_lookup_code) $doc_type_lookup_code = "other";
        $from_name = $af->getVal("afile_name") . " " . $af->getVal("original_name")." ".$af->getParsedText();
        if($doc_type_id == DocType::$DOC_TYPE_DIPLOMA)
        {
            if($doc_attach_id)
            {
                $myQualObj = ApplicantQualification::loadById($doc_attach_id);
                if($myQualObj)
                {
                    $myQualObj->set("adm_file_id", $af->id);
                    $myQualObj->commit();
                }
            }
            else
            {
                $qualification_id = $this->mySuggestedQualficationId($from_name);
                $major_category_id = $this->mySuggestedMajorCategoryId($qualification_id, $from_name);
                $myQualObj = ApplicantQualification::getMyQualificationNeedingFileAttachment($this->id, $af, $qualification_id, $major_category_id);
            }            
        }
        elseif($doc_type_id == DocType::$DOC_TYPE_EXAM)
        {
            if($doc_attach_id)
            {
                $myEvalObj = ApplicantQualification::loadById($doc_attach_id);
                if($myEvalObj)
                {
                    $myEvalObj->set("workflow_file_id", $af->id);
                    $myEvalObj->commit();
                }
            }
            else
            {
                $evaluation_id = $this->mySuggestedEvaluationId($from_name);
                $eval_date = $this->parseEvalDate($evaluation_id, $from_name);
                $myEvalObj = ApplicantEvaluation::getMyEvaluationNeedingFileAttachment($this->id, $af, $evaluation_id, $eval_date);
            }
        }
        else
        {
            
        }

        $afile_name = $doc_type_lookup_code."-".$afObj->id;

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
