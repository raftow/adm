<?php

class NominatingCandidatesEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["nominating_candidates"]["nominatingcandidates.single"] = "Nominating candidates";
		$trad["nominating_candidates"]["nominatingcandidates.new"] = "new";
		$trad["nominating_candidates"]["nominating_candidates"] = "Nominating candidates";
		$trad["nominating_candidates"]["name_ar"] = "Arabic Nominating candidates name";
		$trad["nominating_candidates"]["desc_ar"] = "Arabic Nominating candidates description";
		$trad["nominating_candidates"]["name_en"] = "English Nominating candidates name";
		$trad["nominating_candidates"]["desc_en"] = "English Nominating candidates description";
		$trad["nominating_candidates"]["identity_type_id"] = "Identity type";
		$trad["nominating_candidates"]["academic_program_id"] = "Academic program";
		$trad["nominating_candidates"]["email"] = "e-mail";
		$trad["nominating_candidates"]["study_funding_status_id"] = "حالة";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new NominatingCandidatesArTranslator();
		return new NominatingCandidates();
	}
}