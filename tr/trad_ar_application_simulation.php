<?php

class ApplicationSimulationArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["application_simulation"]["step1"] = "حيثيات المحاكاة";
		$trad["application_simulation"]["step2"] = "اعدادات المحاكاة";
		$trad["application_simulation"]["step3"] = "تنفيذ المحاكاة";
		$trad["application_simulation"]["step4"] = "متابعة سير تنفيذ المحاكاة";
		$trad["application_simulation"]["step5"] = "سجلات المحاكاة";
		
		$trad["application_simulation"]["step6"] = "الفرز";

		$trad["application_simulation"]["prospect"] = "بانتظار محاكاة التسجيل";
		$trad["application_simulation"]["to-do"] = "بانتظار محاكاة التقديم";
		$trad["application_simulation"]["to-decide"] = "بانتظار محاكاة قرار المتقدم";
		$trad["application_simulation"]["done"] = "تمت المحاكاة";
		$trad["application_simulation"]["standby"] = "محاكاة متعثرة";
		
		

		$trad["application_simulation"]["applicationsimulation.single"] = "نوع تقديم";
		$trad["application_simulation"]["applicationsimulation.new"] = "جديد";
		$trad["application_simulation"]["application_simulation"] = "أنواع التقديم";
		$trad["application_simulation"]["name_ar"] = "مسمى  بالعربية";
		$trad["application_simulation"]["name_en"] = "مسمى  بالانجليزية";

		$trad["application_simulation"]["settings"] = "اعدادات المحاكاة";
		$trad["application_simulation"]["log"] = "سجلات تفاصيل المحاكاة";
		$trad["application_simulation"]["application_model_id"] = "نموذج القبول";
		$trad["application_simulation"]["application_plan_id"] = "خطة القبول التي تمت عليها المحاكاة";
		$trad["application_simulation"]["applicant_group_id"] = "مجموعة المتقدمين";
		$trad["application_simulation"]["application_model_branch_mfk"] = "الفروع المختارة";
		$trad["application_simulation"]["nb_desires"] = "عدد الرغبات الأقصى";
		$trad["application_simulation"]["simul_method_enum"] = "طريقة المحاكاة";

		$trad["application_simulation"]["applicationList"] = "مشاهدة نتائج محاكاة التقديم";
		$trad["application_simulation"]["applicationDesireList"] = "مشاهدة نتائج محاكاة الرغبات";
		
		$trad["application_simulation"]["progress_task"] = "المهمة الحالية";
		$trad["application_simulation"]["progress_value"] = "تقدم التنفيذ";
		$trad["application_simulation"]["blocked_applicants_mfk"] = "المتقدمون المتعثرون";

		$trad["application_simulation"]["step_num"] = "رقم المرحلة";
		$trad["application_simulation"]["step_name"] = "المرحلة الحالية";
		$trad["application_simulation"]["nb"] = "العدد";
		$trad["application_simulation"]["example_applicant"] = "مثال 1";
		$trad["application_simulation"]["example_applicant2"] = "مثال 2";
		$trad["application_simulation"]["comments"] = "حالة التقديم وملاحظات";
		$trad["application_simulation"]["atype"] = "الوحدة";

		
		
		
	    // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicationSimulationEnTranslator();
		return new ApplicationSimulation();
	}
}