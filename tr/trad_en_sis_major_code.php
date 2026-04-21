<?php

class SisMajorCodeEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sis_major_code"]["sismajorcode.single"] = "SIS Major Code";
		$trad["sis_major_code"]["sismajorcode.new"] = "new";
		$trad["sis_major_code"]["sis_major_code"] = "SIS Major Codes";
		$trad["sis_major_code"]["name_ar"] = "Arabic Sis major code name";
		$trad["sis_major_code"]["name_en"] = "English Sis major code name";
		$trad["sis_major_code"]["desc_ar"] = "Arabic Sis major code description";
		$trad["sis_major_code"]["desc_en"] = "English Sis major code description";
		$trad["sis_major_code"]["sis_program_code_id"] = "Sis program code";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SisMajorCodeArTranslator();
		return new SisMajorCode();
	}
}