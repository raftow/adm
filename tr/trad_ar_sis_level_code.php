<?php

class SisLevelCodeArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sis_level_code"]["sislevelcode.single"] = "مرحلة نظام معلومات الطالب";
		$trad["sis_level_code"]["sislevelcode.new"] = "جديد(ة)";
		$trad["sis_level_code"]["sis_level_code"] = "مراحل نظام معلومات الطالب";
		$trad["sis_level_code"]["name_ar"] = "مسمى  بالعربية";
		$trad["sis_level_code"]["name_en"] = "مسمى  بالانجليزية";
		$trad["sis_level_code"]["desc_ar"] = "وصف  بالعربية";
		$trad["sis_level_code"]["desc_en"] = "وصف  بالانجليزية";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SisLevelCodeEnTranslator();
		return new SisLevelCode();
	}
}