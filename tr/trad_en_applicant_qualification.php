<?php

class ApplicantQualificationEnTranslator
{
	public static function initData()
	{
		$trad = [];

		$trad["applicant_qualification"]["step1"] = "Definition";

		$trad["applicant_qualification"]["applicantqualification.single"] = "Applicant qualification";
		$trad["applicant_qualification"]["applicantqualification.new"] = "new";
		$trad["applicant_qualification"]["applicant_qualification"] = "Applicant qualifications";

		$trad["applicant_qualification"]["applicant_id"] = "Applicant";
		$trad["applicant_qualification"]["qualification_id"] = "Qualification Type";
		$trad["applicant_qualification"]["major_category_id"] = "Major Category";
		$trad["applicant_qualification"]["major_path_id"] = "Qualification Group";
		$trad["applicant_qualification"]["qualification_major_id"] = "Qualification Major";
		$trad["applicant_qualification"]["gpa"] = "GPA";
		$trad["applicant_qualification"]["gpa_from"] = "Max GPA";
		$trad["applicant_qualification"]["date"] = "Qualification Date";
		$trad["applicant_qualification"]["source"] = "Qualification Source";
		$trad["applicant_qualification"]["imported"] = "Imported";
		$trad["applicant_qualification"]["import_utility_id"] = "Data Source";
		$trad["applicant_qualification"]["qualification_major_desc"] = "Qualification major description";
		$trad["applicant_qualification"]["adm_file_id"] = "The document";
		$trad["applicant_qualification"]["source_name"] = "Qualification source - text";

		$trad["applicant_qualification"]["country_id"] = "country";
		$trad["applicant_qualification"]["grading_scale_id"] = "grading scale";
		return $trad;
	}

	public static function getInstance()
	{
		if (false) return new ApplicantQualificationArTranslator();
		return new ApplicantQualification();
	}
}
