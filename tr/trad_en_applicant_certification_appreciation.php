<?php

class ApplicantCertificationAppreciationEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_certification_appreciation"]["applicantcertificationappreciation.single"] = "Certification of appreciation";
		$trad["applicant_certification_appreciation"]["applicantcertificationappreciation.new"] = "new";
		$trad["applicant_certification_appreciation"]["applicant_certification_appreciation"] = "مهنية";
		$trad["applicant_certification_appreciation"]["name_ar"] = "Arabic Applicant certification appreciation name";
		$trad["applicant_certification_appreciation"]["name_en"] = "English Applicant certification appreciation name";
		$trad["applicant_certification_appreciation"]["desc_ar"] = "Arabic Applicant certification appreciation description";
		$trad["applicant_certification_appreciation"]["desc_en"] = "English Applicant certification appreciation description";
		$trad["applicant_certification_appreciation"]["applicant_id"] = "Applicant";
		$trad["applicant_certification_appreciation"]["certification_issuer"] = "Issuer";
		$trad["applicant_certification_appreciation"]["certification_level_id"] = "Certification levels";
		$trad["applicant_certification_appreciation"]["certification_name"] = "Certification name";
		$trad["applicant_certification_appreciation"]["certification_date"] = "Certification date";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantCertificationAppreciationArTranslator();
		return new ApplicantCertificationAppreciation();
	}
}