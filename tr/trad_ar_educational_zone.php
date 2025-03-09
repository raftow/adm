<?php
class EducationalZoneArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["educational_zone"]["educationalzone.single"] = "منطقة تعليمية";
	$trad["educational_zone"]["educationalzone.new"] = "جديد ة";
	$trad["educational_zone"]["educational_zone"] = "مناطق تعليمية";
	$trad["educational_zone"]["educational_zone_ar"] = "المنطقة - عربي";
	$trad["educational_zone"]["educational_zone_en"] = "المنطقة - انجليزي";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new EducationalZoneEnTranslator();
		return new EducationalZone();
	}
}