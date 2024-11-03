<?php

class ApplicationArTranslator{
    public static function initData()
    {
        $trad = [];
		$trad["application"]["step1"] = "بيانات التقديم";
		$trad["application"]["step2"] = "المسار العام";
		$trad["application"]["step3"] = "اختيار الرغبات";
		$trad["application"]["step4"] = "معلومات فنية";
		$trad["application"]["step5"] = "معلومات متقدمة";

		$trad["application"]["application.single"] = "طلب تقديم";
		$trad["application"]["application.new"] = "جديد";
		$trad["application"]["application"] = "طلبات التقديم";

		$trad["application"]["applicant_id"] = "المتقدم";
		$trad["application"]["application_plan_id"] = "حملة التقديم";
		$trad["application"]["application_model_id"] = "نموذج القبول";
		$trad["application"]["step_num"] = "رقم المرحلة الحالية";
		$trad["application"]["application_step_id"] = "مسمى المرحلة الحالية";
		$trad["application"]["current_fields_matrix"] = "حالة تحديث البيانات";
		
		$trad["application"]["applicant_qualification_id"] = "مؤهل التقديم";
		$trad["application"]["application_status_enum"] = "حالة التقديم";
		$trad["application"]["qualification_id"] = "المؤهل";
		$trad["application"]["major_category_id"] = "فئة التخصص";


		$trad["application"]["program_id"] = "البرنامج";
		$trad["application"]["sis_fields_available"] = "حقول sis متوفرة";
		$trad["application"]["nb_desires"] = "عدد الرغبات";
		
		
        return $trad;
    }

    public static function getInstance()
	{
		return new Application();
	}
}		