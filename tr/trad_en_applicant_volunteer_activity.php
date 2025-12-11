<?php

class ApplicantVolunteerActivityEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_volunteer_activity"]["applicantvolunteeractivity.single"] = "Certifications of appreciation";
		$trad["applicant_volunteer_activity"]["applicantvolunteeractivity.new"] = "new";
		$trad["applicant_volunteer_activity"]["applicant_volunteer_activity"] = "Certification of appreciation";
		$trad["applicant_volunteer_activity"]["name_ar"] = "Arabic Applicant volunteer activity name";
		$trad["applicant_volunteer_activity"]["name_en"] = "English Applicant volunteer activity name";
		$trad["applicant_volunteer_activity"]["desc_ar"] = "Arabic Applicant volunteer activity description";
		$trad["applicant_volunteer_activity"]["desc_en"] = "English Applicant volunteer activity description";
		$trad["applicant_volunteer_activity"]["applicant_id"] = "Applicant";
		$trad["applicant_volunteer_activity"]["organization"] = "Organization";
		$trad["applicant_volunteer_activity"]["volunteer_membership_type_id"] = "membership type";
		$trad["applicant_volunteer_activity"]["level_enum"] = "Level";
		$trad["applicant_volunteer_activity"]["acivity_date"] = "Activity date";
		$trad["applicant_volunteer_activity"]["role_held"] = "Role held";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantVolunteerActivityArTranslator();
		return new ApplicantVolunteerActivity();
	}
}