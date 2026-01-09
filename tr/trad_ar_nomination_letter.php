<?php

class NominationLetterArTranslator
{
	public static function initData()
	{
		$trad = [];
		$trad["nomination_letter"]["step1"] = "خطاب الترشيح";
		$trad["nomination_letter"]["step2"] = "المرشحين";
		$trad["nomination_letter"]["step3"] = "عرض";

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
		$trad["nomination_letter"]["nomination_letter_file_id"] = "خطاب الترشيح";
		$trad["nomination_letter"]["download_light"] = "تحميل الخطاب";
		$trad["nomination_letter"]["pic_view"] = "صورة الخطاب";
		$trad["nomination_letter"]["application_simulation_id"] = "نوع التقديم";
		$trad["nomination_letter"]["nominationCandidateList"] = "قائمة المرشحين";
		$trad["nomination_letter"]["letter_code"] = "رقم الخطاب";


		// steps
		return $trad;
	}

	public static function getInstance()
	{
		if (false) return new NominationLetterEnTranslator();
		return new NominationLetter();
	}
}
