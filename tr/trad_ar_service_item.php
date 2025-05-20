<?php
class ServiceItemArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["service_item"]["serviceitem.single"] = "عنصر خدمة";
	$trad["service_item"]["serviceitem.new"] = "جديد ة";
	$trad["service_item"]["service_item"] = "عناصر الخدمة";
	$trad["service_item"]["service_category_id"] = "فئة الخدمة";
	$trad["service_item"]["service_item_name_ar"] = "عنصر الخدمة - عربي";
	$trad["service_item"]["service_item_name_en"] = "عنصر الخدمة - انجليزي";
	$trad["service_item"]["upload_file_ind"] = "رفع ملفات";
	$trad["service_item"]["document_type_mfk"] = "نوع الوثيقة";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new ServiceItemEnTranslator();
		return new ServiceItem();
	}
}