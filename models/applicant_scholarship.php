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
          
                $applicantObj = $this->het("applicant_id");
                $applicant_id = $this->getVal("applicant_id");
                $application_plan_id = $this->getVal("application_plan_id");
                $application_simulation_id = $this->getVal("application_simulation_id");
                $appObj = Application::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id);
                // 1. update applicant class if needed
                if($appObj)
                {
                        $applicationPlanObj = $appObj->het("application_plan_id");
                        $ScholarshipObj = $this->het("scholarship_id");
                        $sponsor_id = $ScholarshipObj->getVal("sponsor_id");
                        $desireobj = new ApplicationDesire();
                        $desireobj->where("applicant_id = '$applicant_id' 
                                 and application_plan_id = '$application_plan_id' 
                                 and application_simulation_id = '$application_simulation_id' 
                                 and active='Y'");
                        $desireList = $desireobj->loadMany();
                        foreach($desireList as $desire)
                        {
                                $ApplicationClassUpgradeObj = ApplicationClassUpgrade::loadByMainIndex($desire->getVal("application_class_enum"), $sponsor_id);
                                
                                if($ApplicationClassUpgradeObj &&  $applicationPlanObj->getVal("term_id") == $ScholarshipObj->getVal("academic_term_id"))
                                {
                                        // update workflow request if exists
                                        $workflowRequest = $desire->het("workflow_request_id");
                                        if($workflowRequest)
                                        {
                                                $workflowRequest->set("application_class_enum", $ApplicationClassUpgradeObj->getVal("final_applicant_class_id"));
                                                $workflowRequest->commit();
                                        }

                                }
                        }
                }
                // 2. update nominating candidate's study_funding_status_id if exists
                $nominatingCandidateObj = new NominatingCandidates();
                $nominatingCandidateObj->select("applicant_id", $applicant_id);
                $nominatingCandidateObj->select("application_plan_id", $application_plan_id);
                $nominatingCandidateObj->select("application_simulation_id", $application_simulation_id);
                $nominatingCandidateObj->select("active", "Y");
                
                if($nominatingCandidateObj->load())
                {
                        $nominatingCandidateObj->set("study_funding_status_id", 3);
                        $nominatingCandidateObj->update();
                }

                // 3.update  applicant accounts tuition fees if exists
                $applicantAccountObj = new ApplicantAccount();
                $applicantAccountObj->where("applicant_id = '".$applicant_id."' and application_plan_id = '".$application_plan_id."' and application_simulation_id = '".$application_simulation_id."'");
                $applicantAccountObj->loadMany();
                
                foreach($applicantAccountObj as $applicantAccount)
                {
                        
                                $applicationModelFinancialTransactionObj = $applicantAccount->het("application_model_financial_transaction_id");
                                if($applicationModelFinancialTransactionObj->getVal("phase_enum") == 2 && $applicantAccount->getVal("payment_status_enum") == 1) // if the account is for tuition and not already exempted
                                {       
                                        $applicantAccount->set("payment_status_enum", "4"); // معفى
                                        $applicantAccount->commit();
                                         
                                        $transitionId = $applicantAccount->getVal("next_transition_id");
                                        $reqObj = $applicantAccount->het("workflow_request_id");
                                        //run transition 16
                                        if($transitionId){
                                                list($error, $status_comment) = $reqObj->runTransition($transitionId, $lang);

                                        }

                                }
                      
                }

                return true;

        }
}
?>