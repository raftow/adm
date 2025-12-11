<?php

class ApplicantVolunteerActivityArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_volunteer_activity"]["applicantvolunteeractivity.single"] = "لغة متقدم";
		$trad["applicant_volunteer_activity"]["applicantvolunteeractivity.new"] = "جديد(ة)";
		$trad["applicant_volunteer_activity"]["applicant_volunteer_activity"] = "اللغات";
		$trad["applicant_volunteer_activity"]["name_ar"] = "مسمى  بالعربية";
		$trad["applicant_volunteer_activity"]["name_en"] = "مسمى  بالانجليزية";
		$trad["applicant_volunteer_activity"]["desc_ar"] = "وصف  بالعربية";
		$trad["applicant_volunteer_activity"]["desc_en"] = "وصف  بالانجليزية";
		$trad["applicant_volunteer_activity"]["applicant_id"] = "المتقدم";
		$trad["applicant_volunteer_activity"]["organization"] = "المنظمة";
		$trad["applicant_volunteer_activity"]["volunteer_membership_type_id"] = "نوع الالعضوية";
		$trad["applicant_volunteer_activity"]["membership_level_enum"] = "المستوى";
		$trad["applicant_volunteer_activity"]["acivity_date"] = "تاريخ البدء";
		$trad["applicant_volunteer_activity"]["role_held"] = "الوظيفة";
		$trad["applicant_volunteer_activity"]["workflow_file_id"] = "الشهادة";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantVolunteerActivityEnTranslator();
		return new ApplicantVolunteerActivity();
	}
}