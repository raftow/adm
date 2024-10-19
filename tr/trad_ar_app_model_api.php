<?php

class AppModelApiArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["app_model_api"]["appmodelapi.single"] = "خدمة نموذج تقديم";
		$trad["app_model_api"]["appmodelapi.new"] = "جديد(ة)";
		$trad["app_model_api"]["app_model_api"] = "خدمات نماذج التقديم";
		$trad["app_model_api"]["application_model_id"] = "نموذج القبول";
		$trad["app_model_api"]["api_endpoint_id"] = "معرف API";
		$trad["app_model_api"]["manadatory"] = "الزامي؟";
		$trad["app_model_api"]["can_refresh"] = "يمكن التحديث";
		$trad["app_model_api"]["duration_expiry"] = "مدة الصلاحية";
		$trad["app_model_api"]["published"] = "تم النشر";
		$trad["app_model_api"]["application_field_mfk"] = "الحقول المستعملة";
		$trad["app_model_api"]["step_num"] = "أثناء الانتقال الى الخطوة";
		$trad["app_model_api"]["step_num.short"] = "الى الخطوة";
		// steps
		$trad["app_model_api"]["step1"] = "step1";
        return $trad;
    }

    public static function getInstance()
	{
		return new AppModelApi();
	}
}