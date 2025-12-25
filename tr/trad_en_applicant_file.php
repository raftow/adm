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
		$trad["applicant_file"]["document_type_id"] = "document type (admission portal)";
		$trad["applicant_file"]["download_light"] = "Download";
		$trad["applicant_file"]["reupload_enum"] = "Re-upload file ?";



        // steps
        return $trad;
    }

    public static function getInstance()
	{
		if(false) return new ApplicantFileArTranslator();
		return new ApplicantFile();
	}
}