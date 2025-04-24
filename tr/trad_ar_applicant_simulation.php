<?php

class ApplicantSimulationArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_simulation"]["applicantsimulation.single"] = "applicant simulation";
		$trad["applicant_simulation"]["applicantsimulation.new"] = "جديد(ة)";
		$trad["applicant_simulation"]["applicant_simulation"] = "محاكاة متقدم";
		$trad["applicant_simulation"]["name_ar"] = "مسمى  بالعربية";
		$trad["applicant_simulation"]["desc_ar"] = "وصف  بالعربية";
		$trad["applicant_simulation"]["name_en"] = "مسمى  بالانجليزية";
		$trad["applicant_simulation"]["desc_en"] = "وصف  بالانجليزية";
		$trad["applicant_simulation"]["applicant_id"] = "المتقدم";
		$trad["applicant_simulation"]["done"] = "تم الانتهاء ؟";
		$trad["applicant_simulation"]["blocked_reason"] = "سبب التعثر";
		
		
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantSimulationEnTranslator();
		return new ApplicantSimulation();
	}
}