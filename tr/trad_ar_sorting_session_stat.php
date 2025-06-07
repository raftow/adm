<?php

class SortingSessionStatArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sorting_session_stat"]["sortingsessionstat.single"] = "سطر احصائية تنفيذ الفرز";
		$trad["sorting_session_stat"]["sortingsessionstat.new"] = "جديد(ة)";
		$trad["sorting_session_stat"]["sorting_session_stat"] = "سطور احصائية تنفيذ الفرز";
		$trad["sorting_session_stat"]["application_plan_id"] = "خطة التقديم";
		$trad["sorting_session_stat"]["session_num"] = "رقم الفرز";
		$trad["sorting_session_stat"]["application_simulation_id"] = "نوع تقديم";
		$trad["sorting_session_stat"]["application_plan_branch_id"] = "فرع التقديم";
		$trad["sorting_session_stat"]["track_num"] = "مسار الفرز";
		$trad["sorting_session_stat"]["original_capacity"] = "الطاقة الاستيعابية الأصلية";
		$trad["sorting_session_stat"]["capacity"] = "الطاقة الاستيعابية النهائية";
		$trad["sorting_session_stat"]["capacity_history"] = "التعديل على الطاقة";
		$trad["sorting_session_stat"]["nb_accepted"] = "عدد المقبولين";
		$trad["sorting_session_stat"]["free"] = "مقاعد شاغرة";
		$trad["sorting_session_stat"]["execo"] = "متساوين";
		$trad["sorting_session_stat"]["branch_order"] = "ترتيب";
		
		$trad["sorting_session_stat"]["execo_action"] = "قرار المتساوين";

		$trad["sorting_session_stat"]["waiting"] = "قائمة انتظار";
		$trad["sorting_session_stat"]["wp_recommended"] = "الحد الأدنى المُستَحسَن";

		

		$trad["sorting_session_stat"]["step1"] = "نتائج الفرز";
		$trad["sorting_session_stat"]["step2"] = "المقبولين مبدئيا";
		$trad["sorting_session_stat"]["farz-branch"] = "الفرع المعني بالفرز";
		$trad["sorting_session_stat"]["scores"] = "نتائج الفرز";

		$trad["sorting_session_stat"]["min_weighted_percentage"] = "الحد الأدنى للتقديم";

		$trad["sorting_session_stat"]["cond_weighted_percentage"] = "الحد الأدنى للقبول";
		

		$trad["sorting_session_stat"]["min_acc_score1"] = "نسبة القبول الدنيا";
		$trad["sorting_session_stat"]["min_acc_score2"] = "نسبة القبول الدنيا 2";
		$trad["sorting_session_stat"]["min_acc_score3"] = "نسبة القبول الدنيا 3";
		
		$trad["sorting_session_stat"]["min_app_score1"] = "نسبة التقديم الدنيا";
		$trad["sorting_session_stat"]["min_app_score2"] = "نسبة التقديم الدنيا 2";
		$trad["sorting_session_stat"]["min_app_score3"] = "نسبة التقديم الدنيا 3";


		$trad["sorting_session_stat"]["show_score"] = "فلترة المقبولين مبدئيا الذين لديهم نسبة :";
		$trad["sorting_session_stat"]["min_show_score"] = "من"; 
		$trad["sorting_session_stat"]["max_show_score"] = "إلى";
		

		$trad["sorting_session_stat"]["sorting_session_id"] = "تنفيذ الفرز";
		$trad["sorting_session_stat"]["applicationDesireList"] = "الملفات التي سيتم قبولها بشكل مبدئي";
		
		
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SortingSessionStatEnTranslator();
		return new SortingSessionStat();
	}
}