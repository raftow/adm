<?php
class ScholarshipEnTranslator{

    public static function initData()
    {
        $trad = [];
	$trad["scholarship"]["step1"] = "Definition";

	$trad["scholarship"]["scholarship.single"] = "Scholarship";
	$trad["scholarship"]["scholarship.new"] = "new";
	$trad["scholarship"]["scholarship"] = "Scholarships";
	$trad["scholarship"]["scholarship_name_ar"] = "Scholarship Name - arabic";
	$trad["scholarship"]["scholarship_name_en"] = "Scholarship Name - english";
	$trad["scholarship"]["scholarship_code"] = "Scholarship Code";
	$trad["scholarship"]["scholarship_type"] = "Scholarship Type";
	$trad["scholarship"]["percentage"] = "Percentage";
	$trad["scholarship"]["cap_amount"] = "Cap Amount";
	$trad["scholarship"]["sponsor_id"] = "Sponsor";
	$trad["scholarship"]["scholarship_date"] = "date";
	$trad["scholarship"]["adm_file_id"] = "Scholarship grant document";
	$trad["scholarship"]["publish"] = "Publish to Portal";
	$trad["scholarship"]["application_start_date"] = "Application Start Date";
	$trad["scholarship"]["application_end_date"] = "Application End Date";
	$trad["scholarship"]["academic_year_id"] = "Academic year";
	$trad["scholarship"]["academic_term_id"] = "Academic term";
	$trad["scholarship"]["academic_program_id"] = "acasemic_program";
        return $trad;
        }

        public static function getInstance()
	{
		return new Scholarship();
	}
}