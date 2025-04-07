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
             global $lang;
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
            $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("controlPanel"));
            
            
            
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

            return $options_arr;
        }

        public function getMyApplicantList($applicationModelObj=null, $applicantGroupObj=null, $applicationPlanObj=null, $limit = '', $applyDateGreg='', $registerApplicants=[], $fromProspect=false, $lang='ar', $pct_here=30.0)
        {
            $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
            if(!$applicationModelObj) $applicationModelObj = $this->het("application_model_id");
            if(!$applicationModelObj) return [$applicationModelObj, $applicantGroupObj, $applicationPlanObj, [], "No application model defined"];
            if(!$applicantGroupObj) $applicantGroupObj = $this->het("applicant_group_id");
            if(!$applicantGroupObj) return [$applicationModelObj, $applicantGroupObj, $applicationPlanObj, [], "No applicant group defined"];
            
            $application_model_id = $applicationModelObj->id;            
            $applicant_group_id = $applicantGroupObj->id;
            // $application_simulation_id = $this->id;

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
                $where = "id in (select applicant_id from $server_db_prefix"."amd.application where application_plan_id=$application_plan_id and application_simulation_id=2)";
                $context = "Real applicants, applied on this plan (id=$application_plan_id)";
            }
            else
            {
                if($fromProspect)
                {
                    $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
                    $dataProspectDesires = AfwDatabase::db_recup_rows("select * from ".$server_db_prefix."adm.prospect_desire");
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
                                /*
                                $pctDone = ($cntDone*$pct_here)/$cntTotal;
                                $this->set("progress_value",$pctDone);
                                $this->set("progress_task",$register_of." ".$objApplDisplay);
                                $this->commit();*/
                        }     
                    }
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
                        }                    
                    }
                }

                $where = "active='Y' and application_model_id = $application_model_id and applicant_group_id=$applicant_group_id";
                $context = "Applicants that has favorite model (id=$application_model_id) and belongs to group (id=$applicant_group_id)";
            }

            

            $obj = new Applicant();
            $obj->where($where);

            return [$applicationModelObj, $applicantGroupObj, $applicationPlanObj, $obj->loadMany($limit), $context, $offlineDesiresRows];
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

        public function runSimulation($lang="ar")
        {
            AfwSession::setConfig("_sql_analysis_seuil_calls",7000);
            AfwSession::setConfig("applicant_api_request-sql-analysis-max-calls",6000);
            AfwSession::setConfig("application_desire-sql-analysis-max-calls",10000);
            $MAX_TO_LOG = 10;
            if($this->id==2) $typeRun = $this->tm("Real application", $lang);
            else $typeRun = $this->tm("Application simulation", $lang);

            $arrOptions = $this->getOptions();
            if(!$arrOptions["DATE"]) $arrOptions["DATE"] = date("Y-m-d");
            if(!$arrOptions["LOG"])
            {
                $arrOptions["LOG"] = "ERROR,WARNING";
            }
            $log_err = AfwStringHelper::stringContain($arrOptions["LOG"],"ERROR");
            $log_inf = AfwStringHelper::stringContain($arrOptions["LOG"],"INFO");
            $log_war = AfwStringHelper::stringContain($arrOptions["LOG"],"WARNING");
            $log_tech = AfwStringHelper::stringContain($arrOptions["LOG"],"DEBUGG");
            $fromProspect = false;
            if(($arrOptions["REGISTER_APPLICANTS"]=="PROSPECT"))
            {
                $fromProspect = true;
                $arrOptions["REGISTER_APPLICANTS"]="";
            }
            
            $registerApplicants = explode(",",$arrOptions["REGISTER_APPLICANTS"]);
            $showApplicants = explode(",",$arrOptions["SHOW_APPLICANTS"]);
            $err_arr = [];
            $inf_arr = [];
            $war_arr = [];
            $tech_arr = [];
            $log_arr = [];

            $nbLogged = 0;
            /*try {*/
                // $application_model_id = $this->getVal("application_model_id");
                // $applicant_group_id = $this->getVal("applicant_group_id");
                list($applicationModelObj, $applicantGroupObj, $applicationPlanObj, $applicantList, $context, $offlineDesiresRows) = $this->getMyApplicantList(null,null,null,'',$arrOptions["DATE"],$registerApplicants,$fromProspect,$lang,30.0);
                $err = "";
                if(!$applicationModelObj) $err = $this->tm("No Application Model Defined for this simulation", $lang);
                elseif(!$applicantGroupObj) $err = $this->tm("No Applicant Group Defined for this simulation", $lang);
                elseif(!$applicationPlanObj) $err = $this->tm("No Application Plan Defined for this simulation", $lang) . ". ".$this->tm("If you have not defined the DATE parameter for simulation, the system will take the current gregorian date and the current academic term to find the appropriate application plan", $lang);
                else
                {
                    $this->set("application_plan_id", $applicationPlanObj->id);
                    $nbApplicants = count($applicantList);
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
                    $cntTotal = count($applicantList);
                    $cntDone = 0;
                    /**
                     * @var Applicant $applicantItem
                     */
                    
                    $applicantIdnList = array_keys($applicantList);

                    foreach($applicantIdnList as $apidn)
                    {
                        $applicantItem =& $applicantList[$apidn]; 
                        // test if the user has breaked the simulation
                        $row = ApplicationSimulation::checkSimulation($this->id);
                        $progress_value = $row["progress_value"];
                        $progress_task = $row["progress_task"];
                        $stopeMe = $row["stop-me"];
                        if($stopeMe) break;
                        $showMe = ((count($showApplicants)==0) or (in_array($apidn, $showApplicants)));
                        $logMe = $applicantItem->sureIs("log");
                        list($err, $inf, $war, $tech) = $applicantItem->simulateApplication($applicationPlanObj, $this, $offlineDesiresRows[$apidn]);
                        $applicant_name = $applicantItem->getDisplay($lang);
                        $applicant_idn = $applicantItem->getVal("idn");
                        $applicant_id = $applicantItem->id;
                        $cntDone++;
                        // sleep(1);
                        $pctDone = 30+($cntDone*70.0)/$cntTotal;
                        $this->set("progress_value",$pctDone);
                        $this->set("progress_task",$applicant_name);
                        $this->commit();
                        if($logMe and $showMe and $nbLogged<$MAX_TO_LOG)
                        {
                            $nbLogged++;
                            
                            if ($err) $err_arr[] = "$applicant_name : " . $err;                    
                            if ($inf) $inf_arr[] = "$applicant_name : " . $inf;
                            if ($war) $war_arr[] = "$applicant_name : " . $war;
                            if ($tech) $tech_arr[] = $tech;    
                            $t_for = $this->translateOperator("for", $lang);
                            $t_error = $this->translateOperator("error", $lang);
                            $t_information = $this->translateOperator("information", $lang);
                            $t_warning = $this->translateOperator("warning", $lang);
                            $t_debugg = $this->translateOperator("debugg", $lang);
                            $title_sim = "<a target='applicant' href='main.php?Main_Page=afw_mode_edit.php&cl=Applicant&currmod=adm&id=$applicant_id'>$typeRun $t_for $applicant_idn - $applicant_name</a>";
                            $log_arr[] = self::log('title', 'app'.$applicant_idn, $title_sim);
                            if ($err and $log_err) $log_arr[] = self::log('error', 'app'.$applicant_idn, "$t_error : " . $err);                    
                            if ($inf and $log_inf) $log_arr[] = self::log('info', 'app'.$applicant_idn, "$t_information : " . $inf);
                            if ($war and $log_war) $log_arr[] = self::log('warning', 'app'.$applicant_idn, "$t_warning : " . $war);
                            if ($tech and $log_tech) $log_arr[] = self::log('debugg', 'app'.$applicant_idn, "$t_debugg : " . $tech);    
                            
                        }

                        unset($applicantItem);
                        unset($applicantList[$apidn]);
                    }
                }

                $the_log = implode("\n",$log_arr);
                if(strlen($the_log)>20000) $the_log = "too much log, please reduce the number of informations to log or the number of applicants to audit";
                $this->set("progress_task","");
                $this->set("log", $the_log);
                $this->commit();
            /*    
            } catch (Exception $e) {
                $err_arr[] = $e->getMessage();
            } catch (Error $e) {
                $err_arr[] = $e->__toString();
            }
                */
            // die("war_arr=".var_export($war_arr));
            return AfwFormatHelper::pbm_result($err_arr, $inf_arr, $war_arr, "<br>\n", $tech_arr);
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
        $return = $this->getOptions("SHOW_APPLICANTS", true);
        if(!$return) $return = "0";
        // die("getOptions(SHOW_APPLICANTS, true) = $return");
        return $return;
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
            $run_disbaled = "";
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
        if($simulation_progress_value>0)
        {
            $simulation_progress_value_pct = "$simulation_progress_value%";
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
        $html .= "<div id=\"simulation_progress_task\" class=\"simulation_progress task\" >$simulation_progress_value_pct $simulation_progress_task</div>";
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
             
}



// errors 

