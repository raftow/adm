<?php
        class ApplicantScholarship extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "applicant_scholarship"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("applicant_scholarship","id","adm");
                        AdmApplicantScholarshipAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ApplicantScholarship();
                        
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


        public function beforeDelete($id,$id_replace) 
        {
            $server_db_prefix = AfwSession::config("db_prefix","nauss_");
            
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
        public function afterMaj($id, $fields_updated)
        {
                $app_id = $this->getVal("applicant_id");
                if($app_id)
                {
                        $nominatingCandidateObj = new NominatingCandidates();
                        $nominatingCandidateObj->where("applicant_id = '".$app_id."' and active = 'Y'");
                        $nominatingCandidateObj->load();
                        if($nominatingCandidateObj->id )
                        {
                                $nominationLetterObj = $nominatingCandidateObj->het("nomination_letter_id");
                                $ScholarshipObj = $this->het("scholarship_id");
                                $sponsor_id = $ScholarshipObj->getVal("sponsor_id");
                                $applicationPlanObj = $nominationLetterObj->het("application_plan_id");
                                //die($nominationLetterObj->getVal("application_plan_id")."++++");
                                if($applicationPlanObj)
                                {
                                        //die( $applicationPlanObj->getVal("term_id")."----------");
                                        if($sponsor_id==1 && $applicationPlanObj->getVal("term_id") == $ScholarshipObj->getVal("academic_term_id"))
                                        {
                                                $nominatingCandidateObj->set("study_funding_status_id", 3); // منحة الامير نايف
                                                $nominatingCandidateObj->commit();
                                        }
                                }
                                
                                
                        }
                }
        }
}
?>