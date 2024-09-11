<?php
/*
DROP TABLE IF EXISTS c0adm.acondition_origin_scope;

CREATE TABLE IF NOT EXISTS c0adm.`acondition_origin_scope` ( 
    `id` int(11) NOT NULL AUTO_INCREMENT, 
    `created_by` int(11) NOT NULL, 
    `created_at` datetime NOT NULL, 
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
    
    acondition_origin_id int(11) DEFAULT NULL , 
    application_model_id int(11) DEFAULT NULL , 
    training_unit_id int(11) DEFAULT NULL , 
    department_id int(11) DEFAULT NULL , 
    application_model_branch_id int(11) DEFAULT NULL , 
    PRIMARY KEY (`id`) 
    
    ) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;

    
    create unique index uk_acondition_origin_scope on c0adm.acondition_origin_scope(acondition_origin_id,application_model_id,training_unit_id,department_id,application_model_branch_id);
*/
        class AconditionOriginScope extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "acondition_origin_scope"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("acondition_origin_scope","id","adm");
                        AdmAconditionOriginScopeAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new AconditionOriginScope();
                        
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

                public function shouldBeCalculatedField($attribute){
                    if($attribute=="application_model_mfk") return true;
                    return false;
                }

        }
?>