<?php 

                
$file_dir_name = dirname(__FILE__); 
                
// require_once("$file_dir_name/../afw/afw.php");

class SortingGroup extends AdmObject{

        public static $MY_ATABLE_ID=13945; 
  
        public static $DATABASE		= "uoh_adm";
        public static $MODULE		        = "adm";        
        public static $TABLE			= "sorting_group";

	    public static $DB_STRUCTURE = null;

        public static $sortingCritereaMatrix = [];
	
	    public function __construct(){
		parent::__construct("sorting_group","id","adm");
            AdmSortingGroupAfwStructure::initInstance($this);    
	    }

        public static function inverseOrderBySens($sens)
        {
            if($sens=="asc") return "desc"; else return "asc";
        }

        public static function getSortingCriterea($sortingGroupId, $inverseOrderBy=false)
        {
            $sortingCriterea = SortingGroup::loadSortingCriterea($sortingGroupId);
            $sf1 = $sortingCriterea["c1"];
            $sf1_order_sens = $sf1["field_sens"];
            if($inverseOrderBy) $sf1_order_sens = self::inverseOrderBySens($sf1_order_sens);
            $sf1_sql = $sf1 ? "sorting_value_1 float NOT NULL, " : "";
            $sf1_insert = $sf1 ? "sorting_value_1, " : "";
            $sf1_order = $sf1 ? "sorting_value_1 $sf1_order_sens, " : "";
            $sf2 = $sortingCriterea["c2"];
            $sf2_order_sens = $sf2["field_sens"];
            if($inverseOrderBy) $sf2_order_sens = self::inverseOrderBySens($sf2_order_sens);
            $sf2_sql = $sf2 ? "sorting_value_2 float NOT NULL, " : "";
            $sf2_insert = $sf2 ? "sorting_value_2, " : "";
            $sf2_order = $sf2 ? "sorting_value_2 $sf2_order_sens, " : "";
            $sf3 = $sortingCriterea["c3"];
            $sf3_order_sens = $sf3["field_sens"];
            if($inverseOrderBy) $sf3_order_sens = self::inverseOrderBySens($sf3_order_sens);
            $sf3_sql = $sf3 ? "sorting_value_3 float NOT NULL, " : "";
            $sf3_order = $sf3 ? "sorting_value_1 $sf3_order_sens, " : "";
            $sf3_insert = $sf3 ? "sorting_value_3, " : "";
    
            return [$sortingCriterea,
                $sf1,$sf1_order_sens,$sf1_sql,$sf1_insert,$sf1_order,
                $sf2,$sf2_order_sens,$sf2_sql,$sf2_insert,$sf2_order,
                $sf3,$sf3_order_sens,$sf3_sql,$sf3_insert,$sf3_order,
            ];
        }

        
        public static function minMaxFunction($max, $sens)
        {
            if($sens=="desc")
            {
                return $max ? "max" : "min";
            }
            else
            {
                return $max ? "min" : "max";
            }
        }
        public static function getGroupingCriterea($sortingGroupId, $max=false)
        {
            $sortingCriterea = SortingGroup::loadSortingCriterea($sortingGroupId);
            $sf1 = $sortingCriterea["c1"];
            $msf1 = $sf1 ? "min_app_score1" : "";
            
            $sf1_order_sens = $sf1["field_sens"];
            $func = self::minMaxFunction($max, $sf1_order_sens);
            $sf1_func = $sf1 ? "$func(sorting_value_1) as min_app_score1" : "";
            
            $sf2 = $sortingCriterea["c2"];
            $msf2 = $sf2 ? "min_app_score2" : "";
            $sf2_order_sens = $sf2["field_sens"];
            $func = self::minMaxFunction($max, $sf2_order_sens);
            $sf2_func = $sf2 ? "$func(sorting_value_2) as min_app_score2" : "";
            
            $sf3 = $sortingCriterea["c3"];
            $msf3 = $sf3 ? "min_app_score3" : "";
            $sf3_order_sens = $sf3["field_sens"];
            $func = self::minMaxFunction($max, $sf3_order_sens);
            $sf3_func = $sf3 ? "$func(sorting_value_3) as min_app_score3" : "";
    
            return [$sortingCriterea,
                $msf1,$sf1_order_sens,$sf1_func,
                $msf2,$sf2_order_sens,$sf2_func,
                $msf3,$sf3_order_sens,$sf3_func,
            ];
        }

