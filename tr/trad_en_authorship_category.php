<?php

class AuthorshipCategoryEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["authorship_category"]["authorshipcategory.single"] = "Authorship category";
		$trad["authorship_category"]["authorshipcategory.new"] = "new";
		$trad["authorship_category"]["authorship_category"] = "Authorship category";
		$trad["authorship_category"]["name_ar"] = "Arabic Authorship category name";
		$trad["authorship_category"]["name_en"] = "English Authorship category name";
		$trad["authorship_category"]["desc_ar"] = "Arabic Authorship category description";
		$trad["authorship_category"]["desc_en"] = "English Authorship category description";
		$trad["authorship_category"]["scoring_multiplier"] = "Scoring multiplier";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new AuthorshipCategoryArTranslator();
		return new AuthorshipCategory();
	}
}