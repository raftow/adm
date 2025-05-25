<?php

class SortingSessionEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sorting_session"]["step1"] = "Basic information";
		$trad["sorting_session"]["step2"] = "The sorting";
		$trad["sorting_session"]["step3"] = "Validation & Publish";

		$trad["sorting_session"]["sortingsession.single"] = "sorting sessions";
		$trad["sorting_session"]["sortingsession.new"] = "new";
		$trad["sorting_session"]["sorting_session"] = "sorting session";
		$trad["sorting_session"]["name_ar"] = "Arabic Sorting session name";
		$trad["sorting_session"]["desc_ar"] = "Arabic Sorting session description";
		$trad["sorting_session"]["name_en"] = "English Sorting session name";
		$trad["sorting_session"]["desc_en"] = "English Sorting session description";
		$trad["sorting_session"]["application_plan_id"] = "Application plan";
		$trad["sorting_session"]["session_num"] = "Session num";
		$trad["sorting_session"]["sortingGroupList"] = "Sorting Group List";

		$trad["sorting_session"]["started_ind"] = "Sorting has started";
		$trad["sorting_session"]["applicant_id"] = "Applicant IDN for audit";  
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SortingSessionArTranslator();
		return new SortingSession();
	}
}