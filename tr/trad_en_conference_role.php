<?php

class ConferenceRoleEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["conference_role"]["conferencerole.single"] = "scientific conferences roles";
		$trad["conference_role"]["conferencerole.new"] = "new";
		$trad["conference_role"]["conference_role"] = "scientific conference role";
		$trad["conference_role"]["name_ar"] = "Arabic Conference role name";
		$trad["conference_role"]["name_en"] = "English Conference role name";
		$trad["conference_role"]["desc_ar"] = "Arabic Conference role description";
		$trad["conference_role"]["desc_en"] = "English Conference role description";
		$trad["conference_role"]["scoring_multiplier"] = "Scoring multiplier";

        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ConferenceRoleArTranslator();
		return new ConferenceRole();
	}
}