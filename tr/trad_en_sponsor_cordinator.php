<?php

class SponsorCordinatorEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["sponsor_cordinator"]["sponsorcordinator.single"] = "Sponsor Cordinator";
		$trad["sponsor_cordinator"]["sponsorcordinator.new"] = "new";
		$trad["sponsor_cordinator"]["sponsor_cordinator"] = "Sponsor Cordinators";
		$trad["sponsor_cordinator"]["name_ar"] = "Arabic Sponsor cordinator name";
		$trad["sponsor_cordinator"]["desc_ar"] = "Arabic Sponsor cordinator description";
		$trad["sponsor_cordinator"]["name_en"] = "English Sponsor cordinator name";
		$trad["sponsor_cordinator"]["desc_en"] = "English Sponsor cordinator description";
		$trad["sponsor_cordinator"]["nominating_authority_id"] = "Nomination Authority";
		$trad["sponsor_cordinator"]["email"] = "e-mail";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new SponsorCordinatorArTranslator();
		return new SponsorCordinator();
	}
}