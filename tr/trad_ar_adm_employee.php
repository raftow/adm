<?php

class AdmEmployeeArTranslator{
    public static function initData()
    {
        $trad = [];	
        $trad["adm_employee"]["admemployee.single"] = "منسق قبول وتسجيل";
        $trad["adm_employee"]["admemployee.single.short"] = "منسق";
        $trad["adm_employee"]["admemployee.new"] = "جديد";
        $trad["adm_employee"]["adm_employee"] = "منسقي القبول والتسجيل";
        $trad["adm_employee"]["adm_employee.short"] = "المنسقين";
        $trad["adm_employee"]["orgunit_id"] = "إدارة القبول والتسجيل";
        $trad["adm_employee"]["adm_orgunit_id"] = "الإدارة التابع لها";


        $trad["adm_employee"]["firstname"] = "الاسم الأول";
		$trad["adm_employee"]["lastname"] = "اسم العائلة";

		$trad["adm_employee"]["firstname_en"] = "الاسم الأول بالانجليزي";
		$trad["adm_employee"]["lastname_en"] = "اسم العائلة بالانجليزي";
        
        // $trad["adm_employee"]["service_category_mfk"] = "المسؤوليات المناطة به";
        // $trad["adm_employee"]["service_category_mfk_tooltip"] = "أصناف الخدمات  التي يقدمها";
        // $trad["adm_employee"]["service_mfk"] = "الخدمات التي يقدمها";
        // $trad["adm_employee"]["requests_nb"] = "طاقة استيعاب الملفات يوميا";
        $trad["adm_employee"]["employee_id"] = "الموظف";

        $trad["adm_employee"]["ongoing_requests_count"] = "عدد الملفات الجاري العمل عليها";
        $trad["adm_employee"]["done_requests_count"] = "عدد الملفات التي تم التحقيق عليها";
        $trad["adm_employee"]["requests_count"] = "مجموع عدد الملفات المسندة";
        $trad["adm_employee"]["statif_pct"] = "نسبة رضا المتقدم";


        $trad["adm_employee"]["ongoing_requests_count.short"] = "الجاري";
        $trad["adm_employee"]["done_requests_count.short"] = "تم التحقيق";
        $trad["adm_employee"]["requests_count.short"] = "المسند";
        $trad["adm_employee"]["statif_pct.short"] = "رضا المتقدم";
        

        $trad["adm_employee"]["assignedRequests"] = "الملفات المسندة";
        $trad["adm_employee"]["currentRequests"] = "الملفات الحالية";
        $trad["adm_employee"]["finishedRequests"] = "الملفات المنتهية";
        $trad["adm_employee"]["allOrgunitList"] = "إدارات القبول والتسجيل التي يعمل معها";


        $trad["adm_employee"]["active"] = "نشط";
        $trad["adm_employee"]["admin"] = "مشرف تنسيق";
        $trad["adm_employee"]["super_admin"] = "مشرف عام";
        $trad["adm_employee"]["approved"] = "منسق معتمد"; 
        $trad["adm_employee"]["employeeScopeList"] = "قائمة مجالات عمل الموظف";


        $trad["adm_employee"]["step1"] = "البيانات العامة";
        $trad["adm_employee"]["step2"] = "مجالات العمل";
        // $trad["adm_employee"]["step3"] = "الملفات المسندة";
    
        return $trad;
    }

    public static function getInstance()
	{
		return new AdmEmployee();
	}
}
    

    
	

	 
?>