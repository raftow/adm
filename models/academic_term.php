<?php
        class AcademicTerm extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "academic_term"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("academic_term","id","adm");
                        AdmAcademicTermAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new AcademicTerm();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
                }

                public function getDisplay($lang = 'ar')
                {
                        return $this->getVal("term_code");
                }

                public function stepsAreOrdered()
                {
                        return true;
                }

                public function beforeMaj($id, $fields_updated)
                {

                    $date_attributes = [];
                    $date_attributes[] = "start_date";
                    $date_attributes[] = "end_date";
                    $date_attributes[] = "application_start_date";
                    $date_attributes[] = "application_end_date";
                    $date_attributes[] = "admission_start_date";
                    $date_attributes[] = "admission_end_date";
                    $date_attributes[] = "direct_adm_start_date";
                    $date_attributes[] = "direct_adm_end_date";
                    $date_attributes[] = "seats_update_start_date";
                    $date_attributes[] = "seats_update_end_date";
                    $date_attributes[] = "migration_start_date";
                    $date_attributes[] = "migration_end_date";                    

                    foreach($date_attributes as $date_attribute)
                    {
                        if($this->getVal($date_attribute) and $fields_updated[$date_attribute])
                        {
                            $this->set("hijri_".$date_attribute, AfwDateHelper::gregToHijri($this->getVal($date_attribute)));                        
                        }
                    }

                    return true;
                }


                public function getFinishButtonLabel(
                        $lang,
                        $nextStep,
                        $form_readonly = 'RO'
                    )                     
                {
                        if($lang=="ar") return "حفظ وانهاء";
                        return $this->getFinishButtonLabelDefault(
                            $lang,
                            $nextStep,
                            $form_readonly
                        );
                }

        }
?>