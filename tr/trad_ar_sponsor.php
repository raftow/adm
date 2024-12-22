<?php
class SponsorArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["sponsor"]["sponsor.single"] = "مانح";
	$trad["sponsor"]["sponsor.new"] = "جديد";
	$trad["sponsor"]["sponsor"] = "المانحين";
	$trad["sponsor"]["sponsor_type_id"] = "نوع المانح";
	$trad["sponsor"]["sponsor_name_ar"] = "اسم المانح - عربي";
	$trad["sponsor"]["sponsor_name_en"] = "اسم المانح - انجليزي";
	$trad["sponsor"]["sponsor_email"] = "البريد الالكتروني";
	$trad["sponsor"]["sponsor_phone"] = "الهاتف";
	$trad["sponsor"]["sponsor_adress"] = "العنوان";
        return $trad;
        }

        public static function getInstance()
	{
		return new Sponsor();
	}
}