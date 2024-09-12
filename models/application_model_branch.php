<?php
        // rafik 12/02/2024
        // alter table c0adm.application_model_branch add   branch_name_ar varchar(128)  DEFAULT NULL  after is_open;
        // alter table c0adm.application_model_branch add   branch_name_en varchar(128)  DEFAULT NULL  after branch_name_ar;
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
                        return $this->getVal("branch_name_$lang"); 
                }

                public function stepsAreOrdered()
                {
                        return true;
                }


                public function beforeMaj($id, $fields_updated)
                {  
                        
                
                    return true;
                }

                public function genereName($lang="ar", $which="all", $commit=true)
                {
                    $acadProg = $this->het("academic_program_id");            
                    if(!$acadProg) return ["لم يتم تحديد البرنامج", ""];
                    $appModelObj = $this->het("application_model_id");            
                    if(!$appModelObj) return ["لم يتم تحديد البرنامج", ""];
                    
                    if(($which=="all") or ($which=="ar"))
                    {
                        $new_name = $appModelObj->getDisplay("ar")."-".$acadProg->getDisplay("ar");
                        $this->set("program_name_ar", $new_name);                        
                        // die("reset name to : ".$new_name);
                    }
        
                    if(($which=="all") or ($which=="en"))
                    {
                        $new_name = $appModelObj->getDisplay("en")."-".$acadProg->getDisplay("en");
                        $this->set("program_name_en", $new_name); 
                    }

                    // $this->set("gender_enum", $tunitObj->getVal("gender_enum"));
        
                    if($commit) $this->commit();
        
                    return ["", "تم تصفير مسمى البرنامج بنجاح"];
                    
                }

                public static function genereAllNames($lang="ar")
                {
                        $obj = new ApplicationModelBranch();
                        // $obj->select_visibilite_horizontale();
                        $objList = $obj->loadMany();

                        foreach($objList as $objItem)
                        {
                                $objItem->genereName($lang);
                        }
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