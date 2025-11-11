<?php

class ScreenModel extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "screen_model";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;


        public static $idToCodeArr = [];

        public function __construct()
        {
                parent::__construct("screen_model", "id", "adm");
                AdmScreenModelAfwStructure::initInstance($this);
        }

        public static function IdToCode($id)
        {
            if(!isset(self::$idToCodeArr[$id]))
            {
                $obj = ScreenModel::loadById($id);
                if($obj)
                {
                    self::$idToCodeArr[$id] = $obj->getVal("screen_code");
                }
                else
                {
                    self::$idToCodeArr[$id] = "unknown";
                }
            }
            return self::$idToCodeArr[$id];
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

        public static function getScreenData($screen_code)
        {
            $objScreen = ScreenModel::loadByMainIndex($screen_code);
            $lang = AfwLanguageHelper::getGlobalLanguage();
                
            $afList = $objScreen->get("application_field_mfk");
            $data = [];
            $scr_id = $objScreen->id;
            $data["current-screen"]["id"] = $scr_id;
            $data["current-screen"]["code"] = $screen_code;
            $data["screen-$scr_id"]["fields"] = [];
            foreach($afList as $afieldObj)
            {
                if($afieldObj)
                {
    
                    $field_name = $afieldObj->getVal("field_name");
                    $application_table_id = $afieldObj->getVal("application_table_id");
                    $application_table_code = self::code_of_application_table_id($application_table_id);
                    $application_field_type_enum = $afieldObj->getVal("application_field_type_id");
                    $afield_type_code = self::field_type_code($application_field_type_enum);
                    $need_decode = self::need_decode($application_field_type_enum);
                    $field_title_ar = $afieldObj->getVal("field_title_ar");
                    $field_title_en = $afieldObj->getVal("field_title_en");
                    $reel = $afieldObj->sureIs("reel");
                    $additional = $afieldObj->sureIs("additional");
                    $answer = false;  	  
    
                    $data["screen-$scr_id"]["fields"][$afieldObj->id] = ['field' => $field_name, 'additional'=>$additional, 'reel'=>$reel, 'type'=>$afield_type_code, 'need_decode'=>$need_decode, 'table'=>$application_table_code, 'title_ar'=>$field_title_ar, 'title_en'=>$field_title_en, 'answer'=>$answer];
                }
                
            
            }    

            return $data;
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
