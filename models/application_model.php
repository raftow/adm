<?php
        // medali 18/9/2024 : alter table c0adm.application_model add   web_application char(1) DEFAULT NULL  after upload_files;

        class ApplicationModel extends AdmObject{

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "application_model"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("application_model","id","adm");
                        AdmApplicationModelAfwStructure::initInstance($this);
                        
                }

                public static function loadById($id)
                {
                        $obj = new ApplicationModel();
                        
                        if($obj->load($id))
                        {
                                return $obj;
                        }
                        else return null;
                }

                public function getDisplay($lang="ar")
                {
                        return $this->getVal("application_model_name_$lang");                    
                }

                public function stepsAreOrdered()
                {
                        return true;
                }
                
                public static function loadByMainIndex($academic_level_id, $gender_enum, $training_period_enum,$create_obj_if_not_found=false)
                {
                        $obj = new ApplicationModel();
                        $obj->select("academic_level_id",$academic_level_id);
                        $obj->select("gender_enum",$gender_enum);
                        $obj->select("training_period_enum",$training_period_enum);

                        if($obj->load())
                        {
                                if($create_obj_if_not_found) $obj->activate();
                                return $obj;
                        }
                        elseif($create_obj_if_not_found)
                        {
                                $obj->set("academic_level_id",$academic_level_id);
                                $obj->set("gender_enum",$gender_enum);
                                $obj->set("training_period_enum",$training_period_enum);
                                

                                $obj->insertNew();
                                if(!$obj->id) return null; // means beforeInsert rejected insert operation
                                $obj->is_new = true;
                                return $obj;
                        }
                        else return null;
                }


                public function resetNames($lang="ar", $which="all", $commit=true)
                {
                        if(($which=="all") or ($which=="ar"))
                        {
                                $this->set("application_model_name_ar", $this->decode("academic_level_id")."-".$this->decode("gender_enum")."-".$this->decode("training_period_enum"));
                        }

                        if(($which=="all") or ($which=="en"))
                        {
                                $this->set("application_model_name_en", $this->decode("academic_level_id")."-".$this->decode("gender_enum")."-".$this->decode("training_period_enum"));                        
                        }

                        if($commit) $this->commit();

                        return ["", "تم تصفير مسمى الخطة بنجاح"];
                
                }

                public function beforeMaj($id, $fields_updated)
                {  
                        if($fields_updated["academic_level_id"] or $fields_updated["gender_enum"] or $fields_updated["training_period_enum"])
                        {
                                if(!$fields_updated["application_model_name_ar"] or (!$this->getVal("application_model_name_ar")) or ($this->getVal("application_model_name_ar")=="--"))
                                {
                                        $this->resetNames("ar", "ar", false);                  
                                }

                                if(!$fields_updated["application_model_name_en"] or (!$this->getVal("application_model_name_en")) or ($this->getVal("application_model_name_en")=="--"))
                                {
                                        $this->resetNames("en", "en", false);
                                }
                        }
                        

                    
                        return true;
                }


                protected function attributeCanBeEditedBy($attribute, $user, $desc)
                {
                        if(($attribute=="academic_level_id") or ($attribute=="gender_enum") or ($attribute=="training_period_enum"))
                        {
                                $applicationPlanListCount = $this->getRelation("applicationPlanList")->count();
                                if($applicationPlanListCount>0) return [false, 'applicationPlanList is not empty'];
                        }
                        
                        // return type is : array($can, $reason)
                        return [true, ''];
                }


                public function genereApplicationModelBranchList($lang="ar")
                {

                        global $MODE_SQL_PROCESS_LOURD, $nb_queries_executed;
                        $old_nb_queries_executed = $nb_queries_executed;
                        $old_MODE_SQL_PROCESS_LOURD = $MODE_SQL_PROCESS_LOURD;
                        $MODE_SQL_PROCESS_LOURD = true;

                        $err_arr = [];
                        $inf_arr = [];
                        $war_arr = [];
                        $tech_arr = [];
                        $nb_updated = 0;
                        $nb_inserted = 0;

                        $academic_level_id = $this->getVal("academic_level_id");
                        $gender_enum = $this->getVal("gender_enum");

                        
                        
                        $trainingPeriodArr = [$this->getVal("training_period_enum")];
                        // $trainingPeriodArrCount = count($trainingPeriodArr);
                        foreach($trainingPeriodArr as $training_period_enum)
                        {
                                $progOffList = AcademicProgramOffering::loadListeForModel($academic_level_id, $gender_enum);
                                $inf_arr[] = $this->tm("nb of Academic Program Offering")." : ".count($progOffList);
                                foreach($progOffList as $progOffItem)
                                {
                                        $seats_capacity = $this->getVal("seats_capacity_$training_period_enum");
                                        // $appModel = ApplicationModel::loadByMainIndex($academic_level_id, $gender_enum, $training_period_enum);

                                        if($progOffItem)
                                        {
                                                $seats_capacity = 0;
                                                $appModelBr = ApplicationModelBranch::loadByMainIndex($progOffItem->id, $this->id, $seats_capacity, $create_obj_if_not_found=true);

                                                if($appModelBr->is_new)
                                                {
                                                        $nb_inserted++; 
                                                        $inf_arr[] = $appModelBr->tm("created branch")." : ".$appModelBr->getDisplay($lang);
                                                }
                                                else
                                                {
                                                        $nb_updated++;
                                                        // $inf_arr[] = $appModelBr->tm("updated branch")." : ".$appModelBr->getDisplay($lang);  
                                                }

                                                $appModelBr->genereName($lang="ar");
                                        }
                                        /*else 
                                        {
                                                $academic_level_lbl = $this->decode("academic_level_id");
                                                $gender_lbl = $this->decode("gender_enum");
                                
                                                $training_period_title = self::name_of_training_period_enum($training_period_enum, $lang);
                                                $war_arr[] = "$training_period_title : ".$this->tr("has no application model for this academic level and gender"). " $academic_level_lbl / $gender_lbl";
                                        }*/
                                }
                                
                        }

                        // $inf_arr[] = "يوجد $trainingPeriodArrCount من الفترات التدريبية";
                        $inf_arr[] = "تم انشاء $nb_inserted من الفروع";
                        $inf_arr[] = "$nb_updated من الفروع موجودة سابقا";

                        $MODE_SQL_PROCESS_LOURD = $old_MODE_SQL_PROCESS_LOURD;
                        $nb_queries_executed = $old_nb_queries_executed;
                
                        return AfwFormatHelper::pbm_result($err_arr,$inf_arr,$war_arr,"<br>\n",$tech_arr);
                        
                        
                }


                protected function getPublicMethods()
                {
                
                        $pbms = array();
                        
                        

                        $color = "gray";
                        $title_ar = "تصفير مسمى النموذج"; 
                        $methodName = "resetNames";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("application_model_name_ar"));
                        
                        $color = "green";
                        $title_ar = "انشاء جميع الفروع الممكنة"; 
                        $methodName = "genereApplicationModelBranchList";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("applicationModelBranchList"));
                        
                        
                        
                        return $pbms;
                }

                public function shouldBeCalculatedField($attribute){
                        if($attribute=="level_degree_mfk") return true;
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

                // application_model 
   public function getScenarioItemId($currstep)
   {
      if ($currstep == 1) return 425;
      if ($currstep == 2) return 426;
      if ($currstep == 3) return 427;
      if ($currstep == 4) return 434;
      if ($currstep == 5) return 435;

      return 0;
   }


        }
?>