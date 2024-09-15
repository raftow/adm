<?php
        $main_company = AfwSession::config("main_company","all");
        $file_dir_name = dirname(__FILE__);        
        require_once($file_dir_name."/../extra/applicant_additional_fields-$main_company.php");

        class Applicant extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "applicant"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("applicant","id","adm");
                        AdmApplicantAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new Applicant();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
                }

                public function getDisplay($lang = 'ar')
                {
                        return $this->getDefaultDisplay($lang);
                }

                public function stepsAreOrdered()
                {
                        return false;
                }

                

                public static function getAdditionalFieldParams($field_name)
                {
                    global $additional_fields;
                    if(!$additional_fields)
                    {
                        $main_company = AfwSession::config("main_company","all");
                        $file_dir_name = dirname(__FILE__);        
                        require_once($file_dir_name."/../extra/applicant_additional_fields-$main_company.php");
                    }

                    $return = $additional_fields[$field_name];

                    //if(!$return) die("no params for getAdditionalFieldParams($field_name) look additional_fields[$field_name] in additional_fields=".var_export($additional_fields,true));

                    return $return;
                }


                public function additional($field_name, $col_struct)
                {
                    $params = self::getAdditionalFieldParams($field_name);

                    $col_struct = strtolower($col_struct);
                    if($col_struct=="mandatory") return (!$params["optional"]);
                    if($col_struct=="required") return (!$params["optional"]);

                    if($col_struct=="css")
                    {
                        if(!$params["css"]) $params["css"] = 'width_pct_50';
                    } 
                    

                    if($col_struct=="step") 
                    {
                        $step =  $params["step"]+5;
                        //if($col_struct=="step" and $field_name=="attribute_1") throw new AfwRuntimeException("step additional for $field_name =".$step);
                        return $step;
                    }

                    $return = $params[$col_struct];
                    if($col_struct=="css")
                    {
                        // if($field_name=="attribute_18") throw new AfwRuntimeException("css additional for $field_name params=".var_export($params,true)." return=".$return);
                    }
                    

                    //if($col_struct=="fgroup" and $return == "") throw new AfwRuntimeException("fgroup additional return = $return params=".var_export($params,true));

                    //if(!$return) die("no param for additional($field_name, $col_struct) params=".var_export($params,true));

                    return $return;
                }


                protected function paggableAttribute($attribute)
                {
                    if(AfwStringHelper::stringStartsWith($attribute,"attribute_"))
                    {
                        $params = self::getAdditionalFieldParams($attribute);
                        if(!$params)
                        {
                            return [false, "no params defined for this additional attribute"];
                        }
                    }
                    // can be overridden in subclasses
                    return [true, ""];
                }


                public function getAttributeLabel($attribute, $lang = 'ar', $short = false)
                {
                    if(AfwStringHelper::stringStartsWith($attribute,"attribute_"))
                    {
                        $params = self::getAdditionalFieldParams($attribute);
                        if($params)
                        {
                            $return = $params["title_$lang"];
                            if($return) return $return;
                        }
                    }
                    // die("calling getAttributeLabel($attribute, $lang, short=$short)");
                    return AfwLanguageHelper::getAttributeTranslation($this, $attribute, $lang, $short);
                }

                public function myShortNameToAttributeName($attribute)
                {
                    global $additional_fields;
                    if(!$additional_fields)
                    {
                        $main_company = AfwSession::config("main_company","all");
                        $file_dir_name = dirname(__FILE__);        
                        require_once($file_dir_name."/../extra/applicant_additional_fields-$main_company.php");
                    }

                    if($additional_fields)
                    {
                        foreach($additional_fields as $attribute_reel => $paramAF)
                        {
                            $field_code = strtolower($paramAF["field_code"]);
                            if($field_code==$attribute) return $attribute_reel;
                        }
                    }

                    return $attribute;
                }

                protected function getOtherLinksArray($mode,$genereLog=false,$step="all")      
                {
                    global $lang;
                    // $objme = AfwSession::getUserConnected();
                    // $me = ($objme) ? $objme->id : 0;

                    $otherLinksArray = $this->getOtherLinksArrayStandard($mode,$genereLog,$step);
                    $my_id = $this->getId();
                    $displ = $this->getDisplay($lang);
                    
                    if($mode=="mode_applicantQualificationList")
                    {
                        unset($link);
                        $link = array();
                        $title = "إضافة مؤهل جديد";
                        $title_detailed = $title ."لـ : ". $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=ApplicantQualification&currmod=adm&sel_applicant_id=$my_id";
                        $link["TITLE"] = $title;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                    }
                    
                    
                    
                    // check errors on all steps (by default no for optimization)
                    // rafik don't know why this : \//  = false;
                    
                    return $otherLinksArray;
                }

        }
