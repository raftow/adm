<?php

class ActionTypeEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["action_type"]["actiontype.single"] = "Action Type";
		$trad["action_type"]["actiontype.new"] = "new";
		$trad["action_type"]["action_type"] = "Action Type";
		$trad["action_type"]["name_ar"] = "Arabic Action type name";
		$trad["action_type"]["name_en"] = "English Action type name";
		$trad["action_type"]["desc_ar"] = "Arabic Action type description";
		$trad["action_type"]["desc_en"] = "English Action type description";
		$trad["action_type"]["action_type_code"] = "text.16";
		$trad["action_type"]["action_type_name_ar"] = "text.100";
		$trad["action_type"]["action_type_name_en"] = "text.100";
		$trad["action_type"]["new_record_ind"] = "New record ind";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ActionTypeArTranslator();
		return new ActionType();
	}
}