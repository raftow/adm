<?php
class ApplicantScholarshipStatusArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["applicant_scholarship_status"]["applicantscholarshipstatus.single"] = "حالة منحة متقدم";
	$trad["applicant_scholarship_status"]["applicantscholarshipstatus.new"] = "جديد ة";
	$trad["applicant_scholarship_status"]["applicant_scholarship_status"] = "حالات منح المتقدمين";
	$trad["applicant_scholarship_status"]["scholarship_status_ar"] = "حالة المنحة - عربي";
	$trad["applicant_scholarship_status"]["scholarship_status_en"] = "حالة المنحة - انجليزي";
        return $trad;
        }

        public static function getInstance()
	{
		return new ApplicantScholarshipStatus();
	}
}

