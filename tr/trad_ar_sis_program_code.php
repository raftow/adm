<?php

class SisProgramCodeArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sis_program_code"]["sisprogramcode.single"] = "Sis program code";
		$trad["sis_program_code"]["sisprogramcode.new"] = "جديد(ة)";
		$trad["sis_program_code"]["sis_program_code"] = "Sis program codes";
		$trad["sis_program_code"]["lookup_code"] = "الرمز الفني";
		$trad["sis_program_code"]["name_ar"] = "مسمى  بالعربية";
		$trad["sis_program_code"]["name_en"] = "مسمى  بالانجليزية";
		$trad["sis_program_code"]["desc_ar"] = "وصف  بالعربية";
		$trad["sis_program_code"]["desc_en"] = "وصف  بالانجليزية";
		$trad["sis_program_code"]["sis_level_code"] = "رمز .......";
		$trad["sis_program_code"]["validated_by"] = "تم إعتماده من طرف";
		$trad["sis_program_code"]["validated_at"] = "تم إعتماده بتاريخ";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SisProgramCodeEnTranslator();
		return new SisProgramCode();
	}
}