<?php

class ApplicationClassArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["application_class"]["applicationclass.single"] = "تصنيف التقديم";
		$trad["application_class"]["applicationclass.new"] = "جديد(ة)";
		$trad["application_class"]["application_class"] = "تصانيف التقديم";
		$trad["application_class"]["name_ar"] = "مسمى  بالعربية";
		$trad["application_class"]["name_en"] = "مسمى  بالانجليزية";
		$trad["application_class"]["desc_ar"] = "وصف  بالعربية";
		$trad["application_class"]["desc_en"] = "وصف  بالانجليزية";
		$trad["financial_transaction_sis_settings"]["budgeting_ind"] = "مدفوع ؟";

        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicationClassEnTranslator();
		return new ApplicationClass();
	}
}