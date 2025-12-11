<?php

class ApplicantScientificConferenceArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_scientific_conference"]["applicantscientificconference.single"] = "مؤتمر علمي";
		$trad["applicant_scientific_conference"]["applicantscientificconference.new"] = "جديد(ة)";
		$trad["applicant_scientific_conference"]["applicant_scientific_conference"] = "المؤتمرات العلمية";
		$trad["applicant_scientific_conference"]["name_ar"] = "مسمى  بالعربية";
		$trad["applicant_scientific_conference"]["name_en"] = "مسمى  بالانجليزية";
		$trad["applicant_scientific_conference"]["desc_ar"] = "وصف  بالعربية";
		$trad["applicant_scientific_conference"]["desc_en"] = "وصف  بالانجليزية";
		$trad["applicant_scientific_conference"]["applicant_id"] = "المتقدم";
		$trad["applicant_scientific_conference"]["event_name_ar"] = "اسم المؤتمر عربي";
		$trad["applicant_scientific_conference"]["event_name_en"] = "اسم المؤتمر انجليزي";
		$trad["applicant_scientific_conference"]["conference_role_id"] = "دور مؤتمر علمي";
		$trad["applicant_scientific_conference"]["event_topic"] = "الموضوع";
		$trad["applicant_scientific_conference"]["event_date"] = "التاريخ";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantScientificConferenceEnTranslator();
		return new ApplicantScientificConference();
	}
}