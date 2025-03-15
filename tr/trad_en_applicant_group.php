<?php

class ApplicantGroupEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_group"]["applicantgroup.single"] = "Applicant group";
		$trad["applicant_group"]["applicantgroup.new"] = "new";
		$trad["applicant_group"]["applicant_group"] = "Applicant groups";
		$trad["applicant_group"]["name_ar"] = "Arabic Applicant group name";
		$trad["applicant_group"]["desc_ar"] = "Arabic Applicant group description";
		$trad["applicant_group"]["name_en"] = "English Applicant group name";
		$trad["applicant_group"]["desc_en"] = "English Applicant group description";

		$trad["applicant_group"]["step1"] = "General data";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantGroupArTranslator();
		return new ApplicantGroup();
	}
}