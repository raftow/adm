<?php

class ApiEndpointArTranslator{
    public static function initData()
    {
        $trad = [];

    	$trad["api_endpoint"]["apiendpoint.single"] = "خدمة الكترونية";
		$trad["api_endpoint"]["apiendpoint.new"] = "جديد(ة)";
		$trad["api_endpoint"]["api_endpoint"] = "الخدمات الاكترونية";
		$trad["api_endpoint"]["api_endpoint_code"] = "الرمز";
		$trad["api_endpoint"]["api_endpoint_title"] = "الوصف";
		$trad["api_endpoint"]["api_endpoint_name_ar"] = "الاسم العربي";
		$trad["api_endpoint"]["api_endpoint_name_en"] = "الاسم الإنجليزي";
		$trad["api_endpoint"]["adm_file_id"] = "صورة الايقونة";
		$trad["api_endpoint"]["failure_text"] = "رسالة الخطأ";
		$trad["api_endpoint"]["api_url"] = "عنوان Url";
		$trad["api_endpoint"]["application_field_mfk"] = "الحقول المتوفرة";
		$trad["api_endpoint"]["manadatory"] = "الزامي؟";
		$trad["api_endpoint"]["published"] = "منشور";
		$trad["api_endpoint"]["can_refresh"] = "يمكن التحديث";
		$trad["api_endpoint"]["can_refresh.W"] = "ادخال يدوي";
		$trad["api_endpoint"]["can_refresh.EUH"] = "ادخال يدوي";
		$trad["api_endpoint"]["duration_expiry"] = "مدة الصلاحية";
		$trad["api_endpoint"]["api_endpoint_mfk"] = "الخدمات الالكترونية الجزئية";
		

		$trad["api_endpoint"]["step1"] = "التعريف";
        return $trad;
    }

	public static function getInstance()
	{
		return new ApiEndpoint();
	}
}