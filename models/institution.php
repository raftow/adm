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
