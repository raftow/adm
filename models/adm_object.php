<?php

class AdmObject extends AFWObject{

    /*
        // إدارة المنتج	إدارة البيانات العامة للنظام
        public static $AROLE_OF_DATA_SITE = 322;
        
        // التحقيق	التحقيق والرد على طلبات العملاء 
        public static $AROLE_OF_INVESTIGATOR = 323;

        // الإشراف على تشغيل نظام خدمة العملاء
        public static $AROLE_OF_SUPERVISOR = 324;

        // إدخال الطلبات الالكترونية التي تصل عبر الهاتف
        public static $AROLE_OF_REQUEST_ENTER = 327;

        // إدارة البيانات المرجعية للنظام
        public static $AROLE_OF_LOOKUPS = 347;


        public static function userConnectedIsSupervisor($objme=null)
        {
            if(!$objme) $objme = AfwSession::getUserConnected();
            if(!$objme) return 0;

            $employee_id = $objme->getEmployeeId();
            if(!$employee_id) return 0;

            return CrmEmployee::isAdmin($employee_id);
        }

        public static function userConnectedIsGeneralSupervisor($objme=null)
        {
            if(!$objme) $objme = AfwSession::getUserConnected();
            if(!$objme) return 0;

            $employee_id = $objme->getEmployeeId();
            if(!$employee_id) return 0;

            return CrmEmployee::isGeneralAdmin($employee_id);
        }

        public static function userConnectedIsSuperAdmin($objme=null)
        {
                if(!$objme) $objme = AfwSession::getUserConnected();
                if(!$objme) return false;
                return $objme->isSuperAdmin();
        }*/

        public function fld_CREATION_USER_ID()
        {
                return "created_by";
        }
 
        public function fld_CREATION_DATE()
        {
                return "created_at";
        }
 
        public function fld_UPDATE_USER_ID()
        {
        	return "updated_by";
        }
 
        public function fld_UPDATE_DATE()
        {
        	return "updated_at";
        }
 
        public function fld_VALIDATION_USER_ID()
        {
        	return "validated_by";
        }
 
        public function fld_VALIDATION_DATE()
        {
                return "validated_at";
        }
 
        public function fld_VERSION()
        {
        	return "version";
        }
 
        public function fld_ACTIVE()
        {
        	return  "active";
        }
 
        public function isTechField($attribute) {
            return (($attribute=="created_by") or ($attribute=="created_at") or ($attribute=="updated_by") or ($attribute=="updated_at") or ($attribute=="validated_by") or ($attribute=="validated_at") or ($attribute=="version"));  
        }
	

        public function getTimeStampFromRow($row,$context="update", $timestamp_field="")
        {
                if(!$timestamp_field) return $row["synch_timestamp"];
                else return $row[$timestamp_field];
        }


        public static function code_of_training_period_enum($lkp_id=null)
        {
            global $lang;
            if($lkp_id) return self::training_period()['code'][$lkp_id];
            else return self::training_period()['code'];
        }

        public static function name_of_training_period_enum($training_period_enum, $lang="ar")
        {
            return self::training_period()[$lang][$training_period_enum];            
        }
        

        
        
        public static function list_of_training_period_enum()
        {
            global $lang;
            return self::training_period()[$lang];
        }
        
        public static function training_period()
        {
                $arr_list_of_training_period = array();
                
                        
                $arr_list_of_training_period["en"][1] = "Morning";
                $arr_list_of_training_period["ar"][1] = "صباحي";
                $arr_list_of_training_period["code"][1] = "Morning";

                $arr_list_of_training_period["en"][2] = "Evening";
                $arr_list_of_training_period["ar"][2] = "مسائي";
                $arr_list_of_training_period["code"][2] = "Evening";

                /*
                $arr_list_of_training_period["en"][3] = "Online";
                $arr_list_of_training_period["ar"][3] = "عن بعد";
                $arr_list_of_training_period["code"][3] = "Online";*/

                
                return $arr_list_of_training_period;
        } 

        public static function list_of_religion_enum()
        {
            global $lang;
            return self::religion_enum()[$lang];
        }
        
        public static function religion_enum()
        {
                $arr_list_of_religion_enum = array();
                
                        
                $arr_list_of_religion_enum["en"][1] = "Islam";
                $arr_list_of_religion_enum["ar"][1] = "الإسلام";
                $arr_list_of_religion_enum["code"][1] = "Islam";

                $arr_list_of_religion_enum["en"][2] = "People of book";
                $arr_list_of_religion_enum["ar"][2] = "أهل الكتاب";
                $arr_list_of_religion_enum["code"][2] = "Book";

                
                $arr_list_of_religion_enum["en"][3] = "Other religion";
                $arr_list_of_religion_enum["ar"][3] = "دين آخر";
                $arr_list_of_religion_enum["code"][3] = "Other";

                
                return $arr_list_of_religion_enum;
        }

        

