<?php

class ApplicationSimulationArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["application_simulation"]["step1"] = "حيثيات المحاكاة";
		$trad["application_simulation"]["step2"] = "اعدادات المحاكاة";
		$trad["application_simulation"]["step3"] = "تنفيذ المحاكاة";
		$trad["application_simulation"]["step4"] = "سجلات المحاكاة";
		$trad["application_simulation"]["step5"] = "نتائج المحاكاة";

		$trad["application_simulation"]["applicationsimulation.single"] = "طلب محاكاة تقديم";
		$trad["application_simulation"]["applicationsimulation.new"] = "جديد(ة)";
		$trad["application_simulation"]["application_simulation"] = "طلبات محاكاة التقديم";
		$trad["application_simulation"]["name_ar"] = "مسمى  بالعربية";
		$trad["application_simulation"]["name_en"] = "مسمى  بالانجليزية";

		$trad["application_simulation"]["settings"] = "اعدادات المحاكاة";
		$trad["application_simulation"]["log"] = "سجلات تفاصيل المحاكاة";
		$trad["application_simulation"]["application_model_id"] = "نموذج القبول";
		$trad["application_simulation"]["application_plan_id"] = "خطة القبول";
		$trad["application_simulation"]["applicant_group_id"] = "مجموعة المتقدمين";
		$trad["application_simulation"]["application_model_branch_mfk"] = "الفروع المختارة";
		$trad["application_simulation"]["nb_desires"] = "عدد الرغبات الأقصى";
		$trad["application_simulation"]["simul_method_enum"] = "طريقة المحاكاة";

		$trad["application_simulation"]["applicationList"] = "محاكاة التقديم";
		$trad["application_simulation"]["applicationdesireList"] = "محاكاة الرغبات";
		
		$trad["application_simulation"]["progress_task"] = "المهمة الحالية";
		$trad["application_simulation"]["progress_value"] = "تقدم التنفيذ";

		
	    // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicationSimulationEnTranslator();
		return new ApplicationSimulation();
	}
}