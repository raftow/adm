<?php
class ServiceItemEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["service_item"]["serviceitem.single"] = "Service item";
	$trad["service_item"]["serviceitem.new"] = "new";
	$trad["service_item"]["service_item"] = "Service items";
	$trad["service_item"]["service_category_id"] = "service category";
	$trad["service_item"]["service_item_name_ar"] = "service item name arabic";
	$trad["service_item"]["service_item_name_en"] = "service item name english";
	$trad["service_item"]["upload_file_ind"] = "upload file";
	$trad["service_item"]["document_type_mfk"] = "document type";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new ServiceItemArTranslator();
		return new ServiceItem();
	}
}