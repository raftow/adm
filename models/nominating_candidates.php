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
        
        

        public static function loadByApplicationInfos($applicant_id, $application_plan_id, $application_simulation_id)
        {
                if (!$applicant_id) throw new AfwRuntimeException("loadByApplicationInfos : applicant_id is mandatory field");
                if (!$application_plan_id) throw new AfwRuntimeException("loadByApplicationInfos : application_plan_id is mandatory field");
                if (!$application_simulation_id) throw new AfwRuntimeException("loadByApplicationInfos : application_simulation_id is mandatory field");

                $obj = new NominatingCandidates();
                $obj->select("applicant_id", $applicant_id);
                $obj->select("application_plan_id", $application_plan_id);
                $obj->select("application_simulation_id", $application_simulation_id);
                if ($obj->load()) {
                        return $obj;
                } else return null;
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
            if(!$this->sureIs("track_overpass"))
            {
                $color = "green";
                $title_ar = "تجاوز المسار للبرنامج الذي اسند عليه المترشح"; 
                $methodName = "overpassProgram";

                $pbms[AfwStringHelper::hzmEncode($methodName)] = [
                    "METHOD"=>$methodName,
                    "COLOR"=>$color, 
                    "LABEL_AR"=>$title_ar, 
                    "ADMIN-ONLY"=>true, 
                    "BF-ID"=>"", 
                    'STEP' =>$this->stepOfAttribute("track_overpass"),
                    'CONFIRMATION_NEEDED'=>true,
                    'CONFIRMATION_QUESTION' =>array('ar' => "هل أنت متأكد من رغبتك للسماح بتجاوز شرط توفر مسار للبرنامج الذي اسند عليه المترشح وعدم تطبيق هذا الشرط؟ هذه العملية خاضعة للتدقيق وتتبع الأثر", 
                                                                    'en' => "Are you certain you wish to allow the candidate to bypass the requirement of having a track record for the program they were assigned, and not apply this condition? This process is subject to auditing and monitoring."),
                    'CONFIRMATION_WARNING' =>array('ar' => "هذه العملية غير قابلة للتراجع", 
                                                            'en' => "This process is irreversible."),
                ];
            }
            
            
            
            return $pbms;
        }


        public function overpassProgram($lang='ar')
        {
            $objme = AfwSession::getUserConnected();

            if($objme and $objme->isAdmin())
            {
                $this->set("track_overpass_user_id", $objme->id);
                $this->set("track_overpass", "Y");

                $this->commit();

                return ["", "done"];
            }
            else
            {
                return ["not allowed", ""];
            }

            
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

        public function beforeMaj($id, $fields_updated)
        {
            if($fields_updated["nomination_letter_id"])
            {
                $nLetter = $this->het("nomination_letter_id");
                if($nLetter)
                {
                    $this->set("application_plan_id", $nLetter->getVal("application_plan_id"));
                    $this->set("application_simulation_id", $nLetter->getVal("application_simulation_id"));
                }
                else
                {
                    $this->setForce("application_plan_id", 0);
                    $this->setForce("application_simulation_id", 0);
                }
            }
            

            return true;
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
        $this->createOrRepareMyApplicationObjects();
        return true;	
    }

    public function createOrRepareMyApplicationObjects()
    {
        if($this->getVal("idn") and $this->getVal("identity_type_id"))        
        {
            $candidate_country_id = $this->getVal("country_id"); // het("nomination_letter_id")->het("nominating_authority_id")->getVal("country_id");
            if(!$candidate_country_id) $candidate_country_id = $this->het("nomination_letter_id")->het("nominating_authority_id")->getVal("country_id");
            if(!$candidate_country_id) $candidate_country_id = 183;
            $identity_type_id = $this->getVal("identity_type_id");
            $idn = $this->getVal("idn");
            $applicantObj = Applicant::loadByMainIndex($candidate_country_id, $identity_type_id, $idn, true);
            $applicantObj->set("idn_type_id", $this->getVal("identity_type_id"));        
            $applicantObj->set("first_name_ar", $this->getVal("first_name_ar"));
            $applicantObj->set("father_name_ar", $this->getVal("second_name_ar"));
            $applicantObj->set("middle_name_ar", $this->getVal("third_name_ar"));
            $applicantObj->set("last_name_ar", $this->getVal("last_name_ar"));
            $applicantObj->set("first_name_en", $this->getVal("first_name_en"));
            $applicantObj->set("father_name_en", $this->getVal("second_name_en"));
            $applicantObj->set("middle_name_en", $this->getVal("third_name_en"));
            $applicantObj->set("last_name_en", $this->getVal("last_name_en"));
            $applicantObj->set("gender_enum", $this->getVal("gender_enum"));
            $applicantObj->set("email", $this->getVal("email"));
            $applicantObj->set("mobile", $this->getVal("Mobile"));
            $applicantObj->commit();

            $this->set("country_id",$candidate_country_id);
            $this->set("applicant_id",$applicantObj->id);
            $this->commit();
                
            $applicationObj = $this->prepareMyApplication($applicantObj);

            $this->addMyApplicantAccounts();

            return [$applicantObj, $applicationObj];
        }

        return [];
        
    }

    public function prepareMyApplication($applicantObj=null)
    {
        if(!$applicantObj) $applicantObj = $this->het("applicant_id");
        $letterObj = $this->het("nomination_letter_id");

        if($letterObj and $applicantObj)
        {
            $application_simulation_id = self::currentApplicationSimulation();
            $application_plan_id = $letterObj->getVal("application_plan_id");
            $applicationPlanObj = $letterObj->het("application_plan_id");
            if($applicationPlanObj)
            {
                $applicationObj = Application::loadByMainIndex($applicantObj->id, $application_plan_id, $application_simulation_id, $this->getVal("idn"), true);
            }
            
        }

        return $applicationObj;
    }

    public function calcMyApplicationLink($what = "value")
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
            $applicant_id = $this->getVal("applicant_id");
            $applicantObj = $this->het("applicant_id");
            if(!$applicantObj)
            {
                list($applicantObj, $applicationObj) = $this->createOrRepareMyApplicationObjects();
                $applicant_id = $applicantObj->id;
                if(!$applicantObj or !$applicant_id) throw new AfwRuntimeException("failed to create applicant profile record");                
            }
            else $applicationObj = $this->prepareMyApplication($applicantObj);


            if($applicationObj)
            {
                $application_id = $applicationObj->id;
                $status_decoded = $applicationObj->decode("application_status_enum",'',false,$lang);                    
                return "<a class='btn btn-success btn-sm' style='min-width: 130px;font-size: 12px !important;' href='main.php?Main_Page=afw_mode_edit.php&cl=Application&currmod=adm&id=".$application_id."'>$status_decoded</a><br>";
            } 

            if(!$this->getVal("idn") or !$this->getVal("identity_type_id"))        
            {
                return "<p class='error'>No IDN type</p>";
            }
            return "<a class='btn btn-danger btn-sm' style='min-width: 130px;font-size: 12px !important;' href='main.php?Main_Page=afw_mode_edit.php&cl=Applicant&currmod=adm&id=".$applicant_id."'>حساب المتقدم</a><br>";
    }

    public function calcApplicantLink($what = "value")
    {
        
            $lang = AfwLanguageHelper::getGlobalLanguage();
            $applicant_id = $this->getVal("applicant_id");
            $applicantObj = $this->het("applicant_id");
            if(!$applicantObj)
            {
                list($applicantObj, ) = $this->createOrRepareMyApplicationObjects();
                $applicant_id = $applicantObj->id;
                if(!$applicantObj or !$applicant_id) throw new AfwRuntimeException("failed to create applicant profile record");                
            }
            
            /**
            * @var Applicant $applicantObj
            */

            if($applicantObj)
            {
                $nbQuals = $applicantObj->getRelation("applicantQualificationList")->count();
                if($nbQuals==0)
                {
                    $label_btn = $applicantObj->translate("qualif", $lang);                    
                    return "<a class='btn btn-success btn-orange' style='min-width: 130px;font-size: 12px !important;' href='main.php?Main_Page=afw_mode_edit.php&cl=Applicant&currmod=adm&currstep=3&id=".$applicant_id."'>$label_btn</a><br>";
                }
                else
                {
                    $label_btn = $applicantObj->translate("step6", $lang);                    
                    return "<a class='btn btn-success btn-orange' style='min-width: 130px;font-size: 12px !important;' href='main.php?Main_Page=afw_mode_edit.php&cl=Applicant&currmod=adm&currstep=6&id=".$applicant_id."'>$label_btn</a><br>";
                }
                
            } 

            return "---";
    }

    
    
    public function calccandidateFullName($what = "value"){
        return $this->getVal("first_name_ar")." ".$this->getVal("second_name_ar")." ".$this->getVal("third_name_ar")." ".$this->getVal("last_name_ar");
    }


    public function addMyApplicantAccounts()
    {
        $applicant_id = $this->getVal("applicant_id");
        
        $applicationPlanObj = $this->het("application_plan_id");
        if(!$applicationPlanObj) return -1;
        $application_plan_id = $applicationPlanObj->id;
        if(!$application_plan_id) return -2;
        $application_model_id = $applicationPlanObj->getVal("application_model_id");        
        if(!$application_model_id) return -3;
        $application_simulation_id = $this->getVal("application_simulation_id");
        if(!$application_simulation_id) return -4;

        $applicationFinancialTransaction = new ApplicationModelFinancialTransaction();
        $applicationFinancialTransaction->where("application_model_id = $application_model_id and active ='Y' and process_enabled ='Y' and phase_enum=1");
            
        $appFinTransObjectList = $applicationFinancialTransaction->loadMany();
        foreach ($appFinTransObjectList as $appFinTransObject) {
            $applicantAccount = ApplicantAccount::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id, $appFinTransObject->id, true);
            
                
            //$applicantAccount->set("academic_period_id", $current_period_id);
            $applicantAccount->set("total_amount", $appFinTransObject->getVal("amount"));
            $applicantAccount->set("payment_status_enum", 4); // معفي من الدفع            
            $applicantAccount->commit();
        }
    }
}



// errors 

