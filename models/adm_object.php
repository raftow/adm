<?php

class AdmObject extends AfwMomkenObject{

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


        /*

        public static function list_of_qualification_track_enum()
        {
            global $lang;
            return self::qualification_track()[$lang];
        }

        
        public static function qualification_track()
        {
                $arr_list_of_qualification_track = array();
                
                        
                $arr_list_of_qualification_track["en"][1] = "literary";
                $arr_list_of_qualification_track["ar"][1] = "أدبي";
                $arr_list_of_qualification_track["code"][1] = "literary";

                $arr_list_of_qualification_track["en"][2] = "";
                $arr_list_of_qualification_track["ar"][2] = "علمي";
                $arr_list_of_qualification_track["code"][2] = "Book";

                return $arr_list_of_qualification_track;
        } */




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







        public static function list_of_application_status_enum()
        {
            global $lang;
            return self::application_status_enum()[$lang];
        }
        
        public static function application_status_enum()
        {
                $arr_list_of_application_status_enum = array();
                
                        
                $arr_list_of_application_status_enum["en"][1] = "application pending";
                $arr_list_of_application_status_enum["ar"][1] = "جاري التقديم";

                $arr_list_of_application_status_enum["en"][2] = "applied";
                $arr_list_of_application_status_enum["ar"][2] = "متقدم";
                
                $arr_list_of_application_status_enum["en"][3] = "withdrawn";
                $arr_list_of_application_status_enum["ar"][3] = "منسحب";

                $arr_list_of_application_status_enum["en"][4] = "excluded";
                $arr_list_of_application_status_enum["ar"][4] = "مستبعد";
                
                return $arr_list_of_application_status_enum;
        }

        public static function list_of_desire_status_enum()
        {
            global $lang;
            return self::desire_status_enum()[$lang];
        }
        
        public static function desire_status_enum()
        {
                $arr_list_of_application_status_enum = array();
                
                        
                $arr_list_of_desire_status_enum["en"][1] = "candidate";
                $arr_list_of_desire_status_enum["ar"][1] = "مترشح";
                $arr_list_of_desire_status_enum["code"][1] = "candidate";
                                                       
                $arr_list_of_desire_status_enum["en"][2] = "initial acceptance";
                $arr_list_of_desire_status_enum["ar"][2] = "قبول مبدئي";
                $arr_list_of_desire_status_enum["code"][2] = "initial-acceptance";
                                                       
                $arr_list_of_desire_status_enum["en"][3] = "final acceptance";
                $arr_list_of_desire_status_enum["ar"][3] = "قبول نهائي";
                $arr_list_of_desire_status_enum["code"][3] = "final-acceptance";
                                                       
                $arr_list_of_desire_status_enum["en"][4] = "withdrawn";
                $arr_list_of_desire_status_enum["ar"][4] = "منسحب";
                $arr_list_of_desire_status_enum["code"][4] = "withdrawn";
                                                       
                $arr_list_of_desire_status_enum["en"][5] = "rejected";
                $arr_list_of_desire_status_enum["ar"][5] = "مرفوض";
                $arr_list_of_desire_status_enum["code"][5] = "rejected";
                                                       
                $arr_list_of_desire_status_enum["en"][6] = "data review";
                $arr_list_of_desire_status_enum["ar"][6] = "مراجعة البيانات";
                $arr_list_of_desire_status_enum["code"][6] = "data-review";

                $arr_list_of_desire_status_enum["en"][7] = "excluded";
                $arr_list_of_desire_status_enum["ar"][7] = "مستبعد";
                $arr_list_of_desire_status_enum["code"][7] = "excluded";
                
                
                return $arr_list_of_desire_status_enum;
        }
        
        public static function desire_status_enum_by_code($the_code=null)        
        {
            $result = [];
            $arr = self::desire_status_enum();
            foreach($arr['code'] as $eid => $code)
            {
                if($the_code and ($the_code==$code)) return $eid;
                elseif(!$the_code) $result[$code] = $eid;
            }


            if($the_code) return 0;
            else return $result;
        }





