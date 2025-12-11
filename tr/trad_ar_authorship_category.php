<?php

class AuthorshipCategoryArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["authorship_category"]["authorshipcategory.single"] = "فئة المؤلف";
		$trad["authorship_category"]["authorshipcategory.new"] = "جديد(ة)";
		$trad["authorship_category"]["authorship_category"] = "فئات المؤلفين";
		$trad["authorship_category"]["name_ar"] = "مسمى  بالعربية";
		$trad["authorship_category"]["name_en"] = "مسمى  بالانجليزية";
		$trad["authorship_category"]["desc_ar"] = "وصف  بالعربية";
		$trad["authorship_category"]["desc_en"] = "وصف  بالانجليزية";
		$trad["authorship_category"]["scoring_multiplier"] = "التأثير";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new AuthorshipCategoryEnTranslator();
		return new AuthorshipCategory();
	}
}