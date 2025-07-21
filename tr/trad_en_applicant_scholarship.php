<?php
class ApplicantScholarshipEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["applicant_scholarship"]["applicantscholarship.single"] = "Applicant scholarship";
	$trad["applicant_scholarship"]["applicantscholarship.new"] = "new";
	$trad["applicant_scholarship"]["applicant_scholarship"] = "Applicant scholarships";
	$trad["applicant_scholarship"]["applicant_id"] = "applicant";
	$trad["applicant_scholarship"]["scholarship_id"] = "scholarship";
	$trad["applicant_scholarship"]["applicant_scholarship_status_id"] = "applicant scholarship status";
	$trad["applicant_scholarship"]["application_plan_id"] = "application plan";
	$trad["applicant_scholarship"]["application_simulation_id"] = "application type";
	$trad["applicant_scholarship"]["academic_term_id"] = "academic term";
	$trad["applicant_scholarship"]["academic_year_id"] = "academic year";
	$trad["applicant_scholarship"]["academic_program_id"] = "academic_program";
	$trad["applicant_scholarship"]["remarks"] = "Remarks";
        return $trad;
        }

        public static function getInstance()
	{
		return new ApplicantScholarship();
	}
}