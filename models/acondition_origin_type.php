<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table acondition_origin_type : acondition_origin_type - نماذج المستويات الدراسية 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class AconditionOriginType extends AdmObject{

	public static $DATABASE		= ""; 
        public static $MODULE		    = "adm"; 
        public static $TABLE			= ""; 
        public static $DB_STRUCTURE = null;  
        
        
        public function __construct(){
		parent::__construct("acondition_origin_type","id","adm");
                AdmAconditionOriginTypeAfwStructure::initInstance($this);
                
	}
        
        protected function getOtherLinksArray($mode, $genereLog = false, $step="all")      
        {
             global $me, $objme, $lang;
             $otherLinksArray = $this->getOtherLinksArrayStandard($mode, false, $step);
             $my_id = $this->getId();
             $my_disp = $this->getDisplay($lang);
             if($my_id and ($mode=="mode_schoolLevels"))
             {
                  
                       unset($link);
                       $link = array();
                       $title = "إدارة المستويات الدراسية لـ :  ". $my_disp;
                       $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=SchoolLevel&currmod=adm&&id_origin=$my_id&class_origin=AconditionOriginType&module_origin=adm&newo=3&limit=30&ids=all&fixmtit=$title&fixmdisable=1&fixm=acondition_origin_type_id=$my_id&sel_acondition_origin_type_id=$my_id";
                       $link["TITLE"] = $title;
                       $link["UGROUPS"] = array();
                       $otherLinksArray[] = $link;      

             }
             
             return $otherLinksArray;
        }


        public function getLevelClassOf($general)
        {
                global $arr_general_LevelClass;
                if(isset($arr_general_LevelClass[$general])) return $arr_general_LevelClass[$general]["object"];
                $ids_arr = [];
                $schoolLevels = $this->get("schoolLevels");
                foreach($schoolLevels as $schoolLevelItem)
                {
                        $ids_arr[] = $schoolLevelItem->id;
                }
                if(!$general) $general = 0;
                
                $lc = new LevelClass();
                $lc->selectIn("school_level_id", $ids_arr);
                $lc->where("$general between min_eval and max_eval");

                if($lc->load())
                {
                        $arr_general_LevelClass[$general] = ["object"=>$lc, "found"=>true];
                        return $lc;
                }
                else
                {
                        $arr_general_LevelClass[$general] = ["object"=>null, "found"=>false];
                        return null;
                }
        }
}
?>