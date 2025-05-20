<?php
class DocumentTypeEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["document_type"]["documenttype.single"] = "Document type";
	$trad["document_type"]["documenttype.new"] = "new";
	$trad["document_type"]["document_type"] = "Document types";
	$trad["document_type"]["document_type_name_ar"] = "document type name - arabic";
	$trad["document_type"]["document_type_name_en"] = "document type name - english";
	$trad["document_type"]["document_category_id"] = "document category";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new DocumentTypeArTranslator();
		return new DocumentType();
	}
}