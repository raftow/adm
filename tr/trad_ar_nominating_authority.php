<?php

class NominatingAuthorityArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["nominating_authority"]["nominatingauthority.single"] = "جهة ترشيح";
		$trad["nominating_authority"]["nominatingauthority.new"] = "جديدة";
		$trad["nominating_authority"]["nominating_authority"] = "جهات ترشيح";
		$trad["nominating_authority"]["name_ar"] = "مسمى  بالعربية";
		$trad["nominating_authority"]["desc_ar"] = "وصف  بالعربية";
		$trad["nominating_authority"]["name_en"] = "مسمى  بالانجليزية";
		$trad["nominating_authority"]["desc_en"] = "وصف  بالانجليزية";
		$trad["nominating_authority"]["nominating_authority_name_ar"] = "اسم جهة الترشيح عربي";
		$trad["nominating_authority"]["nominating_authority_name_en"] = "اسم جهة الترشيح انجليزي";
		$trad["nominating_authority"]["nominating_authority_category_id"] = "فئة جهة الترشيح";
		$trad["nominating_authority"]["nominating_authority_source_enum"] = "مصدر جهة الترشيح";
		$trad["nominating_authority"]["principal_autority_ind"] = "جهة رئيسية";
		$trad["nominating_authority"]["country_id"] = "الدولة";

        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new NominatingAuthorityEnTranslator();
		return new NominatingAuthority();
	}
}