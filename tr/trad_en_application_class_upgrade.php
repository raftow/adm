<?php

class ApplicationClassUpgradeEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["application_class_upgrade"]["applicationclassupgrade.single"] = "Application class upgrade";
		$trad["application_class_upgrade"]["applicationclassupgrade.new"] = "new";
		$trad["application_class_upgrade"]["application_class_upgrade"] = "Application class upgrade";
		$trad["application_class_upgrade"]["name_ar"] = "Arabic Application class upgrade name";
		$trad["application_class_upgrade"]["name_en"] = "English Application class upgrade name";
		$trad["application_class_upgrade"]["desc_ar"] = "Arabic Application class upgrade description";
		$trad["application_class_upgrade"]["desc_en"] = "English Application class upgrade description";
		$trad["application_class_upgrade"]["application_class_id"] = "Application class";
		$trad["application_class_upgrade"]["sponsor_id"] = "Sponsor";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicationClassUpgradeArTranslator();
		return new ApplicationClassUpgrade();
	}
}