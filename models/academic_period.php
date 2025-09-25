<?php
        class AcademicPeriod extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "academic_period"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("academic_period","id","adm");
                        AdmAcademicPeriodAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new AcademicPeriod();
                        
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