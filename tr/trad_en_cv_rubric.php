<?php

class CvRubricEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["cv_rubric"]["cvrubric.single"] = "cv rubric";
		$trad["cv_rubric"]["cvrubric.new"] = "new";
		$trad["cv_rubric"]["cv_rubric"] = "cv rubric";
		$trad["cv_rubric"]["name_ar"] = "Arabic Cv rubric name";
		$trad["cv_rubric"]["name_en"] = "English Cv rubric name";
		$trad["cv_rubric"]["desc_ar"] = "Arabic Cv rubric description";
		$trad["cv_rubric"]["desc_en"] = "English Cv rubric description";
		$trad["cv_rubric"]["applicant_id"] = "Applicant";
		$trad["cv_rubric"]["cv_rubric_ar"] = "cv rubric arabic";
		$trad["cv_rubric"]["cv_rubric_en"] = "cv rubric english";
		$trad["cv_rubric"]["percentage"] = "weight percentage";
		$trad["cv_rubric"]["rubric_score"] = "score";
		$trad["cv_rubric"]["rubric_score_pct"] = "percentage";
		$trad["cv_rubric"]["module_name"] = "module";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new CvRubricArTranslator();
		return new CvRubric();
	}
}