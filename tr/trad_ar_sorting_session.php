<?php

class SortingSessionArTranslator{
    public static function initData()
    {
        $trad = [];
		$trad["sorting_session"]["step1"] = "معلومات أساسية";
		$trad["sorting_session"]["step2"] = "إعدادات الفرز";
		$trad["sorting_session"]["step3"] = "مؤشرات الجاهزية";
		$trad["sorting_session"]["step5"] = "الاعتماد والنشر";
		$trad["sorting_session"]["step4"] = "لوحة التحكم";
		
		// $trad["sorting_session"]["controlPanel"] = "";
		$trad["sorting_session"]["sortingsession.single"] = "تنفيذ فرز";
		$trad["sorting_session"]["sortingsession.new"] = "جديد";
		$trad["sorting_session"]["sorting_session"] = "إدارة الفرز";
		$trad["sorting_session"]["name_ar"] = "مسمى  بالعربية";
		$trad["sorting_session"]["name_en"] = "مسمى  بالانجليزية";
		$trad["sorting_session"]["application_plan_id"] = "خطة التقديم";
		$trad["sorting_session"]["session_num"] = "رقم الفرز";
		$trad["sorting_session"]["start_date"] = "بداية الفرز";
		$trad["sorting_session"]["end_date"] = "نهاية الفرز";
		$trad["sorting_session"]["validated"] = "تم الاعتماد";
		$trad["sorting_session"]["validate_date"] = "تاريخ الاعتماد";
		
		$trad["sorting_session"]["published"] = "تم النشر";
		$trad["sorting_session"]["publish_date"] = "تاريخ نشر النتائج";
		
		$trad["sorting_session"]["upgraded"] = "تم فرز الترقية";
		$trad["sorting_session"]["last_approve_date"] = "آخر أجل لتأكيد القبول";
		$trad["sorting_session"]["application_ongoing"] = "حالة التقديم"; 
		$trad["sorting_session"]["application_ongoing.YES"] = "جارية"; 
		$trad["sorting_session"]["application_ongoing.NO"] = "متوقفة"; 
		$trad["sorting_session"]["application_ongoing.EUH"] = "البيانات تحت المراجعة"; 
		$trad["sorting_session"]["nb_desires"] = "عدد المترشحين لهذا الفرز";
		$trad["sorting_session"]["application_simulation_id"] = "الفرز على";
		$trad["sorting_session"]["sortingGroupList"] = "مجموعات الفرز";
		$trad["sorting_session"]["sorting group stats"] = "الاحصائيات حسب مجموعات الفرز";
		$trad["sorting_session"]["sorting path stats"] = "الاحصائيات حسب مسارات الفرز";
		
		$trad["sorting_session"]["started_ind"] = "بدأ الفرز";
		$trad["sorting_session"]["statList"] = "احصائيات الفرز";

		$trad["sorting_session"]["applicant_id"] = "رقم تسلسلي تحت المراقبة";

		$trad["sorting_session"]["settings"] = "إعدادات الفرز";
		$trad["sorting_session"]["desires_nb"] = "عدد الترشحات";
		$trad["sorting_session"]["applicants_nb"] = "عدد المتقدمين";
		$trad["sorting_session"]["errors_nb"] = "عدد الأخطاء";
		$trad["sorting_session"]["data_date"] = "تاريخ البيانات";
		$trad["sorting_session"]["stats_date"] = "تاريخ المؤشرات";
		$trad["sorting_session"]["sorting_ready"] = "جاهزية الفرز";
		$trad["sorting_session"]["sorting_ready.YES"] = "جاهز"; 
		$trad["sorting_session"]["sorting_ready.NO"] = "غير جاهز"; 
		$trad["sorting_session"]["sorting_ready.EUH"] = "غير جاهز"; 
		$trad["sorting_session"]["sorting_ready_details"] = "سبب عدم جاهزية الفرز";

		

		// steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SortingSessionEnTranslator();
		return new SortingSession();
	}
}