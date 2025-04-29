<?php

class DisabilityArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["disability"]["disability.single"] = "اعاقة";
		$trad["disability"]["disability.new"] = "جديد(ة)";
		$trad["disability"]["disability"] = "الاعاقات";
		$trad["disability"]["name_ar"] = "مسمى  بالعربية";
		$trad["disability"]["desc_ar"] = "وصف  بالعربية";
		$trad["disability"]["name_en"] = "مسمى  بالانجليزية";
		$trad["disability"]["desc_en"] = "وصف  بالانجليزية";
		$trad["disability"]["lookup_code"] = "الرمز";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new DisabilityEnTranslator();
		return new Disability();
	}
}