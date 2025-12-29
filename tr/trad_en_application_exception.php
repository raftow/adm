<?php

class ApplicationExceptionEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["application_exception"]["applicationexception.single"] = "Application Exception";
		$trad["application_exception"]["applicationexception.new"] = "new";
		$trad["application_exception"]["application_exception"] = "Application Exception";
		$trad["application_exception"]["name_ar"] = "Arabic Application exception name";
		$trad["application_exception"]["name_en"] = "English Application exception name";
		$trad["application_exception"]["desc_ar"] = "Arabic Application exception description";
		$trad["application_exception"]["desc_en"] = "English Application exception description";
		$trad["application_exception"]["applicant_id"] = "Applicant";
		$trad["application_exception"]["application_plan_id"] = "Application plan";
		$trad["application_exception"]["application_simulation_id"] = "Application simulation";
		$trad["application_exception"]["expiry_date"] = "date";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicationExceptionArTranslator();
		return new ApplicationException();
	}
}