<?php
class FaqCategoryArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["faq_category"]["faqcategory.single"] = "فئة سؤال";
	$trad["faq_category"]["faqcategory.new"] = "جديد ة";
	$trad["faq_category"]["faq_category"] = "فئات الأسئلة";
	$trad["faq_category"]["category_name_ar"] = "اسم النوع - عربي";
	$trad["faq_category"]["category_name_en"] = "اسم النوع - انجليزي";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new FaqCategoryEnTranslator();
		return new FaqCategory();
	}
}
