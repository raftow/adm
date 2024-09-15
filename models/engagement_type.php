<?php
// medali 15/09/2024
/*
CREATE TABLE IF NOT EXISTS c0adm.`engagement_type` (
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
  
  `lookup_code` varchar(64) DEFAULT NULL,  
   engagement_type varchar(10)  DEFAULT NULL , 
   engagement_type_name_ar varchar(30)  DEFAULT NULL , 
   engagement_type_name_en varchar(30)  DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;

create unique index uk_engagement_type on c0adm.engagement_type(engagement_type);

INSERT INTO `engagement_type` (`id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `validated_by`, `validated_at`, `active`, `draft`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `lookup_code`, `engagement_type`, `engagement_type_name_ar`, `engagement_type_name_en`) VALUES
(1, 1, '2024-09-15 14:09:11', 1, '2024-09-15 14:09:11', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'PL', 'تعهّد بصحة البيانات', 'Pledge of data accuracy'),
(2, 1, '2024-09-15 14:09:11', 1, '2024-09-15 14:09:11', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'AC', 'عقد اتفاقية قبول', ' admission agreement contract'),
(3, 1, '2024-09-15 14:09:11', 1, '2024-09-15 14:09:11', 0, NULL, 'Y', 'Y', 1, NULL, NULL, NULL, 0, NULL, 'MC', 'شرط يدوي', 'Manual requirement');

*/
        class EngagementType extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "engagement_type"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("engagement_type","id","adm");
                        AdmEngagementTypeAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new EngagementType();
                        
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