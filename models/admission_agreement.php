<?php
class AdmissionAgreement extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "admission_agreement"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("admission_agreement","id","adm");
                        AdmAdmissionAgreementAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new AdmissionAgreement();
                        
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
                    if($this->getVal("agreement_start_date") and $fields_updated["agreement_start_date"])
                    {
                        $this->set("hijri_agreement_start_date", AfwDateHelper::gregToHijri($this->getVal("agreement_start_date")));                        
                    }

                    if($this->getVal("agreement_expiry_date") and $fields_updated["agreement_expiry_date"])
                    {
                        $this->set("hijri_agreement_expiry_date", AfwDateHelper::gregToHijri($this->getVal("agreement_expiry_date")));                        
                    }

                    return true;
                }

        }
?>