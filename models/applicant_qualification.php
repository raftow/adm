<?php
        class ApplicantQualification extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "applicant_qualification"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("applicant_qualification","id","adm");
                        AdmApplicantQualificationAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ApplicantQualification();
                        
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

                public function beforeMaj($id, $fields_updated)
                {

                        if ($fields_updated["qualification_id"] or $fields_updated["major_category_id"]) {

                                $objMajorPath = MajorPath::loadByMainIndex($this->getVal("qualification_id"),$this->getVal("major_category_id"));

                                if ($objMajorPath) {
                                        $this->set("major_path_id", $objMajorPath->id);
                                }
                        }

                        return true;
                }


                  

        }
?>