<?php
class GradingScaleArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["grading_scale"]["gradingscale.single"] = "تصنيف درجة";
	$trad["grading_scale"]["gradingscale.new"] = "جديد ة";
	$trad["grading_scale"]["grading_scale"] = "تصنيفات الدرجات";
	$trad["grading_scale"]["grade_en"] = "الدرجة - عربي";
	$trad["grading_scale"]["grade_ar"] = "الدرجة - انجليزي";
	$trad["grading_scale"]["value_ar"] = "التقدير - عربي";
	$trad["grading_scale"]["value_en"] = "التقدير - انجليزي";
	$trad["grading_scale"]["mark_min"] = "الدرجة الدنيا";
	$trad["grading_scale"]["mark_max"] = "الدرجة القصوى";
	$trad["grading_scale"]["level"] = "المستوى";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new GradingScaleEnTranslator();
		return new GradingScale();
	}
}