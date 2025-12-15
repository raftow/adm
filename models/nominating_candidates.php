<?php 

                
$file_dir_name = dirname(__FILE__); 
                
// require_once("$file_dir_name/../afw/afw.php");

class NominatingCandidates extends AdmObject{

        public static $MY_ATABLE_ID=13999; 

        public static $DATABASE		= "nauss_adm";
        public static $MODULE		        = "adm";        
        public static $TABLE			= "nominating_candidates";

	    public static $DB_STRUCTURE = null;

        /**
         * @var Application $applicationObj
         */
        private $applicationObj = null;
	    public static $STATS_CONFIG = array(
            "st001" => array(
                "PARAMS" => ["sid"],
                "STATS_DATA_FROM" => ['class'=>'NominatingCandidates', 'method'=>'statsData'], // 
                //"URL_SETTINGS" => "main.php?Main_Page=afw_mode_edit.php&cl=CrmOrgunit&id=80&currmod=crm&currstep=5",
                "FOOTER_TITLES" => true,
                "SHOW_PIE" => "FOOTER",
                "PIE_MODE" => "FILTER",
                "FILTER" => "",/**question=all */
                //"CHART_URL" => "chart.php?m=crm&stc=st001&cl=NominatingCandidates&survey_id=1&case=1&f=question",

                "FORMULA_COLS" => array(
                    //0 => array("SHOW-NAME"=>"perf", "METHOD"=>"getPerf"),
                ),


            ),
        );
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
        
