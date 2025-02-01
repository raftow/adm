<?php

class ApplicantEvaluationArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_evaluation"]["applicantevaluation.single"] = "اختبار متقدم";
		$trad["applicant_evaluation"]["applicantevaluation.new"] = "جديد";
		$trad["applicant_evaluation"]["applicant_evaluation"] = "اختبارات المتقدم";

		$trad["applicant_evaluation"]["evaluation_id"] = "الاختبار";
		$trad["applicant_evaluation"]["applicant_id"] = "المتقدم";
		$trad["applicant_evaluation"]["eval_result"] = "درجة الاختبار";
		$trad["applicant_evaluation"]["eval_date"] = "تاريخ الاختبار";
		$trad["applicant_evaluation"]["eval_expired_date"] = "نهاية صلاحية الاختبار";
		$trad["applicant_evaluation"]["eval_level"] = "مستوى الاختبار";
		$trad["applicant_evaluation"]["imported"] = "تم التحقق";
		$trad["applicant_evaluation"]["workflow_file_id"] = "المرفق";
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantEvaluationEnTranslator();
		return new ApplicantEvaluation();
	}
}

	