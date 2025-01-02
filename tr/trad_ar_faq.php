<?php
class FaqArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["faq"]["faq.single"] = "سؤال متكرر";
	$trad["faq"]["faq.new"] = "جديد";
	$trad["faq"]["faq"] = "الأسئلة المتكررة";
	$trad["faq"]["question_ar"] = "نص السؤال - عربي";
	$trad["faq"]["question_en"] = "نص السؤال - انجليزي";
	$trad["faq"]["answer_ar"] = "نص الإجابة - عربي";
	$trad["faq"]["answer_en"] = "نص الإجابة - انجليزي";
	$trad["faq"]["faq_category_id"] = "فئة السؤال";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new FaqEnTranslator();
		return new Faq();
	}
}