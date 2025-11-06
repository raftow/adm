<?php

class NominationLetterArTranslator{
    public static function initData()
    {
        $trad = [];
		$trad["nomination_letter"]["step1"] = "خطاب الترشيح";

		$trad["nomination_letter"]["nominationletter.single"] = "خطاب ترشيح";
		$trad["nomination_letter"]["nominationletter.new"] = "جديد";
		$trad["nomination_letter"]["nomination_letter"] = "خطابات الترشيح";
		$trad["nomination_letter"]["name_ar"] = "مسمى  بالعربية";
		$trad["nomination_letter"]["desc_ar"] = "وصف  بالعربية";
		$trad["nomination_letter"]["name_en"] = "مسمى  بالانجليزية";
		$trad["nomination_letter"]["desc_en"] = "وصف  بالانجليزية";
		$trad["nomination_letter"]["application_plan_id"] = "خطة التقديم";
		$trad["nomination_letter"]["nominating_authority_source_enum"] = "مصدر جهة الترشيح";
		$trad["nomination_letter"]["nominating_authority_id"] = "جهة الترشيح";
		$trad["nomination_letter"]["nomination_letter_date"] = "تاريخ الخطاب";
		$trad["nomination_letter"]["sponsor_cordinator_id"] = "منسق جهة الترشيح";
		$trad["nomination_letter"]["sponsor_cordinator_id"] = "منسق جهة الترشيح";
		$trad["nomination_letter"]["nomination_letter_file_id"] = "منسق جهة الترشيح";

        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new NominationLetterEnTranslator();
		return new NominationLetter();
	}
}