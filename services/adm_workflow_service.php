<?php
class AdmWorkflowService
{
    private static $desireObj = [];
    private static $applicantObj = [];

    public static function loadOriginalObject($wApplicantObj, $wSessionObj, $wModelObj, $wRequestObj)
    {
        $country_id  = $wApplicantObj->getVal('country_id');
        $idn_type_id = $wApplicantObj->getVal('idn_type_id');
        $idn         = $wApplicantObj->getVal('idn');
        $applicant_key = "$country_id-$idn_type_id-$idn";
        if (!self::$applicantObj[$applicant_key]) {
            self::$applicantObj[$applicant_key] = Applicant::loadByMainIndex($country_id, $idn_type_id, $idn);
            if (!self::$applicantObj[$applicant_key]) self::$applicantObj[$applicant_key] = "not-found";
        }
        $applicantObj = self::$applicantObj[$applicant_key];
        if ($applicantObj === "not-found") $applicantObj = null;
        if (!$applicantObj) return [null, null]; // lost original object
        $applicant_id = $applicantObj->id;

        // list($xxx, $application_plan_id) = explode('-', $wSessionObj->getVal('external_code'));
        $external_request_code = $wRequestObj->getVal('external_request_code');
        $external_request_code = str_replace('A', 'X', $external_request_code);
        $external_request_code = str_replace('P', 'X', $external_request_code);
        $external_request_code = str_replace('S', 'X', $external_request_code);
        $external_request_code = str_replace('D', 'X', $external_request_code);

        list($wApplicantObjId, $applicationPlanId, $application_simulation_id, $desire_num) = explode('X', trim($external_request_code, 'X'));

        $desire_key = "$applicant_id-$applicationPlanId-$application_simulation_id-$desire_num";

        if (!self::$desireObj[$desire_key]) {
            self::$desireObj[$desire_key] = ApplicationDesire::loadByMainIndex($applicant_id, $applicationPlanId, $application_simulation_id, $desire_num);
            if (!self::$desireObj[$desire_key]) self::$desireObj[$desire_key] = "not-found";
        }
        $desireObj = self::$desireObj[$desire_key];
        if ($desireObj === "not-found") $desireObj = null;
        $keyLookup = "applicant_id=$applicant_id, PlanId=$applicationPlanId, simulation_id=$application_simulation_id, desire_num=$desire_num";
        return [$desireObj, $keyLookup];
    }

    public static function loadOriginalScopeObject($wScopeObj)
    {
        $program_code = $wScopeObj->getVal('lookup_code');
        if ($program_code) {
            return AcademicProgram::loadByMainIndex($program_code);
        } else
            return null;
    }

    public static function loadOriginalSubScopeObject($wSubScopeObj)
    {
        // $workflow_module_id, $workflow_scope_id, $lookup_code
        $apb_id = $wSubScopeObj->getVal('lookup_code');
        if ($apb_id) {
            return ApplicationPlanBranch::loadById($apb_id);
        } else
            return null;
    }
}
