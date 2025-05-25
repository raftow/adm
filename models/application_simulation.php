<?php 

                
$file_dir_name = dirname(__FILE__); 
                
// require_once("$file_dir_name/../afw/afw.php");

class ApplicationSimulation extends AdmObject{

        public static $MY_ATABLE_ID=13951; 
  
        public static $DATABASE		= "uoh_adm";
        public static $MODULE		        = "adm";        
        public static $TABLE			= "application_simulation";

	    public static $DB_STRUCTURE = null;
	
	    public function __construct(){
		parent::__construct("application_simulation","id","adm");
            AdmApplicationSimulationAfwStructure::initInstance($this);    
	    }
        

        public static function loadById($id)
        {
           $obj = new ApplicationSimulation();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }

        protected function userCanDeleteMeSpecial($auser)
        {
            if($this->id <= 2) return false;
            return true;
        }

        public function deleteAction()
        {
            if($this->id <= 2) return ['', ''];
            return ['delete', ''];
        }
        
        public function isRunning()
        {
            $return = $this->getVal("progress_task");
            if($return=="--STOP--") $return = "";

            return $return;
        }

        public static function checkSimulation($simulation_id)
        {
            $now = date("dHis");
            $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
            $return = AfwDatabase::db_recup_row("select progress_value,progress_task from ".$server_db_prefix."adm.application_simulation where id = '".$simulation_id."' -- $now");

            if($return["progress_task"]=="--STOP--") 
            {
                $return["progress_task"] = "";
                $return["stop-me"] = true;
            }
            return $return;
        }

        public function getScenarioItemId($currstep)
                {
                    
                    return 0;
                }
        
        
        public function getDisplay($lang="ar")
        {
               return $this->getVal("name_$lang");
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
            $title_ar = "تنفيذ المحاكاة"; 
            $methodName = "runSimulation";
            list($dangerous_ar, $dangerous_en) = $this->calcDangerous();
            $pbRow = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("application_plan_id"));
            if($dangerous_en)
            {
                $by_settings_en = "By simulation settings";
                $by_settings_ar = $this->tm($by_settings_en, "ar");
                $methodConfirmationWarningEn = "This action can not be canceled !";
                $methodConfirmationWarning = $this->tm($methodConfirmationWarningEn, "ar") ." ". $by_settings_ar ." ". trim($dangerous_ar, "/");
                $methodConfirmationWarningEn .= " ". $by_settings_en ." ". trim($dangerous_en, "/");
    
                $methodConfirmationQuestionEn = "Are you sure you want to do this action ?";
                $methodConfirmationQuestion = $this->tm($methodConfirmationQuestionEn, "ar");

                $pbRow['CONFIRMATION_NEEDED'] = true;
                $pbRow['CONFIRMATION_WARNING'] = array('ar' => $methodConfirmationWarning, 'en' => $methodConfirmationWarningEn);
                $pbRow['CONFIRMATION_QUESTION'] = array('ar' => $methodConfirmationQuestion, 'en' => $methodConfirmationQuestionEn);
            }
            $pbms[AfwStringHelper::hzmEncode($methodName)] = $pbRow;
            
            $color = "red";
            $title_ar = "تصفير المحاكاة"; 
            $methodName = "resetMySimulation";
            $methodConfirmationWarningEn = "This action can not be canceled !";
            $methodConfirmationWarning = $this->tm($methodConfirmationWarningEn, "ar");

            $methodConfirmationQuestionEn = "Are you sure you want to reset the simulation ?";
            $methodConfirmationQuestion = $this->tm($methodConfirmationQuestionEn, "ar");
            $pbms[AfwStringHelper::hzmEncode($methodName)] = 
                    array("METHOD"=>$methodName,
                          "COLOR"=>$color, 
                          "LABEL_AR"=>$title_ar, 
                          "ADMIN-ONLY"=>true, 
                          "BF-ID"=>"", 
                          'CONFIRMATION_NEEDED' => true,
                          'CONFIRMATION_WARNING' => array('ar' => $methodConfirmationWarning, 'en' => $methodConfirmationWarningEn),
                          'CONFIRMATION_QUESTION' => array('ar' => $methodConfirmationQuestion, 'en' => $methodConfirmationQuestionEn),
                          'STEP' =>$this->stepOfAttribute("application_plan_id"));

            $color = "orange";
            $title_ar = "تصفير المحاكاة للحالات الغير مكتملة"; 
            $methodName = "resetSimulationForNotFinishedApplications";
            $pbms[AfwStringHelper::hzmEncode($methodName)] = 
                                  array("METHOD"=>$methodName,
                                        "COLOR"=>$color, 
                                        "LABEL_AR"=>$title_ar, 
                                        "ADMIN-ONLY"=>true, 
                                        "BF-ID"=>"", 
                                        'STEP' =>$this->stepOfAttribute("application_plan_id"));
                                                    
            
            
