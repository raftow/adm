<?php
class ProgramQualification extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "program_qualification";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;
        public static $arrAllProgramQualification = [];

        public function __construct()
        {
                parent::__construct("program_qualification", "id", "adm");
                AdmProgramQualificationAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                if(!self::$arrAllProgramQualification[$id])
                {
                        $obj = new ProgramQualification();
                        if($obj->load($id))
                        {
                                self::$arrAllProgramQualification[$id] =& $obj;
                        }
                        else self::$arrAllProgramQualification[$id] = "NOT-FOUND";
                }
                if(self::$arrAllProgramQualification[$id]=="NOT-FOUND") return null;

                return self::$arrAllProgramQualification[$id];                
        }

        public static function loadByMainIndex($academic_program_id, $qualification_id, $major_path_id, $qualification_major_id=0, $create_obj_if_not_found = false)
        {
                if (!$academic_program_id) throw new AfwRuntimeException("loadByMainIndex : academic_program_id is mandatory field");
                if (!$qualification_id) throw new AfwRuntimeException("loadByMainIndex : qualification_id is mandatory field");
                if (!$major_path_id) throw new AfwRuntimeException("loadByMainIndex : major_path_id is mandatory field");
                $id = "UK$academic_program_id-$qualification_id-$major_path_id-$qualification_major_id";
                if(!self::$arrAllProgramQualification[$id])
                {

                        $obj = new ProgramQualification();
                        $obj->select("academic_program_id", $academic_program_id);
                        $obj->select("qualification_id", $qualification_id);
                        $obj->select("major_path_id", $major_path_id);
                        $obj->select("qualification_major_id", $qualification_major_id);

                        if ($obj->load()) {
                                if ($create_obj_if_not_found) $obj->activate();
                                self::$arrAllProgramQualification[$id] =& $obj;
                        } elseif ($create_obj_if_not_found) {
                                $obj->set("academic_program_id", $academic_program_id);
                                $obj->set("qualification_id", $qualification_id);
                                $obj->set("major_path_id", $major_path_id);
                                $obj->set("qualification_major_id", $qualification_major_id);

                                $obj->insertNew();
                                if (!$obj->id) self::$arrAllProgramQualification[$id] = "NOT-FOUND";
                                $obj->is_new = true;
                                self::$arrAllProgramQualification[$id] =& $obj;
                        } else self::$arrAllProgramQualification[$id] = "NOT-FOUND";
                }

                if(self::$arrAllProgramQualification[$id]=="NOT-FOUND") return null;

                return self::$arrAllProgramQualification[$id];
        }


        public static function pathExistsFor($academic_program_id, $split_sorting_by_enum, $major_path_id, $returnObject=false)
        {
                // 2 = "تقسيم حسب مجموعة التأهيل" = "Split with major path"
                if ($split_sorting_by_enum == 2) {
                        $mpObj = MajorPath::loadById($major_path_id);
                        $qualification_id = $mpObj->getVal("qualification_id");
                        if($academic_program_id and $qualification_id and $major_path_id)
                        {
                                $progQualObj = self::loadByMainIndex($academic_program_id, $qualification_id, $major_path_id, 0);
                        }
                        else $progQualObj = null;

                        // if(!$progQualObj) die("self::loadByMainIndex($academic_program_id, $qualification_id, $major_path_id, 0) not found");

                        if($returnObject) return $progQualObj;
                        else return ($progQualObj and ($progQualObj->id>0));
                }


                if($returnObject) return null;
                else return false;
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
