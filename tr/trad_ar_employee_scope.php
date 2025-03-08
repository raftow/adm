<?php

class EmployeeScopeArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["employee_scope"]["employeescope.single"] = "مجال عمل";
		$trad["employee_scope"]["employeescope.new"] = "جديد(ة)";
		$trad["employee_scope"]["employee_scope"] = "مجالات عمل الموظف";
		$trad["employee_scope"]["start_date"] = "تاريخ بداية الصلاحية";
		$trad["employee_scope"]["end_date"] = "تاريخ نهاية الصلاحية";
		$trad["employee_scope"]["academic_level_id"] = "مرحلة الاكاديمية";
		$trad["employee_scope"]["application_model_id"] = "نموذج القبول";
		$trad["employee_scope"]["training_unit_type_id"] = "الكلية";
		$trad["employee_scope"]["training_unit_id"] = "منشاة التدريبية";
		$trad["employee_scope"]["adm_employee_id"] = "منسق قبول وتسجيل";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new EmployeeScopeEnTranslator();
		return new EmployeeScope();
	}
}