<?php

class ApplicantCvScoreArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_cv_score"]["applicantcvscore.single"] = "تقييم سيرة ذاتية";
		$trad["applicant_cv_score"]["applicantcvscore.new"] = "جديد(ة)";
		$trad["applicant_cv_score"]["applicant_cv_score"] = "تقييمات السيرة الذاتية";
		$trad["applicant_cv_score"]["name_ar"] = "مسمى  بالعربية";
		$trad["applicant_cv_score"]["name_en"] = "مسمى  بالانجليزية";
		$trad["applicant_cv_score"]["desc_ar"] = "وصف  بالعربية";
		$trad["applicant_cv_score"]["desc_en"] = "وصف  بالانجليزية";
		$trad["applicant_cv_score"]["applicant_id"] = "المتقدم";
		$trad["applicant_cv_score"]["cv_rubric_id"] = "قسم سيرة ذاتية";
		$trad["applicant_cv_score"]["application_id"] = "طلب التقديم";
		$trad["applicant_cv_score"]["review_date"] = "تاريخ البدء";
		$trad["applicant_cv_score"]["rubric_score"] = "نتيجة التقييم";
		$trad["applicant_cv_score"]["comments"] = "ملاحظات";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantCvScoreEnTranslator();
		return new ApplicantCvScore();
	}
}