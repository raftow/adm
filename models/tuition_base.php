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

        public static function getTuitionBaseForApplicant($applicationDesireObj = null, $program_id = 0)
        {

                if ($applicationDesireObj) {
                        $applicationPlanBranch = $applicationDesireObj->het("application_plan_branch_id");
                        if ($applicationPlanBranch) $program_id = $applicationPlanBranch->getVal("program_id");
                }
                if ($program_id) {
                        $objectThis = new TuitionBase();
                        $objectThis->where("active='Y' and program_id = '$program_id'");
                        if ($objectThis->load()) {
                                $res["total_ammount"] = $objectThis->getVal("amount") + $objectThis->getVal("mandatory_fees");
                                $res["curr_ar"] = $objectThis->getVal("currency_ar");
                                $res["curr_en"] = $objectThis->getVal("currency_en");
                                return $res;
                        } else {
                                $academicProgramObj = new AcademicProgram();
                                if ($academicProgramObj->load($program_id)) {
                                        $degree_id = $academicProgramObj->getVal("degree_id");
                                        unset($objectThis);
                                        $objectThis = new TuitionBase();
                                        $objectThis->where("active='Y' and degree_id = '$degree_id'");
                                        if ($objectThis->load()) {
                                                $res["total_ammount"] = $objectThis->getVal("amount") + $objectThis->getVal("mandatory_fees");
                                                $res["curr_ar"] = $objectThis->getVal("currency_ar");
                                                $res["curr_en"] = $objectThis->getVal("currency_en");
                                                return $res;
                                        }
                                }
                                return false;
                        }
                        return false;
                }
                return false;
        }
}
