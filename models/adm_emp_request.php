<?php
// alter table ".$server_db_prefix."adm.adm_emp_request add   admin char(1) DEFAULT NULL  after service_mfk;
// update ".$server_db_prefix."adm.adm_emp_request set admin = 'N';

$file_dir_name = dirname(__FILE__);

// old include of afw.php

class AdmEmpRequest extends AdmObject
{

        // public static $MY_ATABLE_ID= ??; 
        // 117 CRM_INVESTIGATOR	محقق خدمة العملاء			
        public static $JOBROLE_CRM_INVESTIGATOR =  117;
        // 118 CRM_CONTROLLER	مراقب خدمة العملاء			
        public static $JOBROLE_CRM_CONTROLLER =  118;
        // 119 CRM_SUPERVISION	الإشراف العام	
        public static $JOBROLE_CRM_SUPERVISION =  119;
        // 107 CRM_COORDINATION	مشرف تنسيق
        public static $JOBROLE_CRM_COORDINATION =  107;



        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "adm_emp_request";
        public static $DB_STRUCTURE = null;

        public function __construct()
        {
                parent::__construct("adm_emp_request", "id", "adm");
                AdmAdmEmpRequestAfwStructure::initInstance($this);
        }

        public static function resetAll()
        {
                $obj = new AdmEmpRequest();
                $obj->setForce("active", "N");
                $obj->setForce("admin", "N");
                return $obj->update(false);
        }

        public static function loadById($id)
        {
                $obj = new AdmEmpRequest();
                // $obj->select_visibilite_horizontale();
                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public function getScenarioItemId($currstep)
        {
                if ($currstep == 1) return 502;
                if ($currstep == 2) return 503;
                if ($currstep == 3) return 504;

                return 0;
        }

        public static function loadByMainIndex($orgunit_id, $employee_id, $email, $create_obj_if_not_found = false)
        {
                if (!$orgunit_id) throw new AfwRuntimeException("loadByMainIndex : orgunit_id is mandatory field");
                if (!$employee_id) throw new AfwRuntimeException("loadByMainIndex : employee_id is mandatory field");


                $obj = new AdmEmpRequest();
                $obj->select("orgunit_id", $orgunit_id);
                $obj->select("employee_id", $employee_id);
                $obj->select("email", $email);

                if ($obj->load()) {
                        if ($create_obj_if_not_found) $obj->activate();
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        $obj->set("orgunit_id", $orgunit_id);
                        $obj->set("employee_id", $employee_id);
                        $obj->set("email", $email);

                        $obj->insertNew();
                        if (!$obj->id) return null; // means beforeInsert rejected insert operation
                        $obj->is_new = true;
                        return $obj;
                } else return null;
        }

        

        protected function getOtherLinksArray($mode, $genereLog = false, $step = "all")
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
                $employee_id = $this->getVal("employee_id");
                $color = "green";
                $title_ar = "تحديث البيانات من نظام الموارد البشرية";
                $pbms["yc12UI"] = array(
                        "METHOD" => "updateFromExternalSources",
                        "COLOR" => $color,
                        "LABEL_AR" => $title_ar,
                        "PUBLIC" => true,
                        "BF-ID" => "",
                );
                if (!$this->sureIs("approved")) {
                        $methodConfirmationWarningEn = $this->getVal("reject_reason");
                        if (strlen($methodConfirmationWarningEn)<5) {
                                $methodConfirmationWarningEn = "You formally agree that this employee belongs to this organization";
                                $methodConfirmationWarning = $this->tm($methodConfirmationWarningEn, "ar");
                        } else $methodConfirmationWarning = $this->getVal("reject_reason");
                        if (!$methodConfirmationWarning) $methodConfirmationWarning = $this->tm($methodConfirmationWarningEn, "ar");

                        $methodConfirmationQuestionEn = "Are you sure you want to do this approve ?";
                        $methodConfirmationQuestion = $this->tm($methodConfirmationQuestionEn, "ar");
                        $color = "green";
                        if(!$employee_id) $title_ar = "تعيين هذا الموظف على هذه الجهة وعكس صلاحياته";
                        else $title_ar = "عكس التحديثات على الصلاحيات  والبيانات";
                        $pbms["Ac122B"] = array(
                                "METHOD" => "approveAndUpdataDataAndRoles",
                                "COLOR" => $color,
                                "LABEL_AR" => $title_ar,
                                "PUBLIC" => true,
                                "BF-ID" => "",
                                'CONFIRMATION_NEEDED' => true,
                                'CONFIRMATION_WARNING' => array('ar' => $methodConfirmationWarning, 'en' => $methodConfirmationWarningEn),
                                'CONFIRMATION_QUESTION' => array('ar' => $methodConfirmationQuestion, 'en' => $methodConfirmationQuestionEn),
                        );
                }

                if ($this->getVal("employee_id")) 
                {
                        $methodConfirmationWarningEn = "This action can not be canceled !";
                        $methodConfirmationWarning = $this->tm($methodConfirmationWarningEn, "ar");

                        $methodConfirmationQuestionEn = "Are you sure you want to reset the password ?";
                        $methodConfirmationQuestion = $this->tm($methodConfirmationQuestionEn, "ar");
                        $color = "green";
                        $title_ar = "تصفير كلمة المرور الى كلمة مرور مؤقتة";
                        $pbms["xc123B"] = array(
                                "METHOD" => "temporaryPassword",
                                "COLOR" => $color,
                                "LABEL_AR" => $title_ar,
                                "PUBLIC" => true,
                                "BF-ID" => "",
                                'CONFIRMATION_NEEDED' => true,
                                'CONFIRMATION_WARNING' => array('ar' => $methodConfirmationWarning, 'en' => $methodConfirmationWarningEn),
                                'CONFIRMATION_QUESTION' => array('ar' => $methodConfirmationQuestion, 'en' => $methodConfirmationQuestionEn),
                        );
                }        
                



                return $pbms;
        }


