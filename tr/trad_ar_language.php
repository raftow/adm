<?php

class LanguageArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["language"]["language.single"] = "لغة";
		$trad["language"]["language.new"] = "جديد(ة)";
		$trad["language"]["language"] = "اللغات";
		$trad["language"]["name_ar"] = "مسمى  بالعربية";
		$trad["language"]["name_en"] = "مسمى  بالانجليزية";
		$trad["language"]["desc_ar"] = "وصف  بالعربية";
		$trad["language"]["desc_en"] = "وصف  بالانجليزية";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new LanguageEnTranslator();
		return new Language();
	}
}