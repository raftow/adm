<?php

class CvRubricGuideArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["cv_rubric_guide"]["cvrubricguide.single"] = "دليل تقييم";
		$trad["cv_rubric_guide"]["cvrubricguide.new"] = "جديد(ة)";
		$trad["cv_rubric_guide"]["cv_rubric_guide"] = "أدلة التقييم";
		$trad["cv_rubric_guide"]["name_ar"] = "مسمى  بالعربية";
		$trad["cv_rubric_guide"]["name_en"] = "مسمى  بالانجليزية";
		$trad["cv_rubric_guide"]["desc_ar"] = "وصف  بالعربية";
		$trad["cv_rubric_guide"]["desc_en"] = "وصف  بالانجليزية";
		$trad["cv_rubric_guide"]["cv_rubric_item_id"] = "قسم سيرة ذاتية";
		$trad["cv_rubric_guide"]["rubric_score"] = "نتيجة التقييم";
		$trad["cv_rubric_guide"]["rubric_desc"] = "وصف التقييم";
		$trad["cv_rubric_guide"]["score_explanation"] = "تفسير الدرجة";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new CvRubricGuideEnTranslator();
		return new CvRubricGuide();
	}
}