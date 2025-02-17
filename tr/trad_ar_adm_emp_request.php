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
        $trad["adm_emp_request"]["orgunit_id"] = "الجهة المتابعة";
        $trad["adm_emp_request"]["adm_orgunit_id"] = "الجهة التابع لها";
        
        $trad["adm_emp_request"]["employee_id"] = "الموظف";


        $trad["adm_emp_request"]["active"] = "نشط";
        $trad["adm_emp_request"]["approved"] = "طلب مقبول"; 
        $trad["adm_emp_request"]["reject_reason_ar"] = "سبب الرفض بالعربية";
        $trad["adm_emp_request"]["reject_reason_en"] = "سبب الرفض بالانجليزية";
        $trad["adm_emp_request"]["step1"] = "البيانات العامة";
        $trad["adm_emp_request"]["step2"] = "الطلبات المسندة";
        $trad["adm_emp_request"]["step3"] = "جهات المتابعة";
    
        return $trad;
    }

    public static function getInstance()
	{
		return new AdmEmpRequest();
	}
}
    

    
	

	 
?>