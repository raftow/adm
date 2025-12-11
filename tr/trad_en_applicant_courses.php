<?php

class ApplicantCoursesEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_courses"]["applicantcourses.single"] = "Courses and workshops";
		$trad["applicant_courses"]["applicantcourses.new"] = "new";
		$trad["applicant_courses"]["applicant_courses"] = "Courses and workshops";
		$trad["applicant_courses"]["name_ar"] = "Arabic Applicant courses name";
		$trad["applicant_courses"]["name_en"] = "English Applicant courses name";
		$trad["applicant_courses"]["desc_ar"] = "Arabic Applicant courses description";
		$trad["applicant_courses"]["desc_en"] = "English Applicant courses description";
		$trad["applicant_courses"]["applicant_id"] = "Applicant";
		$trad["applicant_courses"]["course_title_ar"] = "Course name arabic";
		$trad["applicant_courses"]["course_title_en"] = "Course name english";
		$trad["applicant_courses"]["course_provider_ar"] = "Course provider arabic";
		$trad["applicant_courses"]["course_provider_en"] = "Course provider english";
		$trad["applicant_courses"]["course_date"] = "Course date";
		$trad["applicant_courses"]["course_duration"] = "Course duration";
		$trad["applicant_courses"]["certificate_ind"] = "certification";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantCoursesArTranslator();
		return new ApplicantCourses();
	}
}