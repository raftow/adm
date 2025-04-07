<?php

class SortingGroupArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sorting_group"]["sortinggroup.single"] = "مجموعة فرز";
		$trad["sorting_group"]["sortinggroup.new"] = "جديد(ة)";
		$trad["sorting_group"]["sorting_group"] = "مجموعات الفرز";
		$trad["sorting_group"]["name_ar"] = "مسمى  بالعربية";
		$trad["sorting_group"]["desc_ar"] = "وصف  بالعربية";
		$trad["sorting_group"]["name_en"] = "مسمى  بالانجليزية";
		$trad["sorting_group"]["desc_en"] = "وصف  بالانجليزية";
		$trad["sorting_group"]["sorting_fields"] = "معايير الفرز";
		$trad["sorting_group"]["sorting_field_1_id"] = "معيار الفرز 1";
		$trad["sorting_group"]["sorting_field_2_id"] = "معيار الفرز 2";
		$trad["sorting_group"]["sorting_field_3_id"] = "معيار الفرز 3";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SortingGroupEnTranslator();
		return new SortingGroup();
	}
}