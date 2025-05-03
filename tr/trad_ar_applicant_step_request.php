<?php

class ApplicantStepRequestArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_step_request"]["applicantsteprequest.single"] = "طلب خدمة الكترونية";
		$trad["applicant_step_request"]["applicantsteprequest.new"] = "جديد(ة)";
		$trad["applicant_step_request"]["applicant_step_request"] = "طلبات الخدمات الالكترونية";
		$trad["applicant_step_request"]["name_ar"] = "مسمى  بالعربية";
		$trad["applicant_step_request"]["desc_ar"] = "وصف  بالعربية";
		$trad["applicant_step_request"]["name_en"] = "مسمى  بالانجليزية";
		$trad["applicant_step_request"]["desc_en"] = "وصف  بالانجليزية";
		$trad["applicant_step_request"]["applicant_id"] = "المتقدم";
		$trad["applicant_step_request"]["application_plan_id"] = "خطة التقديم";
		$trad["applicant_step_request"]["application_model_id"] = "نموذج القبول";
		$trad["applicant_step_request"]["step_num"] = "رقم المرحلة";
		$trad["applicant_step_request"]["done"] = "حالة التحديث";
		$trad["applicant_step_request"]["status_date"] = "تاريخ حالة الطلب";
		$trad["applicant_step_request"]["api_endpoint_id"] = "خدمة الالكترونية";
		$trad["applicant_step_request"]["error_message"] = "رسالة الخطأ";
		$trad["applicant_step_request"]["support_category"] = "فئة طلب الدعم";

		
	
	


		$trad["applicant_step_request"]["done.YES"] = "تم التحديث";
		$trad["applicant_step_request"]["done.EUH"]  = "تعذر جلب البيانات";
		$trad["applicant_step_request"]["done.NO"] = "انتظار...";

		
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantStepRequestEnTranslator();
		return new ApplicantStepRequest();
	}
}