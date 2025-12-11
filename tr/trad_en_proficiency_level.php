<?php

class ProficiencyLevelEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["proficiency_level"]["proficiencylevel.single"] = "Proficiency level";
		$trad["proficiency_level"]["proficiencylevel.new"] = "new";
		$trad["proficiency_level"]["proficiency_level"] = "Proficiency level";
		$trad["proficiency_level"]["name_ar"] = "Arabic Proficiency level name";
		$trad["proficiency_level"]["name_en"] = "English Proficiency level name";
		$trad["proficiency_level"]["desc_ar"] = "Arabic Proficiency level description";
		$trad["proficiency_level"]["desc_en"] = "English Proficiency level description";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ProficiencyLevelArTranslator();
		return new ProficiencyLevel();
	}
}