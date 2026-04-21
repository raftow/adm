<?php

class SisMajorCodeArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sis_major_code"]["sismajorcode.single"] = "تخصص نظام معلومات الطالب";
		$trad["sis_major_code"]["sismajorcode.new"] = "جديد(ة)";
		$trad["sis_major_code"]["sis_major_code"] = "تخصصات نظام معلومات الطالب";
		$trad["sis_major_code"]["name_ar"] = "مسمى  بالعربية";
		$trad["sis_major_code"]["name_en"] = "مسمى  بالانجليزية";
		$trad["sis_major_code"]["desc_ar"] = "وصف  بالعربية";
		$trad["sis_major_code"]["desc_en"] = "وصف  بالانجليزية";
		$trad["sis_major_code"]["sis_program_code_id"] = "Sis program code";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SisMajorCodeEnTranslator();
		return new SisMajorCode();
	}
}