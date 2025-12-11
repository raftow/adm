<?php

class ProficiencyLevelArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["proficiency_level"]["proficiencylevel.single"] = "مستوى لغة";
		$trad["proficiency_level"]["proficiencylevel.new"] = "جديد(ة)";
		$trad["proficiency_level"]["proficiency_level"] = "مستويات اللغات";
		$trad["proficiency_level"]["name_ar"] = "مسمى  بالعربية";
		$trad["proficiency_level"]["name_en"] = "مسمى  بالانجليزية";
		$trad["proficiency_level"]["desc_ar"] = "وصف  بالعربية";
		$trad["proficiency_level"]["desc_en"] = "وصف  بالانجليزية";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ProficiencyLevelEnTranslator();
		return new ProficiencyLevel();
	}
}