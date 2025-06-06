<?php
class Aparameter extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "aparameter";
        public static $DB_STRUCTURE = null;
        private static $subContextValueArray = [];
        private $contextValueArray = [];

        public function __construct()
        {
                parent::__construct("aparameter", "id", "adm");
                AdmAparameterAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new Aparameter();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public static function getMyValueForSubContext($aparameter_id, $major_path_id, $program_track_id, $sub_context_log, 
                                        $application_model_id=0, $application_plan_id=0, $training_unit_id=0, $department_id=0, $application_model_branch_id=0, 
                                        $throwErrorIfNotFound=false, $returnSubContext=false)
        {
                if(!$major_path_id) throw new AfwRuntimeException("major_path_id is mandatory to define a sub-context, log : <br>$sub_context_log <br>");
                $subContext = "APARAM$aparameter_id-MAJPTH$major_path_id-PRGTRK$program_track_id+APPMDL$application_model_id-APPLAN$application_plan_id-TRUNIT$training_unit_id-DEPMNT$department_id-APMDLB$application_model_branch_id";
                if(!self::$subContextValueArray[$subContext]) 
                {
                        $paramValueObj = AparameterValue::loadByMainIndex($aparameter_id, $application_model_id, $application_plan_id, $training_unit_id, $department_id, $application_model_branch_id, $major_path_id, $program_track_id);                
                        if(!$paramValueObj) $paramValueObj = AparameterValue::loadByMainIndex($aparameter_id, $application_model_id, $application_plan_id, $training_unit_id, $department_id, $application_model_branch_id, 0, 0);                
                        if($paramValueObj) self::$subContextValueArray[$subContext] = $paramValueObj->getVal("value");
                        elseif($throwErrorIfNotFound) throw new AfwRuntimeException("no parameter value object for sub-context $subContext, log : <br>$sub_context_log <br>");
                        if(!self::$subContextValueArray[$subContext]) self::$subContextValueArray[$subContext]="NOTHING-FOUND";
                }
                $val = self::$subContextValueArray[$subContext];
                if($val==="NOTHING-FOUND") 
                {
                        $val = null;
                        $subContext .= " => NOTHING-FOUND";
                }
                return $returnSubContext ? [$val, $subContext] : $val;
        }

        public static function getParameterValueForContext($aparameter_id, $application_model_id, $application_plan_id, $obj)
        {
                $objParam = Aparameter::loadById($aparameter_id);
                $objParamValue = $objParam->getMyValueForContext($application_model_id, $application_plan_id, $obj);
                if($objParamValue) return $objParamValue->getVal("value");
                return null;
        }

        public function getMyValueForContext($application_model_id, $application_plan_id, $obj)
        {
                $training_unit_id = 0;
                $department_id = 0;
                $application_model_branch_id = 0;

                $aparam_use_scope_id = $this->getVal("aparam_use_scope_id");
                
                // fixed param not customizable
                if($aparam_use_scope_id==4)
                {
                        $application_model_id = 0;
                        $application_plan_id = 0;
                }
                else
                {
                        if ($obj instanceof ApplicationDesire)
                        {
                                $training_unit_id = $obj->getVal("training_unit_id");                        
                                $department_id = $obj->getVal("department_id");
                                if(!$department_id) $department_id = 0;
                                $application_model_branch_id = $obj->getVal("application_model_branch_id");
                                if(!$application_model_branch_id) $application_model_branch_id = 0;
                        }
                }

                /* if ($obj instanceof Applicant) {
                        $training_unit_id = 0;
                        $department_id = 0;
                        $application_model_branch_id = 0;
                }*/

                

                $context = "$application_model_id-$application_plan_id-$training_unit_id-$department_id-$application_model_branch_id";
                if(!$this->contextValueArray[$context]) 
                {
                        $paramValueObj = null;
                        $widing = true;
                        do {
                                $paramValueObj = AparameterValue::loadByMainIndex($this->id, $application_model_id, $application_plan_id, $training_unit_id, $department_id, $application_model_branch_id);
                                if ($application_model_branch_id) $application_model_branch_id = 0;
                                elseif ($department_id) $department_id = 0;
                                elseif ($training_unit_id) $training_unit_id = 0;
                                elseif ($application_plan_id) $application_plan_id = 0;
                                elseif ($application_model_id) $application_model_id = 0;
                                else $widing = false;
                        } while ((!$paramValueObj) and ($widing or $application_model_id or $application_plan_id or $training_unit_id or $department_id or $application_model_branch_id));
                        if($paramValueObj)
                        {
                                $paramValueObj->optimizeMemory();
                                $this->contextValueArray[$context] = $paramValueObj;
                        }
                        if(!$this->contextValueArray[$context]) $this->contextValueArray[$context] = "NOT-FOUND";
                }
                return $this->contextValueArray[$context];
        }


        public static function list_of_aparam_use_scope_id()
        {
                $lang = AfwLanguageHelper::getGlobalLanguage();
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

        public function getShortDisplay($lang = 'ar')
        {
                return $this->getDefaultDisplay($lang);
        }

        public function getDisplay($lang = 'ar')
        {
                return $this->singleTranslation($lang).":".$this->getDefaultDisplay($lang)." [".$this->id."]";
        }

        protected function getOtherLinksArray($mode, $genereLog = false, $step = "all")
        {
                $lang = AfwLanguageHelper::getGlobalLanguage();
                // $objme = AfwSession::getUserConnected();
                // $me = ($objme) ? $objme->id : 0;

                $otherLinksArray = $this->getOtherLinksArrayStandard($mode, $genereLog, $step);
                $my_id = $this->getId();
                $displ = $this->getDisplay($lang);


                if ($mode == "mode_aparameterValueList") {
                        unset($link);
                        $link = array();
                        $title = "إضافة تخصيص جديد";
                        $title_detailed = $title . "لـ : " . $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=AparameterValue&currmod=adm&sel_aparameter_id=$my_id";
                        $link["TITLE"] = $title;
                        $link["PUBLIC"] = true;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                }



                // check errors on all steps (by default no for optimization)
                // rafik don't know why this : \//  = false;

                return $otherLinksArray;
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
                                // adm.acondition-القيمة المقارنة	aparameter_id  ManyToOne (required field)
                                // require_once "../adm/acondition.php";
                                $obj = new Acondition();
                                $obj->where("aparameter_id = '$id' and active='Y' ");
                                $nbRecords = $obj->count();
                                // check if there's no record that block the delete operation
                                if ($nbRecords > 0) {
                                        $this->deleteNotAllowedReason = "مستعمل في بعض الشروط";
                                        return false;
                                }
                                // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                                if (!$simul) $obj->deleteWhere("aparameter_id = '$id' and active='N'");



                                // FK part of me - deletable 
                                // adm.aparameter_value-القيمة المعلمة	aparameter_id  OneToMany
                                if (!$simul) {
                                        // require_once "../adm/aparameter_value.php";
                                        AparameterValue::removeWhere("aparameter_id='$id'");
                                        // $this->execQuery("delete from ${server_db_prefix}adm.aparameter_value where aparameter_id = '$id' ");

                                }




                                // FK not part of me - replaceable 
                                // adm.acondition-القيمة المقارنة	aparameter_id  ManyToOne
                                if (!$simul) {
                                        // require_once "../adm/acondition.php";
                                        Acondition::updateWhere(array('aparameter_id' => $id_replace), "aparameter_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.acondition set aparameter_id='$id_replace' where aparameter_id='$id' ");
                                }



                                // MFK

                        } else {
                                // FK on me 


                                // adm.acondition-القيمة المقارنة	aparameter_id  ManyToOne (required field)
                                if (!$simul) {
                                        // require_once "../adm/acondition.php";
                                        Acondition::updateWhere(array('aparameter_id' => $id_replace), "aparameter_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.acondition set aparameter_id='$id_replace' where aparameter_id='$id' ");

                                }


                                // adm.aparameter_value-القيمة المعلمة	aparameter_id  OneToMany
                                if (!$simul) {
                                        // require_once "../adm/aparameter_value.php";
                                        AparameterValue::updateWhere(array('aparameter_id' => $id_replace), "aparameter_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.aparameter_value set aparameter_id='$id_replace' where aparameter_id='$id' ");

                                }

                                // adm.acondition-القيمة المقارنة	aparameter_id  ManyToOne
                                if (!$simul) {
                                        // require_once "../adm/acondition.php";
                                        Acondition::updateWhere(array('aparameter_id' => $id_replace), "aparameter_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.acondition set aparameter_id='$id_replace' where aparameter_id='$id' ");
                                }


                                // MFK


                        }
                        return true;
                }
        }

        // aparameter 
        public function getScenarioItemId($currstep)
        {
                if ($currstep == 1) return 379;
                if ($currstep == 2) return 380;
                if ($currstep == 3) return 476;

                return 0;
        }

        public function afterMaj($id, $fields_updated)
        {
                $obj = AparameterValue::loadByMainIndex($this->id,0,0,0,0,0,0,0,true);
                /*
                if($fields_updated["xxxx"])
                {
                        $this->XXXX("ar");
                }*/
        }

        protected function getPublicMethods()
        {
        
                $pbms = array();
                
                

                $color = "green";
                $title_ar = "انشاء نسخة مطابقة"; 
                $methodName = "cloneMe";
                $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "PUBLIC"=>true, "BF-ID"=>"", 'STEPS' =>[2,3]);
                

                
                
                return $pbms;
        }

        public function cloneMe($lang="ar", $cloneValues=true)
        {
                  
                $aparameter_name_ar = $this->getVal("aparameter_name_ar");
                $aparameter_name_en = $this->getVal("aparameter_name_en");
                $aparameterValueList = $this->get("aparameterValueList");
                

                $paramCloned = clone $this;
                $nb_inserts = 0;
                $paramCloned->resetAsCopy();
                $paramCloned->set("aparameter_name_ar", $aparameter_name_ar."-نسخة");
                $paramCloned->set("aparameter_name_en", $aparameter_name_en."-clone");
                if($paramCloned->insert()) $nb_inserts++;
                if($cloneValues)
                {
                        foreach($aparameterValueList as $aparameterValueItem)
                        {
                                if($aparameterValueItem->cloneInParameter($paramCloned->id)) $nb_inserts++;
                        }
                }
                
                return ["", "$nb_inserts objects has been cloned"];

                
        }
}
