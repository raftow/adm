<?php

class ConferenceRoleArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["conference_role"]["conferencerole.single"] = "دور مؤتمر علمي";
		$trad["conference_role"]["conferencerole.new"] = "جديد(ة)";
		$trad["conference_role"]["conference_role"] = "أدوار في المؤتمرات العلمية";
		$trad["conference_role"]["name_ar"] = "مسمى  بالعربية";
		$trad["conference_role"]["name_en"] = "مسمى  بالانجليزية";
		$trad["conference_role"]["desc_ar"] = "وصف  بالعربية";
		$trad["conference_role"]["desc_en"] = "وصف  بالانجليزية";
		$trad["conference_role"]["scoring_multiplier"] = "معامل التقييم";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ConferenceRoleEnTranslator();
		return new ConferenceRole();
	}
}