<?php
class AdmWorkflowService
{
    public static function loadOriginalObject($wApplicantObj, $wSessionObj, $wModelObj, $wRequestObj)
    {
        $country_id = $wApplicantObj->getVal('country_id');
        $idn_type_id = $wApplicantObj->getVal('idn_type_id');
        $idn = $wApplicantObj->getVal('idn');
        $applicantObj = Applicant::loadByMainIndex($country_id, $idn_type_id, $idn);
        $applicant_id = $applicantObj->id;
        // list($xxx, $application_plan_id) = explode('-', $wSessionObj->getVal('external_code'));
        $external_request_code = $wRequestObj->getVal('external_request_code');
        $external_request_code = str_replace('A', 'X', $external_request_code);
        $external_request_code = str_replace('P', 'X', $external_request_code);
        $external_request_code = str_replace('S', 'X', $external_request_code);
        $external_request_code = str_replace('D', 'X', $external_request_code);

        list($wApplicantObjId, $applicationPlanId, $application_simulation_id, $desire_num) = explode('X', $external_request_code);

        $objDesire = ApplicationDesire::loadByMainIndex($applicant_id, $applicationPlanId, $application_simulation_id, $desire_num);
        $keyLookup = "applicant_id=$applicant_id, PlanId=$applicationPlanId, simulation_id=$application_simulation_id, desire_num=$desire_num";
        return [$objDesire, $keyLookup];
    }
}
