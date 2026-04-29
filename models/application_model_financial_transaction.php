<?php
class ApplicationModelFinancialTransaction extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "application_model_financial_transaction";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("application_model_financial_transaction", "id", "adm");
                AdmApplicationModelFinancialTransactionAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new ApplicationModelFinancialTransaction();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public static function loadByMainIndex($application_model_id, $financial_transaction_id, $create_obj_if_not_found = false)
        {
                if (!$application_model_id) throw new AfwRuntimeException("loadByMainIndex : application_model_id is mandatory field");
                if (!$financial_transaction_id) throw new AfwRuntimeException("loadByMainIndex : financial_transaction_id is mandatory field");


                $obj = new ApplicationModelFinancialTransaction();
                $obj->select("application_model_id", $application_model_id);
                $obj->select("financial_transaction_id", $financial_transaction_id);

                if ($obj->load()) {
                        if ($create_obj_if_not_found) $obj->activate();
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        $obj->set("application_model_id", $application_model_id);
                        $obj->set("financial_transaction_id", $financial_transaction_id);

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

        public function synchronizeWithWorkflow()
        {
                $module_id = 1;
                $wftObj = WorkflowFinancialTransaction::loadByMainIndex($module_id, $this->id, true);

                $name_ar = $this->decode("financial_transaction_id", '', false, 'ar');
                $name_en = $this->decode("financial_transaction_id", '', false, 'en');

                $wModelObj = ApplicationModel::retrieveWorkflowModel($this->getVal("application_model_id"), $name_ar, $name_en, true, true);
                $wftObj->set('workflow_model_id', $wModelObj->id);
                $wftObj->set('financial_transaction_name_ar', $name_ar);
                $wftObj->set('financial_transaction_name_en', $name_en);
                $wftObj->set('financial_transaction_description_ar', $name_ar);
                $wftObj->set('financial_transaction_description_en', $name_en);
                $wftObj->commit();

                return $wftObj;
        }

        public function getFinancialTransaction()
        {
                if($this->getVal("is_composite_ind") == "Y"){
                        $objList =  $this->get("financial_transaction_mfk");
                }else{
                        $objList[] = $this->het("financial_transaction_id");
                }
                return $objList;
        }
}
