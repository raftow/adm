<?php
        class TrainingUnitDepartment extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "training_unit_department"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("training_unit_department","id","adm");
                        AdmTrainingUnitDepartmentAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                   $obj = new TrainingUnitDepartment();
                   $obj->select_visibilite_horizontale();
                   if($obj->load($id))
                   {
                        return $obj;
                   }
                   else return null;
                }
                
                
                
                public static function loadByMainIndex($department_id, $training_unit_id,$create_obj_if_not_found=false)
                {
        
        
                   $obj = new TrainingUnitDepartment();
                   $obj->select("department_id",$department_id);
                   $obj->select("training_unit_id",$training_unit_id);
        
                   if($obj->load())
                   {
                        if($create_obj_if_not_found) $obj->activate();
                        return $obj;
                   }
                   elseif($create_obj_if_not_found)
                   {
                        $obj->set("department_id",$department_id);
                        $obj->set("training_unit_id",$training_unit_id);
        
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
                       
        
                       list($data[0],$link[0]) = $this->displayAttribute("department_id",false, $lang);
        
                       
                       return implode(" - ",$data);
                }

                public function beforeDelete($id,$id_replace) 
                {
                    $server_db_prefix = AfwSession::config("db_prefix","c0");
                    
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
?>