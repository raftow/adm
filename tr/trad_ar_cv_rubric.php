<?php

class CvRubricArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["cv_rubric"]["cvrubric.single"] = "قسم سيرة ذاتية";
		$trad["cv_rubric"]["cvrubric.new"] = "جديد(ة)";
		$trad["cv_rubric"]["cv_rubric"] = "أقسام السيرة الذاتية";
		$trad["cv_rubric"]["name_ar"] = "مسمى  بالعربية";
		$trad["cv_rubric"]["name_en"] = "مسمى  بالانجليزية";
		$trad["cv_rubric"]["desc_ar"] = "وصف  بالعربية";
		$trad["cv_rubric"]["desc_en"] = "وصف  بالانجليزية";
		$trad["cv_rubric"]["applicant_id"] = "المتقدم";
		$trad["cv_rubric"]["cv_rubric_ar"] = "عنوان القسم عربي";
		$trad["cv_rubric"]["cv_rubric_en"] = "عنوان القسم انجليزي";
		$trad["cv_rubric"]["weight"] = "وزن القسم";
		$trad["cv_rubric"]["percentage"] = "النسبة المئوية للوزن";
		$trad["cv_rubric"]["rubric_score"] = "النتيجة";
		$trad["cv_rubric"]["rubric_score_pct"] = "النسبة المئوية";
		$trad["cv_rubric"]["module_name"] = "الوحدة";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new CvRubricEnTranslator();
		return new CvRubric();
	}
}