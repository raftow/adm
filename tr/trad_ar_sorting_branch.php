<?php

class SortingBranchArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sorting_branch"]["sortingbranch.single"] = "مسار فرز";
		$trad["sorting_branch"]["sortingbranch.new"] = "جديد(ة)";
		$trad["sorting_branch"]["sorting_branch"] = "مسارات الفرز";
		$trad["sorting_branch"]["name_ar"] = "مسمى  بالعربية";
		$trad["sorting_branch"]["desc_ar"] = "وصف  بالعربية";
		$trad["sorting_branch"]["name_en"] = "مسمى  بالانجليزية";
		$trad["sorting_branch"]["desc_en"] = "وصف  بالانجليزية";
		$trad["sorting_branch"]["sorting_branch_code"] = "رمز المسار";
		$trad["sorting_branch"]["capacity"] = "الطاقة الاستيعابية";
		$trad["sorting_branch"]["application_plan_branch_id"] = "فرع التقديم";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SortingBranchEnTranslator();
		return new SortingBranch();
	}
}