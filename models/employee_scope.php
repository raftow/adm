<?php 

                
$file_dir_name = dirname(__FILE__); 
                
// require_once("$file_dir_name/../afw/afw.php");

class EmployeeScope extends AFWObject{

        public static $MY_ATABLE_ID=13944; 
  
        public static $DATABASE		= "uoh_adm";
        public static $MODULE		        = "adm";        
        public static $TABLE			= "employee_scope";

	    public static $DB_STRUCTURE = null;
	
	    public function __construct(){
		parent::__construct("employee_scope","id","adm");
            AdmEmployeeScopeAfwStructure::initInstance($this);    
	    }
        
        public static function loadById($id)
        {
           $obj = new EmployeeScope();
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
        
        public static function loadByMainIndex($start_date, $end_date,$create_obj_if_not_found=false)
        {


           $obj = new EmployeeScope();
           $obj->select("start_date",$start_date);
           $obj->select("end_date",$end_date);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("start_date",$start_date);
                $obj->set("end_date",$end_date);

                $obj->insertNew();
                if(!$obj->id) return null; // means beforeInsert rejected insert operation
                $obj->is_new = true;
                return $obj;
           }
           else return null;
           
        }


        public function getDisplay($lang="ar")
        {
               
               $data = array();
               $link = array();
               


               
               return implode(" - ",$data);
        }
        
        
        
/*        public function list_of_gender_enum() { 
            $list_of_items = array(); 
            $list_of_items[1] = "LOOKUP_TABLE";  //     code : ... not defined ... 
           return  $list_of_items;
        } 


*/
        
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
            $title_ar = "xxxxxxxxxxxxxxxxxxxx"; 
            $methodName = "mmmmmmmmmmmmmmmmmmmmmmm";
            //$pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("xxyy"));
            
            
            
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

    

    public static function scopeListToSQL($scopeList) 
    {
        $sqlList = [];
        foreach($scopeList as $scope)
        {
            $sqlList[] = "(".self::scopeToSQL($scope).")"; 
        }

        return implode(' or ', $sqlList);
    }

    public static function scopeToSQL($scope, $me="me.") 
    {
        foreach($scope as $key => $val)
        {
            if(!$val) $val = 0;
            $$key = $val;
        } 
        
        return "($academic_level_id=0 or ".$me."academic_level_id = $academic_level_id) and
                ($application_model_id=0 or ".$me."application_model_id = $application_model_id) and
                ($gender_enum=0 or ".$me."gender_enum = $gender_enum) and
                ($training_unit_type_id=0 or ".$me."training_unit_type_id = $training_unit_type_id) and
                ($training_unit_id=0 or ".$me."academic_level_id = $training_unit_id)";
    }

    public function retrieveScope() 
    {
        $currDate = AfwDateHelper::currentHijriDate();
        $start_date = $this->getVal("start_date");
        $end_date = $this->getVal("end_date");
        $academic_level_id = $this->getVal("academic_level_id");
        $application_model_id = $this->getVal("application_model_id");
        $gender_enum = $this->getVal("gender_enum");
        $training_unit_type_id = $this->getVal("training_unit_type_id");
        $training_unit_id = $this->getVal("training_unit_id");
        
        if(((!$start_date) or ($start_date<=$currDate)) and
            ((!$end_date) or ($end_date>=$currDate)))
            {
                return [
                        'academic_level_id' => $academic_level_id,
                        'application_model_id' => $application_model_id,
                        'gender_enum' => $gender_enum,
                        'training_unit_type_id' => $training_unit_type_id,
                        'training_unit_id' => $training_unit_id,
                ];
            }
            else
            {
                return null;
            }
    }
             
}



// errors 

