<?php
        class AparameterValue extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "aparameter_value"; 
                public static $DB_STRUCTURE = null;

                public function __construct(){
                        parent::__construct("aparameter_value","id","adm");
                        AdmAparameterValueAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new AparameterValue();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
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

                        if($attribute == "answer_table_id")
                        {
                                $af_type_id = $this->getVal("afield_type_id");
                                return (($af_type_id==5) or ($af_type_id==6));
                        }

                        if($attribute == "measurement_unit_en")
                        {
                                $af_type_id = $this->getVal("afield_type_id");
                                return self::afield_type()["numeric"][$af_type_id];
                        }

                        if($attribute == "measurement_unit_ar")
                        {
                                $af_type_id = $this->getVal("afield_type_id");
                                return (self::afield_type()["numeric"][$af_type_id] or ($af_type_id==12) or ($af_type_id==15));
                        }


                        

                        return true;
                }

                public function getAttributeLabel($attribute, $lang = 'ar', $short = false)
                {
                        $af_type_id = $this->getVal("afield_type_id");
                        
                        if(($attribute == "measurement_unit_ar") and (($af_type_id==12) or ($af_type_id==15)))
                        {
                                return AfwLanguageHelper::getAttributeTranslation($this, "short enum list name", $lang, $short);
                        }
                        // die("calling getAttributeLabel($attribute, $lang, short=$short)");
                        return AfwLanguageHelper::getAttributeTranslation($this, $attribute, $lang, $short);
                }

                public function dynamic($field_name, $col_struct)
                {
                    $return = null;    
                    $aparamObj = $this->het("aparameter_id"); 
                    if(!$aparamObj) return null;
                    $af_type_id = $aparamObj->getVal("afield_type_id");    
                    if($field_name=="value" and ($col_struct=="TYPE") ) die("dynamic log : af_type_id=$af_type_id aparamObj=".var_export($aparamObj,true));
                    if(!$af_type_id) $af_type_id = 10;

                    $col_struct = strtoupper($col_struct);

                    if($col_struct=="TYPE") 
                    {
                        return AfwUmsPagHelper::afieldTypeToAfwType($af_type_id);
                    }
                    
                    if($col_struct=="ANSMODULE") 
                    {
                        if(($af_type_id==5) or ($af_type_id==6))
                        {
                                $ansTabId = $aparamObj->getVal("answer_table_id"); 
                                $ansTab = $aparamObj->het("answer_table_id"); 
                                if(!$ansTab) return "no-ansTabId-[$ansTabId]";
                                $ansModId = $ansTab->getVal("id_module");
                                $ansMod = $ansTab->het("id_module");                                
                                if(!$ansMod) return "no-module-[$ansModId]-for-ansTabId-[$ansTabId]";
                                return $ansMod->getVal("module_code");
                        }
                    }
                    
                    if($col_struct=="ANSWER") 
                    {
                        if(($af_type_id==5) or ($af_type_id==6))
                        {
                                $ansTabId = $aparamObj->getVal("answer_table_id"); 
                                $ansTab = $aparamObj->het("answer_table_id"); 
                                if(!$ansTab) return "ansTabId-$ansTabId";
                                return $ansTab->getVal("atable_name");
                        }

                        if(($af_type_id==12) or ($af_type_id==15))
                        {
                               return "FUNCTION"; 
                        }
                    }

                    if($col_struct=='FUNCTION_COL_NAME') 
                    {
                        if(($af_type_id==12) or ($af_type_id==15))
                        {
                                $field_name_for_function = $aparamObj->getVal("measurement_unit_ar"); 
                                if($field_name_for_function) return $field_name_for_function;
                                else return $field_name; 
                        }
                    }

                    
                    return $return;
                }

        }
?>
