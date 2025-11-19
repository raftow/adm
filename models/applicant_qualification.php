<?php
class ApplicantQualification extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "applicant_qualification";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("applicant_qualification", "id", "adm");
                AdmApplicantQualificationAfwStructure::initInstance($this);
        }


        
        public static function loadById($id)
        {
                $obj = new ApplicantQualification();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }


        

        public static function getMyQualificationNeedingFileAttachment($applicant_id, $afObj=null, $qualification_id=0, $major_category_id=0)
        {
                if (!$applicant_id) throw new AfwRuntimeException("getMyQualificationNeedingFileAttachment : applicant_id is mandatory field");
                
                $obj = new ApplicantQualification();
                $obj->select("applicant_id", $applicant_id);
                if ($qualification_id) $obj->select("qualification_id", $qualification_id);
                if ($major_category_id) $obj->select("major_category_id", $major_category_id);
                $obj->where("adm_file_id = 0 or adm_file_id is null");
                $obj->select("active", "Y");
                $objNeedFound = $obj->load();
                if($afObj)
                {
                        if(!$objNeedFound)
                        {
                                $obj->set("applicant_id", $applicant_id);
                                $obj->set("qualification_id", $qualification_id);
                                $obj->set("major_category_id", $major_category_id);
                        }
                        $obj->set("adm_file_id", $afObj->id);
                        $obj->commit();
                        return $obj;
                }
                else return $objNeedFound ? $obj : null;                
        }

        public static function loadByMainIndex($applicant_id, $qualification_id, $major_category_id, $create_obj_if_not_found = false)
        {
                if (!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
                if (!$qualification_id) throw new AfwRuntimeException("loadByMainIndex : qualification_id is mandatory field");
                if (!$major_category_id) throw new AfwRuntimeException("loadByMainIndex : major_category_id is mandatory field");


                $obj = new ApplicantQualification();
                $obj->select("applicant_id", $applicant_id);
                $obj->select("qualification_id", $qualification_id);
                $obj->select("major_category_id", $major_category_id);

                if ($obj->load()) {
                        if ($create_obj_if_not_found) $obj->activate();
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        $obj->set("applicant_id", $applicant_id);
                        $obj->set("qualification_id", $qualification_id);
                        $obj->set("major_category_id", $major_category_id);

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

                list($data[0], $link[0]) = $this->displayAttribute("qualification_id", false, $lang);
                list($data[1], $link[1]) = $this->displayAttribute("qualification_major_id", false, $lang);

                // die("AQ::getDisplay = ".var_export($data,true));
                $return = implode(" - ", $data);

                // die("return=$return AQ::getDisplay = ".var_export($data,true));

                return $return;
        }

        public function stepsAreOrdered()
        {
                return false;
        }

        public function beforeMaj($id, $fields_updated)
        {

                if ($fields_updated["qualification_id"] or $fields_updated["major_category_id"]) {

                        $objMajorPath = MajorPath::loadByMainIndex($this->getVal("qualification_id"), $this->getVal("major_category_id"));

                        if ($objMajorPath) {
                                $this->set("major_path_id", $objMajorPath->id);
                        }
                }
                if($fields_updated["gpa"] or $fields_updated["gpa_from"]){
                        if(($fields_updated["gpa_from"])) $gpa_from = $fields_updated["gpa_from"];
                        else $gpa_from = $this->getVal("gpa_from");
                        $this->set("grading_scale_id", $this->getGradingScale($fields_updated["gpa"], $this->getVal("gpa_from")));
                }

                return true;
        }

        public function afterInsert($id, $fields_updated, $disableAfterCommitDBEvent=false)
        {
                if ($fields_updated["qualification_id"]) {
                        /**
                         * @var Applicant $applicantObject
                         */
                        $applicantObject = $this->get("applicant_id");
                        $applicantObject->updateQualificationLevelFields();
                }
        }

        public function afterDelete($id, $id_replace)
        {
                $applicantObject = $this->get("applicant_id");
                $applicantObject->updateQualificationLevelFields();
        }


        public function shouldBeCalculatedField($attribute)
        {
                if ($attribute == "level_enum") return true;
                return false;
        }


        public function beforeDelete($id, $id_replace)
        {
                $lang = AfwLanguageHelper::getGlobalLanguage();

                $server_db_prefix = AfwSession::currentDBPrefix();

                if (!$id) {
                        $id = $this->getId();
                        $simul = true;
                } else {
                        $simul = false;
                }

                if ($id) {
                        if ($id_replace == 0) {
                                // FK part of me - not deletable 
                                // adm.application-مؤهل التقديم	applicant_qualification_id  ManyToOne (required field)
                                // require_once "../adm/application.php";
                                $obj = new Application();
                                $obj->where("applicant_qualification_id = '$id' and active='Y' ");
                                $nbRecords = $obj->count();
                                // check if there's no record that block the delete operation
                                if ($nbRecords > 0) {
                                        $this->deleteNotAllowedReason = self::tm("used in some applications as applicant qualification", $lang);
                                        return false;
                                }
                                // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                                if (!$simul) $obj->deleteWhere("applicant_qualification_id = '$id' and active='N'");



                                // FK part of me - deletable 


                                // FK not part of me - replaceable 
                                // adm.application-مؤهل التقديم	applicant_qualification_id  ManyToOne
                                if (!$simul) {
                                        // require_once "../adm/application.php";
                                        Application::updateWhere(array('applicant_qualification_id' => $id_replace), "applicant_qualification_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.application set applicant_qualification_id='$id_replace' where applicant_qualification_id='$id' ");
                                }

                                // MFK

                        } else {
                                // FK on me 


                                // adm.application-مؤهل التقديم	applicant_qualification_id  ManyToOne (required field)
                                if (!$simul) {
                                        // require_once "../adm/application.php";
                                        Application::updateWhere(array('applicant_qualification_id' => $id_replace), "applicant_qualification_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.application set applicant_qualification_id='$id_replace' where applicant_qualification_id='$id' ");

                                }


                                // adm.application-مؤهل التقديم	applicant_qualification_id  ManyToOne
                                if (!$simul) {
                                        // require_once "../adm/application.php";
                                        Application::updateWhere(array('applicant_qualification_id' => $id_replace), "applicant_qualification_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.application set applicant_qualification_id='$id_replace' where applicant_qualification_id='$id' ");
                                }


                                // MFK


                        }
                        return true;
                }
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

        public function getInfo($info)
        {
                if($info=="secondary_cumulative_pct")
                {
                        // $qualificationId = $this->getVal("qualification_id");                        
                        $qualificationObj = $this->het("qualification_id");
                        $qualificationLevel = $qualificationObj->getVal("level_enum");
                        if($qualificationObj->sureIs("active") and ($qualificationLevel==20))
                        {
                                $gpa_from = $this->getVal("gpa_from");
                                if(!$gpa_from) $gpa_from = 100;
                                $gpa = $this->getVal("gpa");
                                return $gpa * 100 / $gpa_from;
                        }
                        else 

                        return -999;
                }
                
           
                if($info=="secondary_major_path")
                {
                       return $this->getVal("major_path_id");
                }

                if($info=="secondary_major_path_decoded")
                {
                       return $this->decode("major_path_id");
                }


                
                
        }

        public static function getGradingScale($gpa, $gpa_from = 100)
        {
                $grade = ($gpa / $gpa_from) * 100;

                $objGradingScale = new GradingScale();
                $objGradingScale->where("active='Y' and  mark_min2 <= $grade and mark_max >= $grade"); // active='Y' and
                
                if($objGradingScale->getVal("id"))
                        return $objGradingScale->getVal("id");
        }
}