        public function beforeMaj($id, $fields_updated)
        {
                global $lang;
                if($fields_updated["gender_id"] or
                   $fields_updated["hierarchy_level_enum"] or 
                   $fields_updated["firstname"] or
                   $fields_updated["lastname"] or
                   $fields_updated["lastname_en"] or
                   $fields_updated["firstname_en"] or $fields_updated["jobrole_mfk"])      
                {
                        $this->set("approved", "W");
                        $this->set("reject_reason", "----");
                }
                

                return true;
        }

        public function afterUpdate($id, $fields_updated) {}

        public function updateFromExternalSources($lang="ar", $resetExisting=true, $commit=true, $forceDoApproval=false)
        {
                $doApproval = false;   
                if($forceDoApproval) $doApproval = true;
                else
                {
                        if(!$this->sureIs("approved"))
                        {
                                $doApproval = true;   
                        }
                }
                $error = "";
                $warning = "";
                $information = "";
                $technical = "";
                if(!$this->isOk(true, false, $lang)) return [$this->tm("There are errors in data, process can not be completed", $lang), ""];                
                $orgunit_id = $this->getVal("orgunit_id");
                $employee_id = $this->getVal("employee_id");
                $email = $this->getVal("email");
                $emplObj=null;
                if($employee_id) $emplObj = $this->het("employee_id");
                if($emplObj and $emplObj->id and (!$email))
                {
                        $email = $emplObj->getVal("email");
                        $this->set("email", $email);
                }
                $create_obj_if_not_found = true;
                $main_orgunit_id = AfwSession::config("main_orgunit_id", 1);
                if(!$orgunit_id) return [$this->tm("Define first the organization of this employee", $lang), "", ""];
                if(!$email) return [$this->tm("Define first the email of this employee", $lang), "", ""];
                if(!$this->sureIs("active")) return [$this->tm("This reuest is not active, so can not be proceeded", $lang), "", ""];
                if ($employee_id and (!$resetExisting)) 
                {
                        return ["", $this->tm("This account already exists")];
                } 
                else 
                {
                        $emplObj = Employee::loadByEmail($main_orgunit_id, $email, $create_obj_if_not_found);
                        list($err, $info, $war, $tech) = $emplObj->updateMyInfosFromExternalSources($lang);
                        if($doApproval)
                        {
                                if ($err) 
                                {
                                        $this->set("approved", "W");
                                        if($lang=="ar") $this->set("reject_reason", $err);
                                        else $this->set("reject_reason", $err);
                                        $error = $this->tm("The empolyee account has been rejected", $lang). " : " . $err;
                                } 
                                else 
                                {
                                        $emplObj_name_ar = $emplObj->getDisplay("ar");
                                        $emplObj_name_en = $emplObj->getDisplay("en");
                                        $id_sh_org = $emplObj->getVal("id_sh_org");
                                        $id_sh_dep = $emplObj->getVal("id_sh_dep");
                                        $id_sh_div = $emplObj->getVal("id_sh_div");
                                        if (($id_sh_org == $orgunit_id) or ($id_sh_dep == $orgunit_id) or ($id_sh_div == $orgunit_id)) 
                                        {
                                                $this->set("approved", "Y");
                                                if($lang=="ar")  $this->set("reject_reason", "--");
                                                else $this->set("reject_reason", "--");
                                                $employee_id = $emplObj->id;
                                                $this->set("employee_id", $employee_id);
                                                $information = $this->tm("The empolyee account has been approved, he can use it now", $lang);
                                        } 
                                        else 
                                        {
                                                $org_name_ar = $this->showAttribute("orgunit_id", null, true, "ar");
                                                $org_name_en = $this->showAttribute("orgunit_id", null, true, "en");
                                                $sh_name_ar = $emplObj->showAttribute("id_sh_org", null, true, "ar") . "-" . $emplObj->showAttribute("id_sh_dep", null, true, "ar") . "-" . $emplObj->showAttribute("id_sh_div", null, true, "ar");
                                                $sh_name_en = $emplObj->showAttribute("id_sh_org", null, true, "en") . "-" . $emplObj->showAttribute("id_sh_dep", null, true, "en") . "-" . $emplObj->showAttribute("id_sh_div", null, true, "en");
        
                                                if($lang=="ar") $reject_reason = $emplObj_name_ar . " : " . $this->tm("This employee is not from", "ar") . " $org_name_ar " . $this->tm("but from", "ar") . " $sh_name_ar";
                                                else $reject_reason = $emplObj_name_en . " : " . $this->tm("This employee is not from", "en") . " $org_name_en " . $this->tm("but from", "en") . " $sh_name_en";
                                                $this->set("approved", "N");
                                                $this->set("reject_reason", $reject_reason);
                                                $technical = $reject_reason;
                                                $warning = $this->tm("The empolyee account has been rejected", $lang);
                                        }
                                }
                        }
                        else
                        {
                                if($err) $error .= $err;
                                if($info) $information .= $info;
                                if($war) $warning .= $war;
                                if($tech) $technical .= $tech;
                        }
                        
                }
                /*
                $empl = $this->het("employee_id");
                if($empl)
                {
                        $empl->addMeThisJobrole(self::$JOBROLE_CRM_INVESTIGATOR);
                        $empl->updateMyUserInformation();
                }*/
                
                
                

                if ($this->sureIs("active") and $this->sureIs("approved") and ($orgunit_id > 0) and ($emplObj->id > 0)) 
                {
                        $reset_password = $emplObj->is_new;
                        if($reset_password)
                        {
                                $warning .= " resetting password ... ";  
                                list($err, $info, $war) = $this->temporaryPassword($lang, $emplObj, null);
                                if($err) $warning .= " error : $err";
                                if($info) 
                                {
                                        if($err) $warning .= " : ". $info;
                                        else $information .= " : ". $info;
                                }
                                if($war) $warning .= " war : $war";
                        }
                        AdmEmployee::loadByMainIndex($orgunit_id, $emplObj->id, true);
                }

                if($commit) $this->commit();

                return [$error, $information, $warning, $technical];
        }

