<?php

class CvRubricItemArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["cv_rubric_item"]["cvrubricitem.single"] = "نوع قسم سيرة ذاتية";
		$trad["cv_rubric_item"]["cvrubricitem.new"] = "جديد";
		$trad["cv_rubric_item"]["cv_rubric_item"] = "أنواع أقسام السيرة الذاتية";
		$trad["cv_rubric_item"]["name_ar"] = "مسمى  بالعربية";
		$trad["cv_rubric_item"]["name_en"] = "مسمى  بالانجليزية";
		$trad["cv_rubric_item"]["desc_ar"] = "رسالة مساعدة بالعربية";
		$trad["cv_rubric_item"]["desc_en"] = "رسالة مساعدة بالانجليزية";
        $trad["cv_rubric_item"]["lookup_code"] = "رمز  الشاشة";
        $trad["cv_rubric_item"]["module_name"] = "اسم المودل";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new CvRubricItemEnTranslator();
		return new CvRubricItem();
	}
}