<?php
        class Aparameter extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "aparameter"; 
                public static $DB_STRUCTURE = null;

                public function __construct(){
                        parent::__construct("aparameter","id","adm");
                        AdmAparameterAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new Aparameter();
                        
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

        }
?>
