<?php
class AcademicPeriodArTranslator{

    public static function initData()
    {
        $trad = [];
	$trad["academic_period"]["step1"] = "التعريف";

	$trad["academic_period"]["academicperiod.single"] = "فترة تقديم";
	$trad["academic_period"]["academicperiod.new"] = "جديد ة";
	$trad["academic_period"]["academic_period"] = "فترات تقديم";
	$trad["academic_period"]["academic_term_id"] = "الفصل الدراسي";
	$trad["academic_period"]["period_type"] = "نوع الفترة";
	$trad["academic_period"]["application_period_name_ar"] = "اسم الفترة - عربي";
	$trad["academic_period"]["application_period_name_en"] = "اسم الفترة - انجليزي";
	$trad["academic_period"]["application_start_date"] = "تاريخ فتح التقديم";
	$trad["academic_period"]["application_start_time"] = "وقت فتح التقديم";
	$trad["academic_period"]["application_end_date"] = "تاريخ غلق التقديم";
	$trad["academic_period"]["application_end_time"] = "وقت غلق التقديم";
	$trad["academic_period"]["hijri_application_start_date"] = "تاريخ فتح التقديم - هجري";
	$trad["academic_period"]["hijri_application_end_date"] = "تاريخ غلق التقديم - هجري";
	$trad["academic_period"]["last_date_upload_doc"] = "آخر موعد لرفع الوثائق";
	$trad["academic_period"]["last_date_appfee"] = "آخر موعد لدفع رسوم التقديم";
	$trad["academic_period"]["last_date_tuitfee"] = "آخر موعد لدفع الرسوم الدراسية والإدارية";
	$trad["academic_period"]["hijri_last_date_upload_doc"] = "آخر موعد لرفع الوثائق - هجري";
	$trad["academic_period"]["hijri_last_date_appfee"] = "آخر موعد لدفع رسوم التقديم - هجري";
	$trad["academic_period"]["hijri_last_date_tuitfee"] = "آخر موعد لدفع الرسوم الدراسية والإدارية - هجري";
	$trad["applicant_account"]["academic_period_id"] = "فترة التقديم";

        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new AcademicPeriodEnTranslator();
		return new AcademicPeriod();
	}
}
