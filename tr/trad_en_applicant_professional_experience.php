<?php

class ApplicantProfessionalExperienceEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_professional_experience"]["applicantprofessionalexperience.single"] = "Professional experiences";
		$trad["applicant_professional_experience"]["applicantprofessionalexperience.new"] = "new";
		$trad["applicant_professional_experience"]["applicant_professional_experience"] = "Professional experience";
		$trad["applicant_professional_experience"]["name_ar"] = "Arabic Applicant professional experience name";
		$trad["applicant_professional_experience"]["name_en"] = "English Applicant professional experience name";
		$trad["applicant_professional_experience"]["desc_ar"] = "Arabic Applicant professional experience description";
		$trad["applicant_professional_experience"]["desc_en"] = "English Applicant professional experience description";
		$trad["applicant_professional_experience"]["applicant_id"] = "Applicant";
		$trad["applicant_professional_experience"]["job_title_ar"] = "Job title arabic";
		$trad["applicant_professional_experience"]["job_title_en"] = "job title english";
		$trad["applicant_professional_experience"]["employer"] = "Employer";
		$trad["applicant_professional_experience"]["sector_id"] = "Sectors";
		$trad["applicant_professional_experience"]["join_date"] = "Join date";
		$trad["applicant_professional_experience"]["job_duration"] = "Job duration";
		$trad["applicant_professional_experience"]["key_mission"] = "Key mission";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantProfessionalExperienceArTranslator();
		return new ApplicantProfessionalExperience();
	}
}