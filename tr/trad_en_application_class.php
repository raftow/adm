<?php

class ApplicationClassEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["application_class"]["applicationclass.single"] = "Application class";
		$trad["application_class"]["applicationclass.new"] = "new";
		$trad["application_class"]["application_class"] = "Application class";
		$trad["application_class"]["name_ar"] = "Arabic Application class name";
		$trad["application_class"]["name_en"] = "English Application class name";
		$trad["application_class"]["desc_ar"] = "Arabic Application class description";
		$trad["application_class"]["desc_en"] = "English Application class description";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicationClassArTranslator();
		return new ApplicationClass();
	}
}