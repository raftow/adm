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

        }
?>
