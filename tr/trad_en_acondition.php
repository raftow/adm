<?php

class AconditionEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["acondition"]["acondition.single"] = "Acondition";
        $trad["acondition"]["acondition.new"] = "new";
        $trad["acondition"]["acondition"] = "Aconditions";
        $trad["acondition"]["afield_type_id"] = "Afield type";
        $trad["acondition"]["applicationModelFieldList"] = "Application Model Fields";
        $trad["acondition"]["acondition_origin_id"] = "Acondition origin";
        $trad["acondition"]["general"] = "General";
        $trad["acondition"]["acondition_type_id"] = "Acondition type";
        $trad["acondition"]["acondition_name_ar"] = "Acondition name ar";
        $trad["acondition"]["acondition_name_en"] = "Acondition name en";
        $trad["acondition"]["acondition_desc_ar"] = "Acondition desc ar";
        $trad["acondition"]["acondition_desc_en"] = "Acondition desc en";
        $trad["acondition"]["radical"] = "Radical";
        $trad["acondition"]["composed"] = "Composed";
        $trad["acondition"]["application_table_id"] = "Application table";
        $trad["acondition"]["condition_1_id"] = "Condition 1";
        $trad["acondition"]["operator_id"] = "Operator";
        $trad["acondition"]["condition_2_id"] = "Condition 2";
        $trad["acondition"]["afield_id"] = "Afield";
        $trad["acondition"]["compare_id"] = "Compare";
        $trad["acondition"]["aparameter_id"] = "Aparameter";
        $trad["acondition"]["excuse_text_ar"] = "Excuse text ar";
        $trad["acondition"]["excuse_text_en"] = "Excuse text en";
        $trad["acondition"]["priority"] = "Priority";
        $trad["acondition"]["unique_apply"] = "Unique apply";
        $trad["acondition"]["known_already"] = "Known already";
        $trad["acondition"]["show_fe"] = "Show fe";
        $trad["acondition"]["step1"] = "تعريف الشرط";
        $trad["acondition"]["step2"] = "برمجة الشرط";
        $trad["acondition"]["step3"] = "معلومات متقدمة";
        return $trad;
    }

    public static function getInstance()
	{
		return new Acondition();
	}
}