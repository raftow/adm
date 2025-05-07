<?php

class SortingSessionStatEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sorting_session_stat"]["sortingsessionstat.single"] = "sorting session statistics row";
		$trad["sorting_session_stat"]["sortingsessionstat.new"] = "new";
		$trad["sorting_session_stat"]["sorting_session_stat"] = "sorting session statistics rows";
		$trad["sorting_session_stat"]["application_plan_id"] = "Application plan";
		$trad["sorting_session_stat"]["session_num"] = "Session num";
		$trad["sorting_session_stat"]["application_simulation_id"] = "Application simulation";
		$trad["sorting_session_stat"]["application_plan_branch_id"] = "Application plan branch";
		$trad["sorting_session_stat"]["capacity"] = "Capacity";
		$trad["sorting_session_stat"]["nb_accepted"] = "Nb candidates accepted";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SortingSessionStatArTranslator();
		return new SortingSessionStat();
	}
}