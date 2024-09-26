<?php
/*
medali 25/09/2024
CREATE TABLE IF NOT EXISTS c0adm.`admission_agreement_scope` (
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
  
    
   admission_agreement_plan_id int(11) NOT NULL , 
   application_plan_id int(11) NOT NULL , 
   training_unit_id int(11) NOT NULL , 
   auser_id int(11) NOT NULL , 
   start_date datetime DEFAULT NULL , 
   end_date datetime DEFAULT NULL , 
   hijri_start_date varchar(8) NOT NULL , 
   hijri_end_date varchar(8) NOT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;

create unique index uk_admission_agreement_scope on c0adm.admission_agreement_scope(admission_agreement_plan_id,application_plan_id,training_unit_id);
*/

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