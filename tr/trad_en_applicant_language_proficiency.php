<?php

class ApplicantLanguageProficiencyEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_language_proficiency"]["applicantlanguageproficiency.single"] = "language proficiency";
		$trad["applicant_language_proficiency"]["applicantlanguageproficiency.new"] = "new";
		$trad["applicant_language_proficiency"]["applicant_language_proficiency"] = "language proficiency";
		$trad["applicant_language_proficiency"]["name_ar"] = "Arabic Applicant language proficiency name";
		$trad["applicant_language_proficiency"]["name_en"] = "English Applicant language proficiency name";
		$trad["applicant_language_proficiency"]["desc_ar"] = "Arabic Applicant language proficiency description";
		$trad["applicant_language_proficiency"]["desc_en"] = "English Applicant language proficiency description";
		$trad["applicant_language_proficiency"]["applicant_id"] = "Applicant";
		$trad["applicant_language_proficiency"]["language"] = "Language";
		$trad["applicant_language_proficiency"]["proficiency_level_id"] = "Proficiency level";
		$trad["applicant_language_proficiency"]["certification_ind"] = "Test score";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantLanguageProficiencyArTranslator();
		return new ApplicantLanguageProficiency();
	}
}