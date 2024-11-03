<?php
    class AdmissionAgreementException extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "admission_agreement_exception"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("admission_agreement_exception","id","adm");
                        AdmAdmissionAgreementExceptionAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new AdmissionAgreementException();
                        
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