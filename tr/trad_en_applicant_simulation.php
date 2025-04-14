<?php

class ApplicantSimulationEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_simulation"]["applicantsimulation.single"] = "Applicant simulation";
		$trad["applicant_simulation"]["applicantsimulation.new"] = "new";
		$trad["applicant_simulation"]["applicant_simulation"] = "Applicant simulations";
		$trad["applicant_simulation"]["name_ar"] = "Arabic Applicant simulation name";
		$trad["applicant_simulation"]["desc_ar"] = "Arabic Applicant simulation description";
		$trad["applicant_simulation"]["name_en"] = "English Applicant simulation name";
		$trad["applicant_simulation"]["desc_en"] = "English Applicant simulation description";
		$trad["applicant_simulation"]["application_simulation"] = "Application simulation";
		$trad["applicant_simulation"]["applicant_id"] = "Applicant";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantSimulationArTranslator();
		return new ApplicantSimulation();
	}
}