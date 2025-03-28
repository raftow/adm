<?php
class TrainingUnitCollege extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "training_unit_college";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("training_unit_college", "id", "adm");
                AdmTrainingUnitCollegeAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new TrainingUnitCollege();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public static function loadByMainIndex($training_unit_id, $college_id, $create_obj_if_not_found = false)
        {
                $obj = new TrainingUnitCollege();
                $obj->select("training_unit_id", $training_unit_id);
                $obj->select("college_id", $college_id);

                if ($obj->load()) {
                        if ($create_obj_if_not_found) $obj->activate();
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        $obj->set("training_unit_id", $training_unit_id);
                        $obj->set("college_id", $college_id);

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

        // training_unit_college 
        public function getScenarioItemId($currstep)
        {
                if ($currstep == 1) return 404;
                if ($currstep == 2) return 405;

                return 0;
        }
}
