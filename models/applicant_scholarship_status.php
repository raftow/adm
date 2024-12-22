<?php
        class ApplicantScholarshipStatus extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "applicant_scholarship_status"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("applicant_scholarship_status","id","adm");
                        AdmApplicantScholarshipStatusAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ApplicantScholarshipStatus();
                        
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