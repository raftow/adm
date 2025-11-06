<?php

class NominatingAuthorityCategoryEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["nominating_authority_category"]["nominatingauthoritycategory.single"] = "Nominating authority category";
		$trad["nominating_authority_category"]["nominatingauthoritycategory.new"] = "new";
		$trad["nominating_authority_category"]["nominating_authority_category"] = "Nominating authority categories";
		$trad["nominating_authority_category"]["name_ar"] = "Arabic Nominating authority category name";
		$trad["nominating_authority_category"]["desc_ar"] = "Arabic Nominating authority category description";
		$trad["nominating_authority_category"]["name_en"] = "English Nominating authority category name";
		$trad["nominating_authority_category"]["desc_en"] = "English Nominating authority category description";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new NominatingAuthorityCategoryArTranslator();
		return new NominatingAuthorityCategory();
	}
}