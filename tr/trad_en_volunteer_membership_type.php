<?php

class VolunteerMembershipTypeEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["volunteer_membership_type"]["volunteermembershiptype.single"] = "membership type";
		$trad["volunteer_membership_type"]["volunteermembershiptype.new"] = "new";
		$trad["volunteer_membership_type"]["volunteer_membership_type"] = "Membership type";
		$trad["volunteer_membership_type"]["name_ar"] = "Arabic Volunteer membership type name";
		$trad["volunteer_membership_type"]["name_en"] = "English Volunteer membership type name";
		$trad["volunteer_membership_type"]["desc_ar"] = "Arabic Volunteer membership type description";
		$trad["volunteer_membership_type"]["desc_en"] = "English Volunteer membership type description";
		$trad["volunteer_membership_type"]["scoring_impact"] = "Scoring impact";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new VolunteerMembershipTypeArTranslator();
		return new VolunteerMembershipType();
	}
}