<?php

class SortingGroupEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sorting_group"]["sortinggroup.single"] = "Sorting group";
		$trad["sorting_group"]["sortinggroup.new"] = "new";
		$trad["sorting_group"]["sorting_group"] = "Sorting groups";
		$trad["sorting_group"]["name_ar"] = "Arabic Sorting group name";
		$trad["sorting_group"]["desc_ar"] = "Arabic Sorting group description";
		$trad["sorting_group"]["name_en"] = "English Sorting group name";
		$trad["sorting_group"]["desc_en"] = "English Sorting group description";
		$trad["sorting_group"]["sorting_field_1_id"] = "Sorting criteria 1";
		$trad["sorting_group"]["sorting_field_2_id"] = "Sorting criteria 2";
		$trad["sorting_group"]["sorting_field_3_id"] = "Sorting criteria 3";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SortingGroupArTranslator();
		return new SortingGroup();
	}
}