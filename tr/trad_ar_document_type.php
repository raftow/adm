<?php
class DocumentTypeArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["document_type"]["documenttype.single"] = "نوع الوثيقة";
	$trad["document_type"]["documenttype.new"] = "جديد ة";
	$trad["document_type"]["document_type"] = "أنواع الوثائق";
	$trad["document_type"]["document_type_name_ar"] = "اسم نوع الوثيقة - عربي";
	$trad["document_type"]["document_type_name_en"] = "اسم نوع الوثيقة - انجليزي";
	$trad["document_type"]["document_category_id"] = "فئة الوثيق";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new DocumentTypeEnTranslator();
		return new DocumentType();
	}
}