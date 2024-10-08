<?php
/*
DROP TABLE IF EXISTS c0adm.screen_model;

CREATE TABLE IF NOT EXISTS c0adm.`screen_model` (
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
  
    
   screen_code varchar(32)  NOT NULL , 
   screen_title varchar(32)  NOT NULL , 
   screen_name_ar varchar(64)  NOT NULL , 
   screen_name_en varchar(64)  NOT NULL , 
   application_field_mfk smallint NOT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;


-- unique index : 
create unique index uk_screen_model on c0adm.screen_model(screen_code);


    */
class ScreenModel extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "screen_model";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("screen_model", "id", "adm");
                AdmScreenModelAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new ScreenModel();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public static function loadByMainIndex($screen_code,$create_obj_if_not_found=false)
        {
           if(!$screen_code) throw new AfwRuntimeException("loadByMainIndex : screen_code is mandatory field");


           $obj = new ScreenModel();
           $obj->select("screen_code",$screen_code);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("screen_code",$screen_code);

                $obj->insertNew();
                if(!$obj->id) return null; // means beforeInsert rejected insert operation
                $obj->is_new = true;
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
                       // adm.application_step-شاشة الادخال	screen_model_id  حقل يفلتر به (required field)
                        // require_once "../adm/application_step.php";
                        $obj = new ApplicationStep();
                        $obj->where("screen_model_id = '$id' and active='Y' ");
                        $nbRecords = $obj->count();
                        // check if there's no record that block the delete operation
                        if($nbRecords>0)
                        {
                            $this->deleteNotAllowedReason = "Used in some Application steps(s) as ???? ???????";
                            return false;
                        }
                        // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                        if(!$simul) $obj->deleteWhere("screen_model_id = '$id' and active='N'");


                        
                   // FK part of me - deletable 

                   
                   // FK not part of me - replaceable 

                        
                   
                   // MFK

               }
               else
               {
                        // FK on me 
 

                        // adm.application_step-شاشة الادخال	screen_model_id  حقل يفلتر به (required field)
                        if(!$simul)
                        {
                            // require_once "../adm/application_step.php";
                            ApplicationStep::updateWhere(array('screen_model_id'=>$id_replace), "screen_model_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.application_step set screen_model_id='$id_replace' where screen_model_id='$id' ");
                            
                        } 
                        


                        
                        // MFK

                   
               } 
               return true;
            }    
	}
}
