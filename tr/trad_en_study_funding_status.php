<?php

class StudyFundingStatusEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["study_funding_status"]["studyfundingstatus.single"] = "حالة";
		$trad["study_funding_status"]["studyfundingstatus.new"] = "new";
		$trad["study_funding_status"]["study_funding_status"] = "الدراسة";
		$trad["study_funding_status"]["name_ar"] = "Arabic Study funding status name";
		$trad["study_funding_status"]["desc_ar"] = "Arabic Study funding status description";
		$trad["study_funding_status"]["name_en"] = "English Study funding status name";
		$trad["study_funding_status"]["desc_en"] = "English Study funding status description";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new StudyFundingStatusArTranslator();
		return new StudyFundingStatus();
	}
}