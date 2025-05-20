<?php
class ServiceCategoryArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["service_category"]["servicecategory.single"] = "فئة خدمة";
	$trad["service_category"]["servicecategory.new"] = "جديد ة";
	$trad["service_category"]["service_category"] = "فئات الخدمة";
	$trad["service_category"]["service_category_name_ar"] = "اسم فئة الخدمة - عربي";
	$trad["service_category"]["service_category_name_en"] = "اسم فئة الخدمة - انجليزي";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new ServiceCategoryEnTranslator();
		return new ServiceCategory();
	}
}