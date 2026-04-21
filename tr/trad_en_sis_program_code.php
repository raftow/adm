<?php

class SisProgramCodeEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sis_program_code"]["sisprogramcode.single"] = "Sis program code";
		$trad["sis_program_code"]["sisprogramcode.new"] = "new";
		$trad["sis_program_code"]["sis_program_code"] = "Sis program codes";
		$trad["sis_program_code"]["name_ar"] = "Arabic Sis level code name";
		$trad["sis_program_code"]["name_en"] = "English Sis level code name";
		$trad["sis_program_code"]["desc_ar"] = "Arabic Sis level code description";
		$trad["sis_program_code"]["desc_en"] = "English Sis level code description";
		$trad["sis_program_code"]["validated_by"] = "Validated by";
		$trad["sis_program_code"]["validated_at"] = "Validated at";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SisProgramCodeArTranslator();
		return new SisProgramCode();
	}
}