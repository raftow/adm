<?php
class EducationalZoneEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["educational_zone"]["educationalzone.single"] = "Educational zone";
	$trad["educational_zone"]["educationalzone.new"] = "new";
	$trad["educational_zone"]["educational_zone"] = "Educational zones";
	$trad["educational_zone"]["educational_zone_ar"] = "zone - arabic";
	$trad["educational_zone"]["educational_zone_en"] = "zone - english";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new EducationalZoneArTranslator();
		return new EducationalZone();
	}
}
