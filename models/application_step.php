<?php
/* rafik 23/09/2024

DROP TABLE IF EXISTS c0adm.application_step;

CREATE TABLE IF NOT EXISTS c0adm.`application_step` (
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
  
    
   application_model_id int(11) NOT NULL , 
   step_num smallint NOT NULL , 
   general char(1) DEFAULT NULL , 
   screen_model_id int(11) NOT NULL , 
   step_name_ar varchar(100)  NOT NULL , 
   step_name_en varchar(100)  NOT NULL , 
   show_field_mfk varchar(255) DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;


create unique index uk_application_step on c0adm.application_step(application_model_id,step_num);
*/
        class ApplicationStep extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "application_step"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("application_step","id","adm");
                        AdmApplicationStepAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ApplicationStep();
                        
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

                public function beforeMaj($id, $fields_updated)
                {
                        if((!$this->getVal("step_name_ar")) or (!$this->getVal("step_name_en"))) 
                        {
                                $screenObj = $this->het("screen_model_id");
                                if($screenObj)
                                {
                                        $step_name_ar = $screenObj->getVal("screen_name_ar");
                                        $step_name_en = $screenObj->getVal("screen_name_en");
                                        $this->set("step_name_ar", $step_name_ar);
                                        $this->set("step_name_en", $step_name_en);                                        
                                }
                                
                        }

                        if(!$this->getVal("show_field_mfk"))
                        {
                                $screenObj = $this->het("screen_model_id");
                                if($screenObj)
                                {
                                        $application_field_mfk = $screenObj->getVal("application_field_mfk");
                                        
                                        $this->set("show_field_mfk", $application_field_mfk);
                                }
                                
                        }

                        return true;
                }

                public function shouldBeCalculatedField($attribute){
                        if($attribute=="application_field_mfk") return true;
                        return false;
                }

                public function getScenarioItemId($currstep)
                {
                      if($currstep == 1) return 479;
                      if($currstep == 2) return 482;

                      return 0;
                }

                public function beforeDelete($id,$id_replace) 
                {
                        $server_db_prefix = AfwSession::config("db_prefix","c0");
                        
                        if(!$id)
                        {
                                $id = $this->getId();
                                $simul = true;
                        }
                        else
                        {
                                $simul = false;
                        }
                        
                        if($id)
                        {   
                                if($id_replace==0)
                                {
                                        // FK part of me - not deletable 

                                                
                                        // FK part of me - deletable 

                                        
                                        // FK not part of me - replaceable 
                                                // adm.application-مسمى المرحلة الحالية	application_step_id  ManyToOne
                                                if(!$simul)
                                                {
                                                        // require_once "../adm/application.php";
                                                        Application::updateWhere(array('application_step_id'=>$id_replace), "application_step_id='$id'");
                                                        // $this->execQuery("update ${server_db_prefix}adm.application set application_step_id='$id_replace' where application_step_id='$id' ");
                                                }

                                                
                                        
                                        // MFK

                                }
                                else
                                {
                                                // FK on me 
                                        // adm.application-مسمى المرحلة الحالية	application_step_id  ManyToOne
                                                if(!$simul)
                                                {
                                                // require_once "../adm/application.php";
                                                Application::updateWhere(array('application_step_id'=>$id_replace), "application_step_id='$id'");
                                                // $this->execQuery("update ${server_db_prefix}adm.application set application_step_id='$id_replace' where application_step_id='$id' ");
                                                }

                                                
                                                // MFK

                                        
                                } 
                                return true;
                        }    
                }

        }
?>