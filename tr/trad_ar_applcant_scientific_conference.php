<?php

class ApplcantScientificConferenceArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applcant_scientific_conference"]["applcantscientificconference.single"] = "مؤتمر علمي";
		$trad["applcant_scientific_conference"]["applcantscientificconference.new"] = "جديد(ة)";
		$trad["applcant_scientific_conference"]["applcant_scientific_conference"] = "المؤتمرات العلمية";
		$trad["applcant_scientific_conference"]["name_ar"] = "مسمى  بالعربية";
		$trad["applcant_scientific_conference"]["name_en"] = "مسمى  بالانجليزية";
		$trad["applcant_scientific_conference"]["desc_ar"] = "وصف  بالعربية";
		$trad["applcant_scientific_conference"]["desc_en"] = "وصف  بالانجليزية";
		$trad["applcant_scientific_conference"]["applicant_id"] = "المتقدم";
		$trad["applcant_scientific_conference"]["event_name_ar"] = "اسم المؤتمر عربي";
		$trad["applcant_scientific_conference"]["event_name_en"] = "اسم المؤتمر انجليزي";
		$trad["applcant_scientific_conference"]["conference_role_id"] = "دور مؤتمر علمي";
		$trad["applcant_scientific_conference"]["event_topic"] = "الموضوع";
		$trad["applcant_scientific_conference"]["event_date"] = "التاريخ";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplcantScientificConferenceEnTranslator();
		return new ApplcantScientificConference();
	}
}