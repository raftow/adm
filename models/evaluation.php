<?php
class Evaluation extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "evaluation";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("evaluation", "id", "adm");
                AdmEvaluationAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new Evaluation();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public static function loadByEnglishName($name_en)
        {
                $obj = new Evaluation();
                $obj->select("evaluation_name_en", $name_en);
                if ($obj->load()) {
                        return $obj;
                } else return null;
        }

        public static function EvalNameToId($name_en)
        {
                $obj = self::loadByEnglishName($name_en);
                if ($obj) return $obj->id;
                return 0;
        }




        public function getDisplay($lang = 'ar')
        {
                return $this->getDefaultDisplay($lang);
        }

        public function stepsAreOrdered()
        {
                return false;
        }

        protected function userCanEditMeWithoutRole($auser)
        {
                // @todo this temporary for demo of amjad
                return [true, 'for demo'];
        }

        public function beforeDelete($id, $id_replace)
        {
                $server_db_prefix = AfwSession::config("db_prefix", "uoh_");

                if (!$id) {
                        $id = $this->getId();
                        $simul = true;
                } else {
                        $simul = false;
                }

                if ($id) {
                        if ($id_replace == 0) {
                                // FK part of me - not deletable 
                                // adm.applicant_evaluation-الاختبار	evaluation_id  حقل يفلتر به (required field)
                                // require_once "../adm/applicant_evaluation.php";
                                $obj = new ApplicantEvaluation();
                                $obj->where("evaluation_id = '$id' and active='Y' ");
                                $nbRecords = $obj->count();
                                // check if there's no record that block the delete operation
                                if ($nbRecords > 0) {
                                        $this->deleteNotAllowedReason = "Used in some Applicant evaluations(s) as evaluation";
                                        return false;
                                }
                                // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                                if (!$simul) $obj->deleteWhere("evaluation_id = '$id' and active='N'");



                                // FK part of me - deletable 


                                // FK not part of me - replaceable 



                                // MFK

                        } else {
                                // FK on me 


                                // adm.applicant_evaluation-الاختبار	evaluation_id  حقل يفلتر به (required field)
                                if (!$simul) {
                                        // require_once "../adm/applicant_evaluation.php";
                                        ApplicantEvaluation::updateWhere(array('evaluation_id' => $id_replace), "evaluation_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.applicant_evaluation set evaluation_id='$id_replace' where evaluation_id='$id' ");

                                }




                                // MFK


                        }
                        return true;
                }
        }
}
