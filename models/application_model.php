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

                public function createDefaultSteps($lang="ar")
                {
                        $profileScreen = ScreenModel::loadByMainIndex("profile");
                        if(!$profileScreen) return ["no profile screen", ""];
                        $profileStepObj = ApplicationStep::loadByMainIndex($this->id, 0, "Y", $profileScreen, true);
                        $info = "profile step";
                        $info .= $profileStepObj->is_new ? " has been created" : " has been updated";
                        return ["", $info];
                }

                public function beforeMaj($id, $fields_updated)
                {  
                        if($fields_updated["academic_level_id"] or $fields_updated["gender_enum"] or $fields_updated["training_period_enum"])
                        {
                                global $lang;

                                if(!$fields_updated["application_model_name_ar"] or (!$this->getVal("application_model_name_ar")) or ($this->getVal("application_model_name_ar")=="--"))
                                {
                                        $this->resetNames("ar", "ar", false);                  
                                }

                                if(!$fields_updated["application_model_name_en"] or (!$this->getVal("application_model_name_en")) or ($this->getVal("application_model_name_en")=="--"))
                                {
                                        $this->resetNames("en", "en", false);
                                }

                                $this->createDefaultSteps($lang);
                        }

                        $this->createDefaultSteps($lang);

                    
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

                public function findScreenForField($application_field_id)
                {
                        $applicationStepList = $this->get("applicationStepList");   
                        foreach($applicationStepList as $applicationStepItem)
                        {
                                $screen_model_id = $applicationStepItem->getVal("screen_model_id");  
                                $step_num        = $applicationStepItem->getVal("step_num");  
                                $general         = $applicationStepItem->getVal("general");  
                                $field_exists    = $applicationStepItem->findInMfk("show_field_mfk",$application_field_id); 
                                if($field_exists)
                                {
                                        return [$screen_model_id, $step_num, $general];
                                }
                        }

                        return [0,-1,'W'];
                }

                public function genereApplicationModelConditionList($lang="ar")
                {
                        $err_arr = [];
                        $inf_arr = [];
                        $war_arr = [];
                        $tech_arr = [];
                        $nb_updated = 0;
                        $nb_inserted = 0;

                        $aconditionOriginList = $this->get("aconditionOriginList");
                        foreach($aconditionOriginList as $aconditionOriginItem)
                        {
                                $aconditionList = $aconditionOriginItem->get("allAconditionList");  
                                foreach($aconditionList as $aconditionItem)
                                {
                                        $general = $aconditionItem->getVal("general");
                                        $acondition_origin_id = $aconditionItem->getVal("acondition_origin_id");
                                        $amcObj = ApplicationModelCondition::loadByMainIndex($this->id, $aconditionItem->id, $acondition_origin_id, $general, true);
                                        if($amcObj->is_new) $nb_inserted++;
                                        else $nb_updated++;

                                        $aconditionFieldList = $aconditionItem->getAllFields();
                                        // the condition should be executed in the max step num
                                        // when all fields have been recolted
                                        // but min step of exec of step should be 1
                                        $step_num_max = 1;
                                        foreach($aconditionFieldList as $aconditionFieldItem)
                                        {
                                                $application_field_id = $aconditionFieldItem["id"];
                                                $amfObj = ApplicationModelField::loadByMainIndex($this->id, $application_field_id, $aconditionItem->id, true);
                                                if($amfObj->is_new) $nb_inserted++;
                                                else $nb_updated++;
                                                list($screen_model_id, $step_num, $general) = $this->findScreenForField($application_field_id);                                                
                                                $amfObj->set("screen_model_id",$screen_model_id);
                                                $amfObj->set("step_num",$step_num);
                                                $amfObj->commit();
                                                if($step_num_max < $step_num) $step_num_max = $step_num;
                                        }

                                        $amcObj->set("step_num",$step_num_max);
                                        $amcObj->commit();
                                }
                        }

                        $inf_arr[] = "تم اضافة $nb_inserted ما بين شرط وحقل";
                        $inf_arr[] = "تم تحديث $nb_updated ما بين شرط وحقل";

                        return AfwFormatHelper::pbm_result($err_arr,$inf_arr,$war_arr,"<br>\n",$tech_arr);
                        
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
                        
                        $color = "orange";
                        $title_ar = "تحديث الشروط"; 
                        $methodName = "genereApplicationModelConditionList";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("applicationModelConditionList"));
                        
                        
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
                                $title = "إضافة ميزة جديدة";
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

                        if($mode=="mode_applicationStepList")
                        {
                                $objAS = new ApplicationStep();
                                $objAS->select("application_model_id", $my_id);
                                $nextStep = AfwSqlHelper::aggregFunction($objAS, "max(step_num)")+1;
                                unset($link);
                                $link = array();
                                $title = "إضافة خطوة تقديم جديدة";
                                $title_detailed = $title ."لـ : ". $displ;
                                $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=ApplicationStep&currmod=adm&sel_application_model_id=$my_id&sel_step_num=$nextStep";
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
                        if($currstep == 1) return 425;
                        if($currstep == 2) return 426;
                        if($currstep == 3) return 427;
                        if($currstep == 4) return 434;
                        if($currstep == 5) return 435;
                        if($currstep == 6) return 491;
                        if($currstep == 7) return 497;

                        return 0;
                }


        }
?>