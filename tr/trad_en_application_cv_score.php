<?php

class ApplicationCvScoreEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["application_cv_score"]["applicationcvscore.single"] = "Application cv score";
		$trad["application_cv_score"]["applicationcvscore.new"] = "new";
		$trad["application_cv_score"]["application_cv_score"] = "Application cv score";
		$trad["application_cv_score"]["name_ar"] = "Arabic Application cv score name";
		$trad["application_cv_score"]["name_en"] = "English Application cv score name";
		$trad["application_cv_score"]["desc_ar"] = "Arabic Application cv score description";
		$trad["application_cv_score"]["desc_en"] = "English Application cv score description";
		$trad["application_cv_score"]["applicant_id"] = "Applicant";
		$trad["application_cv_score"]["application_plan_id"] = "Application plan";
		$trad["application_cv_score"]["application_simulation_id"] = "Application simulation";
		$trad["application_cv_score"]["score_QUAL"] = "Academic Qualification";
		$trad["application_cv_score"]["review_date_QUAL"] = "Academic Qualification";
		$trad["application_cv_score"]["review_comments_QUAL"] = "Academic Qualification";
		$trad["application_cv_score"]["score_PEXP"] = "Professional experience";
		$trad["application_cv_score"]["review_date_PEXP"] = "Professional experience";
		$trad["application_cv_score"]["review_comments_PEXP"] = "Professional experience";
		$trad["application_cv_score"]["score_CRWQ"] = "Courses and Workshop";
		$trad["application_cv_score"]["review_date_CRWQ"] = "Courses and Workshop";
		$trad["application_cv_score"]["review_comments_CRWQ"] = "Courses and Workshop";
		$trad["application_cv_score"]["score_SCINT"] = "Membership in scientific bodies and societies	FLOAT";
		$trad["application_cv_score"]["review_date_SCINT"] = "Membership in scientific bodies and societies";
		$trad["application_cv_score"]["review_comments_SCINT"] = "Membership in scientific bodies and societies";
		$trad["application_cv_score"]["review_date_VOLAC"] = "Volunteer activities and community service";
		$trad["application_cv_score"]["score_VOLAC"] = "Volunteer activities and community service";
		$trad["application_cv_score"]["review_comments_VOLAC"] = "Volunteer activities and community service";
		$trad["application_cv_score"]["score_AWAP"] = "Certificates of appreciation and awards";
		$trad["application_cv_score"]["review_date_AWAP"] = "Certificates of appreciation and awards";
		$trad["application_cv_score"]["review_comments_AWAP"] = "Certificates of appreciation and awards";
		$trad["application_cv_score"]["score_SCRSC"] = "Scientific publishing and scientific research";
		$trad["application_cv_score"]["review_date_SCRSC"] = "Scientific publishing and scientific research";
		$trad["application_cv_score"]["review_comments_SCRSC"] = "Scientific publishing and scientific research";
		$trad["application_cv_score"]["score_LANGP"] = "Language proficiency";
		$trad["application_cv_score"]["review_date_LANGP"] = "Language proficiency";
		$trad["application_cv_score"]["review_comments_LANGP"] = "Language proficiency";
		$trad["application_cv_score"]["score_SCCONF"] = "Scientific conferences";
		$trad["application_cv_score"]["review_date_SCCONF"] = "Scientific conferences";
		$trad["application_cv_score"]["review_comments_SCCONF"] = "Scientific conferences";
		$trad["application_cv_score"]["score_RECLT"] = "Recommendation letter";
		$trad["application_cv_score"]["review_date_RECLT"] = "Recommendation letter";
		$trad["application_cv_score"]["review_comments_RECLT"] = "Recommendation letter";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicationCvScoreArTranslator();
		return new ApplicationCvScore();
	}
}