<?php
        class Scholarship extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "scholarship"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("scholarship","id","adm");
                        AdmScholarshipAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new Scholarship();
                        
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
                        $lang = AfwLanguageHelper::getGlobalLanguage();
                        // $objme = AfwSession::getUserConnected();
                        // $me = ($objme) ? $objme->id : 0;

                        $otherLinksArray = $this->getOtherLinksArrayStandard($mode,$genereLog,$step);
                        $my_id = $this->getId();
                        $displ = $this->getDisplay($lang);
                        
                        

                        if($mode=="mode_ApplicantScholarshipList")
                        {
                                unset($link);
                                $link = array();
                                $title = "إضافة مستفيد";
                                $title_detailed = $title ."لـ : ". $displ;
                                $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=ApplicantScholarship&currmod=adm&sel_scholarship_id=$my_id";
                                $link["TITLE"] = $title;
                                $link["PUBLIC"] = true;
                                $otherLinksArray[] = $link;
                        }
                        
                        
                        
                        // check errors on all steps (by default no for optimization)
                        // rafik don't know why this : \//  = false;
                        
                        return $otherLinksArray;
                }

             

        }
?>