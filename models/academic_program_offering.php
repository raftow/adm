<?php
        class AcademicProgramOffering extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "academic_program_offering"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("academic_program_offering","id","adm");
                        AdmAcademicProgramOfferingAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new AcademicProgramOffering();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
                }

                public static function loadByMainIndex($academic_program_id, $training_unit_id,$create_obj_if_not_found=false)
                {
                    $obj = new AcademicProgramOffering();
                    $obj->select("academic_program_id",$academic_program_id);
                    $obj->select("training_unit_id",$training_unit_id);

                    if($obj->load())
                    {
                            if($create_obj_if_not_found) $obj->activate();
                            return $obj;
                    }
                    elseif($create_obj_if_not_found)
                    {
                            $obj->set("academic_program_id",$academic_program_id);
                            $obj->set("training_unit_id",$training_unit_id);

                            $obj->insertNew();
                            if(!$obj->id) return null; // means beforeInsert rejected insert operation
                            $obj->is_new = true;
                            return $obj;
                    }
                    else return null;
                
                }

                public static function loadListeForModel($academic_level_id, $gender_enum)
                {
                        $obj = new AcademicProgramOffering();
                        $obj->select("academic_level_id",$academic_level_id);
                        $obj->select("gender_enum",$gender_enum);
                        
                        return $obj->loadMany();

                }


                public function getDisplay($lang="ar")
                {
                    return $this->getVal("program_name_$lang");
                }

                public function stepsAreOrdered()
                {
                        return false;
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

                                    
                            
                            // MFK

                        }
                        else
                        {
                                    // FK on me 

                                    
                                    // MFK

                            
                        } 
                        return true;
                    }    
                }

                public function genereName($lang="ar", $which="all", $commit=true)
                {
                    $acadProg = $this->het("academic_program_id");            
                    if(!$acadProg) return ["لم يتم تحديد البرنامج", ""];
                    $tunitObj = $this->het("training_unit_id");            
                    if(!$tunitObj) return ["لم يتم تحديد الوحدة التدريبية", ""];
                    
                    if(($which=="all") or ($which=="ar"))
                    {
                        $new_name = $tunitObj->getDisplay("ar")."-".$acadProg->getDisplay("ar");
                        $this->set("program_name_ar", $new_name);                        
                        // die("reset name to : ".$new_name);
                    }
        
                    if(($which=="all") or ($which=="en"))
                    {
                        $new_name = $tunitObj->getDisplay("en")."-".$acadProg->getDisplay("en");
                        $this->set("program_name_en", $new_name); 
                    }

                    // $this->set("gender_enum", $tunitObj->getVal("gender_enum"));
        
                    if($commit) $this->commit();
        
                    return ["", "تم تصفير مسمى البرنامج بنجاح"];
                    
                }
                
                protected function afterSetAttribute($attribute)
                {
                        if(($attribute == "training_unit_id") and $this->getVal("training_unit_id"))
                        {
                                $tuObj = $this->het("training_unit_id");
                                if($tuObj)
                                {
                                        $this->set("gender_enum", $tuObj->getVal("gender_enum"));
                                }
                        }

                        if(($attribute == "academic_program_id") and $this->getVal("academic_program_id"))
                        {
                                $acadProg = $this->het("academic_program_id");
                                if($acadProg)
                                {
                                        $this->set("academic_level_id", $acadProg->getVal("academic_level_id"));
                                        $this->set("department_id", $acadProg->getVal("department_id"));
                                        $this->set("major_id", $acadProg->getVal("major_id"));
                                        $this->set("degree_id", $acadProg->getVal("degree_id"));
                                }
                        }
                }

                public function afterMaj($id, $fields_updated)
                {
                        /*
                        if($fields_updated["training_period_menum"] or $fields_updated["seats_capacity_1"] or $fields_updated["seats_capacity_2"] or $fields_updated["seats_capacity_3"])
                        {
                                $this->genereApplicationModelBranchList("ar");
                        }*/
                }

                public function beforeMaj($id, $fields_updated)
                {
                        if($fields_updated["academic_program_id"] or $fields_updated["training_unit_id"] or 1)
                        {
                                if($this->getVal("training_unit_id") and $this->getVal("academic_program_id"))
                                {
                                        if(!$fields_updated["program_name_ar"]) //  or (!$this->getVal("application_model_name_ar")) or ($this->getVal("application_model_name_ar")=="--")
                                        {
                                                $this->genereName("ar", "ar", false);
                                        }
                                        if(!$fields_updated["program_name_en"]) //  or (!$this->getVal("application_model_name_en")) or ($this->getVal("application_model_name_en")=="--")
                                        {
                                                $this->genereName("en", "en", false);
                                        }
                                }
                        }


                        if($fields_updated["training_unit_id"] and $this->getVal("training_unit_id") or 1)
                        {
                                $tuObj = $this->het("training_unit_id");
                                if($tuObj)
                                {
                                        $this->set("gender_enum", $tuObj->getVal("gender_enum"));
                                }
                        }


                        if($fields_updated["academic_program_id"] and $this->getVal("academic_program_id") or 1)
                        {
                                $acadProg = $this->het("academic_program_id");
                                if($acadProg)
                                {
                                        $this->set("academic_level_id", $acadProg->getVal("academic_level_id"));
                                        $this->set("department_id", $acadProg->getVal("department_id"));
                                        $this->set("major_id", $acadProg->getVal("major_id"));
                                        $this->set("degree_id", $acadProg->getVal("degree_id"));
                                }
                        }

                        return true;
                }   


                public static function genereAllNames($lang="ar")
                {
                        $obj = new AcademicProgramOffering();
                        // $obj->select_visibilite_horizontale();
                        $objList = $obj->loadMany();

                        foreach($objList as $objItem)
                        {
                                $objItem->genereName($lang);
                                // $objItem->genereApplicationModelBranchList($lang);                                
                        }
                }

                public static function list_of_training_period_menum()
                {
                        return self::list_of_training_period_enum();
                }

                protected function getPublicMethods()
                {
                
                        $pbms = array();
                        
                        

                        $color = "gray";
                        $title_ar = "تصفير مسمى البرنامج المتاح"; 
                        $methodName = "genereName";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("program_name_ar"));
                        

                        
                        
                        return $pbms;
                }


                

                public function attributeIsApplicable($attribute)
                {
                        /*
                        for($d=1;$d<=3;$d++)
                        {
                                if($attribute == "seats_capacity_$d")
                                {
                                        return $this->findInMfk("training_period_menum",$d, $mfk_empty_so_found=false);
                                }
                        }*/

                        return true;
                }

                protected function getOtherLinksArray($mode, $genereLog = false, $step="all")      
                {
                        global $me, $objme, $lang;
                        $otherLinksArray = $this->getOtherLinksArrayStandard($mode, false, $step);
                        $my_id = $this->getId();
                        $displ = $this->getDisplay($lang);
                        
                        if($mode=="mode_applicationModelBranchList")
                        {
                                unset($link);
                                $my_id = $this->getId();
                                $link = array();
                                $title = "إدارة الطاقة الاستيعابية";
                                $title_detailed = $title ." : " . $displ;
                                $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=ApplicationModelBranch&currmod=adm&id_origin=$my_id&class_origin=AcademicProgramOffering&module_origin=adm&step_origin=3&newo=-1&limit=100&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=program_offering_id=$my_id&sel_program_offering_id=$my_id";
                                $link["TITLE"] = $title;
                                $link["UGROUPS"] = array();
                                $otherLinksArray[] = $link;
                        }
                        
                        return $otherLinksArray;
                }

// academic_program_offering 
public function getScenarioItemId($currstep)
{
   if ($currstep == 1) return 422;
   if ($currstep == 2) return 423;
   if ($currstep == 3) return 424;

   return 0;
}
                

        }
?>