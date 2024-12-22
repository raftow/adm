<?php
class SponsorTypeEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["sponsor_type"]["sponsortype.single"] = "Sponsor type";
	$trad["sponsor_type"]["sponsortype.new"] = "new";
	$trad["sponsor_type"]["sponsor_type"] = "Sponsor types";
	$trad["sponsor_type"]["sponsor_type_name_ar"] = "sponsor type name - arabic";
	$trad["sponsor_type"]["sponsor_type_name_en"] = "sponsor type name - english";
        return $trad;
        }

        public static function getInstance()
	{
		return new SponsorType();
	}
}