<?php
class FaqCategoryEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["faq_category"]["faqcategory.single"] = "Faq category";
	$trad["faq_category"]["faqcategory.new"] = "new";
	$trad["faq_category"]["faq_category"] = "Faq categorys";
	$trad["faq_category"]["category_name_ar"] = "category name - arabic";
	$trad["faq_category"]["category_name_en"] = "category name - english";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new FaqCategoryArTranslator();
		return new FaqCategory();
	}
}