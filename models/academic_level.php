<?php
        class AcademicLevel extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "academic_level"; 
                public static $DB_STRUCTURE = null;

                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("academic_level","id","adm");
                        AdmAcademicLevelAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new AcademicLevel();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
                }

                public function getDisplay($lang = 'ar')
                {
                        return $this->getVal("academic_level_name_".$lang)."-".$this->getVal("academic_level_code");
                }


                protected function getOtherLinksArray($mode,$genereLog=false,$step="all")      
                {
                        $lang = AfwLanguageHelper::getGlobalLanguage();
                        // $objme = AfwSession::getUserConnected();
                        // $me = ($objme) ? $objme->id : 0;

                        $otherLinksArray = $this->getOtherLinksArrayStandard($mode,$genereLog,$step);
                        $my_id = $this->getId();
                        $displ = $this->getDisplay($lang);
                        
                        if($mode=="mode_academicLevelPrivilegeList")
                        {
                                unset($link);
                                $link = array();
                                $title = "إضافة ميزة جديد";
                                $title_detailed = $title ."لـ : ". $displ;
                                $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=AcademicLevelPrivilege&currmod=adm&sel_academic_level_id=$my_id";
                                $link["TITLE"] = $title;
                                $link["UGROUPS"] = array();
                                $otherLinksArray[] = $link;

                                /*
                                unset($link);
                                $link = array();
                                $title = "إدارة الميزات ";
                                $title_detailed = $title ."لـ : ". $displ;
                                $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=AcademicLevelPrivilege&currmod=adm&ids=all&sel_academic_level_id=$my_id&fixm=academic_level_id=$my_id&fixmtit=$title_detailed&newo=10";
                                $link["TITLE"] = $title;
                                $link["UGROUPS"] = array();
                                $otherLinksArray[] = $link;*/
                        }

                        if($mode=="mode_academicLevelOfferingList")
                        {
                                unset($link);
                                $link = array();
                                $title = "إضافة منشأة منفذة جديدة";
                                $title_detailed = $title ."لـ : ". $displ;
                                $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=AcademicLevelOffering&currmod=adm&sel_academic_level_id=$my_id";
                                $link["TITLE"] = $title;
                                $link["UGROUPS"] = array();
                                $otherLinksArray[] = $link;
                        }
                        
                        
                        
                        // check errors on all steps (by default no for optimization)
                        // rafik don't know why this : \//  = false;
                        
                        return $otherLinksArray;
                }

                // academic_level 
                public function getScenarioItemId($currstep)
                {
                        if ($currstep == 1) return 384;
                        if ($currstep == 2) return 385;
                        if ($currstep == 3) return 410;
                        if ($currstep == 4) return 419;

                        return 0;
                }

                public function beforeDelete($id,$id_replace) 
        {
            $server_db_prefix = AfwSession::config("db_prefix","uoh_");
            
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
                       // adm.academic_program-المرحلة الدراسية	academic_level_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/academic_program.php";
                            AcademicProgram::removeWhere("academic_level_id='$id'");
                            // $this->execQuery("delete from ${server_db_prefix}adm.academic_program where academic_level_id = '$id' ");
                            
                        } 
                        
                        
                       // adm.academic_level_privilege-المرحلة التدريبية	academic_level_id  أنا تفاصيل لها
                        if(!$simul)
                        {
                            // require_once "../adm/academic_level_privilege.php";
                            AcademicLevelPrivilege::removeWhere("academic_level_id='$id'");
                            // $this->execQuery("delete from ${server_db_prefix}adm.academic_level_privilege where academic_level_id = '$id' ");
                            
                        } 
                        
                        
                       // adm.academic_level_offering-المرحلة التدريبية	academic_level_id  أنا تفاصيل لها
                        if(!$simul)
                        {
                            // require_once "../adm/academic_level_offering.php";
                            AcademicLevelOffering::removeWhere("academic_level_id='$id'");
                            // $this->execQuery("delete from ${server_db_prefix}adm.academic_level_offering where academic_level_id = '$id' ");
                            
                        } 
                        
                        
                       // adm.application_model-المرحلة التدريبية	academic_level_id  أنا تفاصيل لها
                        if(!$simul)
                        {
                            // require_once "../adm/application_model.php";
                            ApplicationModel::removeWhere("academic_level_id='$id'");
                            // $this->execQuery("delete from ${server_db_prefix}adm.application_model where academic_level_id = '$id' ");
                            
                        } 
                        
                        
                       // adm.application_plan_branch-المرحلة التدريبية	academic_level_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/application_plan_branch.php";
                            ApplicationPlanBranch::removeWhere("academic_level_id='$id'");
                            // $this->execQuery("delete from ${server_db_prefix}adm.application_plan_branch where academic_level_id = '$id' ");
                            
                        } 
                        
                        
                       // adm.program_qualification-المرحلة الاكاديمية	academic_level_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/program_qualification.php";
                            ProgramQualification::removeWhere("academic_level_id='$id'");
                            // $this->execQuery("delete from ${server_db_prefix}adm.program_qualification where academic_level_id = '$id' ");
                            
                        } 
                        
                        

                   
                   // FK not part of me - replaceable 
                       // adm.academic_program_offering-المرحلة الدراسية	academic_level_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/academic_program_offering.php";
                            AcademicProgramOffering::updateWhere(array('academic_level_id'=>$id_replace), "academic_level_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.academic_program_offering set academic_level_id='$id_replace' where academic_level_id='$id' ");
                        }

                        
                   
                   // MFK
                       // adm.academic_term-المراحل التدريبية المعنية	academic_level_mfk  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/academic_term.php";
                            AcademicTerm::updateWhere(array('academic_level_mfk'=>"REPLACE(academic_level_mfk, ',$id,', ',')"), "academic_level_mfk like '%,$id,%'");
                            // $this->execQuery("update ${server_db_prefix}adm.academic_term set academic_level_mfk=REPLACE(academic_level_mfk, ',$id,', ',') where academic_level_mfk like '%,$id,%' ");
                        }
                        

               }
               else
               {
                        // FK on me 
                       // adm.academic_program-المرحلة الدراسية	academic_level_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/academic_program.php";
                            AcademicProgram::updateWhere(array('academic_level_id'=>$id_replace), "academic_level_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.academic_program set academic_level_id='$id_replace' where academic_level_id='$id' ");
                            
                        }
                        
                       // adm.academic_level_privilege-المرحلة التدريبية	academic_level_id  أنا تفاصيل لها
                        if(!$simul)
                        {
                            // require_once "../adm/academic_level_privilege.php";
                            AcademicLevelPrivilege::updateWhere(array('academic_level_id'=>$id_replace), "academic_level_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.academic_level_privilege set academic_level_id='$id_replace' where academic_level_id='$id' ");
                            
                        }
                        
                       // adm.academic_level_offering-المرحلة التدريبية	academic_level_id  أنا تفاصيل لها
                        if(!$simul)
                        {
                            // require_once "../adm/academic_level_offering.php";
                            AcademicLevelOffering::updateWhere(array('academic_level_id'=>$id_replace), "academic_level_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.academic_level_offering set academic_level_id='$id_replace' where academic_level_id='$id' ");
                            
                        }
                        
                       // adm.application_model-المرحلة التدريبية	academic_level_id  أنا تفاصيل لها
                        if(!$simul)
                        {
                            // require_once "../adm/application_model.php";
                            ApplicationModel::updateWhere(array('academic_level_id'=>$id_replace), "academic_level_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.application_model set academic_level_id='$id_replace' where academic_level_id='$id' ");
                            
                        }
                        
                       // adm.application_plan_branch-المرحلة التدريبية	academic_level_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/application_plan_branch.php";
                            ApplicationPlanBranch::updateWhere(array('academic_level_id'=>$id_replace), "academic_level_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.application_plan_branch set academic_level_id='$id_replace' where academic_level_id='$id' ");
                            
                        }
                        
                       // adm.program_qualification-المرحلة الاكاديمية	academic_level_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/program_qualification.php";
                            ProgramQualification::updateWhere(array('academic_level_id'=>$id_replace), "academic_level_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.program_qualification set academic_level_id='$id_replace' where academic_level_id='$id' ");
                            
                        }
                        
                       // adm.academic_program_offering-المرحلة الدراسية	academic_level_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/academic_program_offering.php";
                            AcademicProgramOffering::updateWhere(array('academic_level_id'=>$id_replace), "academic_level_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}adm.academic_program_offering set academic_level_id='$id_replace' where academic_level_id='$id' ");
                        }

                        
                        // MFK
                       // adm.academic_term-المراحل التدريبية المعنية	academic_level_mfk  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../adm/academic_term.php";
                            AcademicTerm::updateWhere(array('academic_level_mfk'=>"REPLACE(academic_level_mfk, ',$id,', ',$id_replace,')"), "academic_level_mfk like '%,$id,%'");
                            // $this->execQuery("update ${server_db_prefix}adm.academic_term set academic_level_mfk=REPLACE(academic_level_mfk, ',$id,', ',$id_replace,') where academic_level_mfk like '%,$id,%' ");
                        }

                   
               } 
               return true;
            }    
	}

}
?>