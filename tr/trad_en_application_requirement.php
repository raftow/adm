<?php

class ApplicationRequirementEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["application_requirement"]["applicationrequirement.single"] = "Application Requirement";
		$trad["application_requirement"]["applicationrequirement.new"] = "new";
		$trad["application_requirement"]["application_requirement"] = "Application Requirements";
		$trad["application_requirement"]["name_ar"] = "Arabic Application requirement name";
		$trad["application_requirement"]["name_en"] = "English Application requirement name";
		$trad["application_requirement"]["desc_ar"] = "Arabic Application requirement description";
		$trad["application_requirement"]["desc_en"] = "English Application requirement description";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicationRequirementArTranslator();
		return new ApplicationRequirement();
	}
}