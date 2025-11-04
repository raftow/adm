<?php
class AcademicTerm extends AdmObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "adm";
        public static $TABLE                        = "academic_term";
        public static $DB_STRUCTURE = null;
        // public static $copypast = true;

        public function __construct()
        {
                parent::__construct("academic_term", "id", "adm");
                AdmAcademicTermAfwStructure::initInstance($this);
        }

        public static function loadById($id)
        {
                $obj = new AcademicTerm();

                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public function getDisplay($lang = 'ar')
        {
                return $this->t("year", $lang) . " " . $this->decode("academic_year_id") . "-" . $this->t("term", $lang) . " " . $this->getVal("term_code");
        }

        public function stepsAreOrdered()
        {
                return true;
        }


        public static function getCurrentTerm($academic_level_id, $dateApplyGreg)
        {                
                $objTerm = new AcademicTerm();
                $objTerm->where("academic_level_mfk like '%,$academic_level_id,%' and (application_start_date is null or '$dateApplyGreg' >= application_start_date) and (application_end_date is null or '$dateApplyGreg' <= application_end_date)");
                if($objTerm->load()) return $objTerm;
                else return null;
        }

        public static function getComingTermsIds($academic_level_id, $nbTerms=99)
        {
                $dateApplyGreg = date("Y-m-d");
                $objTerm = new AcademicTerm();
                $objTerm->where("academic_level_mfk like '%,$academic_level_id,%' and '$dateApplyGreg' < application_start_date");
                return $objTerm->loadListe($nbTerms, "application_start_date asc");
        }


        public function beforeMaj($id, $fields_updated)
        {

                $date_attributes = [];
                $date_attributes[] = "start_date";
                $date_attributes[] = "end_date";
                $date_attributes[] = "application_start_date";
                $date_attributes[] = "application_end_date";
                $date_attributes[] = "admission_start_date";
                $date_attributes[] = "admission_end_date";
                $date_attributes[] = "direct_adm_start_date";
                $date_attributes[] = "direct_adm_end_date";
                $date_attributes[] = "seats_update_start_date";
                $date_attributes[] = "seats_update_end_date";
                $date_attributes[] = "migration_start_date";
                $date_attributes[] = "migration_end_date";
                $date_attributes[] = "Results_Announcement_date";
                $date_attributes[] = "sorting_start_date";
                $date_attributes[] = "sorting_end_date";
                // added by medali
                $date_attributes[] = "last_date_upload_doc";
                $date_attributes[] = "last_date_tuitfee";


                foreach ($date_attributes as $date_attribute) {
                        if ($this->getVal($date_attribute) and $fields_updated[$date_attribute]) {
                                $this->set("hijri_" . $date_attribute, AfwDateHelper::gregToHijri($this->getVal($date_attribute)));
                        }
                }

                return true;
        }


        public function getFinishButtonLabel(
                $lang,
                $nextStep,
                $form_readonly = 'RO'
        ) {
                if ($lang == "ar") return "حفظ وانهاء";
                return AfwWizardHelper::getFinishButtonLabelDefault(
                        $this,
                        $lang,
                        $nextStep,
                        $form_readonly
                );
        }

        // academic_term 
        public function getScenarioItemId($currstep)
        {
                if ($currstep == 1) return 414;
                if ($currstep == 2) return 415;
                if ($currstep == 3) return 416;

                return 0;
        }

        public function getOtherLinksArray($mode,$genereLog=false,$step="all")  
                {
                    $lang = AfwLanguageHelper::getGlobalLanguage();
                        // $objme = AfwSession::getUserConnected();
                        // $me = ($objme) ? $objme->id : 0;

                        $otherLinksArray = $this->getOtherLinksArrayStandard($mode,$genereLog,$step);
                        $my_id = $this->getId();
                        $displ = $this->getDisplay($lang);
                    if($mode=="mode_academicPeriodList")
                        {
                                // added by medali
                                $objPeriod = new AcademicPeriod();
                                $objPeriod->where(" active='Y' and academic_term_id = '$my_id' and application_end_date >= now()");
                                //if no application period exists, create an application  period and validate the start application and end application date ,
                                // and update the academic term otherwise, allow adding a new application period if only the sysdate >=application_period1.(application end date) and update the academic term
                                unset($link);
                                
                                if($objPeriod->count()>0){
                                        $link = array();
                                        $title = "لا يمكن إضافة فترة قبل انتهاء الفترة السابقة";
                                        $title_detailed = $title ."لـ : ". $displ;
                                        $link["URL"] = "#";
                                        $link["TITLE"] = $title;
                                        $link["PUBLIC"] = true;
                                        $link["UGROUPS"] = array();
                                        $otherLinksArray[] = $link;
                                }else{
                                        $link = array();
                                        $title = "إضافة فترة تقديم جديدة";
                                        $title_detailed = $title ."لـ : ". $displ;
                                        $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=AcademicPeriod&currmod=adm&sel_academic_term_id=$my_id";
                                        $link["TITLE"] = $title;
                                        $link["PUBLIC"] = true;
                                        $link["UGROUPS"] = array();
                                        $otherLinksArray[] = $link;
                                }
                               
                        
                                
                        }
                    return $otherLinksArray;

                }

}
