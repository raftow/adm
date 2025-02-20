<?php

class AdmEmpRequestEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["adm_emp_request"]["admemprequest.single"] = "Adm emp request";
		$trad["adm_emp_request"]["admemprequest.new"] = "new";
		$trad["adm_emp_request"]["adm_emp_request"] = "Adm emp requests";
		$trad["adm_emp_request"]["email"] = "e-mail";
        $trad["adm_emp_request"]["orgunit_id"] = "unit";
        $trad["adm_emp_request"]["adm_orgunit_id"] = "Admission and Registration Department";
        
        $trad["adm_emp_request"]["employee_id"] = "employee";


        $trad["adm_emp_request"]["active"] = "active";
        $trad["adm_emp_request"]["approved"] = "approved?"; 
        $trad["adm_emp_request"]["reject_reason"] = "reject reason";

        $trad["adm_emp_request"]["firstname"] = "first name";
		$trad["adm_emp_request"]["lastname"] = "last name";

		$trad["adm_emp_request"]["firstname_en"] = "English first name";
		$trad["adm_emp_request"]["lastname_en"] = "English last name";

        $trad["adm_emp_request"]["jobrole_mfk"] = "Job tasks";
        $trad["adm_emp_request"]["hierarchy_level_enum"] = "Level in the functional structure";

        $trad["adm_emp_request"]["step1"] = "Metadata";
        $trad["adm_emp_request"]["step2"] = "Personal data";
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new AdmEmpRequestArTranslator();
		return new AdmEmpRequest();
	}
}