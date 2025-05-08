<?php

class AconditionArTranslator{
    public static function initData()
    {
        $trad = [];
		$trad["acondition"]["step1"] = "تعريف الشرط";
		$trad["acondition"]["step2"] = "برمجة الشرط";
		$trad["acondition"]["step3"] = "معلومات متقدمة";


		$trad["acondition"]["acondition.single"] = "شرط";
		$trad["acondition"]["acondition.new"] = "جديد";
		$trad["acondition"]["acondition"] = "الشروط";
		
		$trad["acondition"]["acondition_name_ar"] = "مسمى الشرط بالعربية";
		$trad["acondition"]["acondition_name_en"] = "مسمى الشرط بالانجليزية";
		$trad["acondition"]["acondition_desc_ar"] = "وصف الشرط بالعربية";
		$trad["acondition"]["acondition_desc_en"] = "وصف الشرط بالانجليزية";
		$trad["acondition"]["radical"] = "شرط قطعي";
		$trad["acondition"]["composed"] =  "صنف الشرط";
		$trad["acondition"]["composed.YES"] = "شرط مركب";
		$trad["acondition"]["composed.NO"]  = "شرط بسيط";
		$trad["acondition"]["composed.EUH"] = "شرط يدوي";

		$trad["acondition"]["condition_1_id"] = "الجزء الأول من الشرط";
		$trad["acondition"]["operator_id"] = "الأداة المنطقية";
		$trad["acondition"]["condition_2_id"] = "الجزء الثاني من الشرط";
		$trad["acondition"]["afield_id"] = "الحقل";
		$trad["acondition"]["compare_id"] = "أداة المقارنة";
		$trad["acondition"]["aparameter_id"] = "القيمة المقارنة";
		$trad["acondition"]["excuse_text_ar"] = "نص الاعتذار بالعربية";
		$trad["acondition"]["general"] = "الشرط يطبق على";
		$trad["acondition"]["general.YES"] = "المتقدم";
		$trad["acondition"]["general.EUH"]  = "ملف الترشح";
		$trad["acondition"]["general.NO"] = "الرغبة";
		$trad["acondition"]["general.short"] = "يطبق على";
		

		$trad["acondition"]["acondition_type_id"] = "نوع الشرط";
		$trad["acondition"]["acondition_origin_id"] = "اللائحة ";
		$trad["acondition"]["excuse_text_en"] = "نص الاعتذار بالانجليزية";
		$trad["acondition"]["priority"] = "الأولوية";
		$trad["acondition"]["unique_apply"] = "يتم تطبيقه على كل فرع";
		$trad["acondition"]["known_already"] = "قيمة الحقل معلومة مسبقا";
		$trad["acondition"]["show_fe"] = "الاظهار في الواجهة";
		$trad["acondition"]["bfunction_id"] = "الخدمة العملية";

		


		$trad["acondition"]["compare_id.short"] = "مقارنة";

		$trad["acondition"]["acondition_name_ar.short"] = "المسمى بالعربي";
		$trad["acondition"]["acondition_name_en.short"] = "المسمى بالانجليزية";
		
		$trad["acondition"]["condition_1_id.short"] = "الجزء 1";
		$trad["acondition"]["condition_2_id.short"] = "الجزء 2";
		
		
		// $trad["acondition"]["unique_apply.short"] = "يتم تطبيقه على كل فرع";
		$trad["acondition"]["known_already.short"] = "معلومة مسبقا";
		$trad["acondition"]["show_fe.short"] = "الاظهار";
		return $trad;
    }

    public static function getInstance()
	{
		return new Acondition();
	}
}
?>