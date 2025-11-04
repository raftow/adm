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
                // added by medali
                public function afterMaj($id, $fields_updated){
                        $academicTermObj = $this->het("academic_term_id");
                        $arr_field = array("hijri_application_start_date","hijri_application_end_date","last_date_upload_doc","last_date_tuitfee",
                        "hijri_last_date_upload_doc","hijri_last_date_tuitfee");
                        foreach($arr_field as $field){
                                $academicTermObj->set($field,$fields_updated[$field]);

                        }
                        $academicTermObj->commit();	


                }
        }
?>