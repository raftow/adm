<?php
class ApplicantScholarshipArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["applicant_scholarship"]["applicantscholarship.single"] = "منحة متقدم";
	$trad["applicant_scholarship"]["applicantscholarship.new"] = "جديد ة";
	$trad["applicant_scholarship"]["applicant_scholarship"] = "منح المتقدمين";
	$trad["applicant_scholarship"]["applicant_id"] = "المتقدم";
	$trad["applicant_scholarship"]["scholarship_id"] = "المنحة";
	$trad["applicant_scholarship"]["applicant_scholarship_status_id"] = "حالة منحة المتقدم";
	$trad["applicant_scholarship"]["application_plan_id"] = "خطة التقديم";
	$trad["applicant_scholarship"]["application_simulation_id"] = "نوع التقديم";
	$trad["applicant_scholarship"]["academic_term_id"] = "الفصل الأكاديمي";
	$trad["applicant_scholarship"]["academic_year_id"] = "السنة الأكاديمية";
	$trad["applicant_scholarship"]["academic_program_id"] = "البرنامج";
	$trad["applicant_scholarship"]["remarks"] = "ملاحظات";
	$trad["applicant_scholarship"]["grant_committee_interview_score"] = "نتيجة مقابلة لجنة المنح";
	$trad["applicant_scholarship"]["grant_committee_letter"] = "خطاب لجنة المنح";

        return $trad;
        }

        public static function getInstance()
	{
		return new ApplicantScholarship();
	}
}