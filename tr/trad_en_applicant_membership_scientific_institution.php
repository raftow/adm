<?php

class ApplicantMembershipScientificInstitutionEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_membership_scientific_institution"]["applicantmembershipscientificinstitution.single"] = "membership_scientific institutions";
		$trad["applicant_membership_scientific_institution"]["applicantmembershipscientificinstitution.new"] = "new";
		$trad["applicant_membership_scientific_institution"]["applicant_membership_scientific_institution"] = "Membership scientific institution";
		$trad["applicant_membership_scientific_institution"]["name_ar"] = "Arabic Applicant membership scientific institution name";
		$trad["applicant_membership_scientific_institution"]["name_en"] = "English Applicant membership scientific institution name";
		$trad["applicant_membership_scientific_institution"]["desc_ar"] = "Arabic Applicant membership scientific institution description";
		$trad["applicant_membership_scientific_institution"]["desc_en"] = "English Applicant membership scientific institution description";
		$trad["applicant_membership_scientific_institution"]["applicant_id"] = "Applicant";
		$trad["applicant_membership_scientific_institution"]["scientific_institution_membership_type_id"] = "Authorship category";
		$trad["applicant_membership_scientific_institution"]["scientific_istitution_level_enum"] = "Level";
		$trad["applicant_membership_scientific_institution"]["start_date"] = "Start date";
		$trad["applicant_membership_scientific_institution"]["end_date"] = "End date";
		$trad["applicant_membership_scientific_institution"]["role_held"] = "Role hed";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantMembershipScientificInstitutionArTranslator();
		return new ApplicantMembershipScientificInstitution();
	}
}