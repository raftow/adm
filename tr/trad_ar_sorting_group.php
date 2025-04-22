<?php

class SortingGroupArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sorting_group"]["step1"] = "تعريف المجموعة";
		$trad["sorting_group"]["step2"] = "حقول الخوارزمية";


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

		$trad["sorting_group"]["field1_sorting_sens_enum"] = "اتجاه معيار الفرز 1";
		$trad["sorting_group"]["field2_sorting_sens_enum"] = "اتجاه معيار الفرز 2";
		$trad["sorting_group"]["field3_sorting_sens_enum"] = "اتجاه معيار الفرز 3";


		$trad["sorting_group"]["formula_field_1_id"] = "الخوارزمية - حقل 1";
		$trad["sorting_group"]["formula_field_2_id"] = "الخوارزمية - حقل 2";
		$trad["sorting_group"]["formula_field_3_id"] = "الخوارزمية - حقل 3";
		$trad["sorting_group"]["formula_field_4_id"] = "الخوارزمية - حقل 4";
		$trad["sorting_group"]["formula_field_5_id"] = "الخوارزمية - حقل 5";
		$trad["sorting_group"]["formula_field_6_id"] = "الخوارزمية - حقل 6";
		$trad["sorting_group"]["formula_field_7_id"] = "الخوارزمية - حقل 7";
		$trad["sorting_group"]["formula_field_8_id"] = "الخوارزمية - حقل 8";
		$trad["sorting_group"]["formula_field_9_id"] = "الخوارزمية - حقل 9";

        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SortingGroupEnTranslator();
		return new SortingGroup();
	}
}