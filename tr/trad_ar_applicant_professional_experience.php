<?php

class ApplicantProfessionalExperienceArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_professional_experience"]["applicantprofessionalexperience.single"] = "خبرة مهنية";
		$trad["applicant_professional_experience"]["applicantprofessionalexperience.new"] = "جديد(ة)";
		$trad["applicant_professional_experience"]["applicant_professional_experience"] = "الخبرات المهنية﻿";
		$trad["applicant_professional_experience"]["name_ar"] = "مسمى  بالعربية";
		$trad["applicant_professional_experience"]["name_en"] = "مسمى  بالانجليزية";
		$trad["applicant_professional_experience"]["desc_ar"] = "وصف  بالعربية";
		$trad["applicant_professional_experience"]["desc_en"] = "وصف  بالانجليزية";
		$trad["applicant_professional_experience"]["applicant_id"] = "المتقدم";
		$trad["applicant_professional_experience"]["job_title_ar"] = "المسمى الوظيفي عربي";
		$trad["applicant_professional_experience"]["job_title_en"] = "المسمى الوظيفي انجليزي";
		$trad["applicant_professional_experience"]["employer"] = "جهة العمل";
		$trad["applicant_professional_experience"]["sector_id"] = "قطاع العمل";
		$trad["applicant_professional_experience"]["join_date"] = "تاريخ الالتحاق";
		$trad["applicant_professional_experience"]["job_duration"] = "المدة";
		$trad["applicant_professional_experience"]["key_mission"] = "وصف المهام";
		$trad["applicant_professional_experience"]["experience_file_id"] = "المرفق";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantProfessionalExperienceEnTranslator();
		return new ApplicantProfessionalExperience();
	}
}