<?php
class ApplicantAccountEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["applicant_account"]["applicantaccount.single"] = "Applicant fintrans";
	$trad["applicant_account"]["applicantaccount.new"] = "new";
	$trad["applicant_account"]["applicant_account"] = "Applicant fintranss";
	$trad["applicant_account"]["applicant_id"] = "Applicant";
	$trad["applicant_account"]["application_plan_id"] = "application plan";
	$trad["applicant_account"]["application_simulation_id"] = "application type";
	$trad["applicant_account"]["application_model_financial_transaction_id"] = "Application Model Finacial Transaction";
	$trad["applicant_account"]["total_amount"] = "Total Amount";
	$trad["applicant_account"]["payment_status_enum"] = "Payment Status";
	$trad["applicant_account"]["activated_fee"] = "Activate payment for the applicant";
	$trad["applicant_account"]["due_date"] = "due date";
	$trad["applicant_account"]["academic_period_id"] = "Academic period";

        return $trad;
        }

        public static function getInstance()
	{
		return new ApplicantAccount();
	}
}