            return $pbms;
        }

        public function getOptions($option="all", $value=false)
        {
            $options_arr = [];
            $options_arr["SIMULATION-ID"] = $this->id;
            $settings_arr = explode("\n",$this->getVal("settings"));
            foreach($settings_arr as $settings_item)
            {
                $settings_item = trim($settings_item);
                list($optionItem, $optionVal) = explode("=",$settings_item);
                if($option=="all" or $option==$optionItem)
                {
                    if($value) 
                    {
                        // return "($option==all or $option=$optionItem) $settings_item => optionVal=$optionVal";
                        return $optionVal;                        
                    }
                    $options_arr[$optionItem] = $optionVal;
                }
            }
            if($value) return null;
            return $options_arr;
        }

        public function getMyApplicantList($applicationModelObj=null, $applicantGroupObj=null, $applicationPlanObj=null, $limit = '', $applyDateGreg='', $registerApplicants=[], $fromProspect=false, $lang='ar', $pct_here=30.0)
        {
            $application_simulation_id = $this->id;
            $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
            if(!$applicationModelObj) $applicationModelObj = $this->het("application_model_id");
            if(!$applicationModelObj) return [$applicationModelObj, $applicantGroupObj, $applicationPlanObj, [], "No application model defined"];
            if(!$applicantGroupObj) $applicantGroupObj = $this->het("applicant_group_id");
            if(!$applicantGroupObj) return [$applicationModelObj, $applicantGroupObj, $applicationPlanObj, [], "No applicant group defined"];
            
            $application_model_id = $applicationModelObj->id;            
            $applicant_group_id = $applicantGroupObj->id;
            // $application_simulation_id = $this->id;
            $arrOptions = $this->getOptions();
            $continue_from_stop = (strtolower($arrOptions["CONTINUE-FROM-STOP"])=="on");
            if($continue_from_stop and !$limit) 
            {
                $limit = $arrOptions["APPLICANTS-BATCH"];
                if(!$limit) $limit = 1000;
            }
            $offlineDesiresRows = [];
            $apContext = "defined";
            if(!$applicationPlanObj) 
            {
                $apContext = "current (at $applyDateGreg)";
                $applicationPlanObj = $applicationModelObj->getCurrentPlan($applyDateGreg);
            }
            if(!$applicationPlanObj) return [$applicationModelObj, $applicantGroupObj, $applicationPlanObj, [], "No $apContext application plan"];
            $application_plan_id = $applicationPlanObj->id;

            if($applicantGroupObj->id==2)
            {
                $where = "applicant_id in (select applicant_id from $server_db_prefix"."amd.application where application_plan_id=$application_plan_id and application_simulation_id=2)";
                $context = "Real applicants, applied on this plan (id=$application_plan_id)";
            }
            else
            {
                if($fromProspect)
                {
                    
                    
                    if(!$continue_from_stop) $last_done_idn = "";
                    else
                    {
                        $last_done_idn = ApplicantSimulation::aggreg("max(applicant_id)", "done='Y'");
                        if(!$last_done_idn) $last_done_idn = "";
                    }

                    $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
                    $dataProspectDesires = AfwDatabase::db_recup_rows("select * from ".$server_db_prefix."adm.prospect_desire where idn > '$last_done_idn' order by idn limit $limit");
                    $cntDone = 0;
                    $cntTotal = count($dataProspectDesires);
                    foreach($dataProspectDesires as $rowProspectDesire)
                    {
                        $registerApplicantIdn = $rowProspectDesire["idn"];
                        if($registerApplicantIdn)
                        {
                                $offlineDesiresRows[$registerApplicantIdn] = $rowProspectDesire;
                                // will run register apis and this should contain the offline data api
                                $objAppl = Applicant::loadByMainIndex($registerApplicantIdn, true);                
                                $cntDone++;
                                // sleep(1);
                                $register_of = $this->tm("register of", $lang);
                                $objApplDisplay = $objAppl->getDisplay($lang);
                                // put it in the group so that to be taken by simulation
                                $objAppl->set("application_model_id", $application_model_id);
                                $objAppl->set("applicant_group_id", $applicant_group_id);
                                $objAppl->commit();

                                $objApplSim = ApplicantSimulation::loadByMainIndex($application_simulation_id, $objAppl->id, true);  
                                unset($objApplSim);

                                unset($objAppl);
                                /*
                                $pctDone = ($cntDone*$pct_here)/$cntTotal;
                                $this->set("progress_value",$pctDone);
                                $this->set("progress_task",$register_of." ".$objApplDisplay);
                                $this->commit();*/

                                AfwDatabase::db_query("UPDATE ".$server_db_prefix."adm.prospect_desire set done='Y' where idn = '$registerApplicantIdn'");
                        }     
                    }
                    unset($dataProspectDesires);
                    $context = "Applicants configured in prospects settings (prospect_desire)";
                }
                else
                {
                    
                    $cntDone = 0;
                    $cntTotal = count($registerApplicants);
                    foreach($registerApplicants as $registerApplicantIdn)
                    {
                        if($registerApplicantIdn)
                        {
                                // will run register apis and this should contain the offline data api
                                $objAppl = Applicant::loadByMainIndex($registerApplicantIdn, true);                
                                $cntDone++;
                                // sleep(1);
                                $register_of = $this->tm("register of", $lang);
                                $objApplDisplay = $objAppl->getDisplay($lang);
                                // put it in the group so that to be taken by simulation
                                $objAppl->set("application_model_id", $application_model_id);
                                $objAppl->set("applicant_group_id", $applicant_group_id);
                                $objAppl->commit();
                                $pctDone = ($cntDone*$pct_here)/$cntTotal;
                                $this->set("progress_value",$pctDone);
                                $this->set("progress_task",$register_of." ".$objApplDisplay);
                                $this->commit();
                                
                                $objApplSim = ApplicantSimulation::loadByMainIndex($this->id, $objAppl->id, true);  
                                unset($objApplSim);
                                
                                unset($objAppl);
                        }                    
                    }
                    $context = "Applicants configured to be simulated in settings";
                }

                $where = "active='Y' and application_simulation_id=$application_simulation_id and done != 'Y'";
                // "active='Y' and application_model_id = $application_model_id and applicant_group_id=$applicant_group_id";
                
            }

            

            $obj = new ApplicantSimulation();
            $obj->where($where);
            // die("ApplicationSimulation sql many = ".$obj->getSQLMany('', $limit));

            return [$applicationModelObj, $applicantGroupObj, $applicationPlanObj, $obj->loadMany($limit,"done desc, applicant_id"), $context, $offlineDesiresRows];
        }

        public static function log($type, $appidn, $text)
        {
            if($type=="title") return "<h1 class='rslog hide $appidn'>$text</h1>";
            return "<p class='rslog hide $type $appidn'>$text</p>";
        }

        public function stopSimulation($lang="ar")
        {
            $this->set("progress_task","--STOP--");
            $this->commit();
        }

        public function shouldIShowThisApplicant($apid, $apblocked, $blocked_applicants)
        {
            $arrOptions = $this->getOptions();
            $applicants_to_show = $arrOptions["SHOW_APPLICANTS"];
            $max_applicants_to_show = $arrOptions["SHOW_APPLICANTS_MAX"];

            if($applicants_to_show=="BLOCKED") 
            {
                if(!$max_applicants_to_show) $max_applicants_to_show = 10;
                if($apblocked and (count($blocked_applicants)<$max_applicants_to_show))
                {
                    $blocked_applicants[] = $apid;
                    return [true, $blocked_applicants];
                }
                else return [false, $blocked_applicants];
                
            }

            $showApplicants = explode(",", $applicants_to_show);
            $show = ((count($showApplicants)==0) or (in_array($apid, $showApplicants)));

            return [$show, $blocked_applicants];
        }

        public function resetSimulationForNotFinishedApplications()
        {
            $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
            /** 
             * @var ApplicationPlan $applicationPlanObj 
             * */
            $applicationPlanObj = $this->het("application_plan_id");
            $application_plan_id = $applicationPlanObj->id;

            $desire_select_step_id = $applicationPlanObj->getApplicationModel()->calcDesires_selection_step_id();

            $application_simulation_id = $this->id;
            $sets_arr = ['done'=>'N'];
            $where_clause = "active='Y' and application_simulation_id=$application_simulation_id and applicant_id in (select tmp.applicant_id from ".$server_db_prefix."adm.application tmp where tmp.application_simulation_id=$application_simulation_id and tmp.application_plan_id=$application_plan_id and tmp.application_step_id!=$desire_select_step_id)";
            ApplicantSimulation::updateWhere($sets_arr, $where_clause);
        }

        public function resetSimulation($cases)
        {
            $application_simulation_id = $this->id;
            $sets_arr = ['done'=>'N'];
            $where_clause = "active='Y' and application_simulation_id=$application_simulation_id";
            if($cases and (strtolower($cases) != "all")) $where_clause = "and applicant_id in ($cases)";
            ApplicantSimulation::updateWhere($sets_arr, $where_clause);
        }



        public function resetMySimulation($lang="ar")
        {
            return $this->runSimulation($lang, $only_reset=true);
        }

        public function runSimulation($lang="ar", $only_reset=false)
        {
            global $MODE_BATCH_LOURD, $boucle_loadObjectFK;
            $old_MODE_BATCH_LOURD = $MODE_BATCH_LOURD;
            $MODE_BATCH_LOURD = true;
            $old_boucle_loadObjectFK = $boucle_loadObjectFK;
            set_time_limit(1800); 

            AfwSession::setConfig("_sql_analysis_seuil_calls",700000);
            AfwSession::setConfig("applicant_api_request-sql-analysis-max-calls",100000);
            AfwSession::setConfig("applicant-sql-analysis-max-calls",8000);
            AfwSession::setConfig("applicant_simulation-sql-analysis-max-calls",8000);
            AfwSession::setConfig("applicant_qualification-sql-analysis-max-calls",8000);
            AfwSession::setConfig("application-sql-analysis-max-calls",8000);
            AfwSession::setConfig("application_desire-sql-analysis-max-calls",250000);
            AfwSession::setConfig('MAX_INSTANCES_BY_REQUEST',250000);
            $MAX_TO_LOG = 10;
            if($this->id==2) $typeRun = $this->tm("Real application", $lang);
            else $typeRun = $this->tm("Application simulation", $lang);

            $arrOptions = $this->getOptions();
            if(!$arrOptions["DATE"]) $arrOptions["DATE"] = date("Y-m-d");
            if(!$arrOptions["LOG"])
            {
                $arrOptions["LOG"] = "ERROR,WARNING";
            }
            $log = true;
            $log_err = AfwStringHelper::stringContain($arrOptions["LOG"],"ERROR");
            $log_inf = AfwStringHelper::stringContain($arrOptions["LOG"],"INFO");
            $log_war = AfwStringHelper::stringContain($arrOptions["LOG"],"WARNING");
            $log_tech = AfwStringHelper::stringContain($arrOptions["LOG"],"DEBUGG");
            if($only_reset) $arrOptions["RESET_SIMULATION"] = "all";
            if($arrOptions["RESET_SIMULATION"] and (strtolower($arrOptions["RESET_SIMULATION"])!="none"))
            {
                $this->resetSimulation($arrOptions["RESET_SIMULATION"]);
            }

            $fromProspect = false;
            if(($arrOptions["REGISTER_APPLICANTS"]=="PROSPECT"))
            {
                $fromProspect = true;
                $arrOptions["REGISTER_APPLICANTS"]="";
            }

            $stopIfError = (strtolower($arrOptions["STOP_IF_ERROR"])=="on");
            
            $registerApplicants = explode(",",$arrOptions["REGISTER_APPLICANTS"]);
            

            $blocked_applicants = [];

            $err_arr = [];
            $inf_arr = [];
            $war_arr = [];
            $tech_arr = [];
            $log_arr = [];
            $result_arr = [];
            $simulation_method = $this->getVal("simul_method_enum");
            $simulation_method_dec = $this->decode("simul_method_enum");
            if($fromProspect and ($simulation_method!=4)) 
            {
                $war_arr[] = "You are loading applicants from prospect data and you are using method : $simulation_method_dec";
            }

            $nbLogged = 0;
            /*try {*/
                // $application_model_id = $this->getVal("application_model_id");
                // $applicant_group_id = $this->getVal("applicant_group_id");
                list($applicationModelObj, $applicantGroupObj, $applicationPlanObj, $applicantSimList, $context, $offlineDesiresRows) = $this->getMyApplicantList(null,null,null,'',$arrOptions["DATE"],$registerApplicants,$fromProspect,$lang,30.0);
                $err = "";
                if(!$applicationModelObj) $err = $this->tm("No Application Model Defined for this simulation", $lang);
                elseif(!$applicantGroupObj) $err = $this->tm("No Applicant Group Defined for this simulation", $lang);
                elseif(!$applicationPlanObj) $err = $this->tm("No Application Plan Defined for this simulation", $lang) . ". ".$this->tm("If you have not defined the DATE parameter for simulation, the system will take the current gregorian date and the current academic term to find the appropriate application plan", $lang);
                else
                {
                    $this->set("application_plan_id", $applicationPlanObj->id);
                    $this->set("blocked_applicants_mfk", ",0,");
                    $this->commit();
                    $nbApplicants = count($applicantSimList);
                    if($nbApplicants==0) $err = $this->tm("No Applicants found in context", $lang) . " : $context";
                    else 
                    {
                        $log1 = $this->tm("Number of Applicants found in context", $lang) . " : *** <!-- $context --> = $nbApplicants";
                        $inf_arr[] = $log1;
                        $log_arr[] = $log1;
                    }
                }

                if ($err) 
                {
                    $err_arr[] = "error : " . $err;                    
                    $log_arr[] = "error : " . $err; 
                }
                else
                {
                    $cntTotal = count($applicantSimList);
                    $inf_arr[] = "Nb of applicants to simulate application : $cntTotal";
                    
                    $cntDoneSuccess = 0; 
                    $cntDone = 0;
                    /**
                     * @var Applicant $applicantItem
                     */
                    
                    $cc = 0;
                    $bootstraps = 0;
                    $desire_bootstraps = 0;

                    $smallBatchSize = ceil(count($applicantSimList) / 50);
                    if($smallBatchSize<10) $smallBatchSize = 10;
                    
                    $row = null;
                    foreach($applicantSimList as $apsid => $applicantSimItem)
                    {
                        $apid = $applicantSimItem->getVal("applicant_id");
                        $cc++;
                        if($cc==$smallBatchSize) $cc = 0;
                        $applicantItem = Applicant::loadById($apid); 
                        
                        $logMe = $applicantItem->sureIs("log");
                        list($pbm_result, $tech_result) = $applicantItem->simulateApplication($applicationPlanObj, $this, $offlineDesiresRows[$apid],$lang, $only_reset);
                        $bootstraps += $tech_result['bootstraps'];
                        $desire_bootstraps += $tech_result['desire_bootstraps'];
                        $bootstrap_blocked = $tech_result['blocked'];
                        $bootstrap_blocked_reason = $tech_result['blocked_reason'];
                        $bootstrap_blocked_label = $bootstrap_blocked ? $this->tm("simulation has failed", $lang) . " : " . $bootstrap_blocked_reason  : $this->tm("simulation has succeeded", $lang);
                        list($err, $inf, $war, $tech) = $pbm_result;
                        $applicant_name = $applicantItem->getDisplay($lang);
                        $applicant_idn = $applicantItem->getVal("idn");
                        $applicant_id = $applicantItem->id;
                        $cntDone++;
                        if (!$err) $cntDoneSuccess++;
                        // sleep(1);
                        $pctDone = 30+($cntDone*70.0)/$cntTotal;

                        // test if the user has breaked the simulation
                        if(($cc==($smallBatchSize-5)) or ($row === null))                        
                        {
                            if(!$only_reset)
                            {
                                $row = ApplicationSimulation::checkSimulation($this->id);
                                $progress_value = $row["progress_value"];
                                $progress_task = $row["progress_task"];
                                $stopeMe = $row["stop-me"];
                                  
                            }

                            if($progress_value != $pctDone)
                            {
                                $this->set("progress_value",$pctDone);
                                $this->set("progress_task",$applicant_name);
                                $this->commit();
                            }

                            if($stopeMe) break;  
                        }
                        list($showMe, $blocked_applicants) = $this->shouldIShowThisApplicant($apid, $bootstrap_blocked, $blocked_applicants);
                        if($logMe and $showMe and $nbLogged<$MAX_TO_LOG)
                        {
                            $nbLogged++;
                            
                            if ($err)
                            {
                                $err_arr[] = "$applicant_name : " . $err;                    
                                if($stopIfError) break;
                            } 
                            // if ($inf) $inf_arr[] = "$applicant_name : " . $inf;
                            // if ($war) $war_arr[] = "$applicant_name : " . $war;
                            // if ($tech) $tech_arr[] = $tech;    
                            $t_for = $this->translateOperator("for", $lang);
                            $t_error = $this->translateOperator("error", $lang);
                            $t_information = $this->translateOperator("information", $lang);
                            $t_warning = $this->translateOperator("warning", $lang);
                            $t_debugg = $this->translateOperator("debugg", $lang);
                            $title_sim = "<a target='applicant' href='main.php?Main_Page=afw_mode_edit.php&cl=Applicant&currmod=adm&id=$applicant_id'>$typeRun $t_for $applicant_idn - $applicant_name - $bootstrap_blocked_label</a>";
                            $log_arr[] = self::log('title', 'app'.$applicant_idn, $title_sim);
                            if ($err and $log and $log_err) $log_arr[] = self::log('error', 'app'.$applicant_idn, "$t_error : " . $err);                    
                            if ($inf and $log and $log_inf) $log_arr[] = self::log('info', 'app'.$applicant_idn, "$t_information : " . $inf);
                            if ($war and $log and $log_war) $log_arr[] = self::log('warning', 'app'.$applicant_idn, "$t_warning : " . $war);
                            if ($tech and $log and $log_tech) $log_arr[] = self::log('debugg', 'app'.$applicant_idn, "$t_debugg : " . $tech);    
                            
                        }

                        if(!$bootstrap_blocked) 
                        {
                            $applicantSimItem->set("done","Y");
                        }
                        else 
                        {
                            $applicantSimItem->set("done","W");
                            $applicantSimItem->set("blocked_reason",$bootstrap_blocked_reason);
                            if(count($war_arr)<50)
                            {
                                $war_arr[] = "Blocked case : $applicant_idn blocked reason : [$bootstrap_blocked_reason]";
                            }
                            
                        }
                        $applicantSimItem->commit();

                        unset($applicantItem);
                        unset($applicantSimList[$apsid]);
                        unset($applicantSimItem);

                        if(count($log_arr)>6000) 
                        {
                            $log = false;
                            self::log('debugg', 'app'.$applicant_idn, "too much log so stopped"); 
                        }

                        
                    }

                    $result_arr["total"] = $cntDone;
                    $result_arr["success"] = $cntDoneSuccess;
                    $result_arr["abootstrap"] = $bootstraps;
                    $result_arr["dbootstrap"] = $desire_bootstraps;

                    $inf_arr[] = "Nb of applicants simulated : $cntDone";
                    $inf_arr[] = "Nb of applicants simulated with success : $cntDoneSuccess";
                    $inf_arr[] = "Nb of application bootstrap(s) : $bootstraps";
                    $inf_arr[] = "Nb of desire bootstrap(s) : $desire_bootstraps";
                }

                $the_log = implode("\n",$log_arr);

                $this->set("progress_task","");
                $this->set("log", $the_log);
                $this->set("blocked_applicants_mfk", ",".implode(",", $blocked_applicants).",");
                $this->commit();
            /*    
            } catch (Exception $e) {
                $err_arr[] = $e->getMessage();
            } catch (Error $e) {
                $err_arr[] = $e->__toString();
            }
                */
            // die("war_arr=".var_export($war_arr));

            $result_arr["errors"] = count($err_arr);
            $result_arr["warnings"] = count($war_arr);

            $boucle_loadObjectFK = $old_boucle_loadObjectFK;
            $MODE_BATCH_LOURD = $old_MODE_BATCH_LOURD;
            return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr, $result_arr);
        }

        
        
        public function userCanDoOperationOnMe(
            $auser,
            $operation,
            $operation_sql
        ) {
            throw new AfwRuntimeException("userCanDoOperationOnMe($auser->id,$operation,$operation_sql)");
            if($operation_sql=="delete" or $operation_sql=="update") return (($this->id != 1) and ($this->id != 2));
            
            return true;
        }

        public function beforeMaj($id, $fields_updated)
        {
            if(!$fields_updated["log"])
            {
                $this->set("log", "waiting execution ...");
            }
            
            return true;
        }
        
        public function beforeDelete($id,$id_replace) 
        {
            $server_db_prefix = AfwSession::config("db_prefix","uoh_");
            
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

    public function stepsAreOrdered()
    {
        return true;
    }


    public function calcApplicant_ids($what="value")
    {
        $to_show = $this->getOptions("SHOW_APPLICANTS", true);
        if(!$to_show) $to_show = "BLOCKED";
        if($to_show == "BLOCKED")
        {
            $show_applicants_mfk = $this->getVal("blocked_applicants_mfk");
        }
        else
        {
            $show_applicants_mfk = $to_show;
        }

        // if(is_array($show_applicants_mfk)) die("show_applicants_mfk is an array : ".var_export($show_applicants_mfk,true));        
        $show_applicants_mfk = trim($show_applicants_mfk,",");
        if(!$show_applicants_mfk) $show_applicants_mfk = "0";
        return $show_applicants_mfk;
    }

    public function calcControlPanel($what = "value")
    {
        $smid = $this->id;
        $lang = AfwLanguageHelper::getGlobalLanguage();
        $running_message = $this->tm("The simulation is being executed. Please do not exit the page until it is finished.",$lang); 
        $done_message = $this->tm("The simulation is termintated !!!",$lang); 
        $progress_value = $this->getVal("progress_value");
        $simulation_progress_task = $this->getVal("progress_task");
        if($simulation_progress_task=="--STOP--") $simulation_progress_task = "";
        // $progress_value = 49.9;
        if(!$simulation_progress_task) 
        {
            $progress_value = 0.0;
            $stop_disbaled = "disabled";
            $run_disbaled = "disabled"; // no ajax run
            $run_current_check = "<!-- !!!!!!!!!!! **** no simulation-check needed  **** !!!!!!!!!!! -->";
        }
        else
        {
            $stop_disbaled = "";
            $run_disbaled = "disabled";
            $run_current_check = "<script type=\"text/javascript\">
                    $(document).ready(function(){
                        checkCurrentSimulation();
                    });   
            
</script>";
            
        }
        $simulation_progress_value = 5 * intval(floor($progress_value / 5));
        $simulation_real_progress = intval(floor($progress_value * 100)) / 100.0;
        if($simulation_progress_value>0)
        {
            $simulation_progress_value_pct = "$simulation_real_progress%";
        }
        else
        {
            $simulation_progress_value_pct = "";
        }
        // $simulation_progress_task = "تجربة البروقراس بار لرؤية ظهور النص بشكل واضح في داخله";
        $html = "<div class='simulation-panel'>";        
        $html .= "<div id=\"simulation_progress_bar\" class=\"simulation_progress bar\" >
                <div id=\"simulation_progress_value\" class=\"simulation_progress value-$simulation_progress_value\" >&nbsp</div>
        </div>";
        $html .= "<div id=\"simulation_progress_task\" class=\"simulation_progress task\" >$simulation_progress_value_pct - $simulation_progress_task</div>";
        $html .= "</div> <!-- simulation-panel -->";
        $html .= "<div class='control-panel'>";  
        $run_simulation = $this->tm("run simulation", $lang);
        $html .= "<input type=\"button\" name=\"simulation_btn\" simid='$smid' lang='$lang' id=\"simulation_btn\" hint=\"...\" class=\"fa finish simulation_btn longbtn greenbtn wizardbtn center $run_disbaled\" value=\"&nbsp;$run_simulation&nbsp;\" style=\"margin-right: 40%;margin-bottom: 12px;\">";    
        $stop_simulation = $this->tm("stop simulation", $lang);
        $html .= "<input type=\"button\" name=\"stop_simulation_btn\" id=\"stop_simulation_btn\" hint=\"...\" class=\"fa finish stop simulation_btn longbtn yellowbtn wizardbtn center  $stop_disbaled\" value=\"&nbsp;$stop_simulation&nbsp;\" style=\"margin-right: 20px;margin-bottom: 12px;\">";                    
        $html .= "<div class='control-status hide' id='sim-running'>$running_message</div>";
        $html .= "<div class='control-status done hide' id='sim-done'>$done_message</div>";
        $html .= "<input type=\"hidden\" name=\"check-interval-id\" id=\"check-interval-id\" value=\"\" >";    
        $html .= "</div> <!-- control-panel --> $run_current_check";
        return $html;
    }

    public function calcLogPanel($what = "value")
    {
        $smid = $this->id;
        $lang = AfwLanguageHelper::getGlobalLanguage();
        $simulation_progress_task = $this->getVal("progress_task");
        if($simulation_progress_task=="--STOP--") $simulation_progress_task = "";
        $html = "<div class='simulation-panel'>";  
        $html .= "<div class='control-panel'>";  
        if(!$simulation_progress_task)
        {
            
            $html .= "   <div id=\"log_panel\" class=\"log panel\" >";
            $applicationList = $this->get("applicationList");
            foreach($applicationList as $applicationItem)
            {
                $idapp = $applicationItem->getVal("applicant_id");
                $disp = $applicationItem->getShortDisplay($lang);
                $html .= "      <div id=\"log-ap-$idapp\" class=\"simlog case ap-$idapp\" >$disp</div>";
                $html .= "      ";   
            }
            $html .= "   </div> <!-- log_panel -->";   
        }
        else
        {
            $html .= "<div class='control-text' id='sim-run-status'>is running ... please wait the end or stop simulation</div>";
        }        
        $html .= "</div> <!-- control-panel -->";
        return $html;
    }

    public function calcDangerous($what = "value")    
    {

        $arrOptions = $this->getOptions();
        $reset_simulation = (strtolower($arrOptions["RESET_SIMULATION"])!="none");
        $erase_existing_desires = (strtolower($arrOptions["ERASE-EXISTING-DESIRES"])!="off");

        $result_en = "";
        $result_ar = "";

        $reset_simulation_war_en = "The simulation will be reset for some or all applicants";
        $reset_simulation_war_ar = $this->tm($reset_simulation_war_en, "ar");
        $erase_existing_desires_war_en = "The existing desires will reset and re-applied";
        $erase_existing_desires_war_ar = $this->tm($erase_existing_desires_war_en, "ar");
        
        if($reset_simulation) 
        {
            $result_ar .= "/". $reset_simulation_war_ar;
            $result_en .= "/". $reset_simulation_war_ar;
        }
        if($erase_existing_desires) 
        {
            $result_ar .= "/". $erase_existing_desires_war_ar;
            $result_en .= "/". $erase_existing_desires_war_en;
        }

        return [$result_ar, $result_en];
    }

    public function calcStatsPanel($what = "value")
    {
        $smid = $this->id;
        $lang = AfwLanguageHelper::getGlobalLanguage();
        $simulation_progress_task = $this->getVal("progress_task");
        if($simulation_progress_task=="--STOP--") $simulation_progress_task = "";
        $html = "<div class='simulation-panel'>";  
        $html .= "<div class='stats-panel'>";  
        $html .= "   <div id=\"stats_panel\" class=\"stats panel\" >";
        $server_db_prefix = AfwSession::config("db_prefix", "default_db_");

        $arrOptions = $this->getOptions();
        $keyDecodeArr = [];
        $keyDecodeArr["done"] = $this->translate("done", $lang);
        $keyDecodeArr["to-do"] = $this->translate("to-do", $lang);
        $keyDecodeArr["standby"] = $this->translate("standby", $lang);
        
        $fromProspect = false;
        if(($arrOptions["REGISTER_APPLICANTS"]=="PROSPECT"))
        {
            $fromProspect = true;
            $arrOptions["REGISTER_APPLICANTS"]="";
        }        

        $sql_done = "SELECT 'done' as `status`, count(*) as nb FROM ".$server_db_prefix."adm.`applicant_simulation` WHERE `application_simulation_id`=$smid and done = 'Y'
                    union
                    SELECT 'to-do' as `status`, count(*) as nb FROM ".$server_db_prefix."adm.`applicant_simulation` WHERE `application_simulation_id`=$smid and done = 'N'
                    union
                    SELECT 'standby' as `status`, count(*) as nb FROM ".$server_db_prefix."adm.`applicant_simulation` WHERE `application_simulation_id`=$smid and done = 'W'";

        if($fromProspect)
        {   
            $keyDecodeArr["prospect"] = $this->translate("prospect", $lang);         
            $sql_done .= "
                    union
                    SELECT 'prospect' as status, count(*) as nb FROM ".$server_db_prefix."adm.`prospect_desire` WHERE done = 'N';";
        }

        $rows_done = AfwDatabase::db_recup_index($sql_done,"status","nb");
        $html .= "<h1>".$this->tm("Simulation results by status", $lang)."</h1>";
        $html .= AfwHtmlHelper::arrayToHtml($rows_done, $keyDecodeArr);
        $application_model_id = $this->getVal("application_model_id");
        $applicant_group_id = $this->getVal("applicant_group_id");

        $sql_bootstrap = "SELECT b.atype, b.step_num, b.step_name, b.nb, b.example_applicant, b.example_applicant2 from 
                           (SELECT 'applicant' as atype, 0 as step_num, 'التسجيل' as `step_name`, count(*) as nb, min(id) as example_applicant, max(id) as example_applicant2 
                                        FROM ".$server_db_prefix."adm.applicant where application_model_id=$application_model_id and applicant_group_id=$applicant_group_id 
                                union 
                            SELECT 'application' as atype, max(step_num) as step_num, `application_step_id` as `step_name`, count(*) as nb, min(applicant_id) as example_applicant, max(applicant_id) as example_applicant2 
                                        FROM ".$server_db_prefix."adm.`application` WHERE `application_simulation_id` = $smid 
                                            group by `application_step_id` 
                                union
                            SELECT 'desire' as atype, max(step_num) as step_num, `application_step_id` as `step_name`, count(*) as nb, min(applicant_id) as example_applicant, max(applicant_id) as example_applicant2 
                                        FROM ".$server_db_prefix."adm.`application_desire` WHERE `application_simulation_id` = $smid 
                                            group by `application_step_id`) b order by b.step_num asc";

        
        
        $rows_bootstrap = AfwDatabase::db_recup_rows($sql_bootstrap);
        
        $header_bootstrap = ["step_name","nb","atype","example_applicant","example_applicant2"];
        $header_bootstrap = AfwLanguageHelper::translateCols($this,$header_bootstrap, $lang, true);
        $html .= "<h1>".$this->tm("Simulation results by step", $lang)."</h1>";
        $decoderArr = [];
        $decoderArr["atype"] = ["applicant"=>$this->tm("applicant", $lang), "application"=>$this->tm("application", $lang), "desire"=>$this->tm("desire", $lang)];
        $decoderArr["comments"] = ["registered"=>$this->tm("registered", $lang)];
        $decoderArr["step_name"] = AfwLoadHelper::loadAllLookupData(new ApplicationStep,"application_model_id = $application_model_id","");

        // die("decoderArr=".var_export($decoderArr,true));
        $html .= AfwHtmlHelper::tableToHtml($rows_bootstrap, $header_bootstrap, $decoderArr);
        
        
        $html .= "   </div> <!-- stats_panel -->";   
        $html .= "</div> <!-- stats-panel -->";
        $html .= "</div> <!-- simulation-panel -->";
        return $html;
    }
             
}



// errors 

