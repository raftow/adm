<?php

class ApplicationEnTranslator{
    public static function initData()
    {
        $trad = [];
		$trad["application"]["application.single"] = "Application";
		$trad["application"]["application.new"] = "new";
		$trad["application"]["application"] = "Applications";

		$trad["application"]["applicant_id"] = "applicant id";
		$trad["application"]["application_plan_id"] = "application plan id";
		$trad["application"]["application_model_id"] = "application_model id";
		$trad["application"]["step_num"] = "step number";
		$trad["application"]["application_step_id"] = "application step id";
		$trad["application"]["application_status_enum"] = "application status";
		$trad["application"]["applicant_qualification_id"] = "applicant qualification id";
		$trad["application"]["qualification_id"] = "qualification id";
		$trad["application"]["major_category_id"] = "major cathegory id";
		$trad["application"]["sis_fields_available"] = "SIS fields available";
		$trad["application"]["tasks"] = "waiting tasks";
		$trad["application"]["satisfaction"] = "Applicants satisfaction percentage";
		return $trad;
    }

    public static function getInstance()
	{
		return new Application();
	}
}		