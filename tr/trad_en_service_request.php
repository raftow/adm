<?php
class ServiceRequestEnTranslator{

    public static function initData()
    {
        $trad = [];
	$trad["service_request"]["step1"] = "Definition";

	$trad["service_request"]["servicerequest.single"] = "Service request";
	$trad["service_request"]["servicerequest.new"] = "new";
	$trad["service_request"]["service_request"] = "Service requests";
	$trad["service_request"]["idn"] = "identity number";
	$trad["service_request"]["first_name"] = "first name";
	$trad["service_request"]["last_name"] = "last name";
	$trad["service_request"]["mobile"] = "mobile";
	$trad["service_request"]["email"] = "email";
	$trad["service_request"]["service_category_id"] = "service category";
	$trad["service_request"]["service_item_id"] = "service item";
	$trad["service_request"]["subject"] = "subject";
	$trad["service_request"]["description"] = "description";
	$trad["service_request"]["applicant_file_id"] = "applicant file";
	$trad["service_request"]["application_plan_id"] = "application plan";
	$trad["service_request"]["request_status_id"] = "request status";
	$trad["service_request"]["request_type_id"] = "request type";
	$trad["service_request"]["status_comment"] = "status comment";
    $trad["service_request"]["status_date"] = "status date";
    $trad["service_request"]["applicant_id"] = "applicant";

        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new ServiceRequestArTranslator();
		return new ServiceRequest();
	}
}