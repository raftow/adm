<?php

class InstitutionArTranslator{
    public static function initData()
    {
        $trad = [];


$trad["institution"]["application_plan_id"] = "محاكاة حملة التقديم";
	$trad["institution"]["application_model_id"] = "محاكاة نموذج القبول";
	$trad["institution"]["simulation_applicants_ids"] = "محاكاة بعض المتقدمين";
	$trad["institution"]["simulation_applicants_ids.tooltip"] = "أرقام هويات المتقدمين المراد محاكاة التقديم عليهم وإذا كانت أكثر من هوية واحدة فيوضع بين كل هوية والتي تليها فاصل `,` مثال ذلك : 1029397112,1033406602,1010066577";
	

	$trad["institution"]["institution.single"] = "مؤسسة اكاديمية";
	$trad["institution"]["institution.new"] = "جديدة";
	$trad["institution"]["institution"] = "المؤسسات التدريبية";
		$trad["institution"]["institution.single"] = "مؤسسة اكاديمية";
		$trad["institution"]["institution.new"] = "جديد(ة)";
		$trad["institution"]["institution"] = "المؤسسات الدراسية";
		$trad["institution"]["apiEndpointList"] = "قائمة الخدمات الاكترونية";
		$trad["institution"]["institution_code"] = "رمز المؤسسة";
		$trad["institution"]["country_id"] = "الدولة";
		$trad["institution"]["institution_name_ar"] = "الاسم العربي";
		$trad["institution"]["institution_name_en"] = "الاسم الإنجليزي";
		$trad["institution"]["map_location"] = "احداثيات الخريطة";
		$trad["institution"]["website"] = "رابط موقع الواب  Url";
		$trad["institution"]["logo_file_id"] = "صورة شعار المؤسسة";
		$trad["institution"]["background_file_id"] = "صورة الخلفية";
		$trad["institution"]["adress"] = "العنوان";
		$trad["institution"]["postal_code"] = "رمز .......";
		$trad["institution"]["orgunit_id"] = "العنصر في نظام الموارد البشرية";
		$trad["institution"]["adm_orgunit_id"] = "إدارة قبول وتسجيل";
		$trad["institution"]["facebook_profile_link"] = "رابط الحساب على الفيسبوك";
		$trad["institution"]["linkedin_profile_link"] = "رابط الحساب على لينكدإن";
		$trad["institution"]["youtube_profile_link"] = "رابط الحساب على اليوتيوب";
		$trad["institution"]["snapchat_profile_link"] = "رابطالحساب على سناب شات";
		$trad["institution"]["twitter_profile_link"] = "رابط الحساب على تويتر";
		$trad["institution"]["instagram_profile_link"] = "رابط الحساب على انستجرام";
		$trad["institution"]["application_model_id"] = "محاكاة نموذج القبول";
		$trad["institution"]["application_plan_id"] = "محاكاة حملة التقديم";
		$trad["institution"]["simulation_applicants_ids"] = "محاكاة بعض المتقدمين";
		$trad["institution"]["institution_code"] = "رمز المؤسسة";
	$trad["institution"]["institution_name_ar"] = "الاسم العربي";
	$trad["institution"]["institution_name_en"] = "الاسم الإنجليزي";
	$trad["institution"]["orgunit_id"] = "العنصر في نظام الموارد البشرية";
	$trad["institution"]["country_id"] = "الدولة";
	$trad["institution"]["map_location"] = "احداثيات الخريطة";
	$trad["institution"]["website"] = "رابط موقع الواب  Url";
	$trad["institution"]["logo_file_id"] = "صورة شعار المؤسسة";
	$trad["institution"]["background_file_id"] = "صورة الخلفية";
	$trad["institution"]["facebook_profile_link"] = "رابط الحساب على الفيسبوك";
	$trad["institution"]["linkedin_profile_link"] = "رابط الحساب على لينكدإن";
	$trad["institution"]["youtube_profile_link"] = "رابط الحساب على اليوتيوب";
	$trad["institution"]["snapchat_profile_link"] = "رابطالحساب على سناب شات";
	$trad["institution"]["twitter_profile_link"] = "رابط الحساب على تويتر";
	$trad["institution"]["instagram_profile_link"] = "رابط الحساب على انستجرام";
        // steps
		$trad["institution"]["step1"] = "التعريف";
		$trad["institution"]["step2"] = "العناوين";
		$trad["institution"]["step3"] = "الاعدادات";
		$trad["institution"]["step4"] = "الخدمات الاكترونية";

		$trad["institution"]["apiEndpointList"] = "قائمة الخدمات الاكترونية المتوفرة";

		$trad["institution"]["Institution_description_ar"] = "وصف المؤسسة عربي";
		$trad["institution"]["Institution_description_en"] = "وصف المؤسسة انجليزي";
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new InstitutionEnTranslator();
		return new Institution();
	}
}