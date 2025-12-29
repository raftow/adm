<?php

class ActionTypeArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["action_type"]["actiontype.single"] = "نوع الحركة";
		$trad["action_type"]["actiontype.new"] = "جديد";
		$trad["action_type"]["action_type"] = "أنواع الحركة";
		$trad["action_type"]["name_ar"] = "مسمى  بالعربية";
		$trad["action_type"]["name_en"] = "مسمى  بالانجليزية";
		$trad["action_type"]["desc_ar"] = "وصف  بالعربية";
		$trad["action_type"]["desc_en"] = "وصف  بالانجليزية";
		$trad["action_type"]["action_type_code"] = "رمز الحركة";
		$trad["action_type"]["action_type_name_ar"] = "مسمى الحركة عربي";
		$trad["action_type"]["action_type_name_en"] = "مسمى الحركة انجليزي";
		$trad["action_type"]["new_record_ind"] = "مؤشر سجل جديد؟";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ActionTypeEnTranslator();
		return new ActionType();
	}
}