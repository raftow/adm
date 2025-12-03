<?php

class NominatingCandidatesArTranslator{
    public static function initData()
    {
        $trad = [];

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
		$trad["nominating_candidates"]["academic_program_id"] = "برنامج الدراسي";
		$trad["nominating_candidates"]["email"] = "البريد الإلكتروني";
		$trad["nominating_candidates"]["mobile"] = "الجوال";
		$trad["nominating_candidates"]["study_funding_status_id"] = "حالة التمويل";
		$trad["nominating_candidates"]["nomination_letter_id"] = "خطاب الترشيح";
		$trad["nominating_candidates"]["applicant_id"] = "المتقدم";
		$trad["nominating_candidates"]["candidateFullName"] = "اسم المرشح";
		$trad["nominating_candidates"]["myApplicationLink"] = "ملف التقديم";
		$trad["nominating_candidates"]["applicantIdLink"] = "المتقدم";
		$trad["nominating_candidates"]["gender_enum"] = "الجنس";
		$trad["nominating_candidates"]["country_id"] = "الجنسية";
		
		
		

        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new NominatingCandidatesEnTranslator();
		return new NominatingCandidates();
	}
}