        public static function list_of_marital_status_enum()
        {
            global $lang;
            return self::marital_status_enum()[$lang];
        }
        
        public static function marital_status_enum()
        {
                $arr_list_of_marital_status_enum = array();
                
                        
                $arr_list_of_marital_status_enum["en"][1] = "Single";
                $arr_list_of_marital_status_enum["ar"][1] = "أعزب - عزباء";
                $arr_list_of_marital_status_enum["code"][1] = "Single";

                $arr_list_of_marital_status_enum["en"][2] = "Married";
                $arr_list_of_marital_status_enum["ar"][2] = "متزوج(ة)";
                $arr_list_of_marital_status_enum["code"][2] = "Married";

                
                $arr_list_of_marital_status_enum["en"][3] = "Widow";
                $arr_list_of_marital_status_enum["ar"][3] = "أرملة";
                $arr_list_of_marital_status_enum["code"][3] = "Widow";
                
                $arr_list_of_marital_status_enum["en"][4] = "Divorced";
                $arr_list_of_marital_status_enum["ar"][4] = "مطلقة";
                $arr_list_of_marital_status_enum["code"][4] = "Divorced";

                
                return $arr_list_of_marital_status_enum;
        }

        public static function list_of_address_type_enum()
        {
            global $lang;
            return self::address_type_enum()[$lang];
        }
        
        public static function address_type_enum()
        {
                $arr_list_of_address_type_enum = array();
                
                $arr_list_of_address_type_enum["en"][1] = "National Address";
                $arr_list_of_address_type_enum["ar"][1] = "العنوان الوطني";
                $arr_list_of_address_type_enum["code"][1] = "NA";
                        
                $arr_list_of_address_type_enum["en"][2] = "Parent Address";
                $arr_list_of_address_type_enum["ar"][2] = "ولي الامر";
                $arr_list_of_address_type_enum["code"][2] = "PA";

                $arr_list_of_address_type_enum["en"][3] = "Work Address";
                $arr_list_of_address_type_enum["ar"][3] = "عنوان العمل";
                $arr_list_of_address_type_enum["code"][3] = "BU";

                
                $arr_list_of_address_type_enum["en"][4] = "Permanent Address";
                $arr_list_of_address_type_enum["ar"][4] = "دائمة";
                $arr_list_of_address_type_enum["code"][4] = "PR";

                $arr_list_of_address_type_enum["en"][4] = "Billing Address";
                $arr_list_of_address_type_enum["ar"][4] = "اصدار الفواتير";
                $arr_list_of_address_type_enum["code"][4] = "BI";

                
                return $arr_list_of_address_type_enum;
        }

        public static function list_of_employer_enum()
        {
            global $lang;
            return self::employer_enum()[$lang];
        }
        
        public static function employer_enum()
        {
                $arr_list_of_employer_enum = array();
                
                $arr_list_of_employer_enum["en"][1] = "Government sector";
                $arr_list_of_employer_enum["ar"][1] = "قطاع حكومي";
                $arr_list_of_employer_enum["code"][1] = "Government";
                        
                $arr_list_of_employer_enum["en"][2] = "Private sector";
                $arr_list_of_employer_enum["ar"][2] = "قطاع خاص";
                $arr_list_of_employer_enum["code"][2] = "Private";

                return $arr_list_of_employer_enum;
        }

        public static function list_of_relationship_enum()
        {
            global $lang;
            return self::relationship_enum()[$lang];
        }
        
        public static function relationship_enum()
        {
                $arr_list_of_relationship_enum = array();
                
                $arr_list_of_relationship_enum["en"][1] = "Parent";
                $arr_list_of_relationship_enum["ar"][1] = "والد(ة)";
                $arr_list_of_relationship_enum["code"][1] = "P";
                        
                $arr_list_of_relationship_enum["en"][2] = "Hasband/wife";
                $arr_list_of_relationship_enum["ar"][2] = "زوج(ة)";
                $arr_list_of_relationship_enum["code"][2] = "H";

                $arr_list_of_relationship_enum["en"][3] = "Friend";
                $arr_list_of_relationship_enum["ar"][3] = "صديق";
                $arr_list_of_relationship_enum["code"][3] = "F";

                
                $arr_list_of_relationship_enum["en"][4] = "Son";
                $arr_list_of_relationship_enum["ar"][4] = "الابن";
                $arr_list_of_relationship_enum["code"][4] = "S";

                $arr_list_of_relationship_enum["en"][5] = "Brother/Sister";
                $arr_list_of_relationship_enum["ar"][5] = "الاخ-ت";
                $arr_list_of_relationship_enum["code"][5] = "B";

                $arr_list_of_relationship_enum["en"][6] = "Grandpa";
                $arr_list_of_relationship_enum["ar"][6] = "الجد";
                $arr_list_of_relationship_enum["code"][6] = "G";

                $arr_list_of_relationship_enum["en"][7] = "Neighbor";
                $arr_list_of_relationship_enum["ar"][7] = "الجار";
                $arr_list_of_relationship_enum["code"][7] = "N";

                $arr_list_of_relationship_enum["en"][8] = "Guardian";
                $arr_list_of_relationship_enum["ar"][8] = "ولي الامر";
                $arr_list_of_relationship_enum["code"][8] = "G";

                
                return $arr_list_of_relationship_enum;
        }



