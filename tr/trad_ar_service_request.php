<?php
class ServiceRequestArTranslator{

    public static function initData()
    {
        $trad = [];
	$trad["service_request"]["step1"] = "التعريف";

	$trad["service_request"]["servicerequest.single"] = "طلب خدمة";
	$trad["service_request"]["servicerequest.new"] = "جديد ة";
	$trad["service_request"]["service_request"] = "طلبات الخدمات";
	$trad["service_request"]["idn"] = "رقم الهوية";
	$trad["service_request"]["first_name"] = "الاسم الأول";
	$trad["service_request"]["last_name"] = "اسم العائلة";
	$trad["service_request"]["mobile"] = "الجوال";
	$trad["service_request"]["email"] = "البريد الالكتروني";
	$trad["service_request"]["service_category_id"] = "فئة الخدمة";
	$trad["service_request"]["service_item_id"] = "نوع الطلب";
	$trad["service_request"]["subject"] = "موضوع الطلب";
	$trad["service_request"]["description"] = "رسالة الطلب";
	$trad["service_request"]["applicant_file_id"] = "الملف المرفق";
	$trad["service_request"]["application_plan_id"] = "خطة القبول";
	$trad["service_request"]["request_status_id"] = "حالة الطلب";
	//$trad["service_request"]["request_type_id"] = " الطلب";
	$trad["service_request"]["status_comment"] = "ملاحظات الحالة";
    $trad["service_request"]["status_date"] = "تاريخ الحالة";
    $trad["service_request"]["applicant_id"] = "المتقدم";
	$trad["service_request"]["applicantFileIdLink"] = "المرفقات";
	$trad["service_request"]["applicantIdLink"] = "المتقدم";

        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new ServiceRequestEnTranslator();
		return new ServiceRequest();
	}
}