        public static function loadSortingCriterea($id)
        {
            if(!self::$sortingCritereaMatrix[$id])
            {
                $objSG = self::loadById($id);
                
                $sortingCritereaRow = ['c1'=>null,'c2'=>null,'c3'=>null,'f1'=>null,'f2'=>null,'f3'=>null,'f4'=>null,'f5'=>null,'f6'=>null,'f7'=>null,'f8'=>null,'f9'=>null,];

                if($objSG)
                {
                    for($i=1; $i<=3; $i++)
                    {
                        $objSCF = $objSG->het("sorting_field_".$i."_id");
                        if($objSCF)
                        {
                            $nameSCF = $objSCF->getVal("field_name");                            
                            $field_method = $objSCF->sureIs("reel") ? "getVal" : "calc";
                            $sensSCF = self::code_of_sorting_sens_enum($objSG->getVal("field".$i."_sorting_sens_enum"));
                            $sortingCritereaRow['c'.$i] = ["field_name"=>$nameSCF, "field_sens"=>$sensSCF, "field_method"=>$field_method];
                        }
                    }

                    for($f=1;$f<=9;$f++)
                    {
                        $objFMF = $objSG->het("formula_field_".$f."_id");
                        if($objFMF)
                        {
                            $nameFMF = $objFMF->getVal("field_name");                            
                            $field_method = $objFMF->sureIs("reel") ? "getVal" : "calc";
                            $sortingCritereaRow['f'.$f] = ["field_name"=>$nameFMF, "field_method"=>$field_method];
                        }
                    }
                }

                self::$sortingCritereaMatrix[$id] = $sortingCritereaRow;
            }

            return self::$sortingCritereaMatrix[$id];
            
        }
        
        public static function loadById($id)
        {
           $obj = new SortingGroup();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        

        public function getScenarioItemId($currstep)
                {
                    
                    return 0;
                }
        
        
        public function getDisplay($lang="ar")
        {
               return $this->getVal("name_$lang");
        }
        
        
        

        
        protected function getOtherLinksArray($mode,$genereLog=false,$step="all")      
        {
             $lang = AfwLanguageHelper::getGlobalLanguage();
             // $objme = AfwSession::getUserConnected();
             // $me = ($objme) ? $objme->id : 0;

             $otherLinksArray = $this->getOtherLinksArrayStandard($mode,$genereLog,$step);
             $my_id = $this->getId();
             $displ = $this->getDisplay($lang);
             
             
             
             // check errors on all steps (by default no for optimization)
             // rafik don't know why this : \//  = false;
             
             return $otherLinksArray;
        }
        
        protected function getPublicMethods()
        {
            
            $pbms = array();
            
            $color = "green";
            $title_ar = "fill Formula Fields"; 
            $methodName = "fillFormulaFields";
            $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("sorting_field_1_id"));
            
            return $pbms;
        }
        
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
        
        public function fillFormulaFields($lang="ar", $forced=false)
        {
            $formulaField1Obj = $this->het("formula_field_1_id");
            if((!$forced) and $formulaField1Obj) return ["some formula fields already filled, use forced mode", ""];

            $sortingField1Obj = $this->het("sorting_field_1_id");
            if(!$sortingField1Obj) return ["", "", "No sorting field 1 defined"];

            $this->set("formula_field_1_id", $sortingField1Obj->getVal("formula_field_1_id"));
            $this->set("formula_field_2_id", $sortingField1Obj->getVal("formula_field_2_id"));
            $this->set("formula_field_3_id", $sortingField1Obj->getVal("formula_field_3_id"));

            $nb = 3;
            $sortingField2Obj = $this->het("sorting_field_2_id");
            if($sortingField2Obj)
            {
                $this->set("formula_field_4_id", $sortingField2Obj->getVal("formula_field_1_id"));
                $this->set("formula_field_5_id", $sortingField2Obj->getVal("formula_field_2_id"));
                $this->set("formula_field_6_id", $sortingField2Obj->getVal("formula_field_3_id"));
                $nb += 3;

                $sortingField3Obj = $this->het("sorting_field_3_id");
                if($sortingField3Obj)
                {
                    $this->set("formula_field_7_id", $sortingField3Obj->getVal("formula_field_1_id"));
                    $this->set("formula_field_8_id", $sortingField3Obj->getVal("formula_field_2_id"));
                    $this->set("formula_field_9_id", $sortingField3Obj->getVal("formula_field_3_id"));
                    $nb += 3;
                }
            }

            $this->commit();

            return ["", "done $nb fields"];

            
        }

        
        
        public function beforeDelete($id,$id_replace) 
        {
            $server_db_prefix = AfwSession::config("db_prefix","uoh_");
            
            if(!$id)
            {
                $id = $this->getId();
                $simul = true;
            }
            else
            {
                $simul = false;
            }
            
            if($id)
            {   
               if($id_replace==0)
               {
                   // FK part of me - not deletable 

                        
                   // FK part of me - deletable 

                   
                   // FK not part of me - replaceable 

                        
                   
                   // MFK

               }
               else
               {
                        // FK on me 

                        
                        // MFK

                   
               } 
               return true;
            }    
	}
             
}



// errors 

