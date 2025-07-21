<?php

class ApplicationDesireEnTranslator{
    public static function initData()
    {
        $trad = [];	
		

		$trad["application_desire"]["applicationdesire.single"] = "Application desire";
		$trad["application_desire"]["applicationdesire.new"] = "new";
		$trad["application_desire"]["application_desire"] = "Application desires";

		$trad["application_desire"]["applicant_id"] = "applicant";
		$trad["application_desire"]["application_plan_id"] = "application plan";
		$trad["application_desire"]["application_simulation_id"] = "application type";
		$trad["application_desire"]["application_plan_branch_id"] = "application plan branch";
		$trad["application_desire"]["step_num"] = "step number";
		$trad["application_desire"]["application_step_id"] = "step id";
		$trad["application_desire"]["desire_status_enum"] = "desire status";
		$trad["application_desire"]["applicant_qualification_id"] = "applicant qualification id";
		$trad["application_desire"]["qualification_id"] = "qualification id";
		$trad["application_desire"]["major_category_id"] = "major cathegory id";

		$trad["application_desire"]["applicationConditionExecList"] = "Conditions Applied";

		$trad["application_desire"]["step1"] = "Desire definition";
		$trad["application_desire"]["step2"] = "Data";
		$trad["application_desire"]["step3"] = "Conditions Applied";

		return $trad;
    }

    public static function getInstance()
	{
		return new ApplicationDesire();
	}
}