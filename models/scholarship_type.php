<?php
        class ScholarshipType extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "scholarship_type"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("scholarship_type","id","adm");
                        AdmScholarshipTypeAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ScholarshipType();
                        
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
