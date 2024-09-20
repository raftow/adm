<?php
        class Qualification extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "qualification"; 
                public static $DB_STRUCTURE = null;
                public static $copypast = true;

                public function __construct(){
                        parent::__construct("qualification","id","adm");
                        AdmQualificationAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new Qualification();
                        
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

                protected function getOtherLinksArray($mode,$genereLog=false,$step="all")      
                {
                    global $lang;
                    // $objme = AfwSession::getUserConnected();
                    // $me = ($objme) ? $objme->id : 0;

                    $otherLinksArray = $this->getOtherLinksArrayStandard($mode,$genereLog,$step);
                    $my_id = $this->getId();
                    $displ = $this->getDisplay($lang);
                    
                    if($mode=="mode_qualSourceList")
                    {
                        unset($link);
                        $link = array();
                        $title = "إضافة مصدر مؤهل جديد";
                        $title_detailed = $title ."لـ : ". $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=QualSource&currmod=adm&sel_qualification_id=$my_id";
                        $link["TITLE"] = $title;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                    }
                    
                    if($mode=="mode_qualMajorPathList")
                    {
                        unset($link);
                        $link = array();
                        $title = "إضافة مسار تأهيل تخصص جديد";
                        $title_detailed = $title ."لـ : ". $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=QualMajorPath&currmod=adm&sel_qualification_id=$my_id";
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
                    // $server_db_prefix = AfwSession::config("db_prefix","c0");
                    
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
                                // adm.qual_source-Qualification	qualification_id  OneToMany
                                    if(!$simul)
                                    {
                                        // require_once "../adm/qual_source.php";
                                        QualSource::removeWhere("qualification_id='$id'");
                                        // $this->execQuery("delete from ${server_db_prefix}adm.qual_source where qualification_id = '$id' ");
                                        
                                    } 
                                    
                                    

                            
                            // FK not part of me - replaceable 
                                // adm.major_path-Qualification	qualification_id  ManyToOne
                                    if(!$simul)
                                    {
                                        // require_once "../adm/major_path.php";
                                        MajorPath::updateWhere(array('qualification_id'=>$id_replace), "qualification_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.major_path set qualification_id='$id_replace' where qualification_id='$id' ");
                                    }

                                    
                            
                            // MFK

                        }
                        else
                        {
                                    // FK on me 
                                // adm.qual_source-Qualification	qualification_id  OneToMany
                                    if(!$simul)
                                    {
                                        // require_once "../adm/qual_source.php";
                                        QualSource::updateWhere(array('qualification_id'=>$id_replace), "qualification_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.qual_source set qualification_id='$id_replace' where qualification_id='$id' ");
                                        
                                    }
                                    
                                // adm.major_path-Qualification	qualification_id  ManyToOne
                                    if(!$simul)
                                    {
                                        // require_once "../adm/major_path.php";
                                        MajorPath::updateWhere(array('qualification_id'=>$id_replace), "qualification_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.major_path set qualification_id='$id_replace' where qualification_id='$id' ");
                                    }

                                    
                                    // MFK

                            
                        } 
                        return true;
                    }    
            }

            // qualification 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 454;
      if ($currstep == 2) return 455;

      return 0;
   }

        }
?>