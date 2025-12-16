<?php

class CvRubricItemEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["cv_rubric_item"]["cvrubricitem.single"] = "CV Rubric Item";
		$trad["cv_rubric_item"]["cvrubricitem.new"] = "new";
		$trad["cv_rubric_item"]["cv_rubric_item"] = "CV Rubric Item";
		$trad["cv_rubric_item"]["name_ar"] = "Arabic Cv rubric item name";
		$trad["cv_rubric_item"]["name_en"] = "English Cv rubric item name";
		$trad["cv_rubric_item"]["desc_ar"] = "Arabic Cv rubric item description";
		$trad["cv_rubric_item"]["desc_en"] = "English Cv rubric item description";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new CvRubricItemArTranslator();
		return new CvRubricItem();
	}
}