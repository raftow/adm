<?php
class DocumentCategoryEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["document_category"]["documentcategory.single"] = "Document category";
	$trad["document_category"]["documentcategory.new"] = "new";
	$trad["document_category"]["document_category"] = "Document categorys";
	$trad["document_category"]["document_category_name_ar"] = "document category name - arabic";
	$trad["document_category"]["document_category_name_en"] = "document category name - english";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new DocumentCategoryArTranslator();
		return new DocumentCategory();
	}
}