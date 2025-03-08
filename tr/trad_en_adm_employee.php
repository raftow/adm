<?php

class AdmEmployeeEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["adm_employee"]["admemployee.single"] = "Adm employee";
		$trad["adm_employee"]["admemployee.new"] = "new";
		$trad["adm_employee"]["adm_employee"] = "Adm employees";
		$trad["adm_employee"]["email"] = "e-mail";
		$trad["adm_employee"]["employeeScopeList"] = "List of Employee scopes";

		$trad["adm_employee"]["firstname"] = "first name";
		$trad["adm_employee"]["lastname"] = "last name";

		$trad["adm_employee"]["firstname_en"] = "English first name";
		$trad["adm_employee"]["lastname_en"] = "English last name";

        // steps
		$trad["adm_employee"]["step1"] = "General infos";
		$trad["adm_employee"]["step2"] = "Work scope";
		// $trad["adm_employee"]["step3"] = "step3";
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new AdmEmployeeArTranslator();
		return new AdmEmployee();
	}
}