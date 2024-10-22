<?php
class ApplicationRecommendationEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["application_recommendation"]["applicationrecommendation.single"] = "Application recommendation";
	$trad["application_recommendation"]["applicationrecommendation.new"] = "new";
	$trad["application_recommendation"]["application_recommendation"] = "Application recommendations";
	$trad["application_recommendation"]["recommendation_letter_id"] = "recommendation letter";
	$trad["application_recommendation"]["application_id"] = "Application";
	$trad["application_recommendation"]["lor_status_enum"] = "LOR Status";
	$trad["application_recommendation"]["notification_sent"] = "LOR approal Request";
	$trad["application_recommendation"]["notification_date"] = "Approval Request Date";
	$trad["application_recommendation"]["notification_type_enum"] = "Notification type";
	$trad["application_recommendation"]["approval_user_id"] = "Approval  id";
	$trad["application_recommendation"]["comments"] = "Comments";
        return $trad;
        }

        public static function getInstance()
	{
		return new ApplicationRecommendation();
	}
}
