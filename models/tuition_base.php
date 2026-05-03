<?php
class TuitionBase extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "tuition_base";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("tuition_base", "id", "adm");
                AdmTuitionBaseAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new TuitionBase();

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

        public static function getTuitionBaseForApplicant($applicationDesireObj = null, $applicationFinancialTransaction = null, $program_id = 0)
        {
                if ($applicationDesireObj) {
                        $applicationPlanBranch = $applicationDesireObj->het("application_plan_branch_id");
                        if ($applicationPlanBranch) $program_id = $applicationPlanBranch->getVal("program_id");
                }
                if ($applicationFinancialTransaction) {
                        $financialTransactionList = $applicationFinancialTransaction->getFinancialTransaction();
                        
                }
                if ($program_id) {
                        $tuitionBaseObj = new TuitionBase();
                        foreach ($financialTransactionList as $financialTransaction) {
                                $tuitionBaseObj->where("active = 'Y' and (program_id = '$program_id') and financial_transaction_id = '".$financialTransaction->getVal("id")."'");
                                if ($tuitionBaseObj->load()) {
                                        $res["total_ammount"] += (float)$tuitionBaseObj->getVal("amount") + (float)$tuitionBaseObj->getVal("mandatory_fees");
                                        
                                } else {
                                        $academicProgramObj = new AcademicProgram();
                                        if ($academicProgramObj->load($program_id)) {
                                                $degree_id = $academicProgramObj->getVal("degree_id");
                                                unset($objectThis);
                                                $objectThis = new TuitionBase();
                                                $objectThis->where("active='Y' and degree_id = '$degree_id' and financial_transaction_id = '".$financialTransaction->getVal("id")."'");
                                                if ($objectThis->load()) {
                                                        $res["total_ammount"] += (float)$objectThis->getVal("amount") + (float)$objectThis->getVal("mandatory_fees");
                                                        
                                                }
                                        }
                                        die(var_dump($res["total_ammount"]));
                                }
                        
                        }
                        if(!isset($res["total_ammount"])) return false;
                        else{
                                $res["curr_ar"] = $tuitionBaseObj->getVal("currency_ar");
                                $res["curr_en"] = $tuitionBaseObj->getVal("currency_en");
                                return $res;
                        }
                        
                        
                }
                return false;
        }
}
