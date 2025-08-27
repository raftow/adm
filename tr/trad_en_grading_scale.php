<?php
class GradingScaleEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["grading_scale"]["gradingscale.single"] = "Grading scale";
	$trad["grading_scale"]["gradingscale.new"] = "new";
	$trad["grading_scale"]["grading_scale"] = "Grading scales";
	$trad["grading_scale"]["grade_en"] = "grade - arabic";
	$trad["grading_scale"]["grade_ar"] = "grade - english";
	$trad["grading_scale"]["value_ar"] = "rating - arabic";
	$trad["grading_scale"]["value_en"] = "rating - english";
	$trad["grading_scale"]["mark_min"] = "mark min";
	$trad["grading_scale"]["mark_max"] = "mark max";
	$trad["grading_scale"]["level"] = "level";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new GradingScaleArTranslator();
		return new GradingScale();
	}
}
