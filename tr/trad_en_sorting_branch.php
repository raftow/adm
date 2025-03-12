<?php

class SortingBranchEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sorting_branch"]["sortingbranch.single"] = "Sorting branch";
		$trad["sorting_branch"]["sortingbranch.new"] = "new";
		$trad["sorting_branch"]["sorting_branch"] = "Sorting branchs";
		$trad["sorting_branch"]["name_ar"] = "Arabic Sorting branch name";
		$trad["sorting_branch"]["desc_ar"] = "Arabic Sorting branch description";
		$trad["sorting_branch"]["name_en"] = "English Sorting branch name";
		$trad["sorting_branch"]["desc_en"] = "English Sorting branch description";
		$trad["sorting_branch"]["sorting_branch_code"] = "Sorting branch code";
		$trad["sorting_branch"]["capacity"] = "Capacity";
		$trad["sorting_branch"]["application_plan_branch_id"] = "Application plan branch";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SortingBranchArTranslator();
		return new SortingBranch();
	}
}