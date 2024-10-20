<?php

class ApplicationModelFieldArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["application_model_field"]["applicationmodelfield.single"] = "حقل تقديم";
		$trad["application_model_field"]["applicationmodelfield.new"] = "جديد(ة)";
		$trad["application_model_field"]["application_model_field"] = "حقول التقديم";
		$trad["application_model_field"]["application_model_id"] = "نموذج القبول";
		$trad["application_model_field"]["acondition_id"] = "الشرط";
		$trad["application_model_field"]["application_field_id"] = "الحقل";
		$trad["application_model_field"]["screen_model_id"] = "الشاشة";
		$trad["application_model_field"]["step_num"] = "خطوة الإدخال";
		$trad["application_model_field"]["api_endpoint_id"] = "الخدمة الالكترونية";
		$trad["application_model_field"]["duration_expiry"] = "مدة الصلاحية";
        // steps
		$trad["application_model_field"]["step1"] = "step1";
        return $trad;
    }

    public static function getInstance()
	{
		return new ApplicationModelField();
	}
}

