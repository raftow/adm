<?php

class CertificationLevelEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["certification_level"]["certificationlevel.single"] = "Certification levels";
		$trad["certification_level"]["certificationlevel.new"] = "new";
		$trad["certification_level"]["certification_level"] = "Certification level";
		$trad["certification_level"]["name_ar"] = "Arabic Certification level name";
		$trad["certification_level"]["name_en"] = "English Certification level name";
		$trad["certification_level"]["desc_ar"] = "Arabic Certification level description";
		$trad["certification_level"]["desc_en"] = "English Certification level description";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new CertificationLevelArTranslator();
		return new CertificationLevel();
	}
}