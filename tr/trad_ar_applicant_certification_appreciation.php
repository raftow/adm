<?php

class ApplicantCertificationAppreciationArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_certification_appreciation"]["applicantcertificationappreciation.single"] = "خبرة";
		$trad["applicant_certification_appreciation"]["applicantcertificationappreciation.new"] = "جديد(ة)";
		$trad["applicant_certification_appreciation"]["applicant_certification_appreciation"] = "شهادات الشكر و التقدير";
		$trad["applicant_certification_appreciation"]["name_ar"] = "مسمى  بالعربية";
		$trad["applicant_certification_appreciation"]["name_en"] = "مسمى  بالانجليزية";
		$trad["applicant_certification_appreciation"]["desc_ar"] = "وصف  بالعربية";
		$trad["applicant_certification_appreciation"]["desc_en"] = "وصف  بالانجليزية";
		$trad["applicant_certification_appreciation"]["applicant_id"] = "المتقدم";
		$trad["applicant_certification_appreciation"]["certification_issuer"] = "مصدر الشهادة";
		$trad["applicant_certification_appreciation"]["certification_level_id"] = "مستوى الشهادة";
		$trad["applicant_certification_appreciation"]["certification_name"] = "الشهادة";
		$trad["applicant_certification_appreciation"]["certification_date"] = "تاريخ الشهادة";
		$trad["applicant_certification_appreciation"]["certification_file_id"] = "الملف المرفق";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantCertificationAppreciationEnTranslator();
		return new ApplicantCertificationAppreciation();
	}
}