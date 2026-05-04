<?php

class ApplicationClassUpgradeArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["application_class_upgrade"]["applicationclassupgrade.single"] = "تحديث تصنيف المتقدم";
		$trad["application_class_upgrade"]["applicationclassupgrade.new"] = "جديد(ة)";
		$trad["application_class_upgrade"]["application_class_upgrade"] = "تحديثات تصنيف المتقدم";
		
		$trad["application_class_upgrade"]["initial_applicant_class_id"] = "التصنيف الابتدائي";
		$trad["application_class_upgrade"]["final_applicant_class_id"] = "التصنيف النهائي";
		$trad["application_class_upgrade"]["sponsor_id"] = "الجهة الراعية";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicationClassUpgradeEnTranslator();
		return new ApplicationClassUpgrade();
	}
}