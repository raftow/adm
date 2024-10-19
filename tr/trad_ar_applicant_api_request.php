<?php
class ApplicantApiRequestArTranslator
{

    public static function initData()
    {
        $trad = [];

        $trad["applicant_api_request"]["applicantapirequest.single"] = "طلب تحديث بيانات متقدم";
        $trad["applicant_api_request"]["applicantapirequest.new"] = "جديد";
        $trad["applicant_api_request"]["applicant_api_request"] = "طلبات تحديث بيانات متقدم";
        $trad["applicant_api_request"]["applicant_id"] = "المتقدم";
        $trad["applicant_api_request"]["api_endpoint_id"] = "الخدمة الالكترونية";
        $trad["applicant_api_request"]["run_date"] = "تاريخ  التنفيذ";
        $trad["applicant_api_request"]["need_refresh"] = "يحتاج تحديث";
        return $trad;
    }

    public static function getInstance()
    {
        return new ApplicantApiRequest();
    }
}
