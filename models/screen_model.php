<?php

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

        public static function IdToCode($id)
        {
            if($id==2) return	"qualif";
            if($id==3) return	"profile";
            if($id==4) return	"data_import";
            if($id==5) return	"program";
            if($id==6) return	"final";
            if($id==7) return	"desire";
            if($id==8) return	"sorting";
            if($id==9) return	"track_exists";
            if($id==10) return	"upload_document";


            return "unknown";
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
            $server_db_prefix = AfwSession::config("db_prefix","default_db_");
            
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
