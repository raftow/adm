<?php
class RecommendationLetterEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["recommendation_letter"]["recommendationletter.single"] = "Recommendation letter";
	$trad["recommendation_letter"]["recommendationletter.new"] = "new";
	$trad["recommendation_letter"]["recommendation_letter"] = "Recommendation letters";
	$trad["recommendation_letter"]["applicant_id"] = "Applicant Id";
	$trad["recommendation_letter"]["recommender_name"] = "Recommender Name";
	$trad["recommendation_letter"]["mobile"] = "Mobile";
	$trad["recommendation_letter"]["email"] = "Email";
	$trad["recommendation_letter"]["occupation"] = "Occupation / Position";
	$trad["recommendation_letter"]["organization_name"] = "Organization Name";
	$trad["recommendation_letter"]["lor_type"] = "LOR Type";
	$trad["recommendation_letter"]["adm_file_id"] = "LOR file";
	$trad["recommendation_letter"]["status"] = "Status";
        return $trad;
        }

        public static function getInstance()
	{
		return new RecommendationLetter();
	}
}