        public static function code_of_language_enum($lkp_id=null)
        {
            global $lang;
            if($lkp_id) return self::language()['code'][$lkp_id];
            else return self::language()['code'];
        }

        

        
        
        
        public static function list_of_language_enum()
        {
            global $lang;
            return self::language()[$lang];
        }
        
        public static function language()
        {
                $arr_list_of_language = array();
                
                
                $arr_list_of_language["en"][1] = "Arabic";
                $arr_list_of_language["ar"][1] = "العربية";
                $arr_list_of_language["code"][1] = "ar";

                $arr_list_of_language["en"][2] = "English";
                $arr_list_of_language["ar"][2] = "الإنجليزية";
                $arr_list_of_language["code"][2] = "en";

                
                
                
                return $arr_list_of_language;
        } 


        

        
        public static function list_of_level_enum()
        {
            global $lang;
            return self::level()[$lang];
        }
        
        public static function level()
        {
                $arr_list_of_level = array();

                $main_company = AfwSession::config("main_company","all");
                $file_dir_name = dirname(__FILE__);        
                include($file_dir_name."/../extra/qualification_level-$main_company.php");

                foreach($lookup as $id => $lookup_row)
                {
                    $arr_list_of_level["ar"][$id] = $lookup_row["ar"];
                    $arr_list_of_level["en"][$id] = $lookup_row["en"];
                }

                
                return $arr_list_of_level;
        }


        public static function list_of_job_status_enum()
        {
            global $lang;
            return self::job_status()[$lang];
        }
        
        public static function job_status()
        {
                $arr_list_of_job_status = array();
                
                
                $arr_list_of_job_status["en"][1] = "Employee";
                $arr_list_of_job_status["ar"][1] = "موظف";
                $arr_list_of_job_status["code"][1] = "E";

                $arr_list_of_job_status["en"][2] = "Not Employee";
                $arr_list_of_job_status["ar"][2] = "غير موظف";
                $arr_list_of_job_status["code"][2] = "N";

                
                return $arr_list_of_job_status;
        }


        public static function list_of_genre_enum()
        {
            global $lang;
            return self::genre()[$lang];
        }
        
        public static function genre()
        {
                $arr_list_of_gender = array();
                
                
                $arr_list_of_gender["en"][1] = "Male";
                $arr_list_of_gender["ar"][1] = "بنين";
                $arr_list_of_gender["code"][1] = "M";

                $arr_list_of_gender["en"][2] = "Female";
                $arr_list_of_gender["ar"][2] = "بنات";
                $arr_list_of_gender["code"][2] = "F";

                
                return $arr_list_of_gender;
        }


        public static function list_of_gender_enum()
        {
            global $lang;
            return self::gender()[$lang];
        }
        
        public static function gender()
        {
                $arr_list_of_gender = array();
                
                
                $arr_list_of_gender["en"][1] = "Male";
                $arr_list_of_gender["ar"][1] = "بنين";
                $arr_list_of_gender["code"][1] = "M";

                $arr_list_of_gender["en"][2] = "Female";
                $arr_list_of_gender["ar"][2] = "بنات";
                $arr_list_of_gender["code"][2] = "F";

                $arr_list_of_gender["en"][4] = "Mixed";
                $arr_list_of_gender["ar"][4] = "بنين وبنات";
                $arr_list_of_gender["code"][4] = "X";

                
                
                
                return $arr_list_of_gender;
        }

        public static function list_of_genders_enum()
        {
            global $lang;
            return self::genders()[$lang];
        }
        
        public static function genders()
        {
                $arr_list_of_genders = array();
                
                
                $arr_list_of_genders["en"][1] = "Male";
                $arr_list_of_genders["ar"][1] = "البنين";
                $arr_list_of_genders["code"][1] = "M";

                $arr_list_of_genders["en"][2] = "Female";
                $arr_list_of_genders["ar"][2] = "البنات";
                $arr_list_of_genders["code"][2] = "F";

                $arr_list_of_genders["en"][3] = "Male & Female";
                $arr_list_of_genders["ar"][3] = "البنين و البنات";
                $arr_list_of_genders["code"][3] = "MF";

                
                
                
                return $arr_list_of_genders;
        }


