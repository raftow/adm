<?php
class FinancialTransaction extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "financial_transaction";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("financial_transaction", "id", "adm");
                AdmFinancialTransactionAfwStructure::initInstance($this);
        }

        public static function loadByMainIndex($fee_code, $create_obj_if_not_found = false)
        {
                if (!$fee_code) throw new AfwRuntimeException("loadByMainIndex : fee_code is mandatory field");


                $obj = new FinancialTransaction();
                $obj->select("fee_code", $fee_code);

                if ($obj->load()) {
                        if ($create_obj_if_not_found) $obj->activate();
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        $obj->set("fee_code", $fee_code);

                        $obj->insertNew();
                        if (!$obj->id) return null; // means beforeInsert rejected insert operation
                        $obj->is_new = true;
                        return $obj;
                } else return null;
        }

        public static function loadById($id)
        {
                $obj = new FinancialTransaction();

                if ($obj->load($id)) {
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