        public static function list_of_application_admission_enum()
        {
            global $lang;
            return self::application_admission_enum()[$lang];
        }
        
        public static function application_admission_enum()
        {
                $arr_list_of_application_admission_enum = array();
                
                        
                $arr_list_of_application_admission_enum["en"][1] = "Application";
                $arr_list_of_application_admission_enum["ar"][1] = "تقديم";
                $arr_list_of_application_admission_enum["code"][1] = "APP";

                $arr_list_of_application_admission_enum["en"][2] = "Admission";
                $arr_list_of_application_admission_enum["ar"][2] = "قبول";
                $arr_list_of_application_admission_enum["code"][2] = "ADM";

                
                return $arr_list_of_application_admission_enum;
        }

        







        public static function list_of_agreement_scope_type_enum()
        {
            global $lang;
            return self::agreement_scope_type_enum()[$lang];
        }
        
        public static function agreement_scope_type_enum()
        {
                $arr_list_of_agreement_scope_type_enum = array();
                
                        
                $arr_list_of_agreement_scope_type_enum["en"][1] = "general";
                $arr_list_of_agreement_scope_type_enum["ar"][1] = "عام";
                
                $arr_list_of_agreement_scope_type_enum["en"][2] = "private";
                $arr_list_of_agreement_scope_type_enum["ar"][2] = "خاص";
                
                
                
                return $arr_list_of_agreement_scope_type_enum;
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


        


        public static function list_of_gender_enum()
        {
            global $lang;
            return self::gender()[$lang];
        }
        
        public static function gender()
        {
                $arr_list_of_gender = array();
                
                
                $arr_list_of_gender["en"][1] = "Male Students";
                $arr_list_of_gender["ar"][1] = "طلاب";
                $arr_list_of_gender["code"][1] = "M";

                $arr_list_of_gender["en"][2] = "Female Students";
                $arr_list_of_gender["ar"][2] = "طالبات";
                $arr_list_of_gender["code"][2] = "F";

                $arr_list_of_gender["en"][4] = "Male & Female Students";
                $arr_list_of_gender["ar"][4] = "طلاب وطالبات";
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
                $arr_list_of_genders["ar"][1] = "الطلاب";
                $arr_list_of_genders["code"][1] = "M";

                $arr_list_of_genders["en"][2] = "Female";
                $arr_list_of_genders["ar"][2] = "الطالبات";
                $arr_list_of_genders["code"][2] = "F";

                $arr_list_of_genders["en"][3] = "Male & Female";
                $arr_list_of_genders["ar"][3] = "الطلاب و الطالبات";
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

        public static function list_of_lor_status_enum()
        {
            global $lang;
            return self::lor_status()[$lang];
        }
        
        public static function lor_status()
        {
                $arr_list_of_training_mode = array();
                
                
                $arr_list_of_training_mode["en"][1] = "For review";
                $arr_list_of_training_mode["ar"][1] = "للمراجعة";
                
                $arr_list_of_training_mode["en"][2] = "Rejected";
                $arr_list_of_training_mode["ar"][2] = "مرفوضة";
                
                $arr_list_of_training_mode["en"][3] = "Approved";
                $arr_list_of_training_mode["ar"][3] = "معتمدة";
                
                $arr_list_of_training_mode["en"][4] = "Under review";
                $arr_list_of_training_mode["ar"][4] = "قيد المراجعة";
                
                return $arr_list_of_training_mode;
        }

        
        public static function list_of_notification_type_enum()
        {
            global $lang;
            return self::notification_type()[$lang];
        }
        
        public static function notification_type()
        {
                $arr_list_of_training_mode = array();
                
                
                $arr_list_of_training_mode["en"][1] = "email";
                $arr_list_of_training_mode["ar"][1] = "بريد الكتروني";
                
                $arr_list_of_training_mode["en"][2] = "sms";
                $arr_list_of_training_mode["ar"][2] = "رسالة نصية";
                
                $arr_list_of_training_mode["en"][3] = "phone call";
                $arr_list_of_training_mode["ar"][3] = "اتصال هاتفي";
                
                $arr_list_of_training_mode["en"][4] = "direct contact";
                $arr_list_of_training_mode["ar"][4] = "اتصال مباشر";
                
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

        public static function list_of_afield_set_enum()
        {
            global $lang;
            return self::afield_set()[$lang];
        }
        
        public static function afield_set()
        {
                $arr_list_of_afield_set = array();
                
                $arr_list_of_afield_set["en"]  [1] = "";
                $arr_list_of_afield_set["ar"]  [1] = "نتائج الإختبارت";
                $arr_list_of_afield_set["code"][1] = "1";

                $arr_list_of_afield_set["en"]  [2] = "";
                $arr_list_of_afield_set["ar"]  [2] = "الحصول على الشهادات العلمية";
                $arr_list_of_afield_set["code"][2] = "2";

                $arr_list_of_afield_set["en"]  [3] = "";
                $arr_list_of_afield_set["ar"]  [3] = "معدلات الشهادات العلمية";
                $arr_list_of_afield_set["code"][3] = "3";

                $arr_list_of_afield_set["en"]  [4] = "";
                $arr_list_of_afield_set["ar"]  [4] = "تواريخ الشهادات العلمية";
                $arr_list_of_afield_set["code"][4] = "4";
                
                $arr_list_of_afield_set["en"]  [5] = "";
                $arr_list_of_afield_set["ar"]  [5] = "درجات في اختبار أو مؤهل علمي";
                $arr_list_of_afield_set["code"][5] = "5";
                
                
                
                return $arr_list_of_afield_set;
        } 



        

        public static function list_of_entry_type_enum()
        {
            global $lang;
            return self::entry_type()[$lang];
        }
        
        public static function entry_type()
        {
                $arr_list_of_entry_type = array();
                
                $arr_list_of_entry_type["en"]  [1] = "Manual";
                $arr_list_of_entry_type["ar"]  [1] = "يدويا";
                $arr_list_of_entry_type["code"][1] = "";

                $arr_list_of_entry_type["en"]  [2] = "API";
                $arr_list_of_entry_type["ar"]  [2] = "واجهة برمجة التطبيقات";
                $arr_list_of_entry_type["code"][2] = "";

                $arr_list_of_entry_type["en"]  [3] = "Semi-Automatic";
                $arr_list_of_entry_type["ar"]  [3] = "آلي/يدوي";
                $arr_list_of_entry_type["code"][3] = "";

                $arr_list_of_entry_type["en"]  [4] = "Computed";
                $arr_list_of_entry_type["ar"]  [4] = "محسوب غير مدخل";
                $arr_list_of_entry_type["code"][4] = "";
                
                $arr_list_of_entry_type["en"]  [5] = "Web service";
                $arr_list_of_entry_type["ar"]  [5] = "خدمة واب";
                $arr_list_of_entry_type["code"][5] = "";
                
                
                
                return $arr_list_of_entry_type;
        } 
        
        public static function list_of_payment_status_enum()
        {
            global $lang;
            return self::payment_status()[$lang];
        }
        
        public static function payment_status()
        {
                $arr_list_of_Payment_Status = array();
                
                $arr_list_of_Payment_Status["en"]  [1] = "Not Paid";
                $arr_list_of_Payment_Status["ar"]  [1] = "غير مدفوع";
                $arr_list_of_Payment_Status["code"][1] = "";

                $arr_list_of_Payment_Status["en"]  [2] = "Totally Paid";
                $arr_list_of_Payment_Status["ar"]  [2] = "تم الدفع كليا";
                $arr_list_of_Payment_Status["code"][2] = "";

                $arr_list_of_Payment_Status["en"]  [3] = "Partially Paid";
                $arr_list_of_Payment_Status["ar"]  [3] = "تم الدفع جزئيا";
                $arr_list_of_Payment_Status["code"][3] = "";

                $arr_list_of_Payment_Status["en"]  [4] = "Exempt from payment";
                $arr_list_of_Payment_Status["ar"]  [4] = "معفي من الدفع";
                $arr_list_of_Payment_Status["code"][4] = "";
                
                
                
                
                return $arr_list_of_Payment_Status;
        }
        public static function list_of_payment_method_enum()
        {
            global $lang;
            return self::payment_method()[$lang];
        }
        
        public static function payment_method()
        {
                $arr_list_of_payment_method = array();
                
                $arr_list_of_payment_method["en"]  [1] = "Electronic payment";
                $arr_list_of_payment_method["ar"]  [1] = "دفع الكتروني";
                $arr_list_of_payment_method["code"][1] = "";

                $arr_list_of_payment_method["en"]  [2] = "Sadadd";
                $arr_list_of_payment_method["ar"]  [2] = "سداد";
                $arr_list_of_payment_method["code"][2] = "";

                $arr_list_of_payment_method["en"]  [3] = "Cash";
                $arr_list_of_payment_method["ar"]  [3] = "نقدا";
                $arr_list_of_payment_method["code"][3] = "";
                
                
                
                
                return $arr_list_of_payment_method;
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

        public static function list_of_application_table_id()
        {
            global $lang;
            return self::application_table()[$lang];
        }
        
        public static function application_table()
        {
                $arr_list_of_application_table = array();

                $arr_list_of_application_table["ar"][1] = "المتقدمون";
                $arr_list_of_application_table["en"][1] = "Applicants";
                $arr_list_of_application_table["code"][1] = "applicant";

                $arr_list_of_application_table["ar"][2] = "رغبات المتقدم";
                $arr_list_of_application_table["en"][2] = "Applicant desires";
                $arr_list_of_application_table["code"][2] = "adesire";

                $arr_list_of_application_table["ar"][3] = "طلبات التقديم";
                $arr_list_of_application_table["en"][3] = "Applications";
                $arr_list_of_application_table["code"][3] = "application";



                return $arr_list_of_application_table;
        }


        
        
        public static function answer_table()
        {
                $arr_list_of_answer_table = array();

                $arr_list_of_answer_table["ar"][1] = "أنواع الهويات";
                $arr_list_of_answer_table["en"][1] = "identity type";
                $arr_list_of_answer_table["code"][1] = "identity_type";
                $arr_list_of_answer_table["module"][1] = "adm";
                
                /*
                $arr_list_of_answer_table["ar"][2] = "xxxx";
                $arr_list_of_answer_table["en"][2] = "xxxx xxxx";
                $arr_list_of_answer_table["code"][2] = "xxxx";*/


                return $arr_list_of_answer_table;
        }

        public static function list_of_financial_element_unit_enum()
        {
            global $lang;
            return self::financial_element_unit()[$lang];
        }
        
        public static function financial_element_unit()
        {
                $arr_list_of_unit = array();
                
                
                $arr_list_of_unit["en"][1] = "credit hours";
                $arr_list_of_unit["ar"][1] = "الساعة المعتمدة";
                
                $arr_list_of_unit["en"][2] = "courses";
                $arr_list_of_unit["ar"][2] = "المقرر";
                
                $arr_list_of_unit["en"][3] = "terms";
                $arr_list_of_unit["ar"][3] = "الفصل الدراسي";
                
                $arr_list_of_unit["en"][4] = "one-time payment";
                $arr_list_of_unit["ar"][5] = "الدفع مرة واحدة";

                
                return $arr_list_of_unit;
        }

        public function calcHijri_current()
        {
            return AfwDateHelper::currentHijriDate();
        } 


        public static function needUpdateIcon($help)
        {
            return "<img data-toggle='tooltip' data-placement='top' title='$help' width='32' height='32' src=\"pic/need-update.png\" alt=\"\" title=\"\">";
        }

        public static function updatedIcon($help)
        {
            return "<img data-toggle='tooltip' data-placement='top' title='$help' width='32' height='32' src=\"pic/updated.png\" alt=\"\" title=\"\">";
        }

        public function getCssClassName()
        {
            return $this->getTableName();
        }

}