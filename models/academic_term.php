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
                $objTerm->where("academic_level_mfk like '%,$academic_level_id,%' and '$dateApplyGreg' application_start_date and application_end_date");
                if($objTerm->load()) return $objTerm;
                else return null;
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
}
