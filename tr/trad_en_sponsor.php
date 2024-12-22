<?php
class SponsorEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["sponsor"]["sponsor.single"] = "Sponsor";
	$trad["sponsor"]["sponsor.new"] = "new";
	$trad["sponsor"]["sponsor"] = "Sponsors";
	$trad["sponsor"]["sponsor_type_id"] = "sponsor type";
	$trad["sponsor"]["sponsor_name_ar"] = "sponsor name - arabic";
	$trad["sponsor"]["sponsor_name_en"] = "sponsor name - english";
	$trad["sponsor"]["sponsor_email"] = "sponsor email";
	$trad["sponsor"]["sponsor_phone"] = "sponsor phone";
	$trad["sponsor"]["sponsor_adress"] = "sponsor adress";
        return $trad;
        }

        public static function getInstance()
	{
		return new Sponsor();
	}
}