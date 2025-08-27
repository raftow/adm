<?php

class ApplicantQualificationArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_qualification"]["step1"] = "التعريف";

		$trad["applicant_qualification"]["applicantqualification.single"] = "مؤهل متقدم";
		$trad["applicant_qualification"]["applicantqualification.new"] = "جديد";
		$trad["applicant_qualification"]["applicant_qualification"] = "مؤهلات المتقدمين";
	
		$trad["applicant_qualification"]["applicant_id"] = "المتقدم";
		$trad["applicant_qualification"]["qualification_id"] = "المؤهل";
		$trad["applicant_qualification"]["major_category_id"] = "فئة التخصص";
		$trad["applicant_qualification"]["major_path_id"] = "مجموعة التأهيل";
		$trad["applicant_qualification"]["qualification_major_id"] = "تخصص المؤهل";
		$trad["applicant_qualification"]["gpa"] = "المعدل";
		$trad["applicant_qualification"]["gpa_from"] = "من";
		$trad["applicant_qualification"]["date"] = "تاريخ  المؤهل";
		$trad["applicant_qualification"]["source"] = "الجهة مصدر المؤهل";
		$trad["applicant_qualification"]["imported"] = "تم التحقق";
		$trad["applicant_qualification"]["imported.help"] = "تم التحقق من المؤهلات";
		$trad["applicant_qualification"]["import_utility_id"] = "مصدر استيراد البيانات";
		$trad["applicant_qualification"]["qualification_major_desc"] = "وصف تخصص المؤهل";
		$trad["applicant_qualification"]["adm_file_id"] = "المرفق";
		$trad["applicant_qualification"]["source_name"] = "مصدر المؤهل - نص";
		$trad["applicant_qualification"]["educational_zone_id"] = "المنطقة التعليمية";
		
		$trad["applicant_qualification"]["country_id"] = "الدولة";
		$trad["applicant_qualification"]["grading_scale_id"] = "تصنيف الدرجة";

		
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantQualificationEnTranslator();
		return new ApplicantQualification();
	}
}