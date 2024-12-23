<?php
class ScholarshipTypeArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["scholarship_type"]["scholarshiptype.single"] = "نوع منحة دراسية";
	$trad["scholarship_type"]["scholarshiptype.new"] = "جديدة";
	$trad["scholarship_type"]["scholarship_type"] = "أنواع منح دراسية";
	$trad["scholarship_type"]["scholarship_type_name_ar"] = "مسمى نوع  المنحة الدراسية - عربي";
	$trad["scholarship_type"]["scholarship_type_name_en"] = "مسمى نوع المنحة الدراسية - انجليزي";
        return $trad;
        }

        public static function getInstance()
	{
		return new ScholarshipType();
	}
}