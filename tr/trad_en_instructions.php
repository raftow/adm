<?php
class InstructionsEnTranslator{

    public static function initData()
    {
        $trad = [];
	$trad["instructions"]["step1"] = "Definition";

	$trad["instructions"]["instructions.single"] = "Instructions";
	$trad["instructions"]["instructions.new"] = "new";
	$trad["instructions"]["instructions"] = "Instructionss";
	$trad["instructions"]["instruction_title_ar"] = "title - arabic";
	$trad["instructions"]["instruction_title_en"] = "title - english";
	$trad["instructions"]["instruction_description_ar"] = "description - arabic";
	$trad["instructions"]["instruction_description_en"] = "description - english";
	$trad["instructions"]["application_model_id"] = "application model";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new InstructionsArTranslator();
		return new Instructions();
	}
}