<?php

class ApplicantCoursesArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_courses"]["applicantcourses.single"] = "دورة ورشة عمل علمية";
		$trad["applicant_courses"]["applicantcourses.new"] = "جديدة";
		$trad["applicant_courses"]["applicant_courses"] = "الدورات وورش العمل العلمية";
		$trad["applicant_courses"]["name_ar"] = "مسمى  بالعربية";
		$trad["applicant_courses"]["name_en"] = "مسمى  بالانجليزية";
		$trad["applicant_courses"]["desc_ar"] = "وصف  بالعربية";
		$trad["applicant_courses"]["desc_en"] = "وصف  بالانجليزية";
		$trad["applicant_courses"]["applicant_id"] = "المتقدم";
		$trad["applicant_courses"]["course_title_ar"] = "اسم الدورة عربي";
		$trad["applicant_courses"]["course_title_en"] = "اسم الدورة انجليزي";
		$trad["applicant_courses"]["course_provider_ar"] = "الجهة المقدمة عربي";
		$trad["applicant_courses"]["course_provider_en"] = "الجهة المقدمة انجليزي";
		$trad["applicant_courses"]["course_date"] = "تاريخ الدورة";
		$trad["applicant_courses"]["course_duration"] = "مدة الدورة";
		$trad["applicant_courses"]["certificate_ind"] = "هل لديك شهادة";
		$trad["applicant_courses"]["certificate_file_id"] = "الشهادة";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantCoursesEnTranslator();
		return new ApplicantCourses();
	}
}