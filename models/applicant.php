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
?>