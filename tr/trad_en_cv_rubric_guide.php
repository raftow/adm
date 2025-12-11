<?php

class CvRubricGuideEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["cv_rubric_guide"]["cvrubricguide.single"] = "cv rubric guide";
		$trad["cv_rubric_guide"]["cvrubricguide.new"] = "new";
		$trad["cv_rubric_guide"]["cv_rubric_guide"] = "cv rubric guide";
		$trad["cv_rubric_guide"]["name_ar"] = "Arabic Cv rubric guide name";
		$trad["cv_rubric_guide"]["name_en"] = "English Cv rubric guide name";
		$trad["cv_rubric_guide"]["desc_ar"] = "Arabic Cv rubric guide description";
		$trad["cv_rubric_guide"]["desc_en"] = "English Cv rubric guide description";
		$trad["cv_rubric_guide"]["cv_rubric_id"] = "cv rubric";
		$trad["cv_rubric_guide"]["rubric_score"] = "ruric score";
		$trad["cv_rubric_guide"]["rubric_desc"] = "ruric description";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new CvRubricGuideArTranslator();
		return new CvRubricGuide();
	}
}