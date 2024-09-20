<?php
        class AcademicYear extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "academic_year"; 
                public static $DB_STRUCTURE = null;
                
                public static $copypast = true;

                public function __construct(){
                        parent::__construct("academic_year","id","adm");
                        AdmAcademicYearAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new AcademicYear();
                        
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


                public function beforeMaj($id, $fields_updated)
                {
                    if($this->getVal("start_date") and $fields_updated["start_date"])
                    {
                        $this->set("hijri_start_date", AfwDateHelper::gregToHijri($this->getVal("start_date")));                        
                    }

                    if($this->getVal("end_date") and $fields_updated["end_date"])
                    {
                        $this->set("hijri_end_date", AfwDateHelper::gregToHijri($this->getVal("end_date")));                        
                    }

                    return true;
                }


                protected function getOtherLinksArray($mode,$genereLog=false,$step="all")      
                {
                    global $lang;
                    // $objme = AfwSession::getUserConnected();
                    // $me = ($objme) ? $objme->id : 0;

                    $otherLinksArray = $this->getOtherLinksArrayStandard($mode,$genereLog,$step);
                    $my_id = $this->getId();
                    $displ = $this->getDisplay($lang);
                    
                    if($mode=="mode_academicTermList")
                    {
                        unset($link);
                        $link = array();
                        $title = "إضافة فصل تدريبي جديد";
                        $title_detailed = $title ."لـ : ". $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=AcademicTerm&currmod=adm&sel_academic_year_id=$my_id";
                        $link["TITLE"] = $title;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                    }
                    
                    
                    
                    // check errors on all steps (by default no for optimization)
                    // rafik don't know why this : \//  = false;
                    
                    return $otherLinksArray;
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
                            // adm.academic_term-العام التدريبي	academic_year_id  نوع علاقة بين كيانين ← 1
                                if(!$simul)
                                {
                                    // require_once "../adm/academic_term.php";
                                    AcademicTerm::removeWhere("academic_year_id='$id'");
                                    // $this->execQuery("delete from ${server_db_prefix}adm.academic_term where academic_year_id = '$id' ");
                                    
                                } 
                                
                                

                        
                        // FK not part of me - replaceable 

                                
                        
                        // MFK

                    }
                    else
                    {
                                // FK on me 
                            // adm.academic_term-العام التدريبي	academic_year_id  نوع علاقة بين كيانين ← 1
                                if(!$simul)
                                {
                                    // require_once "../adm/academic_term.php";
                                    AcademicTerm::updateWhere(array('academic_year_id'=>$id_replace), "academic_year_id='$id'");
                                    // $this->execQuery("update ${server_db_prefix}adm.academic_term set academic_year_id='$id_replace' where academic_year_id='$id' ");
                                    
                                }
                                

                                
                                // MFK

                        
                    } 
                    return true;
                    }    
            }

            // academic_year 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 412;
      if ($currstep == 2) return 413;

      return 0;
   }

        }
?>