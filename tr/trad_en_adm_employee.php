<?php

class AdmEmployeeEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["adm_employee"]["admemployee.single"] = "Adm employee";
		$trad["adm_employee"]["admemployee.new"] = "new";
		$trad["adm_employee"]["adm_employee"] = "Adm employees";
		$trad["adm_employee"]["email"] = "e-mail";
        // steps
		$trad["adm_employee"]["step1"] = "step1";
		$trad["adm_employee"]["step2"] = "step2";
		$trad["adm_employee"]["step3"] = "step3";
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new AdmEmployeeArTranslator();
		return new AdmEmployee();
	}
}