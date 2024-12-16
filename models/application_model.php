<?php
        class ApplicationModel extends AdmObject{


                private $applicationStepList = null;

                public static $DATABASE		= ""; 
                public static $MODULE		    = "adm"; 
                public static $TABLE			= "application_model"; 
                public static $DB_STRUCTURE = null;
                // public static $copypast = true;

                public function __construct(){
                        parent::__construct("application_model","id","adm");
                        AdmApplicationModelAfwStructure::initInstance($this);
                        
                }

                /**
                 * @param integer $id (id of application model)
                 */

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

                /**
                 * 
                 * @return ApplicationStep
                 */

                public function convertStepNumToObject($step_num)
                {
                        return ApplicationStep::loadByMainIndex($this->id, $step_num);
                }

                public function getBrothers()
                {
                        $this_id = $this->id;
                        $academic_level_id = $this->getVal("academic_level_id");
                        $obj = new ApplicationModel();
                        $obj->select("academic_level_id",$academic_level_id);
                        $obj->where("id != '$this_id'");
                        $obj->get_visibilite_horizontale();
                        return $obj->loadMany();
                        
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
                        if($this->id)
                        {
                                $defaultScreensArr = ["profile","desire","sorting","final"];
                                $info = "default steps : <br>\n";
                                foreach($defaultScreensArr as $i => $defaultScreen)
                                {
                                        $objScreen = ScreenModel::loadByMainIndex($defaultScreen, true);
                                        if(!$objScreen) return ["no `$defaultScreen` screen found", ""];
                                        $stepObj = ApplicationStep::loadByMainIndex($this->id, $i*10, "Y", $objScreen, true);
                                        $info .= "`$defaultScreen` step";
                                        $info .= $stepObj->is_new ? " has been created" : " has been updated";
                                        $info .= "<br>\n";
                                }
                                
                                return ["", $info];
                        }
                        
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

                        //$this->createDefaultSteps($lang);

                    
                        return true;
                }


                public function getAppModelApiOfStep($toStepNum)
                {
                        if(!$toStepNum) $toStepNum = 0;
                        $stepAppModelApiList = $this->getRelation("appModelApiList")->resetWhere("active='Y' and step_num=$toStepNum")->getList();
                        return $stepAppModelApiList;
                }

                public function getAppModelFieldsOfStep($stepNum, $splitByTable=false, $onlyTitles=false, $lang="ar")
                {
                        if(!$stepNum) $stepNum = 0;
                        $applicationModelFieldList = $this->getRelation("applicationModelFieldList")->resetWhere("active='Y' and step_num<=$stepNum")->getList();
                        if(!$splitByTable) return $applicationModelFieldList;
                        else
                        {
                                $applicantFieldsArr = [];
                                $applicationFieldsArr = [];
                                $applicationDesireFieldsArr = [];
                                foreach($applicationModelFieldList as $applicationModelFieldItem)
                                {
                                        $applicationFieldObj = $applicationModelFieldItem->het("application_field_id");
                                        if($applicationFieldObj)
                                        {
                                                $field_name = $applicationFieldObj->getVal("field_name");
                                                $field_title = $applicationFieldObj->getDisplay($lang);
                                                // $field_reel = $applicationFieldObj->_isReel();
                                                $application_table_id = $applicationFieldObj->getVal("application_table_id");
                                                if($application_table_id==1)
                                                {
                                                        if($onlyTitles) $applicantFieldsArr[$field_name] = $field_title;
                                                        else $applicantFieldsArr[$field_name] = $applicationFieldObj;
                                                }
                                                elseif($application_table_id==3)
                                                {
                                                        if($onlyTitles) $applicationFieldsArr[$field_name] = $field_title;
                                                        else $applicationFieldsArr[$field_name] = $applicationFieldObj;
                                                }    
                                                elseif($application_table_id==2)
                                                {
                                                        if($onlyTitles) $applicationDesireFieldsArr[$field_name] = $field_title;
                                                        else $applicationDesireFieldsArr[$field_name] = $applicationFieldObj;
                                                }
                                                else
                                                {
                                                        throw new AfwRuntimeException("unknown application_table_id=$application_table_id");
                                                }
                                                        
                                                        
                                        }
                                }

                                return [$applicantFieldsArr, $applicationFieldsArr, $applicationDesireFieldsArr];
                        }
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

                public function hideAllApplicationModelConditionList()
                {
                        $amcObj = new ApplicationModelCondition(); 
                        $amcObj->select("application_model_id", $this->id);
                        $amcObj->logicDelete(true,false);

                        $amfObj = new ApplicationModelField();
                        $amfObj->select("application_model_id", $this->id);
                        $amfObj->logicDelete(true,false);

                        $amaObj = new AppModelApi();
                        $amaObj->select("application_model_id", $this->id);
                        $amaObj->logicDelete(true,false);

                        

                }

                public function getFieldApiEndpoint($field_name, $application_table_id)
                {
                        $application_fieldObj = ApplicationField::loadByMainIndex($field_name, $application_table_id);
                        if(!$application_fieldObj) return null;
                        // $appModelApiList = $this->objApplicationModel->getAppModelApiOfStep($nextStepNum);
                        $amfObj = ApplicationModelField::loadByMainIndex($this->id, $application_fieldObj->id);
                        if($amfObj) return $amfObj->het("api_endpoint_id");
                        else return null;
                }

                public function getFieldExpiryDuration($field_name, $application_table_id)
                {
                        $application_fieldObj = ApplicationField::loadByMainIndex($field_name, $application_table_id);
                        if(!$application_fieldObj) return null;
                        // $appModelApiList = $this->objApplicationModel->getAppModelApiOfStep($nextStepNum);
                        $amfObj = ApplicationModelField::loadByMainIndex($this->id, $application_fieldObj->id);
                        if($amfObj) return $amfObj->getVal("duration_expiry");
                        else return 0;
                }

                public function genereScreensAndModels($lang="ar")
                {
                        return $this->genereApplicationModelConditionList($lang, $addNewConditions=false);
                }

                public function genereApplicationModelConditionList($lang="ar", $addNewConditions=true)
                {
                        $err_arr = [];
                        $inf_arr = [];
                        $war_arr = [];
                        $tech_arr = [];
                        
                        $cond_nb_updated = 0;
                        $cond_nb_inserted = 0;

                        $fld_nb_updated = 0;
                        $fld_nb_inserted = 0;

                        // $api_nb_updated = 0;
                        $api_nb_inserted = 0;

                        $this_disp = $this->getDisplay($lang);

                        if($addNewConditions) $this->hideAllApplicationModelConditionList();

                        $aconditionOriginList = $this->get("aconditionOriginList");
                        foreach($aconditionOriginList as $aconditionOriginItem)
                        {
                                $aconditionList = $aconditionOriginItem->get("allAconditionList");  
                                foreach($aconditionList as $aconditionItem)
                                {
                                        $general = $aconditionItem->getVal("general");
                                        $acondition_origin_id = $aconditionItem->getVal("acondition_origin_id");
                                        $amcObj = ApplicationModelCondition::loadByMainIndex($this->id, $aconditionItem->id, $acondition_origin_id, $general, $addNewConditions);
                                        if($amcObj->is_new) $cond_nb_inserted++;
                                        else $cond_nb_updated++;

                                        /**
                                         * @var ACondition $aconditionItem
                                         */

                                        $aconditionFieldList = $aconditionItem->getAllFields($this);
                                        // the condition should be executed in the max step num
                                        // when all fields have been recolted
                                        // but min step of exec of step should be 1
                                        $step_num_max = 1;
                                        foreach($aconditionFieldList as $aconditionFieldItem)
                                        {
                                                $application_field_id = $aconditionFieldItem["id"];
                                                $application_field_name = $aconditionFieldItem["name"];
                                                $amfObj = ApplicationModelField::loadByMainIndex($this->id, $application_field_id, $aconditionItem->id, 0, true);
                                                if($amfObj->is_new) $fld_nb_inserted++;
                                                else $fld_nb_updated++;
                                                list($screen_model_id, $step_num, $generalScreen) = $this->findScreenForField($application_field_id);                                                
                                                $arr_api = ApiEndpoint::findAllApiEndpointForField($application_field_id);                                                
                                                $count_api = count($arr_api);
                                                if($count_api==0)
                                                {
                                                        $amfObj->set("api_endpoint_id",0);                                                        
                                                        $err_arr[] = "no api return the field $application_field_name/$application_field_id";
                                                }
                                                elseif($count_api==1)
                                                {
                                                        /**
                                                         * @var ApiEndpoint $apiEndpoint
                                                         */
                                                        $apiEndpoint = $arr_api[0];
                                                        $amfObj->set("api_endpoint_id",$apiEndpoint->id);                                                        
                                                }
                                                elseif(!$amfObj->getVal("api_endpoint_id"))
                                                {
                                                        $war_arr[] = "field $application_field_name/$application_field_id returned by $count_api api(s) please resolve this manually";
                                                }
                                                else
                                                {
                                                        $api_found = false;
                                                        foreach($arr_api as $apiEndpointObj)
                                                        {
                                                                if($apiEndpointObj->id == $amfObj->getVal("api_endpoint_id"))
                                                                {
                                                                        $api_found = true;
                                                                        $apiEndpoint = $apiEndpointObj;
                                                                }
                                                        }

                                                        if(!$api_found)
                                                        {
                                                                $amfObj->set("api_endpoint_id",0); 
                                                                $apiEndpointObjDisplay = $amfObj->showAttribute("api_endpoint_id");                                                                
                                                                $war_arr[] = "The api $apiEndpointObjDisplay can not manage the field $application_field_name/$application_field_id and will be removed";
                                                                $war_arr[] = "field $application_field_name/$application_field_id returned by other $count_api api(s) please resolve this manually";
                                                                $amfObj->set("api_endpoint_id",0);
                                                        }
                                                }
                                                if(!$amfObj->getVal("duration_expiry") and $apiEndpoint) $amfObj->set("duration_expiry",$apiEndpoint->getVal("duration_expiry"));
                                                $amfObj->set("screen_model_id",$screen_model_id);
                                                $amfObj->set("step_num",$step_num);
                                                $amfObj->commit();
                                                if($step_num_max < $step_num) $step_num_max = $step_num;
                                        }

                                        $amcObj->set("step_num",$step_num_max);
                                        $amcObj->commit();
                                }
                        }

                        $applicationModelFieldList = $this->get("applicationModelFieldList");
                        foreach($applicationModelFieldList as $applicationModelFieldItem)
                        {
                                $api_endpoint_id = $applicationModelFieldItem->getVal("api_endpoint_id");
                                if($api_endpoint_id>0)
                                {
                                        if($api_endpoint_id != 13)
                                        {
                                                $application_field_id = $applicationModelFieldItem->getVal("application_field_id");
                                                $new_step_num = $applicationModelFieldItem->getVal("step_num");
                                                if(!$new_step_num) $new_step_num = 1;
                                                $amaObj = AppModelApi::loadByMainIndex($this->id, $api_endpoint_id, true);
                                                if($amaObj->is_new)
                                                {
                                                        $amaObj->set("application_field_mfk", ",$application_field_id,");
                                                        // $amaObj->set("duration_expiry", 15);
                                                        $api_nb_inserted++;
                                                }
                                                else
                                                {
                                                        $amaObj->addRemoveInMfk("application_field_mfk",[$application_field_id],[]);
                                                }
                                                
                                                $amaObj->set("duration_expiry", 15);
                                                $step_num = $amaObj->getVal("step_num");
                                                if((!$step_num) or ($step_num<0) or ($step_num>$new_step_num))
                                                {
                                                        $step_num = $new_step_num;
                                                        $amaObj->set("step_num", $step_num);
                                                }
                
                                                $amaObj->commit();
                                        }
                                        else
                                        {
                                                $inf_arr[] = "for field $application_field_id `manual entry` virtual API(13) has been ignored";
                                        }
                                }
                                else $war_arr[] = "field ".$applicationModelFieldItem->getDisplay("en")." has no api_endpoint defined";
                        }

                        if(!count($aconditionOriginList))
                        {
                                $err_arr[] = "لا يوجد مصادر للشروط لهذا النموذج $this_disp يرجى مراجعة مجال تطبيق اللوائح المعنية";   
                        }

                        if($cond_nb_inserted) $inf_arr[] = "تم اضافة $cond_nb_inserted شرط";
                        elseif($cond_nb_updated) $inf_arr[] = "تم تحديث $cond_nb_updated شرط";
                        else $war_arr[] = "لم يتم تحديث أي شرط";


                        if($fld_nb_inserted) $inf_arr[] = "تم اضافة $fld_nb_inserted حقل";
                        elseif($fld_nb_updated) $inf_arr[] = "تم تحديث $fld_nb_updated حقل";
                        else $war_arr[] = "لم يتم تحديث أي حقل";

                        if($api_nb_inserted) $inf_arr[] = "تم اضافة $api_nb_inserted خدمة";
                        //if($cond_nb_inserted)  $inf_arr[] = "تم تحديث $cond_nb_inserted خدمة";

                        return AfwFormatHelper::pbm_result($err_arr,$inf_arr,$war_arr,"<br>\n",$tech_arr);
                        
                }

                public function hideAllApplicationModelBranchList()
                {
                        $amcObj = new ApplicationModelBranch(); 
                        $amcObj->select("application_model_id", $this->id);
                        $amcObj->logicDelete(true,false);
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

                        $this->hideAllApplicationModelBranchList();
                        
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
                                                $appModelBr->set("gender_enum", $progOffItem->getVal("gender_enum"));
                                                $appModelBr->set("major_id", $progOffItem->getVal("major_id"));
                                                $appModelBr->set("academic_program_id", $progOffItem->getVal("academic_program_id"));  
                                                $appModelBr->commit();
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
                        global $lang;
                
                        $pbms = array();
                        
                        

                        $color = "gray";
                        $title_ar = "تصفير مسمى النموذج"; 
                        $methodName = "resetNames";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "PUBLIC"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("application_model_name_ar"));
                        
                        $color = "green";
                        $title_ar = "تحديث فروع القبول حسب الاعدادات"; 
                        $methodName = "genereApplicationModelBranchList";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "PUBLIC"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("applicationModelBranchList"));
                        

                        $color = "blue";
                        $title_ar = "انشاء جميع الخطوات الافتراضية"; 
                        $methodName = "createDefaultSteps";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "PUBLIC"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("applicationStepList"));
                        
                        

                        $color = "orange";
                        $title_ar = "تحديث الشروط"; 
                        $methodName = "genereApplicationModelConditionList";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "PUBLIC"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("applicationModelConditionList"));
                        
                        

                        $color = "orange";
                        $title_ar = "تحديث الشاشات والخدمات"; 
                        $methodName = "genereScreensAndModels";
                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "PUBLIC"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("applicationModelFieldList"));
                        
                        $amList = $this->getBrothers();
                        /**
                         * @var ApplicationModel $amItem
                         */
                        foreach($amList as $amItem)
                        {
                                $application_field_mfk = $amItem->getVal("application_field_mfk");
                                if(strlen($application_field_mfk)>2)
                                {
                                        $color = "yellow";
                                        $title_ar = "نسخ حقول SIS من ".$amItem->getDisplay("ar"); 
                                        $title_en = "copy SIS fields from ".$amItem->getDisplay("en"); 
                                        $methodName = "copySISFieldsFrom".$amItem->id;
                                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "LABEL_EN"=>$title_en, "PUBLIC"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("application_field_mfk"));
                                }

                                $thisAsCount = $this->getRelation("applicationStepList")->count();
                                $asCount = $amItem->getRelation("applicationStepList")->count();
                                if(($asCount>1) and ($thisAsCount<2 or !$this->isActive()))
                                {
                                        $color = "yellow";
                                        $title_ar = "نسخ الخطوات من ".$amItem->getDisplay("ar"); 
                                        $title_en = "copy steps from ".$amItem->getDisplay("en"); 
                                        $methodName = "copyStepsFrom".$amItem->id;
                                        $pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "LABEL_EN"=>$title_en, "PUBLIC"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("applicationStepList")); 
                                }
                                
                        }
                        
                        
                        
                        
                        return $pbms;
                }


                protected function afwCall($name, $arguments) {
                        if(substr($name, 0, 17)=="copySISFieldsFrom") 
                        {
                            $amId = intval(substr($name, 17));
                            return $this->copySISFieldsFrom($amId, $arguments[0]);
                        }

                        if(substr($name, 0, 13)=="copyStepsFrom") 
                        {
                            $amId = intval(substr($name, 13));
                            return $this->copyStepsFrom($amId, $arguments[0]);
                        }

                        
        
                        return false;
                        // the above return should be keeped if not treated
                }

                public function copyStepsFrom($application_model_id, $lang="ar")
                {
                        if(!$this->id) return ["Application Model destination not found", ""];
                        if(!$application_model_id) return ["Application Model source not found", ""];
                        $amObj = self::loadById($application_model_id);
                        if(!$amObj) return ["Application Model $application_model_id not found", ""];
                        $asList = $amObj->get("applicationStepList");
                        /**
                         * @var ApplicationStep $asItem
                         */
                        $nb = 0;
                        foreach($asList as $asItem)
                        {
                                $stepCopiedObj = $asItem->copyMeInto($this->id);
                                if($stepCopiedObj) $nb += 1;
                        }

                        return ["", "$nb steps copied"];
                }

                public function copySISFieldsFrom($application_model_id, $lang="ar")
                {
                        $server_db_prefix = AfwSession::config("db_prefix", "default_db_");

                        $application_field_mfk = AfwDatabase::db_recup_value("select application_field_mfk from ".$server_db_prefix."adm.application_model where id = $application_model_id");
                        if(strlen($application_field_mfk)>2)
                        {
                                $this->set("application_field_mfk", $application_field_mfk);
                                $this->commit();
                                return ["", "copy of SIS fields done"];
                        }

                        return ["", "", "copy of incomplete SIS fields canceled"];
                        
                }

                public function shouldBeCalculatedField($attribute){
                        if($attribute=="level_degree_mfk") return true;
                        return false;
                }

                public function getStepMax($general=true)
                {
                        if($general) $gen = 'Y';
                        else $gen = 'N';
                        
                        return $this->getRelation("applicationStepList")->resetWhere("active='Y' and general='$gen'")->func("max(step_num)");
                }


                public function getFieldInStep($application_field_id, $step_num)
                {
                       return $this->getRelation("applicationStepList")
                                        ->resetWhere("active='Y' and step_num='$step_num' and show_field_mfk like '%,$application_field_id,%'")                                        
                                        ->func("count(id)");
                }

                public function getNextGeneralStepNumOf($step_num)
                {
                        if(!$this->stepMax) $this->stepMax = $this->getStepMax(true);
                        $return = $step_num + 1;
                        if($return > $this->stepMax) $return = $this->stepMax;
                        return $return;
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
                                $link["PUBLIC"] = true;
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
                                $link["PUBLIC"] = true;
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
                                $link["PUBLIC"] = true;
                                $link["UGROUPS"] = array();
                                $otherLinksArray[] = $link;
                        }
                        if($mode=="mode_financialTransactionList")
                        {
                                unset($link);
                                $link = array();
                                $title = "إضافة بند جديد";
                                $title_detailed = $title ."لـ : ". $displ;
                                $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=ApplicationModelFinancialTransaction&currmod=adm&sel_application_model_id=$my_id";
                                $link["TITLE"] = $title;
                                $link["PUBLIC"] = true;
                                $link["UGROUPS"] = array();
                                $otherLinksArray[] = $link;
                        }

                        /*
                        if($mode=="mode_appModelApiList")
                        {
                                unset($link);
                                $link = array();
                                $title = "إضافة انخراط في خدمة جديدة";
                                $title_detailed = $title ."لـ : ". $displ;
                                $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=AppModelApi&currmod=adm&sel_application_model_id=$my_id";
                                $link["TITLE"] = $title;
                                $link["PUBLIC"] = true;
                                $link["UGROUPS"] = array();
                                $otherLinksArray[] = $link;
                        }*/
                        
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
                        if($currstep == 8) return 499;


                        return 0;
                }


        }
?>