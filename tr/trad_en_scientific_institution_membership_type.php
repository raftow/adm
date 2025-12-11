<?php

class ScientificInstitutionMembershipTypeEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["scientific_institution_membership_type"]["scientificinstitutionmembershiptype.single"] = "Authorship category";
		$trad["scientific_institution_membership_type"]["scientificinstitutionmembershiptype.new"] = "new";
		$trad["scientific_institution_membership_type"]["scientific_institution_membership_type"] = "Authorship category";
		$trad["scientific_institution_membership_type"]["name_ar"] = "Arabic Scientific institution membership type name";
		$trad["scientific_institution_membership_type"]["name_en"] = "English Scientific institution membership type name";
		$trad["scientific_institution_membership_type"]["desc_ar"] = "Arabic Scientific institution membership type description";
		$trad["scientific_institution_membership_type"]["desc_en"] = "English Scientific institution membership type description";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ScientificInstitutionMembershipTypeArTranslator();
		return new ScientificInstitutionMembershipType();
	}
}