<?php

class DisabilityEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["disability"]["disability.single"] = "disablity";
		$trad["disability"]["disability.new"] = "new";
		$trad["disability"]["disability"] = "disablities";
		$trad["disability"]["name_ar"] = "Arabic Disablity name";
		$trad["disability"]["desc_ar"] = "Arabic Disablity description";
		$trad["disability"]["name_en"] = "English Disablity name";
		$trad["disability"]["desc_en"] = "English Disablity description";
		$trad["disability"]["lookup_code"] = "Lookup code";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new DisabilityArTranslator();
		return new Disability();
	}
}