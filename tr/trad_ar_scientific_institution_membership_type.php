<?php

class ScientificInstitutionMembershipTypeArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["scientific_institution_membership_type"]["scientificinstitutionmembershiptype.single"] = "نوع عضوية مجلس علمي";
		$trad["scientific_institution_membership_type"]["scientificinstitutionmembershiptype.new"] = "جديد(ة)";
		$trad["scientific_institution_membership_type"]["scientific_institution_membership_type"] = "أنواع عضويات المجالس العلمية";
		$trad["scientific_institution_membership_type"]["name_ar"] = "مسمى  بالعربية";
		$trad["scientific_institution_membership_type"]["name_en"] = "مسمى  بالانجليزية";
		$trad["scientific_institution_membership_type"]["desc_ar"] = "وصف  بالعربية";
		$trad["scientific_institution_membership_type"]["desc_en"] = "وصف  بالانجليزية";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ScientificInstitutionMembershipTypeEnTranslator();
		return new ScientificInstitutionMembershipType();
	}
}