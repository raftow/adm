<?php

class SectorArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sector"]["sector.single"] = "قطاع عمل";
		$trad["sector"]["sector.new"] = "جديد(ة)";
		$trad["sector"]["sector"] = "القطاعات";
		$trad["sector"]["name_ar"] = "مسمى  بالعربية";
		$trad["sector"]["name_en"] = "مسمى  بالانجليزية";
		$trad["sector"]["desc_ar"] = "وصف  بالعربية";
		$trad["sector"]["desc_en"] = "وصف  بالانجليزية";
		$trad["sector"]["scoring_multiplier"] = "معامل التقييم";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SectorEnTranslator();
		return new Sector();
	}
}