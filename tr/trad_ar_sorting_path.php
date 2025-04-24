<?php

class SortingPathArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sorting_path"]["sortingpath.single"] = "إعداد مسار فرز";
		$trad["sorting_path"]["sortingpath.new"] = "جديد";
		$trad["sorting_path"]["sorting_path"] = "إعدادات مسارات الفرز";
		$trad["sorting_path"]["name_ar"] = "مسمى  بالعربية";
		$trad["sorting_path"]["desc_ar"] = "وصف  بالعربية";
		$trad["sorting_path"]["name_en"] = "مسمى بالانجليزية";
		$trad["sorting_path"]["desc_en"] = "وصف بالانجليزية";
		$trad["sorting_path"]["short_name_ar"] = "مسمى مختصر بالعربية";
		$trad["sorting_path"]["short_name_en"] = "مسمى مختصر بالانجليزية";
		$trad["sorting_path"]["sorting_num"] = "رقم المسار";
		$trad["sorting_path"]["path"] = "المسار";
		
		$trad["sorting_path"]["sorting_path_code"] = "رمز المسار";
		$trad["sorting_path"]["capacity_pct"] = "نسبة الطاقة الاستيعابية";
		$trad["sorting_path"]["application_model_id"] = "نموذج التقديم";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SortingPathEnTranslator();
		return new SortingPath();
	}
}