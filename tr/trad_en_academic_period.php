<?php
class AcademicPeriodEnTranslator{

    public static function initData()
    {
        $trad = [];
	$trad["academic_period"]["step1"] = "Definition";

	$trad["academic_period"]["academicperiod.single"] = "Academic period";
	$trad["academic_period"]["academicperiod.new"] = "new";
	$trad["academic_period"]["academic_period"] = "Academic periods";
	$trad["academic_period"]["academic_term_id"] = "academic term";
	$trad["academic_period"]["period_type"] = "period type";
	$trad["academic_period"]["application_period_name_ar"] = "period name - arabic";
	$trad["academic_period"]["application_period_name_en"] = "period name - english";
	$trad["academic_period"]["application_start_date"] = "Application opening date";
	$trad["academic_period"]["application_start_time"] = "Application opening time";
	$trad["academic_period"]["application_end_date"] = "Application closing date";
	$trad["academic_period"]["application_end_time"] = "Application closing time";
	$trad["academic_period"]["hijri_application_start_date"] = "Application opening date - hijri";
	$trad["academic_period"]["hijri_application_end_date"] = "Application closing date - hijri";
	$trad["academic_period"]["last_date_upload_doc"] = "Last date for submitting documents";
	$trad["academic_period"]["last_date_appfee"] = "Last date for paying application fees";
	$trad["academic_period"]["last_date_tuitfee"] = "Last date for paying tuition and administrative fees";
	$trad["academic_period"]["hijri_last_date_upload_doc"] = "Last date for submitting documents - hijri";
	$trad["academic_period"]["hijri_last_date_appfee"] = "Last date for paying application fees - hijri";
	$trad["academic_period"]["hijri_last_date_tuitfee"] = "Last date for paying tuition and administrative fees - hijri";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new AcademicPeriodArTranslator();
		return new AcademicPeriod();
	}
}