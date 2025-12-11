<?php

class SectorEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sector"]["sector.single"] = "Sectors";
		$trad["sector"]["sector.new"] = "new";
		$trad["sector"]["sector"] = "Sector";
		$trad["sector"]["name_ar"] = "Arabic Sector name";
		$trad["sector"]["name_en"] = "English Sector name";
		$trad["sector"]["desc_ar"] = "Arabic Sector description";
		$trad["sector"]["desc_en"] = "English Sector description";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SectorArTranslator();
		return new Sector();
	}
}