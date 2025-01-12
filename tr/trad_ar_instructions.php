<?php
class InstructionsArTranslator{

    public static function initData()
    {
        $trad = [];
	$trad["instructions"]["step1"] = "التعريف";

	$trad["instructions"]["instructions.single"] = "تعليمات";
	$trad["instructions"]["instructions.new"] = "جديدة";
	$trad["instructions"]["instructions"] = "التعليمات";
	$trad["instructions"]["instruction_title_ar"] = "العنوان - عربي";
	$trad["instructions"]["instruction_title_en"] = "العنوان - انجليزي";
	$trad["instructions"]["instruction_description_ar"] = "نص التعليمات - عربي";
	$trad["instructions"]["instruction_description_en"] = "نص التعليمات - انجليزي";
	$trad["instructions"]["application_model_id"] = "نموذج التقديم";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new InstructionsEnTranslator();
		return new Instructions();
	}
}