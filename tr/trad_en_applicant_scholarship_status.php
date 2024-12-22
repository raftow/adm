<?php
class ApplicantScholarshipStatusEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["applicant_scholarship_status"]["applicantscholarshipstatus.single"] = "Applicant scholarship status";
	$trad["applicant_scholarship_status"]["applicantscholarshipstatus.new"] = "new";
	$trad["applicant_scholarship_status"]["applicant_scholarship_status"] = "Applicant scholarship statuss";
	$trad["applicant_scholarship_status"]["scholarship_status_ar"] = "scholarship status - arabic";
	$trad["applicant_scholarship_status"]["scholarship_status_en"] = "scholarship status - english";
        return $trad;
        }

        public static function getInstance()
	{
		return new ApplicantScholarshipStatus();
	}
}
