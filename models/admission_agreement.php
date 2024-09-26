<?php
/*

medali 24/09/2024

CREATE TABLE IF NOT EXISTS c0adm.`admission_agreement` (
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
  
    
   admfile_id int(11) DEFAULT NULL , 
   admission_agreement_name_ar varchar(128)  NOT NULL , 
   admission_agreement_name_en varchar(128)  NOT NULL , 
   third_party_id int(11) NOT NULL , 
   agreement_start_date datetime DEFAULT NULL , 
   agreement_expiry_date datetime DEFAULT NULL , 
   hijri_agreement_start_date varchar(8) NOT NULL , 
   hijri_agreement_expiry_date varchar(8) NOT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;

create unique index uk_admission_agreement on c0adm.admission_agreement(admission_agreement_name_ar);
*/


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