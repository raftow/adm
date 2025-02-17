<?php
class TrainingUnitType extends AdmObject
{
        


        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "training_unit_type";
        public static $DB_STRUCTURE = null;

        public static $copypast = true;

        public function __construct()
        {
                parent::__construct("training_unit_type", "id", "adm");
                AdmTrainingUnitTypeAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new TrainingUnitType();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public function getDisplay($lang = 'ar')
        {
                return $this->getDefaultDisplay($lang);
        }

        // training_unit_type 
        public function getScenarioItemId($currstep)
        {
                if ($currstep == 1) return 394;
                if ($currstep == 2) return 395;

                return 0;
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
                                // adm.training_unit-نوع المنشاة التدريبية	training_unit_type_id  حقل يفلتر به (required field)
                                // require_once "../adm/training_unit.php";
                                $obj = new TrainingUnit();
                                $obj->where("training_unit_type_id = '$id' and active='Y' ");
                                $nbRecords = $obj->count();
                                // check if there's no record that block the delete operation
                                if ($nbRecords > 0) {
                                        $this->deleteNotAllowedReason = "Used in some Training units(s) as Type of training unit";
                                        return false;
                                }
                                // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                                if (!$simul) $obj->deleteWhere("training_unit_type_id = '$id' and active='N'");

                                // adm.academic_program-الكلّية	college_id  حقل يفلتر به (required field)
                                // require_once "../adm/academic_program.php";
                                $obj = new AcademicProgram();
                                $obj->where("college_id = '$id' and active='Y' ");
                                $nbRecords = $obj->count();
                                // check if there's no record that block the delete operation
                                if ($nbRecords > 0) {
                                        $this->deleteNotAllowedReason = "Used in some Academic programs(s) as College";
                                        return false;
                                }
                                // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                                if (!$simul) $obj->deleteWhere("college_id = '$id' and active='N'");



                                // FK part of me - deletable 


                                // FK not part of me - replaceable 
                                // adm.training_unit_college-الكلية	college_id  حقل يفلتر به
                                if (!$simul) {
                                        // require_once "../adm/training_unit_college.php";
                                        TrainingUnitCollege::updateWhere(array('college_id' => $id_replace), "college_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.training_unit_college set college_id='$id_replace' where college_id='$id' ");
                                }



                                // MFK
                                // adm.academic_level-نوع الجامعات	training_unit_type_mfk  حقل يفلتر به
                                if (!$simul) {
                                        // require_once "../adm/academic_level.php";
                                        AcademicLevel::updateWhere(array('training_unit_type_mfk' => "REPLACE(training_unit_type_mfk, ',$id,', ',')"), "training_unit_type_mfk like '%,$id,%'");
                                        // $this->execQuery("update ${server_db_prefix}adm.academic_level set training_unit_type_mfk=REPLACE(training_unit_type_mfk, ',$id,', ',') where training_unit_type_mfk like '%,$id,%' ");
                                }
                        } else {
                                // FK on me 


                                // adm.training_unit-نوع المنشاة التدريبية	training_unit_type_id  حقل يفلتر به (required field)
                                if (!$simul) {
                                        // require_once "../adm/training_unit.php";
                                        TrainingUnit::updateWhere(array('training_unit_type_id' => $id_replace), "training_unit_type_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.training_unit set training_unit_type_id='$id_replace' where training_unit_type_id='$id' ");

                                }




                                // adm.academic_program-الكلّية	college_id  حقل يفلتر به (required field)
                                if (!$simul) {
                                        // require_once "../adm/academic_program.php";
                                        AcademicProgram::updateWhere(array('college_id' => $id_replace), "college_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.academic_program set college_id='$id_replace' where college_id='$id' ");

                                }


                                // adm.training_unit_college-الكلية	college_id  حقل يفلتر به
                                if (!$simul) {
                                        // require_once "../adm/training_unit_college.php";
                                        TrainingUnitCollege::updateWhere(array('college_id' => $id_replace), "college_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.training_unit_college set college_id='$id_replace' where college_id='$id' ");
                                }


                                // MFK
                                // adm.academic_level-نوع الجامعات	training_unit_type_mfk  حقل يفلتر به
                                if (!$simul) {
                                        // require_once "../adm/academic_level.php";
                                        AcademicLevel::updateWhere(array('training_unit_type_mfk' => "REPLACE(training_unit_type_mfk, ',$id,', ',$id_replace,')"), "training_unit_type_mfk like '%,$id,%'");
                                        // $this->execQuery("update ${server_db_prefix}adm.academic_level set training_unit_type_mfk=REPLACE(training_unit_type_mfk, ',$id,', ',$id_replace,') where training_unit_type_mfk like '%,$id,%' ");
                                }
                        }
                        return true;
                }
        }
}
