<?php
class ApplicantAccount extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "applicant_account";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("applicant_account", "id", "adm");
                AdmApplicantAccountAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new ApplicantAccount();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public static function loadByMainIndex($applicant_id, $application_plan_id, $application_simulation_id, $application_model_financial_transaction_id, $create_obj_if_not_found = false)
        {
                if (!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
                if (!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");
                if (!$application_simulation_id) throw new AfwRuntimeException("loadByMainIndex : application_simulation_id is mandatory field");
                if (!$application_model_financial_transaction_id) throw new AfwRuntimeException("loadByMainIndex : application_model_financial_transaction_id is mandatory field");


                $obj = new ApplicantAccount();
                $obj->select("applicant_id", $applicant_id);
                $obj->select("application_plan_id", $application_plan_id);
                $obj->select("application_simulation_id", $application_simulation_id);
                $obj->select("application_model_financial_transaction_id", $application_model_financial_transaction_id);

                if ($obj->load()) {
                        if ($create_obj_if_not_found) $obj->activate();
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        $obj->set("applicant_id", $applicant_id);
                        $obj->set("application_plan_id", $application_plan_id);
                        $obj->set("application_simulation_id", $application_simulation_id);
                        $obj->set("application_model_financial_transaction_id", $application_model_financial_transaction_id);

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

        public function stepsAreOrdered()
        {
                return false;
        }
}
