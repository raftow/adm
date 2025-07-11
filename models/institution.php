<?php

// medali 14/09/2024
class Institution extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "institution";
        public static $DB_STRUCTURE = null;
        public static $signleton = null;

        public function __construct()
        {
                parent::__construct("institution", "id", "adm");
                AdmInstitutionAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new Institution();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public static function loadSingleton()
        {
                $obj = new Institution();
                $obj->select("active", "Y");
                if ($obj->load()) {
                        return $obj;
                } else return null;
        }

        public static function loadByMainIndex($institution_code, $create_obj_if_not_found = false)
        {
                if (!$institution_code) throw new AfwRuntimeException("loadByMainIndex : institution_code is mandatory field");


                $obj = new Institution();
                $obj->select("institution_code", $institution_code);

                if ($obj->load()) {
                        if ($create_obj_if_not_found) $obj->activate();
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        $obj->set("institution_code", $institution_code);

                        $obj->insertNew();
                        if (!$obj->id) return null; // means beforeInsert rejected insert operation
                        $obj->is_new = true;
                        return $obj;
                } else return null;
        }

        public function getDisplay($lang = 'ar')
        {
                return $this->getDefaultDisplay($lang);
        }

        public static function getSingleton()
        {
                
                if (!self::$signleton) {
                        $institution_code = AfwSession::config("main_company","");
                        if($institution_code)
                        {
                                self::$signleton = self::loadByMainIndex($institution_code);
                                if(!self::$signleton) throw new AfwRuntimeException("the institution $institution_code is not found");
                        }
                        else throw new AfwRuntimeException("please define a main_company in your system config file");
                }

                return self::$signleton;
        }
        
        public static function simulationApplicantsIds() {
                return self::getSingleton()->getVal("simulation_applicants_ids");
        }


        
        public static function simulationApplicationModelId() {
                return self::getSingleton()->getVal("application_model_id");
        }

        public static function simulationApplicationPlanId() {
                return self::getSingleton()->getVal("application_plan_id");
        }


        protected function getPublicMethods()
        {
        
                $pbms = array();
                
                

                $color = "green";
                $title_ar = "احداث/تحديث عنصر الموارد البشرية"; 
                $methodName = "updateOrgunit";
                $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "PUBLIC"=>true, "BF-ID"=>"", 'STEP' =>1);
                

                
                
                return $pbms;
        }

        public function updateOrgunit($lang = "ar")
        {
                $hrm_code = $this->getVal("institution_code");
                if(!$hrm_code) return ["please define institution code before and if the institution is already in HRM system use the same hrm-code to avoid create a duplicated orgunit"];

                $parent_orgunit_id = 0;

                $id_sh_org = 0;
                $id_sh_type = OrgunitType::$ORGUNIT_TYPE_COMPANY;
                $id_domain = Domain::$DOMAIN_ADMISSION;
                
                
                $titre_short_ar = $titre_ar = $this->getVal("institution_name_ar");
                $titre_short_en = $titre_en = $this->getVal("institution_name_en");
                $orgunitObj = Orgunit::findOrgunit($id_sh_type, $id_sh_org, $hrm_code, 
                                $titre_short_ar, $titre_ar, $titre_short_en, $titre_en, $id_domain, $hrm_crm = "crm", $create_obj_if_not_found = false);
                if($orgunitObj)
                {
                        $orgunitObj = Orgunit::findOrgunit($id_sh_type, $id_sh_org, $hrm_code, 
                                $titre_short_ar, $titre_ar, $titre_short_en, $titre_en, $id_domain, $hrm_crm = "hrm", $create_obj_if_not_found = true);
                }
                
                $orgunitObj->set("gender_id", 3);
                $orgunitObj->set("id_sh_parent", $parent_orgunit_id);
                $orgunitObj->set("addresse", $this->getVal("adress")); 
                $city_name = "";
                $orgunitObj->set("city_name", $city_name);
                $orgunitObj->set("cp", $this->getVal("postal_code"));
                $orgunitObj->set("quarter", $this->getVal("quarter"));
                $orgunitObj->commit();
                $this->set("orgunit_id", $orgunitObj->getId());
                $this->commit();
                AdmOrgunit::loadByMainIndex($orgunitObj->id, true);
                $return = $orgunitObj->is_new ? "New HRM Organization created" : "Existing HRM Organization found ";
                $return .= " with ID = ".$orgunitObj->id;

                return ["", $return];
        }

        public function beforeDelete($id, $id_replace)
        {
                $server_db_prefix = AfwSession::config("db_prefix", "default_db_");

                if (!$id) {
                        $id = $this->getId();
                        $simul = true;
                } else {
                        $simul = false;
                }

                if ($id) {
                        if ($id_replace == 0) {
                                // FK part of me - not deletable 


                                // FK part of me - deletable 


                                // FK not part of me - replaceable 



                                // MFK

                        } else {
                                // FK on me 


                                // MFK


                        }
                        return true;
                }
        }

        // institution 
        public function getScenarioItemId($currstep)
        {
                if ($currstep == 1) return 400;
                if ($currstep == 2) return 401;

                return 0;
        }
}
