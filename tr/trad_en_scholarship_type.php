<?php
class ScholarshipTypeEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["scholarship_type"]["scholarshiptype.single"] = "Scholarship type";
	$trad["scholarship_type"]["scholarshiptype.new"] = "new";
	$trad["scholarship_type"]["scholarship_type"] = "Scholarship types";
	$trad["scholarship_type"]["scholarship_type_name_ar"] = "Scholarship type Name - arabic";
	$trad["scholarship_type"]["scholarship_type_name_en"] = "Scholarship type Name - english";
        return $trad;
        }

        public static function getInstance()
	{
		return new ScholarshipType();
	}
}