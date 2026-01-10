<?php
class ApplicantEvaluation extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "applicant_evaluation";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("applicant_evaluation", "id", "adm");
                AdmApplicantEvaluationAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new ApplicantEvaluation();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public static function getMyEvaluationNeedingFileAttachment($applicant_id, $afObj = null, $evaluation_id = 0, $eval_date = null)
        {
                if (!$applicant_id) throw new AfwRuntimeException("getMyQualificationNeedingFileAttachment : applicant_id is mandatory field");

                $obj = new ApplicantEvaluation();
                $obj->select("applicant_id", $applicant_id);
                if ($evaluation_id) $obj->select("evaluation_id", $evaluation_id);
                if ($eval_date) $obj->select("eval_date", $eval_date);
                $obj->where("workflow_file_id = 0 or workflow_file_id is null");

                $obj->select("active", "Y");
                $objNeedFound = $obj->load();
                if ($afObj) {
                        if (!$objNeedFound) {
                                $obj->set("applicant_id", $applicant_id);
                                $obj->set("evaluation_id", $evaluation_id);
                                $obj->set("eval_date", $eval_date);
                        }
                        $obj->set("workflow_file_id", $afObj->id);
                        $obj->commit();
                        return $obj;
                } else return $objNeedFound ? $obj : null;
        }

        public static function loadMaxScoreFor($applicant_id, $eval_id_list)
        {
                $obj = new ApplicantEvaluation();
                $obj->select("applicant_id", $applicant_id);
                $obj->where("evaluation_id in ($eval_id_list)");
                // to debuggg try SELECT evaluation_id, max(eval_result) FROM `applicant_evaluation` WHERE applicant_id = $applicant_id group by evaluation_id;
                return $obj->func("max(eval_result)");
        }

        public static function loadByMainIndex($evaluation_id, $applicant_id, $eval_date, $eval_result, $create_obj_if_not_found = false, $imported = false)
        {
                if (!$evaluation_id) throw new AfwRuntimeException("loadByMainIndex : evaluation_id is mandatory field");
                if (!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");


                $obj = new ApplicantEvaluation();
                $obj->select("evaluation_id", $evaluation_id);
                $obj->select("applicant_id", $applicant_id);
                $obj->select("eval_date", $eval_date);

                if ($obj->load()) {
                        $obj->set("eval_result", $eval_result);
                        if ($create_obj_if_not_found) $obj->activate();
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        $obj->set("evaluation_id", $evaluation_id);
                        $obj->set("applicant_id", $applicant_id);
                        $obj->set("eval_date", $eval_date);
                        $obj->set("eval_result", $eval_result);
                        if ($imported) $obj->set("imported", "Y");
                        else $obj->set("imported", "N");
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

        protected function userCanEditMeWithoutRole($auser)
        {
                // @todo this temporary for demo of amjad
                return [true, 'for demo'];
        }

        public function canBeDeletedWithoutRoleBy($auser)
        {
                return [true, 'for demo'];
        }

        public function beforeDelete($id, $id_replace)
        {
                $server_db_prefix = AfwSession::config("db_prefix", "pmu_");

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


        public function afterMaj($id, $fields_updated)
        {
                if ($this->sureIs("imported")) {
                        /**
                         * @var Applicant $applicantObj
                         */
                        $applicantObj = $this->het("applicant_id");
                        $applicantObj->updateEvaluationFields("ar", $this->getVal("evaluation_id"));
                }
        }


        public function calcNominating_candidates_id($what = "value")
        {
                $nl_id = $this->getVal("nomination_letter_id");
                if (!$nl_id) return AfwLoadHelper::giveWhat(null, $what);
                $applicantObj = $this->het("applicant_id");
                if (!$applicantObj) return AfwLoadHelper::giveWhat(null, $what);
                $identity_type_id = $applicantObj->getVal("idn_type_id");
                $idn = $applicantObj->getVal("idn");
                $ncObject = NominatingCandidates::loadByMainIndex($nl_id, $identity_type_id, $idn);
                return AfwLoadHelper::giveWhat($ncObject, $what);
        }


        public function afterSaveEditCase()
        {
                if ($this->get("calcNominating_candidates_id")) return 2;

                return 1;
        }
}
