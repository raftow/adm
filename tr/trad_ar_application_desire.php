<?php

class ApplicationDesireArTranslator{
    public static function initData()
    {
        $trad = [];
		

		$trad["application_desire"]["applicationdesire.single"] = "رغبة متقدم";
		$trad["application_desire"]["applicationdesire.new"] = "جديدة";
		$trad["application_desire"]["application_desire"] = "رغبات المتقدمين";

		$trad["application_desire"]["idn"] = "رقم هوية المتقدم";
		$trad["application_desire"]["applicant_id"] = "المتقدم";
		$trad["application_desire"]["application_plan_id"] = "حملة التقديم";
		$trad["application_desire"]["application_simulation_id"] = "نوع التقديم";
		$trad["application_desire"]["application_plan_branch_id"] = "فرع التقديم";
		$trad["application_desire"]["application_id"] = "ملف التقديم";
		$trad["application_desire"]["step_num"] = "رقم المرحلة";
		$trad["application_desire"]["application_step_id"] = "المرحلة الحالية";
		$trad["application_desire"]["desire_status_enum"] = "حالة الرغبة";
		$trad["application_desire"]["applicant_qualification_id"] = "مؤهل المتقدم";
		$trad["application_desire"]["qualification_id"] = "المؤهل";
		$trad["application_desire"]["major_category_id"] = "فئة التخصص";
		$trad["application_desire"]["health_ind"] = "لائق طبيا";    
		$trad["application_desire"]["desire_num"] = "ترتيب الرغبة"; 
		$trad["application_desire"]["comments"] = "ملاحظات";    

		$trad["application_desire"]["sorting_field_1_id"] = "معيار الفرز 1";    
		$trad["application_desire"]["sorting_field_2_id"] = "معيار الفرز 2";    
		$trad["application_desire"]["sorting_field_3_id"] = "معيار الفرز 3";    

		$trad["application_desire"]["sorting_value_1"] = "قيمة معيار الفرز 1";    
		$trad["application_desire"]["sorting_value_2"] = "قيمة معيار الفرز 2";    
		$trad["application_desire"]["sorting_value_3"] = "قيمة معيار الفرز 3";    

		 
		$trad["application_desire"]["training_unit_id"] = "المنشأة التدريبية";  
		$trad["application_desire"]["academic_level_id"] = "المرحلة الاكاديمية";
		$trad["application_desire"]["application_model_id"] = "نموذج القبول";
		$trad["application_desire"]["application_model_branch_id"] = "فرع القبول";
		$trad["application_desire"]["training_unit_type_id"] = "الكلية";
		$trad["application_desire"]["gender_enum"] = "الجنس";
		$trad["application_desire"]["sorting_group_id"] = "مجموعة الفرز";

		$trad["application_desire"]["weighted_percentage"] = "النسبة الموزونة";
		$trad["application_desire"]["weighted_percentage_details"] = "تفاصيل حساب النسبة الموزونة";

		$trad["application_desire"]["current_fields_matrix"] = "حالة تحديث البيانات";
		$trad["application_desire"]["applicationConditionExecList"] = "تطبيق الشروط";

		$trad["application_desire"]["step1"] = "التعريف بالرغبة";
		$trad["application_desire"]["step2"] = "البيانات";
		$trad["application_desire"]["step3"] = "حالة التقديم";
		$trad["application_desire"]["step4"] = "تطبيق الشروط";
		$trad["application_desire"]["step5"] = "الفرز والقبول";
		
		return $trad;
    }

    public static function getInstance()
	{
		return new ApplicationDesire();
	}
}