<?php

class ApplicationArTranslator{
    public static function initData()
    {
        $trad = [];
		$trad["application"]["step1"] = "المعلومات الأساسية";
		$trad["application"]["step2"] = "المسار العام";
		$trad["application"]["step3"] = "اختيار الرغبات";
		$trad["application"]["step4"] = "ترتيب الرغبات";
		$trad["application"]["step5"] = "بيانات المتقدم";
		$trad["application"]["step6"] = "القبول";

		$trad["application"]["assignedDesire"] = "الرغبة المسندة";
		$trad["application"]["application.single"] = "طلب تقديم";
		$trad["application"]["application.new"] = "جديد";
		$trad["application"]["application"] = "طلبات التقديم";

		$trad["application"]["applicant_id"] = "المتقدم";
		$trad["application"]["idn"] = "رقم هوية المتقدم";
		$trad["application"]["application_plan_id"] = "حملة التقديم";
		$trad["application"]["application_simulation_id"] = "نوع التقديم";
		$trad["application"]["application_model_id"] = "نموذج القبول";
		$trad["application"]["step_num"] = "رقم المرحلة الحالية";
		$trad["application"]["application_step_id"] = "المرحلة الحالية";
		$trad["application"]["current_fields_matrix"] = "حالة تحديث البيانات";
		$trad["application"]["applicantSimulationList"] = "نتيجة المحاكاة";

		$trad["application"]["needed_docs_available"] = "الوثائق المطلوبة متوفرة";
		

		$trad["application"]["applicationQualificationList"] = "المؤهلات المسموحة للتقديم";
		
		$trad["application"]["applicant_qualification_id"] = "مؤهل التقديم";
		$trad["application"]["application_status_enum"] = "حالة التقديم";
		$trad["application"]["comments"] = "ملاحظات"; 
		$trad["application"]["qualification_id"] = "المؤهل";
		$trad["application"]["major_category_id"] = "فئة التخصص";
		$trad["application"]["application_fees_paid"] = "رسوم التقديم مدفوعة";

		$trad["application"]["program_id"] = "البرنامج";
		$trad["application"]["sis_fields_available"] = "حقول sis متوفرة";
		$trad["application"]["nb_desires"] = "عدد الرغبات";
		$trad["application"]["applicationDesireList"] = "ترتيب الرغبات";
		$trad["application"]["training_period_enum"] = "فترة التدريب";
		$trad["application"]["application_plan_branch_mfk"] = "اختيار الرغبات";
		
		// $trad["application"]["satisfaction"] = "نسبة رضا العملاء";
		// $trad["application"]["tasks"] = "مهام بالانتظار";

		$trad["application"]["weighted_percentage"] = "النسبة الموزونة الحالية";
		$trad["application"]["weighted_percentage_details"] = "تفاصيل حساب النسبة الموزونة";
		$trad["application"]["weighted_pctg"] = "النسبة الموزونة المتقدم بها";

		$trad["application"]["applicant_decision_enum"] = "قرار المتقدم";
		
		$trad["application"]["sis_fields_not_available"] = "الحقول الغير متوفرة للترحيل لنظام بيانات الطالب";
		$trad["application"]["tafrigh_available"] = "لديه تفريغ من جهة العمل";
		
        return $trad;
    }

    public static function getInstance()
	{
		return new Application();
	}
}		