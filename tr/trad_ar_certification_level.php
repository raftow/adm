<?php

class CertificationLevelArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["certification_level"]["certificationlevel.single"] = "مستوى شهادة";
		$trad["certification_level"]["certificationlevel.new"] = "جديد(ة)";
		$trad["certification_level"]["certification_level"] = "مستويات الشهادة";
		$trad["certification_level"]["name_ar"] = "مسمى  بالعربية";
		$trad["certification_level"]["name_en"] = "مسمى  بالانجليزية";
		$trad["certification_level"]["desc_ar"] = "وصف  بالعربية";
		$trad["certification_level"]["desc_en"] = "وصف  بالانجليزية";
		$trad["certification_level"]["scoring_multiplier"] = "معامل التصحيح";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new CertificationLevelEnTranslator();
		return new CertificationLevel();
	}
}