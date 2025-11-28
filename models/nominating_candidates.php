<?php 

                
$file_dir_name = dirname(__FILE__); 
                
// require_once("$file_dir_name/../afw/afw.php");

class NominatingCandidates extends AdmObject{

        public static $MY_ATABLE_ID=13999; 
  
        public static $DATABASE		= "nauss_adm";
        public static $MODULE		        = "adm";        
        public static $TABLE			= "nominating_candidates";

	    public static $DB_STRUCTURE = null;
	
	    public function __construct(){
		parent::__construct("nominating_candidates","id","adm");
            AdmNominatingCandidatesAfwStructure::initInstance($this);    
	    }
        
        public static function loadById($id)
        {
           $obj = new NominatingCandidates();
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
        
        /*
        public function isTechField($attribute) {
            return (($attribute=="created_by") or 
                    ($attribute=="created_at") or 
                    ($attribute=="updated_by") or 
                    ($attribute=="updated_at") or 
                    // ($attribute=="validated_by") or ($attribute=="validated_at") or 
                    ($attribute=="version"));  
        }*/
        
        
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
               
                $app_id = $this->getVal("applicant_id");
                if($app_id){
                
                    $obj = new Application();
                    $obj->where("applicant_id = '$app_id' and active='Y' ");
                    $nbRecords = $obj->count();
                    if($nbRecords>0)
                    {
                        $this->deleteNotAllowedReason = "Some related application(s) exists";
                        return false;
                    }else{
                        //Delete applicant 
                        $this->het("applicant_id")->delete();
                        // delete qualification
                        $qualification = new ApplicantQualification();
                        $qualification->deleteWhere("applicant_id = '$app_id'");
                        // delete Evaluation 
                        $AppEvaluation = new ApplicantEvaluation();
                        $AppEvaluation->deleteWhere("applicant_id = '$app_id'");
                    }
                }
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

    public function afterMaj($id, $fields_updated){
        $create_if_not_exist = true;
        $idn = (isset($fields_updated["idn"])) ? $fields_updated["idn"] :$this->getVal("idn") ;
        $idn_type = (isset($fields_updated["identity_type_id"])) ? $fields_updated["identity_type_id"] :$this->getVal("identity_type_id") ;
//die("idn type $idn_type");
        $objAppl = Applicant::loadByMainIndex($idn, $create_if_not_exist);
        //die($this->getVal("idn")."==>".$objAppl->id);
        if($objAppl->is_new){
            $objAppl->set("idn_type_id", $idn_type);
            $objAppl->set("idn",$idn);
            $objAppl->set("first_name_ar",$fields_updated["first_name_ar"]);
            $objAppl->set("father_name_ar",$fields_updated["second_name_ar"]);
            $objAppl->set("middle_name_ar",$fields_updated["third_name_ar"]);
            $objAppl->set("last_name_ar",$fields_updated["last_name_ar"]);
            $objAppl->set("first_name_en",$fields_updated["first_name_en"]);
            $objAppl->set("father_name_en",$fields_updated["second_name_en"]);
            $objAppl->set("middle_name_en",$fields_updated["third_name_en"]);
            $objAppl->set("last_name_en",$fields_updated["last_name_en"]);
            $objAppl->set("email",$fields_updated["email"]);
            $objAppl->set("mobile",$fields_updated["mobile"]);
            $objAppl->set("gender_enum",$fields_updated["gender_enum"]);
            
            $objAppl->commit();

        }
        if($objAppl->id){
            $this->set("applicant_id",$objAppl->id);
            $this->commit();
        }
        return true;	
    }
     public function calcApplicantIdLink($what = "value")
    {
            $applicant_id = $this->getVal("applicant_id");
            $lang = AfwLanguageHelper::getGlobalLanguage();
            if($applicant_id)
            {
                //$appObj = Application::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id, $idn, true);
                $letterObj = $this->het("nomination_letter_id");
                $application_plan_id = $letterObj->getVal("application_plan_id");
                $appObj = new Application();
                $appObj->where("applicant_id = '$applicant_id' and application_plan_id= '$application_plan_id'");
                if($appObj->load()){
                    $application_id = $appObj->id;
                    $status_decoded = $appObj->decode("application_status_enum",'',false,$lang);                    
                    return "<a class='btn btn-success btn-sm' style='min-width: 130px;font-size: 12px !important;' href='main.php?Main_Page=afw_mode_edit.php&cl=Application&currmod=adm&id=".$application_id."'>$status_decoded</a><br>";
                } 
                return "<a class='btn btn-danger btn-sm' style='min-width: 130px;font-size: 12px !important;' href='main.php?Main_Page=afw_mode_edit.php&cl=Applicant&currmod=adm&id=".$applicant_id."'>حساب المتقدم</a><br>";
            }
            else
            {
                $params = "&idn_type=".$this->getVal("identity_type_id");
                $params .= "&idn=".$this->getVal("idn");
                $params .= "&first_name_ar=".$this->getVal("first_name_ar");
                $params .= "&second_name_ar=".$this->getVal("second_name_ar");
                $params .= "&third_name_ar=".$this->getVal("third_name_ar");
                $params .= "&last_name_ar=".$this->getVal("last_name_ar");
                $params .= "&first_name_en=".$this->getVal("first_name_en");
                $params .= "&second_name_en=".$this->getVal("second_name_en");
                $params .= "&third_name_en=".$this->getVal("third_name_en");
                $params .= "&last_name_en=".$this->getVal("last_name_en");
                $params .= "&gender_enum=".$this->getVal("gender_enum");
                
                $params .= "&email=".$this->getVal("email");
                $params .= "&Mobile=".$this->getVal("Mobile");

                return "<a class='btn btn-default btn-sm' style='min-width: 130px;font-size: 12px !important;' href='main.php?Main_Page=afw_mode_edit.php&cl=Applicant&currmod=adm".$params."'>إنشاء حساب المتقدم</a><br>";
            }
    }
    
    public function calccandidateFullName($what = "value"){
        return $this->getVal("first_name_ar")." ".$this->getVal("second_name_ar")." ".$this->getVal("third_name_ar")." ".$this->getVal("last_name_ar");
    }


    public function addApplicantAccount($applicant_id,$application_model_id,$application_plan_id, $application_simulation_id)
    {
        $applicationFinancialTransaction = new ApplicationModelFinancialTransaction();
        $applicationFinancialTransaction->where("application_model_id = $application_model_id and active ='Y' and process_enabled ='Y' and phase_enum=1");
            
        $appFinTransObject_list = $applicationFinancialTransaction->loadMany();
        foreach ($appFinTransObject_list as $row) {
            $applicantAccount = ApplicantAccount::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id, $row->getval("id"), true);
            
                
            //$applicantAccount->set("academic_period_id", $current_period_id);
            $applicantAccount->set("total_amount",$row->getVal("amount"));
            $applicantAccount->set("payment_status_enum", 4); // معفي من الدفع
            
            $applicantAccount->commit();
        }
    }
}



// errors 

