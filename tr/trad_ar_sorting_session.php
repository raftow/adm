<?php

class SortingSessionArTranslator{
    public static function initData()
    {
        $trad = [];
		$trad["sorting_session"]["step1"] = "معلومات أساسية";
		$trad["sorting_session"]["step2"] = "عملية الفرز";
		$trad["sorting_session"]["step3"] = "الاعتماد والنشر";
		
		$trad["sorting_session"]["sortingsession.single"] = "كرة فرز";
		$trad["sorting_session"]["sortingsession.new"] = "جديدة";
		$trad["sorting_session"]["sorting_session"] = "كرات فرز";
		$trad["sorting_session"]["name_ar"] = "مسمى  بالعربية";
		$trad["sorting_session"]["name_en"] = "مسمى  بالانجليزية";
		$trad["sorting_session"]["application_plan_id"] = "خطة التقديم";
		$trad["sorting_session"]["session_num"] = "كرة الفرز";
		$trad["sorting_session"]["start_date"] = "بداية الفرز";
		$trad["sorting_session"]["end_date"] = "نهاية الفرز";
		$trad["sorting_session"]["validated"] = "تم الاعتماد";
		$trad["sorting_session"]["validate_date"] = "تاريخ الاعتماد";
		
		$trad["sorting_session"]["published"] = "تم النشر";
		$trad["sorting_session"]["publish_date"] = "تاريخ نشر النتائج";
		
		$trad["sorting_session"]["upgraded"] = "تم فرز الترقية";
		$trad["sorting_session"]["last_approve_date"] = "آخر أجل لتأكيد القبول";
		 
		$trad["sorting_session"]["nb_desires"] = "عدد المترشحين لكرة الفرز";
		$trad["sorting_session"]["application_simulation_id"] = "الفرز على";
		$trad["sorting_session"]["sortingGroupList"] = "مجموعات الفرز";
		
		
		
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SortingSessionEnTranslator();
		return new SortingSession();
	}
}