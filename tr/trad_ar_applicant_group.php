<?php

class ApplicantGroupArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_group"]["applicantgroup.single"] = "مجموعة متقدمين";
		$trad["applicant_group"]["applicantgroup.new"] = "جديد(ة)";
		$trad["applicant_group"]["applicant_group"] = "مجموعات المتقدمين";
		$trad["applicant_group"]["name_ar"] = "مسمى  بالعربية";
		$trad["applicant_group"]["desc_ar"] = "وصف  بالعربية";
		$trad["applicant_group"]["name_en"] = "مسمى  بالانجليزية";
		$trad["applicant_group"]["desc_en"] = "وصف  بالانجليزية";

		$trad["applicant_group"]["step1"] = "البيانات العامة";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantGroupEnTranslator();
		return new ApplicantGroup();
	}
}