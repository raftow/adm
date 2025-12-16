<?php

class ApplicationCvScoreArTranslator{
    public static function initData()
    {
        $trad = [];
		$trad["application_cv_score"]["step1"] = "التعريف";
		$trad["application_cv_score"]["step2"] = "المؤهلات الأكاديمية";
		$trad["application_cv_score"]["step3"] = "المؤهلات المهنية";
		$trad["application_cv_score"]["step4"] = "الدورات وورش العمل";
		$trad["application_cv_score"]["step5"] = "العضوية في المؤسسات والجمعيات العلمية";
		$trad["application_cv_score"]["step6"] = "الأنشطة التطوعية وخدمة المجتمع";
		$trad["application_cv_score"]["step7"] = "الشكر و التقدير و الجوائز";
		$trad["application_cv_score"]["step8"] = "النشر العلمي والبحث العلمي";
		$trad["application_cv_score"]["step9"] = "اللغات";
		$trad["application_cv_score"]["step10"] = "المؤتمرات العلمية";
		$trad["application_cv_score"]["step11"] = "التوصيات العلمية";
		
		$trad["application_cv_score"]["QUALList"] = "قائمة المؤهلات الأكاديمية";
		$trad["application_cv_score"]["PEXPList"] = "قائمة المؤهلات المهنية";
		$trad["application_cv_score"]["CRWQList"] = "قائمة الدورات وورش العمل";
		$trad["application_cv_score"]["SCINTList"] = "قائمة العضوية في المؤسسات والجمعيات العلمية";
		$trad["application_cv_score"]["VOLACList"] = "قائمة النشاطات التطوعية وخدمة المجتمع";
		$trad["application_cv_score"]["AWAPList"] = "قائمة الشهادات الشكر و التقدير و الجوائز";
		$trad["application_cv_score"]["SCRSCList"] = "قائمة النشر العلمي والبحث العلمي";
		$trad["application_cv_score"]["LANGPList"] = "قائمة إتقان اللغات";
		$trad["application_cv_score"]["SCCONFList"] = "قائمة المؤتمرات العلمية";
		$trad["application_cv_score"]["RECLTList"] = "قائمة التوصيات العلمية";

$trad["application_cv_score"]["QUALGuideList"] = "دليل تقييم المؤهلات الأكاديمية";
$trad["application_cv_score"]["PEXPGuideList"] = "دليل تقييم المؤهلات المهنية";
$trad["application_cv_score"]["CRWQGuideList"] = "دليل تقييم الدورات وورش العمل";
$trad["application_cv_score"]["SCINTGuideList"] = "دليل تقييم العضوية في المؤسسات والجمعيات العلمية";
$trad["application_cv_score"]["VOLACGuideList"] = "دليل تقييم النشاطات التطوعية وخدمة المجتمع";
$trad["application_cv_score"]["AWAPGuideList"] = "دليل تقييم الشهادات الشكر و التقدير و الجوائز";
$trad["application_cv_score"]["SCRSCGuideList"] = "دليل تقييم النشر العلمي والبحث العلمي";
$trad["application_cv_score"]["LANGPGuideList"] = "دليل تقييم إتقان اللغات";
$trad["application_cv_score"]["SCCONFGuideList"] = "دليل تقييم المؤتمرات العلمية";
$trad["application_cv_score"]["RECLTGuideList"] = "دليل تقييم التوصيات العلمية";

		$trad["application_cv_score"]["applicationcvscore.single"] = "درجة سيرة ذاتية";
		$trad["application_cv_score"]["applicationcvscore.new"] = "جديد ة";
		$trad["application_cv_score"]["application_cv_score"] = "درجات السيرة الذاتية";
		$trad["application_cv_score"]["name_ar"] = "مسمى  بالعربية";
		$trad["application_cv_score"]["name_en"] = "مسمى  بالانجليزية";
		$trad["application_cv_score"]["desc_ar"] = "وصف  بالعربية";
		$trad["application_cv_score"]["desc_en"] = "وصف  بالانجليزية";
		$trad["application_cv_score"]["applicant_id"] = "المتقدم";
		$trad["application_cv_score"]["application_plan_id"] = "خطة التقديم";
		$trad["application_cv_score"]["application_simulation_id"] = "الapplication_simulation.single";
		$trad["application_cv_score"]["score_QUAL"] = "التقييم"; // المؤهلات الأكاديمية
		$trad["application_cv_score"]["review_date_QUAL"] = "تاريخ التقييم";
		$trad["application_cv_score"]["review_comments_QUAL"] = "تعليقات التقييم";
		$trad["application_cv_score"]["score_PEXP"] = "التقييم"; // الخبرات المهنية
		$trad["application_cv_score"]["review_date_PEXP"] = "تاريخ التقييم";
		$trad["application_cv_score"]["review_comments_PEXP"] = "تعليقات التقييم";
		$trad["application_cv_score"]["score_CRWQ"] = "التقييم"; // الدورات وورش العمل العلمية
		$trad["application_cv_score"]["review_date_CRWQ"] = "تاريخ التقييم";
		$trad["application_cv_score"]["review_comments_CRWQ"] = "تعليقات التقييم";
		$trad["application_cv_score"]["score_SCINT"] = "التقييم"; // العضوية في المؤسسات والجمعيات العلمية
		$trad["application_cv_score"]["review_date_SCINT"] = "تاريخ التقييم";
		$trad["application_cv_score"]["review_comments_SCINT"] = "تعليقات التقييم";
		$trad["application_cv_score"]["review_date_VOLAC"] = "تاريخ التقييم";
		$trad["application_cv_score"]["score_VOLAC"] = "التقييم"; // النشاطات التطوعية وخدمة المجتمع
		$trad["application_cv_score"]["review_comments_VOLAC"] = "تعليقات التقييم";
		$trad["application_cv_score"]["score_AWAP"] = "التقييم"; // الشهادات الشكر و التقدير و الجوائز
		$trad["application_cv_score"]["review_date_AWAP"] = "تاريخ التقييم";
		$trad["application_cv_score"]["review_comments_AWAP"] = "تعليقات التقييم";
		$trad["application_cv_score"]["score_SCRSC"] = "التقييم"; // النشر العلمي والبحث العلمي
		$trad["application_cv_score"]["review_date_SCRSC"] = "تاريخ التقييم";
		$trad["application_cv_score"]["review_comments_SCRSC"] = "تعليقات التقييم";
		$trad["application_cv_score"]["score_LANGP"] = "التقييم"; // إتقان اللغات
		$trad["application_cv_score"]["review_date_LANGP"] = "تاريخ التقييم";
		$trad["application_cv_score"]["review_comments_LANGP"] = "تعليقات التقييم";
		$trad["application_cv_score"]["score_SCCONF"] = "التقييم"; // المؤتمرات العلمية
		$trad["application_cv_score"]["review_date_SCCONF"] = "تاريخ التقييم";
		$trad["application_cv_score"]["review_comments_SCCONF"] = "تعليقات التقييم";
		$trad["application_cv_score"]["score_RECLT"] = "التقييم"; // التوصيات العلمية
		$trad["application_cv_score"]["review_date_RECLT"] = "تاريخ التقييم";
		$trad["application_cv_score"]["review_comments_RECLT"] = "تعليقات التقييم";
		$trad["application_cv_score"]["total_score"] = "الإجمالي";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicationCvScoreEnTranslator();
		return new ApplicationCvScore();
	}
}