<?php

class ApplicantFileArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_file"]["applicantfile.single"] = "مرفق";
		$trad["applicant_file"]["applicantfile.new"] = "جديد(ة)";
		$trad["applicant_file"]["applicant_file"] = "مرفقات المتقدم";
		$trad["applicant_file"]["name_ar"] = "مسمى  بالعربية";
		$trad["applicant_file"]["desc_ar"] = "وصف  بالعربية";
		$trad["applicant_file"]["name_en"] = "مسمى  بالانجليزية";
		$trad["applicant_file"]["desc_en"] = "وصف  بالانجليزية";
		$trad["applicant_file"]["applicant_id"] = "المتقدم";
		$trad["applicant_file"]["idn"] = "رقم هوية المتقدم";
		$trad["applicant_file"]["workflow_file_id"] = "الملف";
		$trad["applicant_file"]["doc_type_id"] = "نوع المستند";
		$trad["applicant_file"]["document_type_id"] = "نوع الوثيقة (في البوابة)";

		$trad["applicant_file"]["approved"] = "حالة الاعتماد";
		$trad["applicant_file"]["approved.YES"] = "تم الاعتماد";
		$trad["applicant_file"]["approved.NO"]  = "تم الرفض";
		$trad["applicant_file"]["approved.EUH"] = "جاري العمل عليه";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
		if(false) return new ApplicantFileEnTranslator();
		return new ApplicantFile();
	}
}