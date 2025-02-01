<?php
class ApplicantEvaluationEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["applicant_evaluation"]["applicantevaluation.single"] = "Applicant evaluation";
		$trad["applicant_evaluation"]["applicantevaluation.new"] = "new";
		$trad["applicant_evaluation"]["applicant_evaluation"] = "Applicant evaluations";

		$trad["applicant_evaluation"]["evaluation_id"] = "evaluation";
		$trad["applicant_evaluation"]["applicant_id"] = "applicant";
		$trad["applicant_evaluation"]["eval_result"] = "Grade";
		$trad["applicant_evaluation"]["eval_date"] = "Evaluation Date";
		$trad["applicant_evaluation"]["eval_expired_date"] = "expiry validity date";
		$trad["applicant_evaluation"]["eval_level"] = "Evaluation level";
		$trad["applicant_evaluation"]["workflow_file_id"] = "The document";
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ApplicantEvaluationArTranslator();
		return new ApplicantEvaluation();
	}
}
	