        public function approveAndUpdataDataAndRoles($lang="ar", $create_obj_if_not_found = true, $regenereCacheFile=true)
        {
                $technical = "";
                if(!$this->isOk(true, false, $lang)) return [$this->tm("There are errors in data, process can not be completed", $lang), ""];                
                if(!$this->sureIs("active")) return [$this->tm("This reuest is not active, so can not be proceeded", $lang), "", ""];
                $id_sh_org = AfwSession::config("main_orgunit_id", 1); 
                $orgunit_id = $this->getVal("orgunit_id");
                if(!$orgunit_id) return [$this->tm("Define first the organization of this employee", $lang), "", ""];
                $email = $this->getVal("email");
                if(!$email) return [$this->tm("Define first the email of this employee", $lang), "", ""];
                
                $employeeObj = Employee::loadByEmail($id_sh_org, $email, $create_obj_if_not_found);
                if(!$employeeObj) return [$this->tm("The empolyee account creation has been failed, contact your administrator", $lang), "", ""];
                if(!$employeeObj->id) return [$this->tm("The empolyee account creation has been failed, contact your administrator", $lang), "", "", $employeeObj->getTechnicalNotes()];
                $domain_id = Domain::$DOMAIN_ADMISSION;
                $jobrole_mfk  = $this->getVal("jobrole_mfk");
                $gender_id  = $this->getVal("gender_id");
                $firstname  = $this->getVal("firstname");
                $lastname  = $this->getVal("lastname");
                $lastname_en  = $this->getVal("lastname_en");
                $firstname_en = $this->getVal("firstname_en");
                $hierarchy_level_enum = $this->getVal("hierarchy_level_enum");
                      
                $employeeObj->set("domain_id", $domain_id);
                $employeeObj->set("jobrole_mfk", $jobrole_mfk);
                $employeeObj->set("id_sh_dep", $orgunit_id);
                
                $employeeObj->set("gender_id", $gender_id);
                $employeeObj->set("firstname", $firstname);
                $employeeObj->set("lastname", $lastname);
                $employeeObj->set("lastname_en", $lastname_en);
                $employeeObj->set("firstname_en", $firstname_en);
                $employeeObj->commit();

                /**
                 * @var Auser $auserObj
                 */

                $auserObj = $employeeObj->het("auser_id");
                if(!$auserObj) return [$this->tm("The user account creation has been failed, contact your administrator", $lang), "", ""];
                if(!$auserObj->id) return [$this->tm("The user account creation has been failed, contact your administrator", $lang), "", "", $auserObj->getTechnicalNotes()];

                $auserObj->set("hierarchy_level_enum", $hierarchy_level_enum);
                $auserObj->commit();
                $warning = "";
                if($regenereCacheFile)
                {
                        $technical .= " generating cache file ... <br>"; 
                        list($err, $info, $war) = $auserObj->generateCacheFile($lang, false, true);
                        if($err) $technical .= " error : $err <br>";
                        if($info) $technical .= " info : $info <br>";
                        if($war) $technical .= " war : $war <br>";
                }

                
                $reset_password = $employeeObj->is_new;
                if($reset_password)
                {
                      $warning .= " resetting password ... <br>";  
                      list($err, $info, $war) = $this->temporaryPassword($lang, $employeeObj, $auserObj);
                      if($err) $warning .= " error : $err <br>";
                      if($info) $warning .= " info : $info <br>";
                      if($war) $warning .= " war : $war <br>";
                }
                $this->set("employee_id", $employeeObj->id);
                $this->set("approved", "Y");
                if($lang=="ar")  $this->set("reject_reason", "---");
                else $this->set("reject_reason", "---");
                $this->commit();
                $employee_id = $employeeObj->id;
                if ($this->sureIs("active") and $this->sureIs("approved") and ($orgunit_id > 0) and ($employee_id > 0)) {
                        AdmEmployee::loadByMainIndex($orgunit_id, $employee_id, true);
                }

                return ["", $this->tm("The empolyee account has been approved, he can use it now", $lang), $warning, $technical];
        }

        public function temporaryPassword($lang="ar", $employeeObj=null, $auserObj = null)
        {
                if(!$employeeObj) $employeeObj = $this->het("employee_id");
                if(!$employeeObj) return [$this->tm("The empolyee account creation has been failed, contact your administrator", $lang), "", ""];
                /**
                 * @var Auser $auserObj
                 */
                if(!$auserObj) $auserObj = $employeeObj->het("auser_id");
                if(!$auserObj) return [$this->tm("The user account creation has been failed, contact your administrator", $lang), "", ""];


                list($err, $info, $war, $pwd, $sent_by, $sent_to) = $auserObj->resetPassword($lang);
                if(!$err) $info = $this->tm("Password has been resetted. The new password has been sent by",$lang)." : ".$this->tm($sent_by,$lang)." ". $this->tm("to",$lang) . " ". $sent_to;
                if((!$sent_by) or ($sent_by == "nothing")) $war .= " pwd=[0123".$pwd."3210]";
                return [$err, $info, $war,];
        }

        

        
}
