<?php

class ApplcantScientificConferenceEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applcant_scientific_conference"]["applcantscientificconference.single"] = "scientific conferences";
		$trad["applcant_scientific_conference"]["applcantscientificconference.new"] = "new";
		$trad["applcant_scientific_conference"]["applcant_scientific_conference"] = "scientific conference";
		$trad["applcant_scientific_conference"]["name_ar"] = "Arabic Applcant scientific conference name";
		$trad["applcant_scientific_conference"]["name_en"] = "English Applcant scientific conference name";
		$trad["applcant_scientific_conference"]["desc_ar"] = "Arabic Applcant scientific conference description";
		$trad["applcant_scientific_conference"]["desc_en"] = "English Applcant scientific conference description";
		$trad["applcant_scientific_conference"]["applicant_id"] = "Applicant";
		$trad["applcant_scientific_conference"]["event_name_ar"] = "Event name arabic";
		$trad["applcant_scientific_conference"]["event_name_en"] = "Event name english";
		$trad["applcant_scientific_conference"]["conference_role_id"] = "scientific conferences roles";
		$trad["applcant_scientific_conference"]["event_topic"] = "Topic";
		$trad["applcant_scientific_conference"]["event_date"] = "Event date";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplcantScientificConferenceArTranslator();
		return new ApplcantScientificConference();
	}
}