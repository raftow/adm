<?php
/*
medali 25/09/2024

CREATE TABLE IF NOT EXISTS c0adm.`admission_agreement_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `created_at`   datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `validated_by` int(11) DEFAULT NULL,
  `validated_at` datetime DEFAULT NULL,
  `active` char(1) NOT NULL,
  `draft` char(1) NOT NULL default 'Y',
  `version` int(4) DEFAULT NULL,
  `update_groups_mfk` varchar(255) DEFAULT NULL,
  `delete_groups_mfk` varchar(255) DEFAULT NULL,
  `display_groups_mfk` varchar(255) DEFAULT NULL,
  `sci_id` int(11) DEFAULT NULL,
  
    
   admission_agreement_id int(11) NOT NULL , 
   application_plan_id int(11) NOT NULL , 
   admission_agreement_plan_name_ar varchar(200)  NOT NULL , 
   admission_agreement_plan_name_en varchar(200)  DEFAULT NULL , 
   application_plan_branch_id int(11) DEFAULT NULL , 
   agreement_scope_type_enum smallint NOT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;

create unique index uk_admission_agreement_plan on c0adm.admission_agreement_plan(admission_agreement_id,application_plan_id);

*/
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
