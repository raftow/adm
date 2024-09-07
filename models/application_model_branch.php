<?php
        class ApplicationModelBranch extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "application_model_branch"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("application_model_branch","id","adm");
                        AdmApplicationModelBranchAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ApplicationModelBranch();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
                }

                

                public static function loadByMainIndex($program_offering_id, $application_model_id, $seats_capacity=0, $create_obj_if_not_found=false)
                {
                        $obj = new ApplicationModelBranch();
                        $obj->select("program_offering_id",$program_offering_id);
                        $obj->select("application_model_id",$application_model_id);

                        if($obj->load())
                        {
                                if($create_obj_if_not_found) 
                                {
                                        $obj->set("seats_capacity", $seats_capacity);
                                        $obj->activate();
                                }
                                return $obj;
                        }
                        elseif($create_obj_if_not_found)
                        {
                                $obj->set("program_offering_id",$program_offering_id);
                                $obj->set("application_model_id",$application_model_id);
                                $obj->set("seats_capacity", $seats_capacity);
                                $obj->set("confirmation_days",3);
                                //@todo calculate direct_adm_capacity from pct
                                $direct_adm_capacity_pct = 0.1;
                                $obj->set("direct_adm_capacity", round($seats_capacity*$direct_adm_capacity_pct));
                                $obj->insertNew();
                                if(!$obj->id) return null; // means beforeInsert rejected insert operation
                                $obj->is_new = true;
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
                        return true;
                }


                public function beforeMaj($id, $fields_updated)
                {  
                        
                
                    return true;
                }


                public function afterMaj($id, $fields_updated)
                {  
                        if($fields_updated["seats_capacity"])
                        {
                             $amObj = $this->het("application_model_id");   
                             $poObj = $this->het("program_offering_id");   
                             if($amObj and $poObj)
                             {
                                $period = $amObj->getVal("training_period_enum");
                                $poObj->set("seats_capacity_$period", $this->getVal("seats_capacity"));
                                $poObj->commit();
                             }
                        }
                        
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