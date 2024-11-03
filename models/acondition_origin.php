<?php
class AconditionOrigin extends AdmObject{

	public static $DATABASE		= ""; 
        public static $MODULE		    = "adm"; 
        public static $TABLE			= "acondition_origin"; 
        public static $DB_STRUCTURE = null;

        public function __construct(){
		parent::__construct("acondition_origin","id","adm");
                AdmAconditionOriginAfwStructure::initInstance($this);
                
	}

        public static function loadById($id)
        {
           $obj = new AconditionOrigin();
           
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }

        public static function loadByMainIndex($acondition_origin_type_id,$acondition_origin_order,$create_obj_if_not_found=false)
        {
                $obj = new AconditionOrigin();
                if(!$acondition_origin_type_id) throw new AfwRuntimeException("loadByMainIndex : acondition_origin_type_id is mandatory field");
                if(!$acondition_origin_order) throw new AfwRuntimeException("loadByMainIndex : acondition_origin_order is mandatory field");
                $obj->select("acondition_origin_type_id",$acondition_origin_type_id);
                $obj->select("acondition_origin_order",$acondition_origin_order); 
                if($obj->load())
                {
                        if($create_obj_if_not_found) $obj->activate();
                        return $obj;
                }
                elseif($create_obj_if_not_found)
                {
                        $obj->set("acondition_origin_type_id",$acondition_origin_type_id);
                        $obj->set("acondition_origin_order",$acondition_origin_order); 
                        $obj->insertNew();
                        $obj->is_new = true;
                        return $obj;
                }
                else return null;
 
        }
        
        protected function getOtherLinksArray($mode, $genereLog = false, $step="all")      
        {
                global $me, $objme, $lang;
                
                $displ = $this->getDisplay($lang);
                $otherLinksArray = $this->getOtherLinksArrayStandard($mode, false, $step);
                $my_id = $this->getId();

                if($my_id and ($mode=="mode_aconditionList"))
                {
                        
                        unset($link);
                        $link = array();
                        $title = "إضافة شرط جديد";
                        $general = $this->getVal("general");
                        $title_detailed = $title ."لـ : ". $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=Acondition&currmod=adm&sel_acondition_origin_id=$my_id&sel_general=$general";
                        $link["TITLE"] = $title;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;     

                }

                if($my_id and ($mode=="mode_aconditionOriginScopeList"))
                {
                        
                        unset($link);
                        $link = array();
                        $title = "إضافة مجال تطبيق جديد";
                        $title_detailed = $title ."لـ : ". $displ;
                        $link["URL"] = "main.php?mp=ed&cl=AconditionOriginScope&cm=adm&sel_acondition_origin_id=$my_id";
                        $link["TITLE"] = $title;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;     

                }
                
                return $otherLinksArray;          
        }

        public function beforeDelete($id,$id_replace) 
        {
            $server_db_prefix = AfwSession::config("db_prefix","default_db_");
            
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

         // acondition_origin 
        public function getScenarioItemId($currstep)
        {
                if ($currstep == 1) return 375;
                if ($currstep == 2) return 376;
                if ($currstep == 3) return 473;
                if ($currstep == 4) return 484;
                return 0;
        }

        public function stepsAreOrdered()
        {
                return false;
        }

        
}
?>