<?php
        class TuitionBase extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "tuition_base"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("tuition_base","id","adm");
                        AdmTuitionBaseAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new TuitionBase();
                        
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

                public function getTuitionBaseForApplicant($application_desire_id){
                        $applicationDesireObj =  ApplicationDesire::loadById($application_desire_id);
                        $applicationPlanBranch = $applicationDesireObj->het("application_plan_branch_id");
                        $program_id = $applicationPlanBranch->getVal("program_id");
                        if($program_id){
                                $this->where("active='Y' and program_id = '$program_id'");
                                if($this->load()){
                                        $res["total_ammount"] = $this->getVal("amount") + $this->getVal("mandatory_fees");
                                        $res["curr_ar"] = $this->getVal("currency_ar");
                                        $res["curr_en"] = $this->getVal("currency_en");
                                        return $res;

                                }else{
                                        $academicProgramObj = $applicationPlanBranch->het("program_id");
                                        $degree_id = $academicProgramObj->getVal("degree_id");
                                        $this->where("active='Y' and degree_id = '$degree_id'");
                                        if($this->load()){
                                                $res["total_ammount"] = $this->getVal("amount") + $this->getVal("mandatory_fees");
                                                $res["curr_ar"] = $this->getVal("currency_ar");
                                                $res["curr_en"] = $this->getVal("currency_en");
                                                return $res;
                                        }
                                        return false;
                                        
                                }
                                return false;

                        }
                        return false;

                }

        }
?>