<?php

class SortingSessionStatArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sorting_session_stat"]["sortingsessionstat.single"] = "سطر احصائية كرة الفرز";
		$trad["sorting_session_stat"]["sortingsessionstat.new"] = "جديد(ة)";
		$trad["sorting_session_stat"]["sorting_session_stat"] = "سطور احصائية كرة الفرز";
		$trad["sorting_session_stat"]["application_plan_id"] = "خطة التقديم";
		$trad["sorting_session_stat"]["session_num"] = "كرة الفرز";
		$trad["sorting_session_stat"]["application_simulation_id"] = "طلب محاكاة تقديم";
		$trad["sorting_session_stat"]["application_plan_branch_id"] = "فرع التقديم";
		$trad["sorting_session_stat"]["track_num"] = "مسار الفرز";
		$trad["sorting_session_stat"]["capacity"] = "الطاقة الاستيعابية";
		$trad["sorting_session_stat"]["nb_accepted"] = "عدد المقبولين";

		$trad["sorting_session_stat"]["step1"] = "نتائج الفرز";
		$trad["sorting_session_stat"]["step2"] = "المقبولين";
		$trad["sorting_session_stat"]["farz-branch"] = "الفرع المعني بالفرز";
		$trad["sorting_session_stat"]["scores"] = "نتائج الفرز";

		$trad["sorting_session_stat"]["min_acc_score1"] = "نسبة القبول";
		$trad["sorting_session_stat"]["min_acc_score2"] = "نسبة القبول 2";
		$trad["sorting_session_stat"]["min_acc_score3"] = "نسبة القبول 3";
		
		$trad["sorting_session_stat"]["min_app_score1"] = "نسبة التقديم";
		$trad["sorting_session_stat"]["min_app_score2"] = "نسبة التقديم 2";
		$trad["sorting_session_stat"]["min_app_score3"] = "نسبة التقديم 3";

		$trad["sorting_session_stat"]["sorting_session_id"] = "كرة الفرز";
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