        public static function loadByMainIndex($nomination_letter_id, $identity_type_id, $idn,$create_obj_if_not_found=false)
        {
           if(!$nomination_letter_id) throw new AfwRuntimeException("loadByMainIndex : nomination_letter_id is mandatory field");
           if(!$identity_type_id) throw new AfwRuntimeException("loadByMainIndex : identity_type_id is mandatory field");
           if(!$idn) throw new AfwRuntimeException("loadByMainIndex : idn is mandatory field");


           $obj = new NominatingCandidates();
           $obj->select("nomination_letter_id",$nomination_letter_id);
           $obj->select("identity_type_id",$identity_type_id);
           $obj->select("idn",$idn);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("nomination_letter_id",$nomination_letter_id);
                $obj->set("identity_type_id",$identity_type_id);
                $obj->set("idn",$idn);

                $obj->insertNew();
                if(!$obj->id) return null; // means beforeInsert rejected insert operation
                $obj->is_new = true;
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


        public function gotoNextStep($lang='ar')
        {
            $this->getMyApplication();
            if($this->applicationObj)
            {
                return $this->applicationObj->gotoNextStep($lang);
            }

            return ['no application obj', ''];
        }

        public function gotoPreviousStep($lang='ar')
        {
            $this->getMyApplication();
            if($this->applicationObj)
            {
                return $this->applicationObj->gotoPreviousStep($lang);
            }

            return ['no application obj', ''];
        }
        
        protected function getPublicMethods()
        {
            
            $pbms = array();
            $this->getMyApplication();
            if($this->applicationObj)
            {

                $currentStepNum = $this->applicationObj->getVal("step_num") ? $this->applicationObj->getVal("step_num") : 0;
                $nextStepNum = $currentStepNum + 1;
                $nextStepObj = ApplicationStep::loadByMainIndex($this->applicationObj->getApplicationModel()->id, $nextStepNum);

                $previousStepNum = ($currentStepNum>1) ? $currentStepNum-1 : 1;
                $previousStepObj = ApplicationStep::loadByMainIndex($this->applicationObj->getApplicationModel()->id, $previousStepNum);
                
                $color = "green";
                $title_ar = $nextStepObj->tm("go to next step", 'ar') . " '" . $nextStepObj->getDisplay("ar") . "'";
                $title_en = $nextStepObj->tm("go to next step", 'en') . " '" . $nextStepObj->getDisplay("en") . "'";
                $methodName = "gotoNextStep";
                $pbms['xabc4578'] = array(
                        "METHOD" => $methodName,
                        "COLOR" => $color,
                        "LABEL_AR" => $title_ar,
                        "LABEL_EN" => $title_en,
                        "ADMIN-ONLY" => true,
                        "HIDE" => true,
                        "BF-ID" => "",
                );

                $color = "blue";
                $title_ar = $previousStepObj->tm("go to previous step", 'ar') . " '" . $previousStepObj->getDisplay("ar") . "'";
                $title_en = $previousStepObj->tm("go to previous step", 'en') . " '" . $previousStepObj->getDisplay("en") . "'";
                $methodName = "gotoPreviousStep";
                $pbms['zsde1239'] = array(
                        "METHOD" => $methodName,
                        "COLOR" => $color,
                        "LABEL_AR" => $title_ar,
                        "LABEL_EN" => $title_en,
                        "ADMIN-ONLY" => true,
                        "HIDE" => true,
                        "BF-ID" => "",
                );


                if(!$this->applicationObj->sureIs("signup_acknowldgment"))
                {
                        $color = "blue";
                        $title_en = "Signup Acknowldgment";
                        $title_ar = $this->tm($title_en, 'ar');
                        
                        $methodName = "signupAcknowldgment";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD" => $methodName, "COLOR" => $color, 
                                                "LABEL_AR" => $title_ar, 
                                                "LABEL_EN" => $title_en, 
                                                "PUBLIC" => true, "BF-ID" => "", 'STEP' => 6);        


                }
                


                if(!$this->sureIs("track_overpass"))
                {
                    $color = "green";
                    $title_ar = "تجاوز المسار للبرنامج الذي اسند عليه المترشح"; 
                    $methodName = "overpassTrackCondition";

                    $pbms[AfwStringHelper::hzmEncode($methodName)] = [
                        "METHOD"=>$methodName,
                        "COLOR"=>$color, 
                        "LABEL_AR"=>$title_ar, 
                        "ADMIN-ONLY"=>true, 
                        "BF-ID"=>"", 
                        'STEP' =>$this->stepOfAttribute("trackOverpassDiv"),
                        'CONFIRMATION_NEEDED'=>true,
                        'CONFIRMATION_QUESTION' =>array('ar' => "هل أنت متأكد من رغبتك للسماح بتجاوز شرط توفر مسار للبرنامج الذي اسند عليه المترشح وعدم تطبيق هذا الشرط؟ هذه العملية خاضعة للتدقيق وتتبع الأثر", 
                                                                        'en' => "Are you certain you wish to allow the candidate to bypass the requirement of having a track record for the program they were assigned, and not apply this condition? This process is subject to auditing and monitoring."),
                        'CONFIRMATION_WARNING' =>array('ar' => "هذا الاجراء غير قابل للتراجع", 
                                                                'en' => "This process is irreversible."),
                    ];
                }


                if(!$this->sureIs("rating_overpass"))
                {
                    $color = "green";
                    $title_ar = "تجاوز شرط التقدير لهذا المترشح"; 
                    $methodName = "overpassRatingCondition";

                    $pbms[AfwStringHelper::hzmEncode($methodName)] = [
                        "METHOD"=>$methodName,
                        "COLOR"=>$color, 
                        "LABEL_AR"=>$title_ar, 
                        "ADMIN-ONLY"=>true, 
                        "BF-ID"=>"", 
                        'STEP' =>$this->stepOfAttribute("ratingOverpassDiv"),
                        'CONFIRMATION_NEEDED'=>true,
                        'CONFIRMATION_QUESTION' =>array('ar' => "هل أنت متأكد من رغبتك للسماح بتجاوز شرط التقدير لهذا المترش وعدم تطبيقه؟ هذه العملية خاضعة للتدقيق وتتبع الأثر", 
                                                                        'en' => "Are you certain you wish to allow the candidate to bypass the requirement of having a track record for the program they were assigned, and not apply this condition? This process is subject to auditing and monitoring."),
                        'CONFIRMATION_WARNING' =>array('ar' => "هذا الاجراء غير قابل للتراجع", 
                                                                'en' => "This process is irreversible."),
                    ];
                }
            }
            
            
            
            return $pbms;
        }


