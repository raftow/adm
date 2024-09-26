<?php
    class AdmissionAgreementScope extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "admission_agreement_scope"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("admission_agreement_scope","id","adm");
                        AdmAdmissionAgreementScopeAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new AdmissionAgreementScope();
                        
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
                    if($this->getVal("start_date") and $fields_updated["start_date"])
                    {
                        $this->set("hijri_start_date", AfwDateHelper::gregToHijri($this->getVal("start_date")));                        
                    }

                    if($this->getVal("end_date") and $fields_updated["end_date"])
                    {
                        $this->set("hijri_end_date", AfwDateHelper::gregToHijri($this->getVal("end_date")));                        
                    }

                    return true;
                }

        }
?>