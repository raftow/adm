<?php
class RecommendationLetterArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["recommendation_letter"]["recommendationletter.single"] = "رسالة توصية";
	$trad["recommendation_letter"]["recommendationletter.new"] = "جديد ة";
	$trad["recommendation_letter"]["recommendation_letter"] = "رسائل التوصية";
	$trad["recommendation_letter"]["applicant_id"] = "معرف المتقدم";
	$trad["recommendation_letter"]["recommender_name"] = "اسم الموصي";
	$trad["recommendation_letter"]["mobile"] = "الهاتف/الجوال";
	$trad["recommendation_letter"]["email"] = "البريد الالكتروني";
	$trad["recommendation_letter"]["occupation"] = "المهنة / المنصب";
	$trad["recommendation_letter"]["organization_name"] = "المؤسسة";
	$trad["recommendation_letter"]["lor_type"] = "نوع التوصية";
	$trad["recommendation_letter"]["adm_file_id"] = "ملف رسالة التوصية  العلمية";
	$trad["recommendation_letter"]["status"] = "حالة الاعتماد";
        return $trad;
        }

        public static function getInstance()
	{
		return new RecommendationLetter();
	}
}