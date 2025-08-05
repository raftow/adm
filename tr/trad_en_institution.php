<?php

class InstitutionEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["institution"]["institution.single"] = "Institution";
		$trad["institution"]["institution.new"] = "new";
		$trad["institution"]["institution"] = "Institutions";
		$trad["institution"]["apiEndpointList"] = "List of Api endpoints";
		$trad["institution"]["institution_code"] = "Institution Code";
		$trad["institution"]["country_id"] = "Country";
		$trad["institution"]["institution_name_ar"] = "Institution Name - Ar";
		$trad["institution"]["institution_name_en"] = "Institution Name - Ar";
		$trad["institution"]["map_location"] = "Map Location";
		$trad["institution"]["website"] = "API Url";
		$trad["institution"]["logo_file_id"] = "Logo";
		$trad["institution"]["background_file_id"] = "Background";
		$trad["institution"]["adress"] = "Adress English";
		$trad["institution"]["facebook_profile_link"] = "Facebook";
		$trad["institution"]["linkedin_profile_link"] = "Linkedin";
		$trad["institution"]["youtube_profile_link"] = "Youtube";
		$trad["institution"]["snapchat_profile_link"] = "Snapchat";
		$trad["institution"]["twitter_profile_link"] = "Twitter";
		$trad["institution"]["instagram_profile_link"] = "Instagram";
		$trad["institution"]["application_model_id"] = "Simulate the application model";
		$trad["institution"]["application_plan_id"] = "Simulate the application plan";
        // steps
		$trad["institution"]["step1"] = "Definition";
		$trad["institution"]["step2"] = "Adresses";
		$trad["institution"]["step3"] = "Settings";
		$trad["institution"]["step4"] = "APIs";

		$trad["institution"]["apiEndpointList"] = "Available APIs";
		$trad["institution"]["Institution_description_ar"] = "Institution description arabic ";

		$trad["institution"]["Institution_description_en"] = "Institution description english ";

		$trad["institution"]["adress_ar"] = "Adress arabic";
		$trad["institution"]["main_color1"] = "Main color 1";
		$trad["institution"]["main_color2"] = "Main color 2";
		$trad["institution"]["horizontal_logo_file_id"] = "Horizontal logo file";
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new InstitutionArTranslator();
		return new Institution();
	}
}