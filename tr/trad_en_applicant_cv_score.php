<?php

class ApplicantCvScoreEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_cv_score"]["applicantcvscore.single"] = "applicant cv scores";
		$trad["applicant_cv_score"]["applicantcvscore.new"] = "new";
		$trad["applicant_cv_score"]["applicant_cv_score"] = "applicant cv score";
		$trad["applicant_cv_score"]["name_ar"] = "Arabic Applicant cv score name";
		$trad["applicant_cv_score"]["name_en"] = "English Applicant cv score name";
		$trad["applicant_cv_score"]["desc_ar"] = "Arabic Applicant cv score description";
		$trad["applicant_cv_score"]["desc_en"] = "English Applicant cv score description";
		$trad["applicant_cv_score"]["applicant_id"] = "Applicant";
		$trad["applicant_cv_score"]["cv_rubric_id"] = "cv rubric";
		$trad["applicant_cv_score"]["application_id"] = "Application";
		$trad["applicant_cv_score"]["review_date"] = "Review date";
		$trad["applicant_cv_score"]["rubric_score"] = "ruric score";
		$trad["applicant_cv_score"]["comments"] = "Comments";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantCvScoreArTranslator();
		return new ApplicantCvScore();
	}
}