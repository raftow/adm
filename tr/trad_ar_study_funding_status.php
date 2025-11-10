<?php

class StudyFundingStatusArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["study_funding_status"]["studyfundingstatus.single"] = "حالة تمويل الدراسة";
		$trad["study_funding_status"]["studyfundingstatus.new"] = "جديد(ة)";
		$trad["study_funding_status"]["study_funding_status"] = "حالات تمويل الدراسة";
		$trad["study_funding_status"]["name_ar"] = "مسمى  بالعربية";
		$trad["study_funding_status"]["desc_ar"] = "وصف  بالعربية";
		$trad["study_funding_status"]["name_en"] = "مسمى  بالانجليزية";
		$trad["study_funding_status"]["desc_en"] = "وصف  بالانجليزية";
		$trad["study_funding_status"]["payment_ind"] = "مؤشر الدفع";
		
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new StudyFundingStatusEnTranslator();
		return new StudyFundingStatus();
	}
}