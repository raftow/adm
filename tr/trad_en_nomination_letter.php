<?php

class NominationLetterEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["nomination_letter"]["nominationletter.single"] = "Nomination letter";
		$trad["nomination_letter"]["nominationletter.new"] = "new";
		$trad["nomination_letter"]["nomination_letter"] = "Nomination letters";
		$trad["nomination_letter"]["name_ar"] = "Arabic Nomination letter name";
		$trad["nomination_letter"]["desc_ar"] = "Arabic Nomination letter description";
		$trad["nomination_letter"]["name_en"] = "English Nomination letter name";
		$trad["nomination_letter"]["desc_en"] = "English Nomination letter description";
		$trad["nomination_letter"]["application_plan_id"] = "Application plan";
		$trad["nomination_letter"]["nominating_authority_id"] = "Nomination Authority";
		$trad["nomination_letter"]["nomination_letter_date"] = "letter date";
		$trad["nomination_letter"]["sponsor_cordinator_id"] = "Sponsor cordinator";
		$trad["nomination_letter"]["nomination_letter_file_id"] = "Nomination Letter file";
		$trad["nomination_letter"]["download_light"] = "file";
		
		$trad["nomination_letter"]["letter_code"] = "Letter Number";

        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new NominationLetterArTranslator();
		return new NominationLetter();
	}
}