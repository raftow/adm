<?php

class NominatingAuthorityEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["nominating_authority"]["nominatingauthority.single"] = "Nomination Authority";
		$trad["nominating_authority"]["nominatingauthority.new"] = "new";
		$trad["nominating_authority"]["nominating_authority"] = "Nomination Autority";
		$trad["nominating_authority"]["name_ar"] = "Arabic Nominating authority name";
		$trad["nominating_authority"]["desc_ar"] = "Arabic Nominating authority description";
		$trad["nominating_authority"]["name_en"] = "English Nominating authority name";
		$trad["nominating_authority"]["desc_en"] = "English Nominating authority description";
		$trad["nominating_authority"]["nominating_authority_category_id"] = "Nominating authority category";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new NominatingAuthorityArTranslator();
		return new NominatingAuthority();
	}
}