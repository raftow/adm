<?php
class ApplicationRecommendationArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["application_recommendation"]["applicationrecommendation.single"] = "توصية تقديم";
	$trad["application_recommendation"]["applicationrecommendation.new"] = "جديد ة";
	$trad["application_recommendation"]["application_recommendation"] = "توصيات التقديم";
	$trad["application_recommendation"]["recommendation_letter_id"] = "معرف التوصية";
	$trad["application_recommendation"]["application_id"] = "التقديم";
	$trad["application_recommendation"]["lor_status_enum"] = "حالة الاعتماد";
	$trad["application_recommendation"]["notification_sent"] = "طلب اعتماد التوصية";
	$trad["application_recommendation"]["notification_date"] = "تاريخ الارسال";
	$trad["application_recommendation"]["notification_type_enum"] = "نوع الرسالة";
	$trad["application_recommendation"]["approval_user_id"] = "مسؤول الاعتماد";
	$trad["application_recommendation"]["comments"] = "ملاحظات";
        return $trad;
        }

        public static function getInstance()
	{
		return new ApplicationRecommendation();
	}
}
