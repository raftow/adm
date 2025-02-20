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

        public function getDisplay($lang = "ar")
        {

                $data = array();
                $link = array();


                list($data[0], $link[0]) = $this->displayAttribute("employee_id", false, $lang);
                list($data[1], $link[1]) = $this->displayAttribute("orgunit_id", false, $lang);
                list($data[2], $link[2]) = $this->displayAttribute("email", false, $lang);


                return implode(" - ", $data);
        }

        protected function getOtherLinksArray($mode, $genereLog = false, $step = "all")
        {
                global $me, $objme, $lang;
                $otherLinksArray = $this->getOtherLinksArrayStandard($mode, false, $step);
                $my_id = $this->getId();
                $displ = $this->getDisplay($lang);



                return $otherLinksArray;
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

        public function isTechField($attribute)
        {
                return (($attribute == "created_by") or ($attribute == "created_at") or ($attribute == "updated_by") or ($attribute == "updated_at") or ($attribute == "validated_by") or ($attribute == "validated_at") or ($attribute == "version"));
        }


        protected function getPublicMethods()
        {

                $pbms = array();

                if (!$this->estApproved()) {
                        $methodConfirmationWarningEn = $this->getVal("reject_reason_en");
                        if (!$methodConfirmationWarningEn) {
                                $methodConfirmationWarningEn = "We can not automatically approve that this employee is from this organization";
                                $methodConfirmationWarning = $this->tm($methodConfirmationWarningEn, "ar");
                        } else $methodConfirmationWarning = $this->getVal("reject_reason_ar");
                        if (!$methodConfirmationWarning) $methodConfirmationWarning = $this->tm($methodConfirmationWarningEn, "ar");

                        $methodConfirmationQuestionEn = "Are you sure you want to approve this employee on this organization inspite of the aobove explanation ?";
                        $methodConfirmationQuestion = $this->tm($methodConfirmationQuestionEn, "ar");
                        $color = "green";
                        $title_ar = "اعتمد هذا الموظف على هذه الجهة";
                        $pbms["xc123B"] = array(
                                "METHOD" => "approveAnyWay",
                                "COLOR" => $color,
                                "LABEL_AR" => $title_ar,
                                "PUBLIC" => true,
                                "BF-ID" => "",
                                'confirmation_needed' => true,
                                'CONFIRMATION_WARNING' => array('ar' => $methodConfirmationWarning, 'en' => $methodConfirmationWarningEn),
                                'CONFIRMATION_QUESTION' => array('ar' => $methodConfirmationQuestion, 'en' => $methodConfirmationQuestionEn),
                        );
                }



                return $pbms;
        }


        public function beforeMaj($id, $fields_updated)
        {
                global $lang;

                $orgunit_id = $this->getVal("orgunit_id");
                $employee_id = $this->getVal("employee_id");
                $email = $this->getVal("email");
                $approved = $this->sureIs("approved");

                if ($this->sureIs("active") and ($orgunit_id > 0) and ($email)) {
                        if ($employee_id) {
                                $this->set("email", "");
                        } else {
                                $main_orgunit_id = AfwSession::config("main_orgunit_id", 1);
                                $emplObj = Employee::loadByEmail($main_orgunit_id, $email, true);
                                list($err, $info) = $emplObj->updateMyInfosFromExternalSources($lang);
                                if ($err) {
                                        $this->set("approved", "W");
                                        if($lang=="ar") $this->set("reject_reason", $err);
                                        else $this->set("reject_reason", $err);
                                } else {
                                        $emplObj_name_ar = $emplObj->getDisplay("ar");
                                        $emplObj_name_en = $emplObj->getDisplay("en");
                                        $id_sh_org = $emplObj->getVal("id_sh_org");
                                        $id_sh_dep = $emplObj->getVal("id_sh_dep");
                                        $id_sh_div = $emplObj->getVal("id_sh_div");
                                        if (($id_sh_org == $orgunit_id) or ($id_sh_dep == $orgunit_id) or ($id_sh_div == $orgunit_id)) {
                                                $this->set("approved", "Y");
                                                if($lang=="ar")  $this->set("reject_reason", "لا ينطبق");
                                                else $this->set("reject_reason", "N/A");
                                                $employee_id = $emplObj->id;
                                                $this->set("employee_id", $employee_id);
                                        } else {
                                                $org_name_ar = $this->showAttribute("orgunit_id", null, true, "ar");
                                                $org_name_en = $this->showAttribute("orgunit_id", null, true, "en");
                                                $sh_name_ar = $emplObj->showAttribute("id_sh_org", null, true, "ar") . "-" . $emplObj->showAttribute("id_sh_dep", null, true, "ar") . "-" . $emplObj->showAttribute("id_sh_div", null, true, "ar");
                                                $sh_name_en = $emplObj->showAttribute("id_sh_org", null, true, "en") . "-" . $emplObj->showAttribute("id_sh_dep", null, true, "en") . "-" . $emplObj->showAttribute("id_sh_div", null, true, "en");

                                                $reject_reason_ar = $emplObj_name_ar . " : " . $this->tm("This employee is not from", "ar") . " $org_name_ar " . $this->tm("but from", "ar") . " $sh_name_ar";
                                                $reject_reason_en = $emplObj_name_en . " : " . $this->tm("This employee is not from", "en") . " $org_name_en " . $this->tm("but from", "en") . " $sh_name_en";
                                                $this->set("approved", "N");
                                                if($lang=="ar") $this->set("reject_reason", $reject_reason_ar);
                                                else $this->set("reject_reason", $reject_reason_en);
                                        }
                                }
                        }
                        /*
                        $empl = $this->het("employee_id");
                        if($empl)
                        {
                                $empl->addMeThisJobrole(self::$JOBROLE_CRM_INVESTIGATOR);
                                $empl->updateMyUserInformation();
                        }*/
                }

                if ($this->sureIs("active") and $approved and ($orgunit_id > 0) and ($employee_id > 0)) {
                        AdmEmployee::loadByMainIndex($orgunit_id, $employee_id, true);
                }

                return true;
        }

        public function afterUpdate($id, $fields_updated) {}

        public function  calcAdm_orgunit_id()
        {
                if (!$this->getVal("orgunit_id")) return null;
                $obj = AdmOrgunit::loadByMainIndex($this->getVal("orgunit_id"));
                return $obj;
        }
}
