<?php
class ApplicantApiRequestEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["applicant_api_request"]["applicantapirequest.single"] = "Applicant api request";
	$trad["applicant_api_request"]["applicantapirequest.new"] = "new";
	$trad["applicant_api_request"]["applicant_api_request"] = "Applicant api requests";
	$trad["applicant_api_request"]["applicant_id"] = "The applicant";
	$trad["applicant_api_request"]["api_endpoint_id"] = "Api";
	$trad["applicant_api_request"]["run_date"] = "Run Date";
	$trad["applicant_api_request"]["need_refresh"] = "need refresh";
        return $trad;
        }

        public static function getInstance()
	{
		return new ApplicantApiRequest();
	}
}