<?php

class AdmEmpRequestArTranslator{
    public static function initData()
    {
        $trad = [];	
        $trad["adm_emp_request"]["admemprequest.single"] = "طلب اضافة منسق قبول وتسجيل";
        $trad["adm_emp_request"]["admemprequest.single.short"] = "طلب اضافة منسق";
        $trad["adm_emp_request"]["admemprequest.new"] = "جديد";
        $trad["adm_emp_request"]["adm_emp_request"] = "طلبات اضافة منسقي القبول والتسجيل";
        $trad["adm_emp_request"]["adm_emp_request.short"] = "طلبات اضافة المنسقين";
        $trad["adm_emp_request"]["email"] = "البريد الالكتروني";
        $trad["adm_emp_request"]["orgunit_id"] = "الوحدة";
        $trad["adm_emp_request"]["adm_orgunit_id"] = "ادارة القبول والتسجيل";
        
        $trad["adm_emp_request"]["employee_id"] = "الموظف";


        $trad["adm_emp_request"]["active"] = "نشط";
        $trad["adm_emp_request"]["approved"] = "طلب مقبول؟"; 
        $trad["adm_emp_request"]["reject_reason"] = "سبب الرفض ";

        $trad["adm_emp_request"]["firstname"] = "الاسم الأول";
		$trad["adm_emp_request"]["lastname"] = "اسم العائلة";

		$trad["adm_emp_request"]["firstname_en"] = "الاسم الأول بالانجليزي";
		$trad["adm_emp_request"]["lastname_en"] = "اسم العائلة بالانجليزي";

        $trad["adm_emp_request"]["jobrole_mfk"] = "المهام الوظيفية";
        $trad["adm_emp_request"]["hierarchy_level_enum"] = "المستوى في الهيكل الوظيفي";

        $trad["adm_emp_request"]["step1"] = "بيانات التعريف";
        $trad["adm_emp_request"]["step2"] = "البيانات الشخصية";

        
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new AdmEmpRequestEnTranslator();
		return new AdmEmpRequest();
	}
}
    

    
	

	 
?>