        public function overpassTrackCondition($lang='ar')
        {
            $objme = AfwSession::getUserConnected();

            if($objme and $objme->isAdmin())
            {
                $this->set("track_overpass_user_id", $objme->id);
                $this->set("track_overpass", "Y");
                $this->set("track_overpass_gdate", date("Y-m-d H:i:s"));

                $this->commit();

                return ["", "done"];
            }
            else
            {
                return ["not allowed", ""];
            }

            
        }


        public function signupAcknowldgment($lang="ar")
        {
                // $applicantObj = $this->het("applicant_id");
                $this->getMyApplication();
                if($this->applicationObj) 
                {
                    return $this->applicationObj->signupAcknowldgment($lang);
                }
                return ["no-application", ""];    
        }






        public function overpassRatingCondition($lang='ar')
        {
            $objme = AfwSession::getUserConnected();

            if($objme and $objme->isAdmin())
            {
                $this->set("rating_overpass_user_id", $objme->id);
                $this->set("rating_overpass", "Y");
                $this->set("rating_overpass_gdate", date("Y-m-d H:i:s"));

                $this->commit();

                return ["", "done"];
            }
            else
            {
                return ["not allowed", ""];
            }

            
        }


        
        
        
        
        public function beforeMaj($id, $fields_updated)
        {
            $this->getMyApplication();

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


            if ($fields_updated["qualification_id"] or $fields_updated["major_category_id"]) {

                        $objMajorPath = MajorPath::loadByMainIndex($this->getVal("qualification_id"), $this->getVal("major_category_id"));

                        if ($objMajorPath) {
                                $this->set("major_path_id", $objMajorPath->id);
                        }
            }


            if ($fields_updated["academic_program_id"])
            {
                $fields_updated["application_plan_branch_mfk"] = $this->getVal("application_plan_branch_mfk");
                if(!$fields_updated["application_plan_branch_mfk"]) $fields_updated["application_plan_branch_mfk"] = "@wasEmpty";
                $this->set("application_plan_branch_mfk", ",");                            
            }
            
            if ($fields_updated["application_plan_branch_mfk"] and $this->getVal("application_plan_branch_mfk"))
            {
                if($this->applicationObj) 
                {
                    $this->applicationObj->set("application_plan_branch_mfk", $this->getVal("application_plan_branch_mfk"));                            
                    $this->applicationObj->set("comments", "NomCand::beforeMaj has updated branchMfk to : ".$this->getVal("application_plan_branch_mfk"));
                    $this->applicationObj->commit();
                }
                // else die("NomCand::beforeMaj => applicationObj not found");
            }


            if ($fields_updated["training_period_enum"])
            {
                if($this->applicationObj) 
                {
                    $this->applicationObj->set("training_period_enum", $this->getVal("training_period_enum"));                            
                    $this->applicationObj->commit();
                }
            }
            


            if (
                $fields_updated["grading_scale_id"] or 
                $fields_updated["qual_country_id"] or 
                $fields_updated["date"] or 
                $fields_updated["gpa_from"] or 
                $fields_updated["gpa"] or 
                $fields_updated["qualification_major_id"] or 
                $fields_updated["major_path_id"] or 
                $fields_updated["major_category_id"] or 
                $fields_updated["qualification_id"]
               ) 
            {
                $appQualObjId = 0;
                $source_name = "nominating-candidate-".$this->id;
                $applicant_id = $this->getVal("applicant_id");
                
                if( $applicant_id and
                    $this->getVal("grading_scale_id") and
                    $this->getVal("qual_country_id") and 
                    $this->getVal("date") and 
                    $this->getVal("gpa_from") and 
                    $this->getVal("gpa") and 
                    $this->getVal("qualification_major_id") and 
                    $this->getVal("major_path_id") and 
                    $this->getVal("major_category_id") and 
                    $this->getVal("qualification_id"))
                {
                        $appQualObj = ApplicantQualification::loadByMainIndex($applicant_id, $this->getVal("qualification_id"), $this->getVal("major_category_id"), true);
                        $appQualObjId = $appQualObj->id;
                        $appQualObj->set("source_name", $source_name);
                        $appQualObj->set("grading_scale_id", $this->getVal("grading_scale_id"));
                        $appQualObj->set("country_id", $this->getVal("qual_country_id"));
                        $appQualObj->set("date", $this->getVal("date"));
                        $appQualObj->set("gpa_from", $this->getVal("gpa_from"));
                        $appQualObj->set("gpa", $this->getVal("gpa"));
                        $appQualObj->set("qualification_major_id", $this->getVal("qualification_major_id"));
                        $appQualObj->set("major_path_id", $this->getVal("major_path_id"));
                        $appQualObj->set("grading_scale_id", $this->getVal("grading_scale_id"));
                        $appQualObj->commit();

                        
                        if($this->applicationObj) 
                        {
                            $this->applicationObj->set("applicant_qualification_id", $appQualObjId);                            
                            $this->applicationObj->commit();
                        }

                }

                /*
                if($this->applicationObj)  //  and $this->applicationObj->isChanged()
                {                    
                    
                }*/
                else die("NomCand::beforeMaj => applicationObj need to commit but object not found");

                ApplicantQualification::deleteWhere("applicant_id = $applicant_id and source_name = '$source_name' and id != '$appQualObjId' and imported != 'Y'");

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
                $application_plan_id = $this->getVal("application_plan_id");
                $applicant_id = $this->getVal("applicant_id");
                $application_simulation_id = $this->getVal("application_simulation_id");
                
                if($application_plan_id and $applicant_id and $application_simulation_id){
                
                    $obj = new Application();
                    $obj->where("applicant_id = '$applicant_id' and application_plan_id = '$application_plan_id' and application_simulation_id = '$application_simulation_id' and active='Y' and application_status_enum = ".self::application_status_enum_by_code('complete'));
                    $nbRecords = $obj->count();
                    if($nbRecords>0)
                    {
                        $this->deleteNotAllowedReason = "Some related completed application exists";
                        return false;
                    }
                    else
                    {
                        
                        // delete application
                        $application = new Application();
                        $application->deleteWhere("applicant_id = '$applicant_id' and application_plan_id = '$application_plan_id' and application_simulation_id = '$application_simulation_id'");

                        // delete desire
                        $desire = new ApplicationDesire();
                        $desire->deleteWhere("applicant_id = '$applicant_id' and application_plan_id = '$application_plan_id' and application_simulation_id = '$application_simulation_id'");


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
            $applicantObj->set("mobile", $this->getVal("mobile"));
            $applicantObj->commit();

            $this->set("country_id",$candidate_country_id);
            $this->set("applicant_id",$applicantObj->id);
            $this->commit();
                
            $applicationObj = $this->getMyApplication($applicantObj);

            $this->addMyApplicantAccounts();

            return [$applicantObj, $applicationObj];
        }

        return [];
        
    }
    

    public function getMyApplication()
    {
        if(!$this->applicationObj)
        {
            $applicant_id = $this->getVal("applicant_id");
            $application_simulation_id = $this->getVal("application_simulation_id");
            $application_plan_id = $this->getVal("application_plan_id");

            if($applicant_id and $application_plan_id and $application_simulation_id)
            {
                $this->applicationObj = Application::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id, $this->getVal("idn"), true);
                if($this->getVal("application_plan_branch_mfk")) $this->applicationObj->set("application_plan_branch_mfk", $this->getVal("application_plan_branch_mfk"));                            
                if($this->getVal("training_period_enum")) $this->applicationObj->set("training_period_enum", $this->getVal("training_period_enum"));  
                $this->applicationObj->set("signup_acknowldgment", "Y");  
                $this->applicationObj->set("comments", "NomCand :: first creation of applicatio");                
                $this->applicationObj->commit();
            }
        }
        
        

        return $this->applicationObj;
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
            else $applicationObj = $this->getMyApplication();

            $nbQuals = $applicantObj->getRelation("applicantQualificationList")->count();
            if($nbQuals==0) return "الرجاء استكمال المؤهلات العلمية أولا";
        
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
                list($applicantObj, $applicationObj) = $this->createOrRepareMyApplicationObjects();
                $applicant_id = $applicantObj->id;
                if(!$applicantObj or !$applicant_id) throw new AfwRuntimeException("failed to create applicant profile record");                
            }
            else $applicationObj = $this->getMyApplication();
            
            /**
            * @var Applicant $applicantObj
            */

            if($applicantObj)
            {
                $nbQuals = $applicantObj->getRelation("applicantQualificationList")->count();
                $application_status_enum = $applicationObj ? $applicationObj->getVal("application_status_enum") : 1;
                $application_status_code = self::application_status_code($application_status_enum);
                if($nbQuals==0)
                {
                    $label_btn = $applicantObj->translate("qualif", $lang);                    
                    return "<a class='btn btn-success btn-orange' style='min-width: 130px;font-size: 12px !important;' href='main.php?Main_Page=afw_mode_edit.php&cl=Applicant&currmod=adm&currstep=3&id=".$applicant_id."'>$label_btn</a><br>";
                }
                elseif($application_status_code != "complete")
                {
                    $label_btn = $applicantObj->translate("step6", $lang);                    
                    return "<a class='btn btn-success btn-orange' style='min-width: 130px;font-size: 12px !important;' href='main.php?Main_Page=afw_mode_edit.php&cl=Applicant&currmod=adm&currstep=6&id=".$applicant_id."'>$label_btn</a><br>";
                }
                else
                {
                        
                    $label_btn = $applicantObj->translate("show", $lang, true);                    
                    return "<a class='btn btn-success btn-orange' style='min-width: 130px;font-size: 12px !important;' href='main.php?Main_Page=afw_mode_edit.php&cl=Applicant&currmod=adm&currstep=1&id=".$applicant_id."'>$label_btn</a><br>";
                }
                
            } 

            return "<p class='error' hint='no applicant object found'>!!!</p>";
    }


