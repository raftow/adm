<?php

class ApplicationExceptionArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["application_exception"]["applicationexception.single"] = "استثناء تقديم";
		$trad["application_exception"]["applicationexception.new"] = "جديد(ة)";
		$trad["application_exception"]["application_exception"] = "استثناءات التقديم";
		$trad["application_exception"]["name_ar"] = "مسمى  بالعربية";
		$trad["application_exception"]["name_en"] = "مسمى  بالانجليزية";
		$trad["application_exception"]["desc_ar"] = "وصف  بالعربية";
		$trad["application_exception"]["desc_en"] = "وصف  بالانجليزية";
		$trad["application_exception"]["applicant_id"] = "المتقدم";
		$trad["application_exception"]["application_plan_id"] = "خطة التقديم";
		$trad["application_exception"]["application_simulation_id"] = "نوع التقديم";
		$trad["application_exception"]["expiry_date"] = "تاريخ نهاية الاستثناء";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicationExceptionEnTranslator();
		return new ApplicationException();
	}
}