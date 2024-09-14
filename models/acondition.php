<?php
// ------------------------------------------------------------------------------------
// 27/1/2023
// ALTER TABLE `acondition` CHANGE `acondition_order` `acondition_order` SMALLINT(6) NOT NULL DEFAULT '0'; 

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class Acondition extends AdmObject{

	public static $DATABASE		= ""; 
        public static $MODULE		    = "adm"; 
        public static $TABLE			= ""; 
        public static $DB_STRUCTURE = null; 


        private Acondition $cond1Obj = null;
        private Acondition $cond2Obj = null;
        private ApplicationField $afObj = null;
        private Aparameter $aparamObj = null;
        
        

        public function __construct(){
		parent::__construct("acondition","id","adm");
                AdmAconditionAfwStructure::initInstance($this);
	}

        public static function loadById($id)
        {
                $obj = new Acondition();
                
                if($obj->load($id))
                {
                        return $obj;
                }
                else return null;
        }
        
        public function getDisplay($lang="ar")
        {
               if($lang=="fr") $lang = "en";
               list($data,$link) = $this->displayAttribute("acondition_origin_id");
               $data2 = $this->getVal("acondition_name_$lang");
               //$data3 = $this->getVal("acondition_order");
               return $data." ← ".$data2;
        }

        public function getDropdownDisplay($lang="ar")
        {
               if($lang=="fr") $lang = "en";
               list($data,$link) = $this->displayAttribute("acondition_origin_id");
               $data2 = $this->getVal("acondition_name_$lang");
               // $data3 = $this->getVal("acondition_order");
               return $data." ← ".$data2;
        }

        public static function loadByMainIndex($acondition_origin_id,$acondition_order,$create_obj_if_not_found=false)
        {
           $obj = new Acondition();
           if(!$acondition_origin_id) throw new AfwRuntimeException("loadByMainIndex : acondition_origin_id is mandatory field");
           if(!$acondition_order) throw new AfwRuntimeException("loadByMainIndex : acondition_order is mandatory field");
           $obj->select("acondition_origin_id",$acondition_origin_id);
           $obj->select("acondition_order",$acondition_order); 
           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("acondition_origin_id",$acondition_origin_id);
                $obj->set("acondition_order",$acondition_order); 
                $obj->insertNew();
                $obj->is_new = true;
                return $obj;
           }
           else return null;
 
        }

        public static function list_of_operator_id()
        {
            global $lang;
            return self::operator()[$lang];
        }
        
        public static function operator()
        {
                $arr_list_of_operator = array();
                
                
                $arr_list_of_operator["en"][1] = "And";
                $arr_list_of_operator["ar"][1] = "و";

                $arr_list_of_operator["en"][2] = "Or";
                $arr_list_of_operator["ar"][2] = "أو";

                
                
                
                return $arr_list_of_operator;
        } 


        public static function code_of_compare_id($lkp_id=null)
        {
            global $lang;
            if($lkp_id) return self::compare()['code'][$lkp_id];
            else return self::compare()['code'];
        }
        
        
        public static function list_of_compare_id()
        {
            global $lang;
            return self::compare()[$lang];
        }
        
        public static function compare()
        {
                $arr_list_of_compare = array();
                
                
                $arr_list_of_compare["en"][7] = "Belongs to";
                $arr_list_of_compare["ar"][7] = "ينتمي إلى";
                $arr_list_of_compare["code"][7] = "in";

                $arr_list_of_compare["en"][8] = "Does not belong to";
                $arr_list_of_compare["ar"][8] = "لا ينتمي إلى";
                $arr_list_of_compare["code"][8] = "!in";

                $arr_list_of_compare["en"][1] = "Equal to";
                $arr_list_of_compare["ar"][1] = "يساوي";
                $arr_list_of_compare["code"][1] = "=";

                $arr_list_of_compare["en"][2] = "Greater than";
                $arr_list_of_compare["ar"][2] = "أكبر من";
                $arr_list_of_compare["code"][2] = ">";

                $arr_list_of_compare["en"][3] = "Less than";
                $arr_list_of_compare["ar"][3] = "أصغر من";
                $arr_list_of_compare["code"][3] = "<";

                $arr_list_of_compare["en"][4] = "Greater than or equal to";
                $arr_list_of_compare["ar"][4] = "أكبر أو يساوي";
                $arr_list_of_compare["code"][4] = ">=";

                $arr_list_of_compare["en"][5] = "Less than or equal to";
                $arr_list_of_compare["ar"][5] = "أصغر أو يساوي";
                $arr_list_of_compare["code"][5] = "<=";

                $arr_list_of_compare["en"][6] = "Not equal to";
                $arr_list_of_compare["ar"][6] = "لا يساوي";
                $arr_list_of_compare["code"][6] = "!=";

                $arr_list_of_compare["en"][9] = "Contains";
                $arr_list_of_compare["ar"][9] = "يحتوي علي";
                $arr_list_of_compare["code"][9] = "";

                $arr_list_of_compare["en"][10] = "Not contains";
                $arr_list_of_compare["ar"][10] = "لا يحتوي علي";
                $arr_list_of_compare["code"][10] = "";

                
                
                
                return $arr_list_of_compare;
        } 


        public function attributeIsApplicable($attribute)
        {
                /*
                global $objme;
                
                
                */

                if (($attribute == "condition_1_id") or ($attribute == "operator_id") or ($attribute == "condition_2_id")) 
                {
                        return $this->_isComposed();
                }

                if (($attribute == "afield_id") or ($attribute == "compare_id") or ($attribute == "aparameter_id")) 
                {
                        return (!$this->_isComposed());
                }

                return true;
        }

        public function applyOnMe($obj, $simulate=true)
        {
                if($this->_isComposed())
                {
                        // to avoid for big loops to recreate the composing objects for each iteration
                        // save it inside a private attribute
                        if(!$this->cond1Obj) $this->cond1Obj = $this->get("condition_1_id");
                        if(!$this->cond2Obj) $this->cond2Obj = $this->get("condition_2_id");

                        $res1 = $this->cond1Obj->applyOnMe($obj, $simulate);
                        $res2 = $this->cond2Obj->applyOnMe($obj, $simulate);
                }
        }

        /*
        public function whyAttributeIsNotApplicable($attribute, $lang = "ar")
        {
                $icon = "na20.png";
                $textReason = $this->translateMessage("ACTIVATE-STATS-COMPUTE-OPTION", $lang);
                return array($icon, $textReason);
        }*/
}
?>      