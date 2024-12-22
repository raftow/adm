<?php
        class ApplicantScholarship extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "applicant_scholarship"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("applicant_scholarship","id","adm");
                        AdmApplicantScholarshipAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ApplicantScholarship();
                        
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