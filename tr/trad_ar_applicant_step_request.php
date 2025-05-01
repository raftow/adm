<?php

class ApplicantStepRequestArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_step_request"]["applicantsteprequest.single"] = "طلب انتقال مرحلة";
		$trad["applicant_step_request"]["applicantsteprequest.new"] = "جديد(ة)";
		$trad["applicant_step_request"]["applicant_step_request"] = "طلبات انتقال مراحل";
		$trad["applicant_step_request"]["name_ar"] = "مسمى  بالعربية";
		$trad["applicant_step_request"]["desc_ar"] = "وصف  بالعربية";
		$trad["applicant_step_request"]["name_en"] = "مسمى  بالانجليزية";
		$trad["applicant_step_request"]["desc_en"] = "وصف  بالانجليزية";
		$trad["applicant_step_request"]["applicant_id"] = "المتقدم";
		$trad["applicant_step_request"]["application_plan_id"] = "خطة التقديم";
		$trad["applicant_step_request"]["application_model_id"] = "نموذج القبول";
		$trad["applicant_step_request"]["step_num"] = "رقم المرحلة";
		$trad["applicant_step_request"]["done"] = "تم الانتهاء ؟";
		$trad["applicant_step_request"]["status_date"] = "تاريخ حالة الطلب";
		$trad["applicant_step_request"]["api_endpoint_id"] = "خدمة الالكترونية";

		
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantStepRequestEnTranslator();
		return new ApplicantStepRequest();
	}
}