<?php

class ApplicantLanguageProficiencyArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_language_proficiency"]["applicantlanguageproficiency.single"] = "لغة متقدم";
		$trad["applicant_language_proficiency"]["applicantlanguageproficiency.new"] = "جديد(ة)";
		$trad["applicant_language_proficiency"]["applicant_language_proficiency"] = "اللغات";
		$trad["applicant_language_proficiency"]["name_ar"] = "مسمى  بالعربية";
		$trad["applicant_language_proficiency"]["name_en"] = "مسمى  بالانجليزية";
		$trad["applicant_language_proficiency"]["desc_ar"] = "وصف  بالعربية";
		$trad["applicant_language_proficiency"]["desc_en"] = "وصف  بالانجليزية";
		$trad["applicant_language_proficiency"]["applicant_id"] = "المتقدم";
		$trad["applicant_language_proficiency"]["language_id"] = "اللغة";
		$trad["applicant_language_proficiency"]["proficiency_level_id"] = "مستوى اللغة";
		$trad["applicant_language_proficiency"]["certification_ind"] = "هل لديك شهادة";
		$trad["applicant_language_proficiency"]["certification_file_id"] = "الشهادة";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantLanguageProficiencyEnTranslator();
		return new ApplicantLanguageProficiency();
	}
}