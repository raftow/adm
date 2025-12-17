<?php

class LorTypeArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["lor_type"]["lortype.single"] = "التوصية";
		$trad["lor_type"]["lortype.new"] = "جديد(ة)";
		$trad["lor_type"]["lor_type"] = "أنواع رسائل";
		$trad["lor_type"]["name_ar"] = "مسمى  بالعربية";
		$trad["lor_type"]["name_en"] = "مسمى  بالانجليزية";
		$trad["lor_type"]["desc_ar"] = "وصف  بالعربية";
		$trad["lor_type"]["desc_en"] = "وصف  بالانجليزية";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new LorTypeEnTranslator();
		return new LorType();
	}
}