    public function calcApplyConditionsDiv($what = "value")
    {
        // $applicantObj = $this->het("applicant_id");  and $applicantObj
        $applicationObj = $this->getMyApplication();        
        if($applicationObj)
        {
            $html = $applicationObj->calcApplyConditionsDiv($what);
        }
        else $html = "No application found, please contact administartor";

        return $html;
    }


    public function calcDragDropDiv($what = "value")
    {
        $html = "";
        $applicationObj = $this->getMyApplication();        
        if($applicationObj)
        {
            $html = $applicationObj->calcDragDropDiv($what);
        }

        return $html;
    }
    
    
    public function calcCandidateFullName($what = "value"){
        return $this->getVal("first_name_ar")." ".$this->getVal("second_name_ar")." ".$this->getVal("third_name_ar")." ".$this->getVal("last_name_ar");
    }


    public function calcProgram_offering_mfk($what = "value")
    {
        $applicationObj = $this->getMyApplication();        
        if($applicationObj)
        {
            return $applicationObj->calcProgram_offering_mfk($what);
        }
        else return ",";
    }


    public function assignedProgramDiv($what = "value")
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        if($this->getVal("academic_program_id")>0)
        {
            $message = $this->tm("Assigned academic program", $lang) . " : " . $this->decode("academic_program_id", '', false, $lang);
            return "<div class='warning info alert'>$message</div>";
        }
        else
        {
            return "";
        }
    }

    public function calcTrackOverpassDiv($what = "value")
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        if($this->sureIs("track_overpass"))
        {
            $rack_overpass_user_name = $this->decode("track_overpass_user_id", '', false, $lang);
            $rack_overpass_when = $this->decode("track_overpass_gdate", '', false, $lang);
            if(!$rack_overpass_when) $rack_overpass_when = "غير معروف";
            $message = $this->tm("Track has been overpassed by", $lang) . " : $rack_overpass_user_name ".$this->translateOperator('at',$lang)." ".$rack_overpass_when;
            return "<div class='warning info alert'>$message</div>";
        }
        else
        {
            return "";
        }
    }

    public function calcRatingOverpassDiv($what = "value")
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        if($this->sureIs("rating_overpass"))
        {
            $rating_overpass_user_name = $this->decode("rating_overpass_user_id", '', false, $lang);
            $rating_overpass_when = $this->decode("rating_overpass_gdate", '', false, $lang);
            if(!$rating_overpass_when) $rating_overpass_when = "غير معروف";
            $message = $this->tm("Rating has been overpassed by", $lang) . " : $rating_overpass_user_name ".$this->translateOperator('at',$lang)." ".$rating_overpass_when;
            return "<div class='warning info alert'>$message</div>";
        }
        else
        {
            return "";
        }
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

            $total_amount = $appFinTransObject->getVal("amount");
            $payment_status_enum = 4; // معفي من الدفع            
            ApplicantAccount::loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id, $appFinTransObject->id, $total_amount, $payment_status_enum, true);
        }
    }

    public function stepsAreOrdered()
    {
        if($this->isEmpty()) return true;
        return 5;
    }


    public function attributeIsApplicable($attribute)
    {
        $branch_count = count(explode(",",trim($this->getVal('application_plan_branch_mfk'),",")));
        $ok = ($branch_count == 1);
        if ($this->stepOfAttribute($attribute)>=6) {
                return $ok;
        }
        

        return true;
    }    

    protected function getSpecificDataErrors(
                $lang = 'ar',
                $show_val = true,
                $step = 'all',
                $erroned_attribute = null,
                $stop_on_first_error = false,
                $start_step = null,
                $end_step = null
        ) 
    {
                global $objme;
                $sp_errors = [];
                $branch_count = count(explode(",",trim($this->getVal('application_plan_branch_mfk'),",")));
                
                if ($this->stepContainAttribute($step, "application_plan_branch_mfk")) {
                    if ($branch_count>1) {
                            $sp_errors['application_plan_branch_mfk'] = $this->translateMessage('only one application branch is allowed', $lang);
                    }
                }

                return $sp_errors;
    }

    /*
    public static function statsData($paramsArr=[])
    {
        $lang= AfwLanguageHelper::getGlobalLanguage();
        $application_plan_id = $paramsArr["application_plan_id"];
        if(!$survey_id) $survey_id = 11;

        
        $sql_arr = [];
        $stat_trad = [];
        // $stat_trad["question"] = AfwLanguageHelper::translateStatsColumn("question", "Survey", null, $lang);
        $stat_trad["question_title"] = AfwLanguageHelper::translateStatsColumn("question_title", "Survey", null, $lang);
        $stat_trad["verysatisfied"] = AfwLanguageHelper::translateStatsColumn("verysatisfied", "Survey", null, $lang);
        $stat_trad["satisfied"] = AfwLanguageHelper::translateStatsColumn("satisfied", "Survey", null, $lang);
        $stat_trad["indifferent"] = AfwLanguageHelper::translateStatsColumn("indifferent", "Survey", null, $lang);
        $stat_trad["unsatisfied"] = AfwLanguageHelper::translateStatsColumn("unsatisfied", "Survey", null, $lang);
        $stat_trad["veryunsatisfied"] = AfwLanguageHelper::translateStatsColumn("veryunsatisfied", "Survey", null, $lang);
        $stat_trad["noresponse"] = AfwLanguageHelper::translateStatsColumn("noresponse", "Survey", null, $lang);
        // $stat_trad["all_count"] = AfwLanguageHelper::translateStatsColumn("all_count", "Survey", null, $lang);

        $q = "select SUM(nc.id) candid_id
        --,IF(na.nominating_authority_source_enum=1, 'داخلي', IF(na.nominating_authority_source_enum=2, 'خارجي', 'غير محدد')) source
        ,ac.program_name_ar
        --,na.nominating_authority_name_ar,sf.name_ar
        from ".$server_db_prefix."adm.application a 
        inner join ".$server_db_prefix."adm.applicant ap on a.applicant_id=ap.id 
        inner join ".$server_db_prefix."adm.nominating_candidates nc on ap.id=nc.applicant_id
        inner join ".$server_db_prefix."adm.nomination_letter nl on nc.nomination_letter_id = nl.id
        inner join ".$server_db_prefix."adm.nominating_authority na on nl.nominating_authority_id=na.id
        inner join ".$server_db_prefix."adm.study_funding_status sf on nc.study_funding_status_id = sf.id
        inner join ".$server_db_prefix."adm.academic_program ac on nc.academic_program_id = ac.id
        where a.application_plan_id = '".$application_plan_id."' group by ac.program_name_ar";

        
        


        return [AfwDatabase::db_recup_rows($sql), $stat_trad, $question_title_arr];

        
    }
    */


}



// errors 

