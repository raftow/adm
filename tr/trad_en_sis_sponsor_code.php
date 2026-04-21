<?php

class SisSponsorCodeEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sis_sponsor_code"]["sissponsorcode.single"] = "Sis sponsor code";
		$trad["sis_sponsor_code"]["sissponsorcode.new"] = "new";
		$trad["sis_sponsor_code"]["sis_sponsor_code"] = "Sis sponsor codes";
		$trad["sis_sponsor_code"]["name_ar"] = "Arabic Sis major code name";
		$trad["sis_sponsor_code"]["name_en"] = "English Sis major code name";
		$trad["sis_sponsor_code"]["desc_ar"] = "Arabic Sis major code description";
		$trad["sis_sponsor_code"]["desc_en"] = "English Sis major code description";
		$trad["sis_sponsor_code"]["validated_by"] = "Validated by";
		$trad["sis_sponsor_code"]["validated_at"] = "Validated at";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SisSponsorCodeArTranslator();
		return new SisSponsorCode();
	}
}