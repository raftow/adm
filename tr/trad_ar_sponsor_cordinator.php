<?php

class SponsorCordinatorArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sponsor_cordinator"]["sponsorcordinator.single"] = "منسقين جهات ترشيح";
		$trad["sponsor_cordinator"]["sponsorcordinator.new"] = "جديد";
		$trad["sponsor_cordinator"]["sponsor_cordinator"] = "منسق جهة ترشيح";
		$trad["sponsor_cordinator"]["name_ar"] = "مسمى  بالعربية";
		$trad["sponsor_cordinator"]["desc_ar"] = "وصف  بالعربية";
		$trad["sponsor_cordinator"]["name_en"] = "مسمى  بالانجليزية";
		$trad["sponsor_cordinator"]["desc_en"] = "وصف  بالانجليزية";
		$trad["sponsor_cordinator"]["nominating_authority_id"] = "جهة الترشيح";
		$trad["sponsor_cordinator"]["sponsor_cordinator_name_ar"] = "اسم المنسق عربي";
		$trad["sponsor_cordinator"]["sponsor_cordinator_name_en"] = "اسم المنسق انجليزي";
		$trad["sponsor_cordinator"]["email"] = "البريد الإلكتروني";
		$trad["sponsor_cordinator"]["Mobile"] = "الجوال";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SponsorCordinatorEnTranslator();
		return new SponsorCordinator();
	}
}