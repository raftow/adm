<?php
        class ApplicationPlanBranch extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "application_plan_branch"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("application_plan_branch","id","adm");
                        AdmApplicationPlanBranchAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ApplicationPlanBranch();
                        
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
                        return true;
                }

                


                public function beforeMaj($id, $fields_updated)
                {  
                        $applicationPlanObj = null;
                        if($fields_updated["application_plan_id"] and $this->getVal("application_plan_id"))
                        {
                                $applicationPlanObj = $this->het("application_plan_id");
                                if($applicationPlanObj)
                                {
                                        $this->set("academic_level_id", $applicationPlanObj->calc("academic_level_id"));
                                        $this->set("gender_enum", $applicationPlanObj->calc("gender_enum"));
                                        $this->set("term_id", $applicationPlanObj->getVal("term_id"));
                                        
                                }
                        }

                        if($fields_updated["program_id"] or $fields_updated["training_unit_id"])
                        {
                                if($this->getVal("program_id") and $this->getVal("training_unit_id"))
                                {
                                     $progOffObj = AcademicProgramOffering::loadByMainIndex($this->getVal("program_id"),$this->getVal("training_unit_id"));           
                                     if($progOffObj) 
                                     {
                                        $this->set("program_offering_id", $progOffObj->id);
                                        if(!$applicationPlanObj) 
                                        {
                                                $applicationPlanObj = $this->het("application_plan_id");
                                                $applicationModelBranchObj = ApplicationModelBranch::loadByMainIndex($progOffObj->id, $applicationPlanObj->getVal("application_model_id"));
                                                if($applicationModelBranchObj) $this->set("application_model_branch_id", $applicationModelBranchObj->id);
                                        }
                                        
                                        
                                     }
                                }
                        }

                        if($this->getVal("application_end_date") and $fields_updated["application_end_date"])
                        {
                                $this->repareHijriApplicationEndDate("ar", false);
                        }

                    return true;
                }

                

                public function repareHijriApplicationEndDate($lang="ar", $commit=true)
                {
                        list($application_end_date, $application_end_time) = explode(" ",$this->getVal("application_end_date"));
                        if($application_end_date and ($application_end_date != "0000-00-00"))
                        {
                                $this->set("hijri_application_end_date", AfwDateHelper::gregToHijri($application_end_date));                        
                        }
                        else
                        {
                                $this->set("hijri_application_end_date", "");                        
                        }
                        
                        if($commit) $this->commit();

                        return ["","repareHijriApplicationEndDate done"];
                }


                protected function afterSetAttribute($attribute)
                {
                        if(($attribute == "application_plan_id") and $this->getVal("application_plan_id"))
                        {
                                $applicationPlanObj = $this->het("application_plan_id");
                                if($applicationPlanObj)
                                {
                                        $this->set("academic_level_id", $applicationPlanObj->calc("academic_level_id"));
                                        $this->set("gender_enum", $applicationPlanObj->calc("gender_enum"));
                                        $this->set("term_id", $applicationPlanObj->getVal("term_id"));
                                }
                        }
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

                // application_plan_branch 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 430;
      if ($currstep == 2) return 431;

      return 0;
   }
                 

        }
?>