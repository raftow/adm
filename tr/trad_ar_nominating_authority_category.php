<?php

class NominatingAuthorityCategoryArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["nominating_authority_category"]["nominatingauthoritycategory.single"] = "فئة جهات الترشيح";
		$trad["nominating_authority_category"]["nominatingauthoritycategory.new"] = "جديدة";
		$trad["nominating_authority_category"]["nominating_authority_category"] = "فئات جهات الترشيح";
		$trad["nominating_authority_category"]["name_ar"] = "مسمى  بالعربية";
		$trad["nominating_authority_category"]["desc_ar"] = "وصف  بالعربية";
		$trad["nominating_authority_category"]["name_en"] = "مسمى  بالانجليزية";
		$trad["nominating_authority_category"]["desc_en"] = "وصف  بالانجليزية";
		$trad["nominating_authority_category"]["nominating_authority_category_name_ar"] = "اسم الفئة عربي";
		$trad["nominating_authority_category"]["nominating_authority_category_name_en"] = "اسم الفئة انجليزي";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new NominatingAuthorityCategoryEnTranslator();
		return new NominatingAuthorityCategory();
	}
}