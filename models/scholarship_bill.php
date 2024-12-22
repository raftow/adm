<?php
        class ScholarshipBill extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "scholarship_bill"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("scholarship_bill","id","adm");
                        AdmScholarshipBillAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ScholarshipBill();
                        
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