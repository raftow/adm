<?php

class ApplicantQualificationArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_evaluation"]["applicantevaluation.single"] = "اختبار المتقدم";
		$trad["applicant_evaluation"]["applicantevaluation.new"] = "جديد ة";
		$trad["applicant_evaluation"]["applicant_evaluation"] = "اختبارات المتقدم";

		$trad["applicant_evaluation"]["evaluation_id"] = "الاختبار";
		$trad["applicant_evaluation"]["applicant_id"] = "المتقدم";
		$trad["applicant_evaluation"]["eval_result"] = "درجة الاختبار";
		$trad["applicant_evaluation"]["eval_date"] = "تاريخ الاختبار";
		$trad["applicant_evaluation"]["eval_expired_date"] = "نهاية صلاحية الاختبار";
		$trad["applicant_evaluation"]["eval_level"] = "مستوى الاختبار";
		$trad["applicant_evaluation"]["imported"] = "تم التحقق";
		$trad["applicant_evaluation"]["adm_file_id"] = "المرفق";
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantQualificationEnTranslator();
		return new ApplicantQualification();
	}
}

	