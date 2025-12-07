<?php

class NominatingCandidatesArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["nominating_candidates"]["step1"] = "تعريف المترشح";
		$trad["nominating_candidates"]["step2"] = "البيانات الشخصية";
		$trad["nominating_candidates"]["step3"] = "المؤهل العلمي";
		$trad["nominating_candidates"]["step4"] = "رفع الوثائق";
		$trad["nominating_candidates"]["step5"] = "طلب التقديم";
		$trad["nominating_candidates"]["step6"] = "معلومات متقدمة";

		$trad["nominating_candidates"]["nominatingcandidates.single"] = "مرشح";
		$trad["nominating_candidates"]["nominatingcandidates.new"] = "جديد(ة)";
		$trad["nominating_candidates"]["nominating_candidates"] = "المرشحين";
		$trad["nominating_candidates"]["name_ar"] = "مسمى  بالعربية";
		$trad["nominating_candidates"]["desc_ar"] = "وصف  بالعربية";
		$trad["nominating_candidates"]["name_en"] = "مسمى  بالانجليزية";
		$trad["nominating_candidates"]["desc_en"] = "وصف  بالانجليزية";
		$trad["nominating_candidates"]["identity_type_id"] = "نوع الهوية";
		$trad["nominating_candidates"]["idn"] = "الهوية";
		$trad["nominating_candidates"]["first_name_ar"] = "الاسم الأول عربي";
		$trad["nominating_candidates"]["second_name_ar"] = "اسم الأب عربي";
		$trad["nominating_candidates"]["third_name_ar"] = "اسم الجد عربي";
		$trad["nominating_candidates"]["last_name_ar"] = "الاسم الأخير عربي";
		$trad["nominating_candidates"]["first_name_en"] = "الاسم الأول انجليزي";
		$trad["nominating_candidates"]["second_name_en"] = "اسم الأب انجليزي";
		$trad["nominating_candidates"]["third_name_en"] = "اسم الجد انجليزي";
		$trad["nominating_candidates"]["last_name_en"] = "الاسم الأخير انجليزي";
		$trad["nominating_candidates"]["academic_program_id"] = "البرنامج الذي اسند عليه المترشح";
		$trad["nominating_candidates"]["email"] = "البريد الإلكتروني";
		$trad["nominating_candidates"]["mobile"] = "الجوال";
		$trad["nominating_candidates"]["study_funding_status_id"] = "حالة التمويل";
		$trad["nominating_candidates"]["nomination_letter_id"] = "خطاب الترشيح";
		$trad["nominating_candidates"]["application_plan_id"] = "خطة التقديم";
		$trad["nominating_candidates"]["application_simulation_id"] = "نوع التقديم";
		$trad["nominating_candidates"]["applicant_id"] = "المتقدم";
		$trad["nominating_candidates"]["candidateFullName"] = "اسم المرشح";
		$trad["nominating_candidates"]["myApplicationLink"] = "ملف التقديم";
		$trad["nominating_candidates"]["applicantLink"] = "استكمال البيانات";
		$trad["nominating_candidates"]["gender_enum"] = "الجنس";
		$trad["nominating_candidates"]["country_id"] = "الجنسية";
		$trad["nominating_candidates"]["track_overpass_user_id"] = "الموظف الذي قام بفسح التجاوز للمسار";
		$trad["nominating_candidates"]["track_overpass_user_id.short"] = "موظف التجاوز";
		$trad["nominating_candidates"]["track_overpass"] = "تم فسح تجاوز المسار للبرنامج الذي اسند عليه المترشح؟";
		$trad["nominating_candidates"]["track_overpass.short"] = "تجاوز المسار؟";
		$trad["nominating_candidates"]["track_overpass_gdate"] = "تاريخ فسح التجاوز للمسار";

		$trad["nominating_candidates"]["rating_overpass_user_id"] = "الموظف الذي قام بفسح التجاوز لشرط التقدير";
		$trad["nominating_candidates"]["rating_overpass_user_id.short"] = "موظف التجاوز";
		$trad["nominating_candidates"]["rating_overpass"] = "تم فسح تجاوز شرط التقدير لهذا المترشح؟";
		$trad["nominating_candidates"]["rating_overpass.short"] = "تجاوز التقدير؟";
		$trad["nominating_candidates"]["rating_overpass_gdate"] = "تاريخ فسح التجاوز لشرط التقدير";


		$trad["nominating_candidates"]["qualification_id"] = "المؤهل";
		$trad["nominating_candidates"]["major_category_id"] = "فئة التخصص";
		$trad["nominating_candidates"]["major_path_id"] = "مجموعة التأهيل";
		$trad["nominating_candidates"]["qualification_major_id"] = "تخصص المؤهل";
		$trad["nominating_candidates"]["gpa"] = "المعدل";
		$trad["nominating_candidates"]["gpa_from"] = "من";
		$trad["nominating_candidates"]["date"] = "تاريخ  المؤهل";
		$trad["nominating_candidates"]["qualification_major_desc"] = "وصف تخصص المؤهل";
		$trad["nominating_candidates"]["adm_file_id"] = "المرفق";
		$trad["nominating_candidates"]["source_name"] = "مصدر المؤهل - نص";
		$trad["nominating_candidates"]["country_id"] = "الدولة";
		$trad["nominating_candidates"]["grading_scale_id"] = "التقدير";
		
		
		
		

        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new NominatingCandidatesEnTranslator();
		return new NominatingCandidates();
	}
}