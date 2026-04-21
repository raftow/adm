<?php

class SisLevelCodeEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sis_level_code"]["sislevelcode.single"] = "SIS Level Code";
		$trad["sis_level_code"]["sislevelcode.new"] = "new";
		$trad["sis_level_code"]["sis_level_code"] = "SIS Level Codes";
		$trad["sis_level_code"]["name_ar"] = "Arabic Sis level code name";
		$trad["sis_level_code"]["name_en"] = "English Sis level code name";
		$trad["sis_level_code"]["desc_ar"] = "Arabic Sis level code description";
		$trad["sis_level_code"]["desc_en"] = "English Sis level code description";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SisLevelCodeArTranslator();
		return new SisLevelCode();
	}
}