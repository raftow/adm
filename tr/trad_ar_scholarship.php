<?php
class ScholarshipArTranslator{

    public static function initData()
    {
        $trad = [];
	$trad["scholarship"]["step1"] = "التعريف";

	$trad["scholarship"]["scholarship.single"] = "منحة";
	$trad["scholarship"]["scholarship.new"] = "جديد ة";
	$trad["scholarship"]["scholarship"] = "منح";
	$trad["scholarship"]["scholarship_name_ar"] = "مسمى المنحة الدراسية - عربي";
	$trad["scholarship"]["scholarship_name_en"] = "مسمى المنحة الدراسية - انجليزي";
	$trad["scholarship"]["scholarship_code"] = "رمز المنحة الدراسية";
	$trad["scholarship"]["scholarship_type"] = "نوع المنحة";
	$trad["scholarship"]["percentage"] = "نسبة مائوية";
	$trad["scholarship"]["cap_amount"] = "الحد الأقصى للمبلغ";
	$trad["scholarship"]["sponsor_id"] = "المانح";
	$trad["scholarship"]["scholarship_date"] = "التاريخ";
	$trad["scholarship"]["adm_file_id"] = "وثيقة المنحة الدراسية";
	$trad["scholarship"]["publish"] = "تفعيل النشر";
	$trad["scholarship"]["application_start_date"] = "تاريخ بداية التقديم";
	$trad["scholarship"]["application_end_date"] = "تاريخ نهاية التقديم";
	$trad["scholarship"]["academic_year_id"] = "العام الأكاديمي";
	$trad["scholarship"]["academic_term_id"] = "الفصل الدراسي";
	$trad["scholarship"]["academic_program_id"] = "البرنامج";
        return $trad;
        }

        public static function getInstance()
	{
		return new Scholarship();
	}
}
