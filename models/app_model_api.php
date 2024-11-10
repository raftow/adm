<?php
        class AppModelApi extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "app_model_api"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("app_model_api","id","adm");
                        AdmAppModelApiAfwStructure::initInstance($this);
                        
                }

                public static function loadByMainIndex($application_model_id, $api_endpoint_id,$create_obj_if_not_found=false)
                {
                   if(!$application_model_id) throw new AfwRuntimeException("loadByMainIndex : application_model_id is mandatory field");
                   if(!$api_endpoint_id) throw new AfwRuntimeException("loadByMainIndex : api_endpoint_id is mandatory field");
        
        
                   $obj = new AppModelApi();
                   $obj->select("application_model_id",$application_model_id);
                   $obj->select("api_endpoint_id",$api_endpoint_id);
        
                   if($obj->load())
                   {
                        if($create_obj_if_not_found) $obj->activate();
                        return $obj;
                   }
                   elseif($create_obj_if_not_found)
                   {
                        $obj->set("application_model_id",$application_model_id);
                        $obj->set("api_endpoint_id",$api_endpoint_id);
        
                        $obj->insertNew();
                        if(!$obj->id) return null; // means beforeInsert rejected insert operation
                        $obj->is_new = true;
                        return $obj;
                   }
                   else return null;
                   
                }
        
        

                public static function loadById($id)
                {
                        $obj = new AppModelApi();
                        
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
                        if($attribute=="api_field_mfk") return true;
                        return false;
                }

                public function beforeDelete($id,$id_replace) 
                {
                        $server_db_prefix = AfwSession::config("db_prefix","tvtc_");
                        
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

                                        
                                
                                // MFK

                        }
                        else
                        {
                                        // FK on me 

                                        
                                        // MFK

                                
                        } 
                        return true;
                }    
                }

        }
?>