<?php

class AdmOrgunitEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["adm_orgunit"]["admorgunit.single"] = "Adm orgunit";
		$trad["adm_orgunit"]["admorgunit.new"] = "new";
		$trad["adm_orgunit"]["adm_orgunit"] = "Adm orgunits";
        // steps
		$trad["adm_orgunit"]["step1"] = "step1";
		$trad["adm_orgunit"]["step2"] = "step2";
		$trad["adm_orgunit"]["step3"] = "step3";
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new AdmOrgunitArTranslator();
		return new AdmOrgunit();
	}
}