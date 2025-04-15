<?php

class ApplicationSimulationEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["application_simulation"]["step1"] = "Simulation Details";    
		$trad["application_simulation"]["step2"] = "Simulation Settings";   
		$trad["application_simulation"]["step3"] = "Simulation Execution";
		$trad["application_simulation"]["step4"] = "Simulation Logs";
		$trad["application_simulation"]["step5"] = "Simulation Results";

		$trad["application_simulation"]["applicationsimulation.single"] = "Application simulation";
		$trad["application_simulation"]["applicationsimulation.new"] = "new";
		$trad["application_simulation"]["application_simulation"] = "Application simulations";
		$trad["application_simulation"]["name_ar"] = "Arabic Application simulation name";
		$trad["application_simulation"]["desc_ar"] = "Arabic Application simulation description";
		$trad["application_simulation"]["name_en"] = "English Application simulation name";
		$trad["application_simulation"]["desc_en"] = "English Application simulation description";
		$trad["application_simulation"]["application_model_id"] = "Application model";
		$trad["application_simulation"]["application_plan_id"] = "Application plan";
		$trad["application_simulation"]["applicant_group_id"] = "Applicant group";
		$trad["application_simulation"]["application_model_branch_mfk"] = "Selected branches";
		$trad["application_simulation"]["nb_desires"] = "Number of desires";
		$trad["application_simulation"]["simul_method_enum"] = "Simulation method";
		$trad["application_simulation"]["progress_task"] = "Progress task";
		$trad["application_simulation"]["progress_value"] = "Progress value";
		$trad["application_simulation"]["blocked_applicants_mfk"] = "Blocked applicants";

        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicationSimulationArTranslator();
		return new ApplicationSimulation();
	}
}