        public static function list_of_training_mode_enum()
        {
            global $lang;
            return self::training_mode()[$lang];
        }
        
        public static function training_mode()
        {
                $arr_list_of_training_mode = array();
                
                
                $arr_list_of_training_mode["en"][1] = "Presence";
                $arr_list_of_training_mode["ar"][1] = "حضوري";
                $arr_list_of_training_mode["code"][1] = "P";

                $arr_list_of_training_mode["en"][2] = "Online";
                $arr_list_of_training_mode["ar"][2] = "عن بعد";
                $arr_list_of_training_mode["code"][2] = "O";

                $arr_list_of_training_mode["en"][3] = "Mixed";
                $arr_list_of_training_mode["ar"][3] = "مدمج";
                $arr_list_of_training_mode["code"][3] = "X";

                
                return $arr_list_of_training_mode;
        }


        

        public static function code_of_term_mode_enum($lkp_id=null)
        {
            global $lang;
            if($lkp_id) return self::term_mode()['code'][$lkp_id];
            else return self::term_mode()['code'];
        }
        
        
        public static function list_of_term_mode_enum()
        {
            global $lang;
            return self::term_mode()[$lang];
        }
        
        public static function term_mode()
        {
                $arr_list_of_term_mode = array();
                
                $arr_list_of_term_mode["en"]  [1] = "Annual";
                $arr_list_of_term_mode["ar"]  [1] = "سنوي";
                $arr_list_of_term_mode["code"][1] = "";

                $arr_list_of_term_mode["en"]  [2] = "Semester";
                $arr_list_of_term_mode["ar"]  [2] = "نصفي";
                $arr_list_of_term_mode["code"][2] = "";

                $arr_list_of_term_mode["en"]  [3] = "Trimester";
                $arr_list_of_term_mode["ar"]  [3] = "ثلثي";
                $arr_list_of_term_mode["code"][3] = "";

                $arr_list_of_term_mode["en"]  [4] = "Quarter";
                $arr_list_of_term_mode["ar"]  [4] = "ربعي";
                $arr_list_of_term_mode["code"][4] = "";

                
                
                
                return $arr_list_of_term_mode;
        } 

        

        public static function executeIndicator($object, $indicator, $normal_class, $arrObjectsRelated, $sens="asc", $default_red_pct=0, $default_orange_pct=0)
        {
                global $MODE_SQL_PROCESS_LOURD, $nb_queries_executed;
                $old_nb_queries_executed = $nb_queries_executed;
                $old_MODE_SQL_PROCESS_LOURD = $MODE_SQL_PROCESS_LOURD;
                $MODE_SQL_PROCESS_LOURD = true;

                if(!$normal_class) $normal_class="vert";
                $methodIndicator = "get".$indicator."Indicator";
                list($objective, $value) = $object->$methodIndicator($arrObjectsRelated);

                $objective_red_pct = $object->getVal(strtolower($indicator)."_red_pct");
                if(!$objective_red_pct) $objective_red_pct = $default_red_pct;
                if(!$objective_red_pct) $objective_red_pct = ($sens=="asc") ? 80.0 : 120.0;
                
                $objective_red = $objective_red_pct * $objective / 100.0;
                
                $orange_pct = $object->getVal("orange_pct");
                
                if(!$orange_pct) $orange_pct = $default_orange_pct;
                if(!$orange_pct) $orange_pct = ($sens=="asc") ? 90.0 : 110.0; // %
                $objective_orange_pct = round($objective_red_pct * 100.0 / $orange_pct);
                $objective_orange = $objective_orange_pct * $objective / 100.0;

                if(($sens=="asc"))
                {
                        if($value<$objective_red) $value_class = "$indicator rouge";
                        elseif($value<$objective_orange) $value_class = "orange";
                        else $value_class = $normal_class;
                }
                else
                {
                        if($value>$objective_red) $value_class = "$indicator rouge";
                        elseif($value>$objective_orange) $value_class = "orange";
                        else $value_class = $normal_class;
                }

                $MODE_SQL_PROCESS_LOURD = $old_MODE_SQL_PROCESS_LOURD;
                $nb_queries_executed = $old_nb_queries_executed;
                

                // die("$objective, $value, $value_class, $objective_red, $objective_orange");
                return [$objective, $value, $value_class, $objective_red, $objective_orange];

        }


        public function calcHijri_current()
        {
            return AfwDateHelper::currentHijriDate();
        } 

}