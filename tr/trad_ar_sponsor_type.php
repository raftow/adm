<?php
class SponsorTypeArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["sponsor_type"]["sponsortype.single"] = "نوع مانح";
	$trad["sponsor_type"]["sponsortype.new"] = "جديد";
	$trad["sponsor_type"]["sponsor_type"] = "أنواع المانحين";
	$trad["sponsor_type"]["sponsor_type_name_ar"] = "اسم نوع المانح - عربي";
	$trad["sponsor_type"]["sponsor_type_name_en"] = "اسم نوع المانح - انجليزي";
        return $trad;
        }

        public static function getInstance()
	{
		return new SponsorType();
	}
}
