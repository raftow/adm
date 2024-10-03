<?php
/*
medali 25/09/2024
CREATE TABLE IF NOT EXISTS c0adm.`admission_agreement_plan_person` (
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
  
    
   identity_type_id int(11) NOT NULL , 
   idn varchar(40)  NOT NULL , 
   applicant_id int(11) NOT NULL , 
   applicant_name varchar(128)  NOT NULL , 
   admission_agreement_plan_id int(11) NOT NULL , 
   applicant_informed char(1) DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;

create unique index uk_admission_agreement_plan_person on c0adm.admission_agreement_plan_person(applicant_id,admission_agreement_plan_id);
*/
    class AdmissionAgreementPlanPerson extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "admission_agreement_plan_person"; 
                public static $DB_STRUCTURE = null;
                public static $copypast = true;

                public function __construct(){
                        parent::__construct("admission_agreement_plan_person","id","adm");
                        AdmAdmissionAgreementPlanPersonAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new AdmissionAgreementPlanPerson();
                        
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