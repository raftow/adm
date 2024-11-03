<?php
        class ApplicationDesire extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "application_desire"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("application_desire","id","adm");
                        AdmApplicationDesireAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ApplicationDesire();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
                }

                public static function loadByMainIndex($applicant_id, $application_plan_id, $desire_num,$create_obj_if_not_found=false)
                {
                        if(!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
                        if(!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");
                        if(!$desire_num) throw new AfwRuntimeException("loadByMainIndex : desire_num is mandatory field");


                        $obj = new ApplicationDesire();
                        $obj->select("applicant_id",$applicant_id);
                        $obj->select("application_plan_id",$application_plan_id);
                        $obj->select("desire_num",$desire_num);

                        if($obj->load())
                        {
                                if($create_obj_if_not_found) $obj->activate();
                                return $obj;
                        }
                        elseif($create_obj_if_not_found)
                        {
                                $obj->set("applicant_id",$applicant_id);
                                $obj->set("application_plan_id",$application_plan_id);
                                $obj->set("desire_num",$desire_num);

                                $obj->insertNew();
                                if(!$obj->id) return null; // means beforeInsert rejected insert operation
                                $obj->is_new = true;
                                return $obj;
                        }
                        else return null;
                        
                }


                public static function loadByBigIndex($applicant_id, $application_plan_id, $application_plan_branch_id,$create_obj_if_not_found=false)
                {
                        if(!$applicant_id) throw new AfwRuntimeException("loadByMainIndex : applicant_id is mandatory field");
                        if(!$application_plan_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_id is mandatory field");
                        if(!$application_plan_branch_id) throw new AfwRuntimeException("loadByMainIndex : application_plan_branch_id is mandatory field");


                        $obj = new ApplicationDesire();
                        $obj->select("applicant_id",$applicant_id);
                        $obj->select("application_plan_id",$application_plan_id);
                        $obj->select("application_plan_branch_id",$application_plan_branch_id);

                        if($obj->load())
                        {
                                if($create_obj_if_not_found) $obj->activate();
                                return $obj;
                        }
                        elseif($create_obj_if_not_found)
                        {
                                $obj->set("applicant_id",$applicant_id);
                                $obj->set("application_plan_id",$application_plan_id);
                                $obj->set("application_plan_branch_id",$application_plan_branch_id);

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

        }
?>