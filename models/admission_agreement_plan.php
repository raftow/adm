<?php

class AdmissionAgreementPlan extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "admission_agreement_plan"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("admission_agreement_plan","id","adm");
                        AdmAdmissionAgreementPlanAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new AdmissionAgreementPlan();
                        
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
                        return true;
                }

                protected function getOtherLinksArray($mode, $genereLog = false, $step = 2)
                {
                    global $lang;
                    // $objme = AfwSession::getUserConnected();
                    // $me = ($objme) ? $objme->id : 0;
            
                    $otherLinksArray = $this->getOtherLinksArrayStandard($mode, $genereLog, $step);
                    $my_id = $this->getId();
                    $displ = $this->getDisplay($lang);
            
                    if ($mode == "mode_addmissionagreementscopeList") {
                        unset($link);
                        $link = array();
                        $title = "إضافة نطاق";
                        // $title_detailed = $title . "لـ : " . $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=AdmissionAgreementScope&currmod=adm&sel_admission_agreement_plan_id=$my_id";
                        $link["TITLE"] = $title;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                    }
                    return $otherLinksArray;
    
            }
            
            public function attributeIsApplicable($attribute)
            {
                    /*
                    global $objme;
                    
                    
                    */
    
                    if (($attribute == "addmissionagreementscopeList") ) 
                    {
                        $agreement_scope_type_enum = $this->getVal("agreement_scope_type_enum");
                        return ($agreement_scope_type_enum==2);
                    }
    
                    return true;
            }  

        }
?>
