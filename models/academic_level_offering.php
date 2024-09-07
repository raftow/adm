<?php
        class AcademicLevelOffering extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "academic_level_offering"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("academic_level_offering","id","adm");
                        AdmAcademicLevelOfferingAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new AcademicLevelOffering();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
                }

                public function getDisplay($lang="ar")
                {
                       
                       $data = array();
                       $link = array();
                       
        
                       list($data[0],$link[0]) = $this->displayAttribute("academic_level_id",false, $lang);
                       list($data[1],$link[1]) = $this->displayAttribute("training_unit_id",false, $lang);
        
                       
                       return implode(" تنفيذ ",$data);
                }

                public function stepsAreOrdered()
                {
                        return false;
                }

        }
?>