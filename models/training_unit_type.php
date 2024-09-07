<?php
        class TrainingUnitType extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "training_unit_type"; 
                public static $DB_STRUCTURE = null;
                
                public static $copypast = true;

                public function __construct(){
                        parent::__construct("training_unit_type","id","adm");
                        AdmTrainingUnitTypeAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new TrainingUnitType();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
                }

                public function getDisplay($lang = 'ar')
                {
                        return $this->getDefaultDisplay($lang);
                }

        }
?>