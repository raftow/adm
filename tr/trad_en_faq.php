<?php
class FaqEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["faq"]["faq.single"] = "Faq";
	$trad["faq"]["faq.new"] = "new";
	$trad["faq"]["faq"] = "Faqs";
	$trad["faq"]["question_ar"] = "question - arabic";
	$trad["faq"]["question_en"] = "cquestion - english";
	$trad["faq"]["answer_ar"] = "answer - arabic";
	$trad["faq"]["answer_en"] = "answer - english";
	$trad["faq"]["faq_category_id"] = "question category";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new FaqArTranslator();
		return new Faq();
	}
}