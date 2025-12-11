<?php

class LanguageEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["language"]["language.single"] = "Languages";
		$trad["language"]["language.new"] = "new";
		$trad["language"]["language"] = "Language";
		$trad["language"]["name_ar"] = "Arabic Language name";
		$trad["language"]["name_en"] = "English Language name";
		$trad["language"]["desc_ar"] = "Arabic Language description";
		$trad["language"]["desc_en"] = "English Language description";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new LanguageArTranslator();
		return new Language();
	}
}