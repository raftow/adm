	<?php

	class AppModelApiEnTranslator{
		public static function initData()
		{
			$trad = [];
	
			$trad["app_model_api"]["appmodelapi.single"] = "App model api";
			$trad["app_model_api"]["appmodelapi.new"] = "new";
			$trad["app_model_api"]["app_model_api"] = "App model apis";
			$trad["app_model_api"]["application_model_id"] = "Application Model";
			$trad["app_model_api"]["api_endpoint_id"] = "Api Endpoint";
			$trad["app_model_api"]["manadatory"] = "Mandatory";
			$trad["app_model_api"]["can_refresh"] = "Can Refresh";
			$trad["app_model_api"]["duration_expiry"] = "Duration Expiry";
			$trad["app_model_api"]["published"] = "Published";
			// steps
			$trad["app_model_api"]["step1"] = "step1";
			return $trad;
		}
	
		public static function getInstance()
		{
			return new AppModelApi();
		}
	}	