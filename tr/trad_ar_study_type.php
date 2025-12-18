<?php

class StudyTypeArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["study_type"]["studytype.single"] = "نوع الدراسة";
		$trad["study_type"]["studytype.new"] = "جديد";
		$trad["study_type"]["study_type"] = "أنواع الدراسات";
		$trad["study_type"]["lookup_code"] = "الرمز الفني";
		$trad["study_type"]["name_ar"] = "مسمى نوع الدراسة بالعربية";
		$trad["study_type"]["name_en"] = "مسمى نوع الدراسة بالانجليزية";
		$trad["study_type"]["desc_ar"] = "وصف نوع الدراسة بالعربية";
		$trad["study_type"]["desc_en"] = "وصف نوع الدراسة بالانجليزية";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new StudyTypeEnTranslator();
		return new StudyType();
	}
}