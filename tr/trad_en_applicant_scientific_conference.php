<?php

class ApplicantScientificConferenceEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_scientific_conference"]["applicantscientificconference.single"] = "scientific conferences";
		$trad["applicant_scientific_conference"]["applicantscientificconference.new"] = "new";
		$trad["applicant_scientific_conference"]["applicant_scientific_conference"] = "scientific conference";
		$trad["applicant_scientific_conference"]["name_ar"] = "Arabic Applicant scientific conference name";
		$trad["applicant_scientific_conference"]["name_en"] = "English Applicant scientific conference name";
		$trad["applicant_scientific_conference"]["desc_ar"] = "Arabic Applicant scientific conference description";
		$trad["applicant_scientific_conference"]["desc_en"] = "English Applicant scientific conference description";
		$trad["applicant_scientific_conference"]["applicant_id"] = "Applicant";
		$trad["applicant_scientific_conference"]["event_name_ar"] = "Event name arabic";
		$trad["applicant_scientific_conference"]["event_name_en"] = "Event name english";
		$trad["applicant_scientific_conference"]["conference_role_id"] = "scientific conferences roles";
		$trad["applicant_scientific_conference"]["event_topic"] = "Topic";
		$trad["applicant_scientific_conference"]["event_date"] = "Event date";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantScientificConferenceArTranslator();
		return new ApplicantScientificConference();
	}
}