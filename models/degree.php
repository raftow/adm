<?php
        class Degree extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "degree"; 
                public static $DB_STRUCTURE = null;

                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("degree","id","adm");
                        AdmDegreeAfwStructure::initInstance($this);
                        
                }


                public function getDisplay($lang="ar")
                {
                    return $this->getVal("degree_code")."-".$this->getVal("degree_name_$lang");
                }

                public static function loadById($id)
                {
                        $obj = new Degree();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
                }


                public static function loadByMainIndex($degree_code, $degree_name_ar, $degree_name_en, $create_obj_if_not_found=false)
                {
                    $obj = new Degree();
                    $obj->select("degree_code",$degree_code);

                    if($obj->load())
                    {
                            if($create_obj_if_not_found) 
                            {
                                $obj->set("degree_name_ar",$degree_name_ar);
                                $obj->set("degree_name_en",$degree_name_en);
                                $obj->activate();
                            }
                        
                            
                            return $obj;
                    }
                    elseif($create_obj_if_not_found)
                    {
                            $obj->set("degree_code",$degree_code);
                            $obj->set("degree_name_ar",$degree_name_ar);
                            $obj->set("degree_name_en",$degree_name_en);

                            $obj->insertNew();
                            if(!$obj->id) return null; // means beforeInsert rejected insert operation
                            $obj->is_new = true;
                            return $obj;
                    }
                    else return null;
                
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

                                                
                                        // FK part of me - deletable 

                                        
                                        // FK not part of me - replaceable 
                                        // adm.academic_program-Degree	degree_id  نوع علاقة بين كيانين ← 2
                                                if(!$simul)
                                                {
                                                // require_once "../adm/academic_program.php";
                                                AcademicProgram::updateWhere(array('degree_id'=>$id_replace), "degree_id='$id'");
                                                // $this->execQuery("update ${server_db_prefix}adm.academic_program set degree_id='$id_replace' where degree_id='$id' ");
                                                }

                                                
                                        
                                        // MFK
                                        // adm.academic_level-Graduation Certificate	degree_mfk  نوع علاقة بين كيانين ← 2
                                                if(!$simul)
                                                {
                                                // require_once "../adm/academic_level.php";
                                                AcademicLevel::updateWhere(array('degree_mfk'=>"REPLACE(degree_mfk, ',$id,', ',')"), "degree_mfk like '%,$id,%'");
                                                // $this->execQuery("update ${server_db_prefix}adm.academic_level set degree_mfk=REPLACE(degree_mfk, ',$id,', ',') where degree_mfk like '%,$id,%' ");
                                                }
                                                

                                }
                                else
                                {
                                                // FK on me 
                                        // adm.academic_program-Degree	degree_id  نوع علاقة بين كيانين ← 2
                                                if(!$simul)
                                                {
                                                // require_once "../adm/academic_program.php";
                                                AcademicProgram::updateWhere(array('degree_id'=>$id_replace), "degree_id='$id'");
                                                // $this->execQuery("update ${server_db_prefix}adm.academic_program set degree_id='$id_replace' where degree_id='$id' ");
                                                }

                                                
                                                // MFK
                                        // adm.academic_level-Graduation Certificate	degree_mfk  نوع علاقة بين كيانين ← 2
                                                if(!$simul)
                                                {
                                                // require_once "../adm/academic_level.php";
                                                AcademicLevel::updateWhere(array('degree_mfk'=>"REPLACE(degree_mfk, ',$id,', ',$id_replace,')"), "degree_mfk like '%,$id,%'");
                                                // $this->execQuery("update ${server_db_prefix}adm.academic_level set degree_mfk=REPLACE(degree_mfk, ',$id,', ',$id_replace,') where degree_mfk like '%,$id,%' ");
                                                }

                                        
                                } 
                                return true;
                        }    
                }

                // degree 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 386;
      if ($currstep == 2) return 387;

      return 0;
   }

        }
?>