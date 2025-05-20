<?php
class DocumentCategoryArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["document_category"]["documentcategory.single"] = "فئة وثيقة";
	$trad["document_category"]["documentcategory.new"] = "جديد ة";
	$trad["document_category"]["document_category"] = "فئات الوثائق";
	$trad["document_category"]["document_category_name_ar"] = "اسم فئة الوثيقة - عربي";
	$trad["document_category"]["document_category_name_en"] = "اسم فئة الوثيقة - انجليزي";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new DocumentCategoryEnTranslator();
		return new DocumentCategory();
	}
}
