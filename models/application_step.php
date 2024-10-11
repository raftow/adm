<?php

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

                public static function loadByMainIndex(
                        $application_model_id, 
                        $step_num,
                        $general='Y',    
                        $screenModelObj=null,                        
                        $create_obj_if_not_found=false)
                {
                   if(!$application_model_id) throw new AfwRuntimeException("loadByMainIndex : application_model_id is mandatory field");
                   if($step_num<0) throw new AfwRuntimeException("loadByMainIndex : step_num is mandatory field");

                   if($create_obj_if_not_found) 
                   {
                        if(!$screenModelObj) throw new AfwRuntimeException("loadByMainIndex : screenModelObj is mandatory attribute when you will create an instance");
                        $screen_model_id = $screenModelObj->id;
                        $show_field_mfk = $screenModelObj->getVal("application_field_mfk");
                        $step_name_ar = $screenModelObj->getVal("screen_name_ar");
                        $step_name_en = $screenModelObj->getVal("screen_name_en");
                   }
                   
        
                   $obj = new ApplicationStep();
                   $obj->select("application_model_id",$application_model_id);
                   $obj->select("step_num",$step_num);
        
                   if($obj->load())
                   {
                        if($create_obj_if_not_found) 
                        {
                                $obj->set("general",$general);
                                $obj->set("screen_model_id",$screen_model_id);
                                $obj->set("step_name_ar",$step_name_ar);
                                $obj->set("step_name_en",$step_name_en);
                                $obj->set("show_field_mfk",$show_field_mfk);
                                $obj->activate();
                        }
                        return $obj;
                   }
                   elseif($create_obj_if_not_found)
                   {
                        $obj->set("application_model_id",$application_model_id);
                        $obj->set("step_num",$step_num);


                        $obj->set("general",$general);
                        $obj->set("screen_model_id",$screen_model_id);
                        $obj->set("step_name_ar",$step_name_ar);
                        $obj->set("step_name_en",$step_name_en);
                        $obj->set("show_field_mfk",$show_field_mfk);
        
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

                public function applyMyGeneralConditionsOn($applicationObject)
                {
                        $err_arr = [];
                        $inf_arr = [];
                        $war_arr = [];
                        $tech_arr = [];

                        $application_model_id = $this->getVal("application_model_id");
                        $step_num = $this->getVal("step_num");
                        $acondList = ApplicationModelCondition::loadStepNumConditions($application_model_id, $step_num, true);
                        foreach($acondList as $acondItem)
                        {
                                
                        }

                        return AfwFormatHelper::pbm_result($err_arr,$inf_arr,$war_arr,"<br>\n",$tech_arr);
                }

        }
?>