/*
INSERT INTO `applicant` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `email`, `mobile`, `country_id`, `idn_type_id`, `idn`, `id_issue_place`, `id_issue_date`, `id_expiry_date`, `religion_enum`, `gender_enum`, `mother_saudi_ind`, `mother_idn`, `mother_birth_date`, `passeport_num`, `passeport_expiry_gdate`, `first_name_ar`, `father_name_ar`, `middle_name_ar`, `last_name_ar`, `first_name_en`, `father_name_en`, `middle_name_en`, `last_name_en`, `birth_date`, `birth_gdate`, `place_of_birth`, `marital_status_enum`, `profile_approved`, `address_type_enum`, `address`, `city_id`, `postal_code`, `country_code`, `username`, `password`, `signup_acknowldgment`, `has_iban`, `iban`, `bank_account_pledge`, `job_status_enum`, `employer_approval`, `employer_enum`, `employer_approval_afile_id`, `guardian_name`, `guardian_phone`, `guardian_idn`, `guardian_id_date`, `guardian_id_place`, `relationship_enum`, `attribute_1`, `attribute_2`, `attribute_3`, `attribute_4`, `attribute_5`, `attribute_6`, `attribute_8`, `attribute_9`, `attribute_11`, `attribute_12`, `attribute_13`, `attribute_14`, `attribute_15`, `attribute_16`, `attribute_17`, `attribute_18`, `attribute_19`, `attribute_20`, `attribute_21`, `attribute_22`, `attribute_23`, `attribute_24`, `attribute_25`, `attribute_26`, `attribute_27`, `attribute_28`, `attribute_29`, `attribute_30`, `attribute_31`, `attribute_32`, `attribute_33`, `attribute_34`, `attribute_35`, `attribute_36`, `attribute_37`) VALUES
(1, 1, '2024-05-21 15:25:28', 1, '2024-07-22 12:06:58', 0, NULL, 'Y', 'Y', 10, NULL, NULL, NULL, 0, 'rafiq.boubaker@gmail.com', '0598988330', 213, 2, '2340182555', 'الرياض', '2024-05-15 00:00:00', '2025-05-14 00:00:00', 1, 1, 'N', NULL, NULL, 'AS001235', '2028-05-11 00:00:00', 'رفيق', 'محمد نورالدين', 'بوبكر', 'بوبكر', 'Rafik', 'Med Noureddine', 'Boubaker', 'BOUBAKER', '13950118', '1973-09-13 00:00:00', 'بازمة - قبلي', 2, 'N', 1, 'شارع الأنشاء 6606', 301, '1005', 'Saudi Arab', 'rboubaker', NULL, 'W', 'N', NULL, 'N', 2, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1000994556, 0, '2024-09-01 12:18:55', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 1112968, NULL, NULL, 183, 1, '1000994556', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, '', NULL, 'شاكر', 'كاسب', 'بن سماح', 'الحسني العنزي', 'SHAKER', 'KASEB', 'S', 'ALANIZY', '14010516', '1981-03-22 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1003035910, 0, '2024-09-01 12:25:38', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 1160878, NULL, NULL, 183, 1, '1003035910', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, '', NULL, 'جميل بن', 'عدال بن', 'شمروخ', 'الرقاص العتيبي', 'JAMEEL', 'ADDAL', 'S', 'ALOTAIBI', '14020929', '1982-07-20 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1003311162, 0, '2024-09-01 12:30:40', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 1481400, NULL, NULL, 183, 1, '1003311162', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, '', NULL, 'بكر', 'بن ابراهيم', 'بن عثمان', 'بن حسن هوساوي', 'BAKR', 'IBRAHIM', 'O', 'HAWSAWI', '14020116', '1981-11-12 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1010066577, 0, '2024-09-01 12:26:36', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 1201322, NULL, NULL, 183, 1, '1010066577', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, '', NULL, 'عايض', 'مفرح', 'بن سعد', 'الرياحي البقمي', 'AYEDH', 'MOFAREH', 'SAAD', 'ALRYAHI ALBOGAMI', '14040320', '1983-12-24 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1011896691, 0, '2024-09-01 12:33:01', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 1626304, NULL, NULL, 183, 1, '1011896691', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, '', NULL, 'عبدالعزيز بن', 'عيسى بن', 'حبيب', 'السالم', 'ABDULAZIZ', 'ESSA', 'H', 'ALSALEM', '14050411', '1985-01-02 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1014361404, 0, '2024-09-01 12:31:22', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 1543060, NULL, NULL, 183, 1, '1014361404', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, '', NULL, 'مبارك', 'بن سليمان', 'بن مبارك', 'الظاهري الحربي', 'MUBARAK', 'SULAIMAN', 'MUBARAK', 'ALHARBI', '14021208', '1982-09-25 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1015295155, 0, '2024-09-01 12:31:58', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 1579452, NULL, NULL, 183, 1, '1015295155', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, '', NULL, 'خالد بن', 'عبد الله بن', 'علي', 'المطير', 'KHALED', 'ABDULLAH', 'A', 'ALMUTAIR', '13971114', '1977-10-26 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1015850520, 0, '2024-09-01 12:29:27', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 1418648, NULL, NULL, 183, 1, '1015850520', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, '', NULL, 'محمد بن', 'علي بن', 'عبدالله ظافري', 'حمدي', 'MOHAMMED', 'ALI', 'A', 'HAMDI', '14000701', '1980-05-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1016067116, 0, '2024-09-01 12:15:13', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 790224, NULL, NULL, 183, 1, '1016067116', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, 'G314431', NULL, 'عثمان ابن', 'علي ابن', 'عبدالمحسن', 'المحمد', 'OTHMAN', 'ALI', 'A', 'ALMOHAMMED', '14020813', '1982-06-05 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1016417568, 0, '2024-09-01 12:28:55', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 1372056, NULL, NULL, 183, 1, '1016417568', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, '', NULL, 'خالد', 'دوخي', 'مبارك', 'المانع الدوسري', 'KHALID', 'DOKHY', 'MOBARAK', 'AL-DOUSARI', '14041117', '1984-08-14 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1018199719, 0, '2024-09-01 12:26:03', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 1171104, NULL, NULL, 183, 1, '1018199719', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, '', NULL, 'منصور بن', 'عبدالله بن', 'خلوفه', 'الجميري الشهري', 'MANSOUR', 'ABDULLAH', 'K', 'ALSHEHRI', '14060407', '1985-12-19 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1022973240, 0, '2024-09-01 12:25:28', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 1151338, NULL, NULL, 183, 1, '1022973240', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, '', NULL, 'عبد المجيد بن', 'عبد الرحمن بن', 'يوسف', 'السويدان', 'ABDULMAJEED', 'ABDULRAHMAN', 'Y', 'ALSEWEDAN', '14050824', '1985-05-14 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1024509604, 0, '2024-09-01 12:33:12', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 1635510, NULL, NULL, 183, 1, '1024509604', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, '', NULL, 'طارق بن', 'خالد بن', 'عبداللطيف', 'الطعيمه', 'TARIQ', 'KHALID', 'A', 'ALTUAYMAH', '14041202', '1984-08-28 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1029397112, 0, '2024-09-01 12:26:58', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 1216524, NULL, NULL, 183, 1, '1029397112', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, '', NULL, 'سلطان بن', 'شقير بن', 'سند', 'العتيبي', 'SULTAN', 'SHQEER', 'S.', 'ALOTAIBI', '13860701', '1966-10-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1030910358, 0, '2024-09-01 12:29:53', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 1430010, NULL, NULL, 183, 1, '1030910358', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, '', NULL, 'سعد', 'حامد', 'احمد', 'المفضلي الزهراني', 'SAAD', 'HAMID', 'AHMED', 'AL-ZAHRANI', '14060107', '1985-09-21 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1033406602, 0, '2024-09-01 12:28:59', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 1374636, NULL, NULL, 183, 1, '1033406602', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, '', NULL, 'حسن بن', 'سعيد بن', 'علي العاصمي', 'المالكي', 'HASSAN', 'SAEED', 'A', 'ALMALKI', '13990701', '1979-05-27 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1035236890, 0, '2024-09-01 12:34:11', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 1673150, NULL, NULL, 183, 1, '1035236890', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, '', NULL, 'عبدالله', 'بن عبدالرحمن', 'بن عبدالمحسن', 'الروقي', 'ABDUALLAH', 'ABDULLRHMAN', 'A', 'ALRUQI', '13930701', '1973-07-30 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1036110953, 0, '2024-09-01 12:33:28', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 1639976, NULL, NULL, 183, 1, '1036110953', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, '', NULL, 'عبدالله بن', 'منصور بن', 'حسن سيار', 'المالكي', 'ABDULLAH', 'MANSOUR', 'H', 'ALMALKI', '14040402', '1984-01-05 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1037821616, 0, '2024-09-01 12:18:20', 0, '0000-00-00 00:00:00', NULL, NULL, 'Y', 'Y', NULL, NULL, NULL, NULL, 1063432, NULL, NULL, 183, 1, '1037821616', NULL, NULL, NULL, NULL, 1, '', NULL, NULL, '', NULL, 'حسن', 'جخدب', 'محمد', 'آل مطرف', '-', '-', '-', '-', '14020520', '1982-03-15 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

*/