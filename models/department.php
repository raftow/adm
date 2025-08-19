<?php
        class Department extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "department"; 
                public static $DB_STRUCTURE = null;
                
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("department","id","adm");
                        AdmDepartmentAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new Department();
                        
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


                protected function getOtherLinksArray($mode,$genereLog=false,$step="all")      
                {
                    $lang = AfwLanguageHelper::getGlobalLanguage();
                    // $objme = AfwSession::getUserConnected();
                    // $me = ($objme) ? $objme->id : 0;

                    $otherLinksArray = $this->getOtherLinksArrayStandard($mode,$genereLog,$step);
                    $my_id = $this->getId();
                    $displ = $this->getDisplay($lang);
                    
                    if($mode=="mode_majorDepartmentList")
                    {
                        unset($link);
                        $link = array();
                        $title = "إضافة علاقة قسم $displ بتخصص جديد";
                        $title_detailed = $title ."لـ : ". $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=MajorDepartment&currmod=adm&sel_department_id=$my_id";
                        $link["TITLE"] = $title;
                        $link["PUBLIC"] = true;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                    }
                    
                    
                    
                    // check errors on all steps (by default no for optimization)
                    // rafik don't know why this : \//  = false;
                    
                    return $otherLinksArray;
                }

                // department 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 390;
      if ($currstep == 2) return 391;

      return 0;
   }

        }
?>