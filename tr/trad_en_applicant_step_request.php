<?php

class ApplicantStepRequestEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_step_request"]["applicantsteprequest.single"] = "step move request";
		$trad["applicant_step_request"]["applicantsteprequest.new"] = "new";
		$trad["applicant_step_request"]["applicant_step_request"] = "step move requests";
		$trad["applicant_step_request"]["name_ar"] = "Arabic Applicant step request name";
		$trad["applicant_step_request"]["desc_ar"] = "Arabic Applicant step request description";
		$trad["applicant_step_request"]["name_en"] = "English Applicant step request name";
		$trad["applicant_step_request"]["desc_en"] = "English Applicant step request description";
		$trad["applicant_step_request"]["applicant_id"] = "Applicant";
		$trad["applicant_step_request"]["application_plan_id"] = "Application plan";
		$trad["applicant_step_request"]["application_model_id"] = "Application model";
		$trad["applicant_step_request"]["step_num"] = "step number";
		$trad["applicant_step_request"]["status_date"] = "Status date";
		$trad["applicant_step_request"]["api_endpoint_id"] = "Api endpoint";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantStepRequestArTranslator();
		return new ApplicantStepRequest();
	}
}