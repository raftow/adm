<?php
        class MajorPath extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "major_path"; 
                public static $DB_STRUCTURE = null;
                public static $arrAllMajorPaths = [];
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("major_path","id","adm");
                        AdmMajorPathAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        if(!self::$arrAllMajorPaths[$id])
                        {
                                $obj = new MajorPath();
                                if($obj->load($id))
                                {
                                        self::$arrAllMajorPaths[$id] =& $obj;
                                }
                                else self::$arrAllMajorPaths[$id] = "NOT-FOUND";
                        }
                        if(self::$arrAllMajorPaths[$id]=="NOT-FOUND") return null;

                        return self::$arrAllMajorPaths[$id];
                        

                }

                
                public static function loadByMainIndex($qualification_id, $major_category_id,$create_obj_if_not_found=false)
                {
                    $obj = new MajorPath();
                    $obj->select("qualification_id",$qualification_id);
                    $obj->select("major_category_id",$major_category_id);

                    if($obj->load())
                    {
                            if($create_obj_if_not_found) $obj->activate();
                            self::$arrAllMajorPaths[$obj->id] = $obj;
                            return $obj;
                    }
                    elseif($create_obj_if_not_found)
                    {
                            $obj->set("qualification_id",$qualification_id);
                            $obj->set("major_category_id",$major_category_id);

                            $obj->insertNew();
                            if(!$obj->id) return null; // means beforeInsert rejected insert operation
                            $obj->is_new = true;
                            // self::$arrAllMajorPaths[$obj->id] = $obj;
                            return $obj;
                    }
                    else return null;
                
                }

                

                public function getShortDisplay($lang = 'ar')
                {
                        return $this->getVal("major_path_name_$lang");                    
                }

                public function getDisplay($lang = 'ar')
                {
                        return $this->getDefaultDisplay($lang); //." [".$this->id."]";
                }

                public function stepsAreOrdered()
                {
                        return false;
                }

                protected function getOtherLinksArray($mode,$genereLog=false,$step="all")      
                {
                    $lang = AfwLanguageHelper::getGlobalLanguage();
                    // $objme = AfwSession::getUserConnected();
                    // $me = ($objme) ? $objme->id : 0;

                    $otherLinksArray = $this->getOtherLinksArrayStandard($mode,$genereLog,$step);
                    $my_id = $this->getId();
                    $displ = $this->getDisplay($lang);
                    
                    if($mode=="mode_qualMajorPathList")
                    {
                        unset($link);
                        $link = array();
                        $title = "إضافة مسار تأهيل تخصص جديد";
                        $title_detailed = $title ."لـ : ". $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=QualMajorPath&currmod=adm&sel_major_path_id=$my_id";
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
                                // adm.qual_major_path-Major Path	major_path_id  OneToMany
                                if(!$simul)
                                {
                                    // require_once "../adm/qual_major_path.php";
                                    QualMajorPath::removeWhere("major_path_id='$id'");
                                    // $this->execQuery("delete from ${server_db_prefix}adm.qual_major_path where major_path_id = '$id' ");
                                    
                                } 
                                    
                                // FK not part of me - replaceable 

                                // MFK

                        }
                        else
                        {
                                    // FK on me 
                                    // adm.qual_major_path-Major Path	major_path_id  OneToMany
                                    if(!$simul)
                                    {
                                        // require_once "../adm/qual_major_path.php";
                                        QualMajorPath::updateWhere(array('major_path_id'=>$id_replace), "major_path_id='$id'");
                                        // $this->execQuery("update ${server_db_prefix}adm.qual_major_path set major_path_id='$id_replace' where major_path_id='$id' ");
                                        
                                    }
                                    

                                    
                                    // MFK

                            
                        } 
                        return true;
                    }    
            }

        }
?>