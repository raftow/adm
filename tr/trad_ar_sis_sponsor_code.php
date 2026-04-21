<?php

class SisSponsorCodeArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sis_sponsor_code"]["sissponsorcode.single"] = "Sis sponsor code";
		$trad["sis_sponsor_code"]["sissponsorcode.new"] = "جديد(ة)";
		$trad["sis_sponsor_code"]["sis_sponsor_code"] = "Sis sponsor codes";
		$trad["sis_sponsor_code"]["name_ar"] = "مسمى  بالعربية";
		$trad["sis_sponsor_code"]["name_en"] = "مسمى  بالانجليزية";
		$trad["sis_sponsor_code"]["desc_ar"] = "وصف  بالعربية";
		$trad["sis_sponsor_code"]["desc_en"] = "وصف  بالانجليزية";
		$trad["sis_sponsor_code"]["validated_by"] = "تم إعتماده من طرف";
		$trad["sis_sponsor_code"]["validated_at"] = "تم إعتماده بتاريخ";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SisSponsorCodeEnTranslator();
		return new SisSponsorCode();
	}
}