<?php
class ServiceCategoryEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["service_category"]["servicecategory.single"] = "Service category";
	$trad["service_category"]["servicecategory.new"] = "new";
	$trad["service_category"]["service_category"] = "Service categorys";
	$trad["service_category"]["service_category_name_ar"] = "service category name - arabic";
	$trad["service_category"]["service_category_name_en"] = "service category name - english";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new ServiceCategoryArTranslator();
		return new ServiceCategory();
	}
}
