<?php

class VolunteerMembershipTypeArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["volunteer_membership_type"]["volunteermembershiptype.single"] = "نوع العضوية";
		$trad["volunteer_membership_type"]["volunteermembershiptype.new"] = "جديد(ة)";
		$trad["volunteer_membership_type"]["volunteer_membership_type"] = "أنواع العضوية";
		$trad["volunteer_membership_type"]["name_ar"] = "مسمى  بالعربية";
		$trad["volunteer_membership_type"]["name_en"] = "مسمى  بالانجليزية";
		$trad["volunteer_membership_type"]["desc_ar"] = "وصف  بالعربية";
		$trad["volunteer_membership_type"]["desc_en"] = "وصف  بالانجليزية";
		$trad["volunteer_membership_type"]["scoring_impact"] = "التأثير";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new VolunteerMembershipTypeEnTranslator();
		return new VolunteerMembershipType();
	}
}