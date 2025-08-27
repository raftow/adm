<?php
        class GradingScale extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "grading_scale"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("grading_scale","id","adm");
                        AdmGradingScaleAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new GradingScale();
                        
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

                public function stepsAreOrdered()
                {
                        return false;
                }

        }
?>