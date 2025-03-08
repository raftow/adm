<?php

class EmployeeScopeEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["employee_scope"]["employeescope.single"] = "Employee scope";
		$trad["employee_scope"]["employeescope.new"] = "new";
		$trad["employee_scope"]["employee_scope"] = "Employee scopes";
		$trad["employee_scope"]["start_date"] = "Role start date";
		$trad["employee_scope"]["end_date"] = "Role end date";
		$trad["employee_scope"]["academic_level_id"] = "Academic level";
		$trad["employee_scope"]["application_model_id"] = "Application model";
		$trad["employee_scope"]["training_unit_type_id"] = "College";
		$trad["employee_scope"]["training_unit_id"] = "Training unit";
		$trad["employee_scope"]["adm_employee_id"] = "Adm employee";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new EmployeeScopeArTranslator();
		return new EmployeeScope();
	}
}