<?php

class AdmEmpRequestEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["adm_emp_request"]["admemprequest.single"] = "Adm emp request";
		$trad["adm_emp_request"]["admemprequest.new"] = "new";
		$trad["adm_emp_request"]["adm_emp_request"] = "Adm emp requests";
		$trad["adm_emp_request"]["email"] = "e-mail";
        // steps
		$trad["adm_emp_request"]["step1"] = "step1";
		$trad["adm_emp_request"]["step2"] = "step2";
		$trad["adm_emp_request"]["step3"] = "step3";
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new AdmEmpRequestArTranslator();
		return new AdmEmpRequest();
	}
}