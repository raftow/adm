<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table adm_orgunit : adm_orgunit - جهات المتابعة و إعداداتها 
// ------------------------------------------------------------------------------------
// alter table ".$server_db_prefix."adm.adm_employee add   admin char(1) DEFAULT NULL  after service_mfk;
// update ".$server_db_prefix."adm.adm_employee set admin = 'N';
                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class AdmEmployee extends AdmObject
{
        public static $orgListOfEmployee = [];

        // public static $MY_ATABLE_ID= ??; 
        // 117 CRM_INVESTIGATOR	محقق خدمة العملاء			
        public static $JOBROLE_CRM_INVESTIGATOR =  117;
        // 118 CRM_CONTROLLER	مراقب خدمة العملاء			
        public static $JOBROLE_CRM_CONTROLLER =  118;
        // 119 CRM_SUPERVISION	الإشراف العام	
        public static $JOBROLE_CRM_SUPERVISION =  119;		
        // 107 CRM_COORDINATION	مشرف تنسيق
        public static $JOBROLE_CRM_COORDINATION =  107;

     
        
	public static $DATABASE		= ""; 
        public static $MODULE		    = "adm"; 
        public static $TABLE			= "adm_employee"; 
        public static $DB_STRUCTURE = null;
        
        public function __construct(){
		parent::__construct("adm_employee","id","adm");
                AdmAdmEmployeeAfwStructure::initInstance($this);  
                
	}

        

        public static function resetAll()
        {
           $obj = new AdmEmployee();
           $obj->setForce("active", "N");
           $obj->setForce("admin", "N");
           return $obj->update(false);           
        }
        
        public static function loadById($id)
        {
           $obj = new AdmEmployee();
           // $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        public function select_visibilite_horizontale($dropdown=false)
        {
                $objme = AfwSession::getUserConnected();
                
                if($objme and $objme->isAdmin()) 
                {
                        // no VH for system admin
                }
                else
                {
                        $empl_id = $objme ? $objme->getEmployeeId() : 0;
                        
                        if($empl_id) $iam_general_supervisor = AdmObject::userConnectedIsGeneralSupervisor();
                        if($empl_id) $iam_supervisor = AdmObject::userConnectedIsSupervisor();                        
                        if(!$iam_general_supervisor) $iam_general_supervisor = 0;
                        if(!$iam_supervisor) $iam_supervisor = 0;

                        // if the user is an employee 
                        // he is allowed to see adm employee if :
                        // 1. he is a general supervisor 
                        // or
                        // 2. he is a supervisor

                        $employee_allowed_to_see_adm_employee_cond = 
                            "($iam_general_supervisor>0 or $iam_supervisor>0)";
                        
                        $this->where("($empl_id>0 and $employee_allowed_to_see_adm_employee_cond)"); 
                        
                }
                        
                $selects = array();
                $this->select_visibilite_horizontale_default($dropdown, $selects);
        }
        
        
        public static function loadByMainIndex($orgunit_id, $employee_id, $create_obj_if_not_found=false)
        {
           $obj = new AdmEmployee();
           if(!$orgunit_id) throw new AfwRuntimeException("loadByMainIndex : orgunit_id is mandatory field");
           if(!$employee_id) throw new AfwRuntimeException("loadByMainIndex : employee_id is mandatory field");


           $obj->select("orgunit_id",$orgunit_id);
           $obj->select("employee_id",$employee_id);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("orgunit_id",$orgunit_id);
                $obj->set("employee_id",$employee_id);
                
                $obj->insert();
                $obj->is_new = true;
                return $obj;
           }
           else return null;
           
        }


        public static function auserAdmEmployee($employee_id, $orgunit_id=0)
        {
                if(!$orgunit_id) $orgunit_id = AdmEmployee::orgOfEmployee($employee_id, false, true);

                if($orgunit_id>0) return AdmEmployee::checkExistance($orgunit_id, $employee_id);
                else return null;
        }
        

        public static function checkExistance($orgunit_id, $employee_id)
        {
                if(!$orgunit_id) return false;
                if(!$employee_id) return false;

                $objadmemp = self::loadByMainIndex($orgunit_id, $employee_id, $create_obj_if_not_found=false);

                return $objadmemp;
        }



        public function getDisplay($lang="ar")
        {
               
               $data = array();
               $link = array();
               

               list($data[0],$link[0]) = $this->displayAttribute("employee_id",false, $lang);
               list($data[1],$link[1]) = $this->displayAttribute("orgunit_id",false, $lang);

               
               return implode(" - ",$data);
        }

        public function getShortDisplay($lang="ar")
        {
               return $this->showAttribute("employee_id");
        }


        protected function getOtherLinksArray($mode, $genereLog = false, $step="all")      
        {
             global $me, $objme, $lang;
             $otherLinksArray = $this->getOtherLinksArrayStandard($mode, false, $step);
             $my_id = $this->getId();
             $displ = $this->getDisplay($lang);
             
             
             
             return $otherLinksArray;
        }
        
        protected function getPublicMethods()
        {
            
            $pbms = array();
            
            $color = "green";
            $title_ar = "xxxxxxxxxxxxxxxxxxxx"; 
            //$pbms["xc123B"] = array("METHOD"=>"methodName","COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"");
            
            
            
            return $pbms;
        }
        
        
        


        public function afterInsert($id, $fields_updated) 
        {
                if($this->sureIs("active") and ($this->getVal("employee_id")>0))
                {
                        $empl = $this->het("employee_id");
                        if($empl)
                        {
                                $empl->addMeThisJobrole(self::$JOBROLE_CRM_INVESTIGATOR);
                                $empl->updateMyUserInformation();
                        }
                }
        }

        public function afterUpdate($id, $fields_updated) 
        {
                if(($this->getVal("employee_id")>0) and 
                   ($fields_updated["active"] or $fields_updated["admin"] or $fields_updated["super_admin"] or $fields_updated["requests_nb"]))
                {
                        $empl = $this->het("employee_id");
                        if($this->sureIs("active"))
                        {
                                if($this->sureIs("super_admin"))
                                {
                                     //
                                     $empl->addMeThisJobrole(self::$JOBROLE_CRM_INVESTIGATOR);
                                     $empl->addMeThisJobrole(self::$JOBROLE_CRM_COORDINATION);
                                     $empl->addMeThisJobrole(self::$JOBROLE_CRM_CONTROLLER);
                                     $empl->addMeThisJobrole(self::$JOBROLE_CRM_SUPERVISION);
                                     $empl->updateMyUserInformation();    
                                }
                                elseif($this->sureIs("admin"))
                                {
                                        $empl->addMeThisJobrole(self::$JOBROLE_CRM_INVESTIGATOR);
                                        $empl->addMeThisJobrole(self::$JOBROLE_CRM_COORDINATION);
                                        $empl->addMeThisJobrole(self::$JOBROLE_CRM_CONTROLLER);
                                        $empl->removeMeThisJobrole(self::$JOBROLE_CRM_SUPERVISION);
                                        $empl->updateMyUserInformation();    
                                }
                                else
                                {
                                        $empl->addMeThisJobrole(self::$JOBROLE_CRM_INVESTIGATOR);
                                        $empl->removeMeThisJobrole(self::$JOBROLE_CRM_COORDINATION);
                                        $empl->removeMeThisJobrole(self::$JOBROLE_CRM_CONTROLLER);
                                        $empl->removeMeThisJobrole(self::$JOBROLE_CRM_SUPERVISION);
                                        $empl->updateMyUserInformation();    
                                }        
                        }
                        else
                        {
                                $empl->removeMeThisJobrole(self::$JOBROLE_CRM_COORDINATION);
                                $empl->removeMeThisJobrole(self::$JOBROLE_CRM_SUPERVISION);
                                $empl->removeMeThisJobrole(self::$JOBROLE_CRM_CONTROLLER);
                                $empl->updateMyUserInformation();    
                                // has been disabled so remove all ongoing assigned tickets   
                                $this->removeMeAllAssigned();
                        }
                         

                        Request::assignSupervisorForNonAssigned(false,true);
                }
        }


        private function removeMeAllAssigned()
        {
            $obj = new Request();

            $me_id = $this->getVal("employee_id");
            $me_org_id = $this->getVal("orgunit_id");


            $obj->where("supervisor_id = $me_id");
            $obj->where("status_id not in (6,7,8,9)");
            $obj->setForce("supervisor_id",0);
            $obj->update(false);


            
            $obj->where("(employee_id = $me_id and orgunit_id = $me_org_id)");
            $obj->where("status_id in (2,4)");
            $obj->setForce("employee_id",0);
            $obj->setForce("orgunit_id",0);
            $status_comment = "removeMeAllAssigned me_id=".$me_id;
            $obj->setForce("status_comment", $status_comment);
            $obj->update(false);
        }
        
        public function beforeDelete($id,$id_replace) 
        {
            
            
            if($id)
            {   
               if($id_replace==0)
               {
                   $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK part of me - not deletable 

                        
                   $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK part of me - deletable 

                   
                   // FK not part of me - replaceable 

                        
                   
                   // MFK

               }
               else
               {
                        $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK on me 

                        
                        // MFK

                   
               } 
               return true;
            }    
	    }


        
        


        public function calcRequests_count($only_done=false, $ongoing_only=false, $satisfied_only=false, $surveyed_only=false)
        {
            if(!$this->getVal("employee_id")) return null;

            $employee_id = $this->getVal("employee_id");
            $orgunit_id = $this->getVal("orgunit_id");

            $obj = new Request();
            $obj->select("employee_id", $employee_id);
            $obj->select("orgunit_id", $orgunit_id);

            if($only_done) $obj->where("status_id in (".Request::$REQUEST_STATUSES_DONE.")");
            elseif($ongoing_only) $obj->where("status_id in (".Request::$REQUEST_STATUSES_ONGOING_INVESTIGATOR.")");

            if($satisfied_only) $obj->where("service_satisfied = 'Y'");

            if($surveyed_only) $obj->where("survey_sent = 'Y'");

            return $obj->count();
        }

        public function calcDone_requests_count($satisfied_only=false, $surveyed_only=false)
        {
                return $this->calcRequests_count($only_done=true, $ongoing_only=false, $satisfied_only, $surveyed_only);
        }

        public function calcDoneSurveyed_requests_count($satisfied_only=false)
        {
                return $this->calcDone_requests_count($satisfied_only, $surveyed_only=true);
        }

        public function calcDoneSurveyedSatisfied_requests_count()
        {
                return $this->calcDoneSurveyed_requests_count($satisfied_only=true);
        }

        public function calcOngoing_requests_count($satisfied_only=false, $surveyed_only=false)
        {
                return $this->calcRequests_count($only_done=false, $ongoing_only=true, $satisfied_only, $surveyed_only);
        }

        public function calcInbox_count()
        {
                if(!$this->getVal("employee_id")) return null;
                $myEmplId = $this->getVal("employee_id");
                if(AdmEmployee::isAdmin($myEmplId)) 
                {
                        $where_sql = "((".Request::inboxSqlCond("supervisor", $myEmplId, "").") or (".Request::inboxSqlCond("investigator", $myEmplId, "")."))";
                }
                else
                {
                        $where_sql = Request::inboxSqlCond("investigator", $myEmplId, "");
                }

                $obj = new Request();
                $obj->where($where_sql);

                return $obj->count();
        }


        public function calcStatif_pct()
        {
            $all_count = $this->calcDoneSurveyed_requests_count();
            if(!$all_count) return null;
            $satisfied_only_count = $this->calcDoneSurveyedSatisfied_requests_count();
            

            return round($satisfied_only_count*100/$all_count);
        }

        public static function getSupervisorArray()
        {
                $obj = new AdmEmployee();
                // $obj->select_visibilite_horizontale();
                $obj->select("admin","Y");
                $obj->select("active", 'Y');

                return $obj->loadMany();
        }

        public static function getSupervisorList()
        {
                
                $objList = self::getSupervisorArray();

                $supervList = array();

                foreach($objList as $objItem)
                {
                        $supervList[$objItem->getVal("employee_id")] = array('obj' => $objItem, 'curr' => 0);   // ->getDisplay("ar")
                }
                return $supervList;
        }

        public static function isAdmin($employee_id)
        {
                $obj = new AdmEmployee();
                $obj->select("admin","Y");
                $obj->select("employee_id",$employee_id);
                $obj->load();
                return $obj->id;

        }


        public static function isGeneralAdmin($employee_id)
        {
                $obj = new AdmEmployee();
                $obj->select("super_admin","Y");
                $obj->select("employee_id",$employee_id);
                $obj->load();
                return $obj->id;

        }

        public static function getInvestigatorListOfIds($orgunit_id)
        {
                $invList = self::getInvestigatorList($orgunit_id);

                $invListIds = array();
                foreach($invList as $id => $invObj)
                {
                        $invListIds[] = $invObj->id;
                }

                return array($invListIds, $invList);
        }

        public static function getInvestigatorList($orgunit_id, $except_investigator_id=0)
        {
                $obj = new AdmEmployee();
                if(!$orgunit_id) $obj->simpleError("getInvestigatorList need a correct and valid orgunit_id");
                // $obj->select_visibilite_horizontale();
                $obj->select("orgunit_id",$orgunit_id);
                $obj->select("active", 'Y');
                $obj->where("super_admin = 'N' and employee_id != $except_investigator_id");  
                // admin = 'N' and // rafik 30/8/2022 : I removed this from above acondition because admin (مشرف تنسيق) can be a supervisor 
                
                
                $objList = AfwLoadHelper::loadList($obj, "employee_id");

                return $objList;
        }

        public static function getInvestigatorArray($orgunit_id, $except_investigator_id=0)
        {
                $obj = new AdmEmployee();
                if(!$orgunit_id) $obj->simpleError("getInvestigatorList need a correct and valid orgunit_id");
                // $obj->select_visibilite_horizontale();
                $obj->select("orgunit_id",$orgunit_id);
                $obj->select("active", 'Y');
                $obj->where("admin = 'N' and super_admin = 'N' and employee_id != $except_investigator_id");
                
                $objList = $obj->loadMany();

                $investList = array();

                foreach($objList as $objItem)
                {
                        $investList[$objItem->getVal("employee_id")] = array('obj' => $objItem, 'curr' => 0);   // ->getDisplay("ar")
                }
                return $investList;
        }


        public static function orgOfEmployee($employee_id, $return_object=false, $return_id = true)
        {
                if(!self::$orgListOfEmployee[$employee_id])
                {
                        $obj = new AdmEmployee();
                        // $obj->select_visibilite_horizontale();
                        $obj->select("employee_id",$employee_id);
                        $obj->select("active", 'Y');
                        
                        self::$orgListOfEmployee[$employee_id] = AfwLoadHelper::loadList($obj, "orgunit_id");
                }
                
                $objList = self::$orgListOfEmployee[$employee_id];

                if(count($objList)==1)
                {
                        foreach($objList as $objItem) 
                        {
                                if($return_object) return  $objItem;
                                elseif($return_id) return $objItem->id;
                                else 
                                {
                                        $lang = AfwSession::getSessionVar("current_lang");
                                        if(!$lang) $lang = "ar";
                                        return AfwLanguageHelper::tt("المنسق(ـة) في") . " " . $objItem->getDisplay($lang);
                                }
                        }                
                }
                elseif(count($objList)>1)
                {
                        if($return_object) return  null;
                        elseif($return_id) return 0;
                        else 
                        {
                                $lang = AfwSession::getSessionVar("lang");
                                if(!$lang) $lang = "ar";
                                return "<div class='adm-warning'>".AfwLanguageHelper::tt("معين في أكثر من جهة متابعة",$lang)."</div>";
                        }
                }
                else
                {
                        if($return_object) return  null;
                        elseif($return_id) return 0;
                        else 
                        {
                                $lang = AfwSession::getSessionVar("lang");
                                if(!$lang) $lang = "ar";
                                return "<div class='adm-warning'>".AfwLanguageHelper::tt("غير معين في جهة متابعة",$lang)."</div>";
                        }
                }
        }

        public static function getBestAvailableInvestigator($orgunit_id, $except_investigator_id=0)
        {
                $investigatorList = self::getInvestigatorArray($orgunit_id);
                if($except_investigator_id) unset($investigatorList[$except_investigator_id]);
                else $except_investigator_id=0;
                // AfwRunHelper::safeDie("investigatorList = ".var_export($investigatorList,true));
                $stats_arr = Request::aggreg($function="count(*)", $where="active='Y' and status_id in (".Request::$REQUEST_STATUSES_ONGOING_INVESTIGATOR.") and orgunit_id=$orgunit_id and employee_id > 0 and employee_id != $except_investigator_id", $group_by = "employee_id",$throw_error=true, $throw_analysis_crash=true);
                // AfwRunHelper::safeDie("stats_arr = ".var_export($stats_arr,true));
                $best_investigator_id = 0;
                if(count($stats_arr)>0)
                {
                        $min_curr_count = 99999;
                        
                        foreach($stats_arr as $investigator_id => $curr_count)
                        {
                                $investigatorList[$investigator_id]["curr"] = $curr_count;
                                if(($curr_count < $min_curr_count) and ($investigatorList[$investigator_id]["obj"]))
                                {
                                        $min_curr_count = $curr_count;
                                        $best_investigator_id = $investigator_id; 
                                }

                        }
                }

                // but if one licensor doesn't have any previous request assigned he will not be in $stats_arr 
                // he should be the best_licensor because he have no request assigned, so check this :
                foreach($investigatorList as $investigator_id => $investigatorItem)
                {
                        if(!$investigatorItem["curr"]) $best_investigator_id = $investigator_id; 
                }


                
                
                if((!$best_investigator_id) or (!$investigatorList[$best_investigator_id]["obj"]))
                {
                        reset($investigatorList);
                        $first_item = current($investigatorList);
                        // AfwRunHelper::safeDie("first_item = ".var_export($first_item,true)." investigatorList = ".var_export($investigatorList,true));
                        if($first_item["obj"]) $best_investigator_id = $first_item["obj"]->getVal("employee_id");
                }

                if($best_investigator_id) $return = $investigatorList[$best_investigator_id];
                else $return = null;

                // die("best_investigator_id = $best_investigator_id , return = ".var_export($return,true).", investigatorList = ".var_export($investigatorList,true));

                return array($best_investigator_id, $return, $investigatorList);

                
                
                
        }

        public static function getBestAvailableSupervisor($except_supervisor_id=0,$re_distribution=false)
        {
                global $allSupervisorList;
                if(!$allSupervisorList) $allSupervisorList = self::getSupervisorList();                
                $supervisorList = $allSupervisorList;
                if($except_supervisor_id) unset($supervisorList[$except_supervisor_id]);
                else $except_supervisor_id=0;                 
                // AfwRunHelper::safeDie("supervisorList = ".var_export($supervisorList,true));
                $best_supervisor_id = 0;


                $stats_arr = Request::aggreg($function="count(*)", $where="active='Y' and status_id in (".Request::$REQUEST_STATUSES_ONGOING_SUPERVISOR.") and supervisor_id > 0 and supervisor_id != $except_supervisor_id", $group_by = "supervisor_id",$throw_error=true, $throw_analysis_crash=true);                                        
                if(count($stats_arr)>0)
                {
                        foreach($stats_arr as $superv_id => $curr_count)
                        {
                                $supervisorList[$superv_id]["curr"] = $curr_count;
                        }
                }



                $min_curr_count = 99999;

                foreach($supervisorList as $superv_id => $supervisorRow)
                {
                        $curr_count = $supervisorRow["curr"];
                        if(($curr_count < $min_curr_count) and ($supervisorRow["obj"]))
                        {
                                $min_curr_count = $curr_count;
                                $best_supervisor_id = $superv_id; 
                        }
                }


                if((!$best_supervisor_id) or (!$supervisorList[$best_supervisor_id]["obj"]))
                {
                        reset($supervisorList);
                        $first_item = current($supervisorList);
                        // AfwRunHelper::safeDie("first_item = ".var_export($first_item,true)." supervisorList = ".var_export($supervisorList,true));
                        if($first_item["obj"]) $best_supervisor_id = $first_item["obj"]->getVal("employee_id");
                }

                if($best_supervisor_id) $return = $supervisorList[$best_supervisor_id];
                else $return = null;

                // AfwRunHelper::safeDie("best_supervisor_id = $best_supervisor_id , return = ".var_export($return,true));

                return array($best_supervisor_id, $return, $supervisorList, $stats_arr);

                
                
                
        }

        public function assignMeAsRequestSupervisor($requestObj, $commit = true)
        {
                $requestObj->set("supervisor_id", $this->getVal("employee_id"));
                if($commit) $requestObj->commit();
        }


        public function assignMeAsRequestInvestigator($requestObj, $lang="ar")
        {
                list($err, $info) = $requestObj->assignRequest($this->getVal("employee_id"), $lang);
                if($err) AfwSession::pushError($err);
                if($info) AfwSession::pushInformation($info); 
        }

        public function calcArchive_date()
        {                
		return AfwDateHelper::shiftHijriDate("",-180);
        }


        protected function hideDisactiveRowsFor($auser)
        {
                if(!$auser) return true;
                if(AdmObject::userConnectedIsGeneralSupervisor($auser)) return false;
                if($auser->isAdmin()) return false;  
                return true;
        }

        public function shouldBeCalculatedField($attribute){
                if($attribute=="email") return true;
                return false;
        }

        public function myShortNameToAttributeName($attribute)
        {
                if ($attribute == "employee") return "employee_id";
                
                return $attribute;
        }

        
             
}
?>