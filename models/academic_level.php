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
                        global $lang;
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

                

        }
?>