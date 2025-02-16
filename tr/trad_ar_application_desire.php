<?php

class ApplicationDesireArTranslator{
    public static function initData()
    {
        $trad = [];
		

		$trad["application_desire"]["applicationdesire.single"] = "رغبة متقدم";
		$trad["application_desire"]["applicationdesire.new"] = "جديدة";
		$trad["application_desire"]["application_desire"] = "رغبات المتقدمين";

		$trad["application_desire"]["applicant_id"] = "المتفدم";
		$trad["application_desire"]["application_plan_id"] = "حملة التقديم";
		$trad["application_desire"]["application_plan_branch_id"] = "فرع التقديم";
		$trad["application_desire"]["application_id"] = "التقديم";
		$trad["application_desire"]["step_num"] = "رقم المرحلة";
		$trad["application_desire"]["application_step_id"] = "معرف المرحلة";
		$trad["application_desire"]["desire_status_enum"] = "حالة الرغبة";
		$trad["application_desire"]["applicant_qualification_id"] = "مؤهل المتقدم";
		$trad["application_desire"]["qualification_id"] = "المؤهل";
		$trad["application_desire"]["major_category_id"] = "فئة التخصص";
		$trad["application_desire"]["health_ind"] = "لائق طبيا";    
		$trad["application_desire"]["desire_num"] = "ترتيب الرغبة"; 
		$trad["application_desire"]["comments"] = "ملاحظات";     
		  

		$trad["application_desire"]["weighted_percentage"] = "النسبة الموزونة";
		$trad["application_desire"]["weighted_percentage_details"] = "تفاصيل حساب النسبة الموزونة";

		$trad["application_desire"]["current_fields_matrix"] = "حالة تحديث البيانات";
		$trad["application_desire"]["applicationConditionExecList"] = "تطبيق الشروط";

		$trad["application_desire"]["step1"] = "التعريف بالرغبة";
		$trad["application_desire"]["step2"] = "البيانات";
		$trad["application_desire"]["step3"] = "تطبيق الشروط";
		
		return $trad;
    }

    public static function getInstance()
	{
		return new ApplicationDesire();
	}
}