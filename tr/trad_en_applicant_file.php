<?php

class ApplicantFileEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_file"]["applicantfile.single"] = "Applicant file";
		$trad["applicant_file"]["applicantfile.new"] = "new";
		$trad["applicant_file"]["applicant_file"] = "applicant file";
		$trad["applicant_file"]["name_ar"] = "Arabic Applicant file name";
		$trad["applicant_file"]["desc_ar"] = "Arabic Applicant file description";
		$trad["applicant_file"]["name_en"] = "English Applicant file name";
		$trad["applicant_file"]["desc_en"] = "English Applicant file description";
		$trad["applicant_file"]["applicant_id"] = "The applicant";
		$trad["applicant_file"]["workflow_file_id"] = "The file";
		$trad["applicant_file"]["doc_type_id"] = "The document type";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
		return new ApplicantFile();
	}
}