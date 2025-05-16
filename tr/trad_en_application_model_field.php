<?php

	class ApplicationModelFieldEnTranslator{
		public static function initData()
		{
			$trad = [];
	
			$trad["application_model_field"]["applicationmodelfield.single"] = "Application model field";
			$trad["application_model_field"]["applicationmodelfield.new"] = "new";
			$trad["application_model_field"]["application_model_field"] = "Application model fields";

			$trad["application_model_field"]["application_model_id"] = "The application model";
			$trad["application_model_field"]["acondition_id"] = "The condition";
			$trad["application_model_field"]["application_field_id"] = "The field";
			$trad["application_model_field"]["screen_model_id"] = "The screen";
			$trad["application_model_field"]["step_num"] = "The step number";
			$trad["application_model_field"]["api_endpoint2_id"] = "Alternative API";
			$trad["application_model_field"]["api_endpoint_id"] = "API";
			$trad["application_model_field"]["answer"] = "Show the selection list on the front-end";
			$trad["application_model_field"]["mandatory"] = "mandatory";
			
			// steps
			$trad["application_model_field"]["step1"] = "step1";
			return $trad;
		}
	
		public static function getInstance()
		{
			return new ApplicationModelField();
		}
	}	