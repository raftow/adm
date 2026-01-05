<?php

class ApplicationRequirementArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["application_requirement"]["applicationrequirement.single"] = "متطلب تقديم";
		$trad["application_requirement"]["applicationrequirement.new"] = "جديد(ة)";
		$trad["application_requirement"]["application_requirement"] = "متطلبات التقديم";
		$trad["application_requirement"]["name_ar"] = "مسمى  بالعربية";
		$trad["application_requirement"]["name_en"] = "مسمى  بالانجليزية";
		$trad["application_requirement"]["desc_ar"] = "وصف  بالعربية";
		$trad["application_requirement"]["desc_en"] = "وصف  بالانجليزية";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicationRequirementEnTranslator();
		return new ApplicationRequirement();
	}
}