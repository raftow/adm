<?php
        class Major extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "major"; 
                public static $DB_STRUCTURE = null;
                
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("major","id","adm");
                        AdmMajorAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new Major();
                        
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
                    global $lang;
                    // $objme = AfwSession::getUserConnected();
                    // $me = ($objme) ? $objme->id : 0;

                    $otherLinksArray = $this->getOtherLinksArrayStandard($mode,$genereLog,$step);
                    $my_id = $this->getId();
                    $displ = $this->getDisplay($lang);
                    
                    if($mode=="mode_majorDepartmentList")
                    {
                        unset($link);
                        $link = array();
                        $title = "إضافة علاقة تخصص $displ بقسم جديد";
                        $title_detailed = $title ."لـ : ". $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=MajorDepartment&currmod=adm&sel_major_id=$my_id";
                        $link["TITLE"] = $title;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                    }
                    
                    
                    
                    // check errors on all steps (by default no for optimization)
                    // rafik don't know why this : \//  = false;
                    
                    return $otherLinksArray;
                }

                // major 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 388;
      if ($currstep == 2) return 389;

      return 0;
   }

        }
?>