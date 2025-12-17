<?php

class LorTypeEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["lor_type"]["lortype.single"] = "LOR type";
		$trad["lor_type"]["lortype.new"] = "new";
		$trad["lor_type"]["lor_type"] = "نوع رسالة التوصية";
		$trad["lor_type"]["name_ar"] = "Arabic Lor type name";
		$trad["lor_type"]["name_en"] = "English Lor type name";
		$trad["lor_type"]["desc_ar"] = "Arabic Lor type description";
		$trad["lor_type"]["desc_en"] = "English Lor type description";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new LorTypeArTranslator();
		return new LorType();
	}
}