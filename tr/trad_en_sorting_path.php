<?php

class SortingPathEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sorting_path"]["sortingpath.single"] = "Sorting branch";
		$trad["sorting_path"]["sortingpath.new"] = "new";
		$trad["sorting_path"]["sorting_path"] = "Sorting branchs";
		$trad["sorting_path"]["name_ar"] = "Arabic Sorting branch name";
		$trad["sorting_path"]["desc_ar"] = "Arabic Sorting branch description";
		$trad["sorting_path"]["name_en"] = "English Sorting branch name";
		$trad["sorting_path"]["desc_en"] = "English Sorting branch description";
		$trad["sorting_path"]["sorting_path_code"] = "Sorting branch code";
		$trad["sorting_path"]["capacity_pct"] = "Capacity percentage";
		$trad["sorting_path"]["application_model_id"] = "Application plan branch";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SortingPathArTranslator();
		return new SortingPath();
	}
}