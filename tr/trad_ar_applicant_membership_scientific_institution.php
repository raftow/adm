<?php

class ApplicantMembershipScientificInstitutionArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_membership_scientific_institution"]["applicantmembershipscientificinstitution.single"] = "العضوية في المؤسسات والجمعيات العلمية";
		$trad["applicant_membership_scientific_institution"]["applicantmembershipscientificinstitution.new"] = "جديد(ة)";
		$trad["applicant_membership_scientific_institution"]["applicant_membership_scientific_institution"] = "العضوية في المؤسسات والجمعيات العلمية";
		$trad["applicant_membership_scientific_institution"]["name_ar"] = "مسمى  بالعربية";
		$trad["applicant_membership_scientific_institution"]["name_en"] = "مسمى  بالانجليزية";
		$trad["applicant_membership_scientific_institution"]["desc_ar"] = "وصف  بالعربية";
		$trad["applicant_membership_scientific_institution"]["desc_en"] = "وصف  بالانجليزية";
		$trad["applicant_membership_scientific_institution"]["applicant_id"] = "المتقدم";
		$trad["applicant_membership_scientific_institution"]["organization_name"] = "اسم";
		$trad["applicant_membership_scientific_institution"]["scientific_institution_membership_type_id"] = "نوع عضوية مجلس علمي";
		$trad["applicant_membership_scientific_institution"]["scientific_istitution_level_enum"] = "المستوى";
		$trad["applicant_membership_scientific_institution"]["start_date"] = "تاريخ البداية";
		$trad["applicant_membership_scientific_institution"]["end_date"] = "تاريخ النهاية";
		$trad["applicant_membership_scientific_institution"]["role_held"] = "الدور";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantMembershipScientificInstitutionEnTranslator();
		return new ApplicantMembershipScientificInstitution();
	}
}