<?php
class ApplicantAccountArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["applicant_account"]["applicantaccount.single"] = "رسوم متقدم";
	$trad["applicant_account"]["applicantaccount.new"] = "جديد ة";
	$trad["applicant_account"]["applicant_account"] = "رسوم المتقدمين";
	$trad["applicant_account"]["applicant_id"] = "المتقدم";
	$trad["applicant_account"]["application_id"] = "طلب التقديم";
	$trad["applicant_account"]["application_model_financial_transaction_id"] = "نوع الحركة المالية";
	$trad["applicant_account"]["total_amount"] = "المبلغ الإجمالي";
	$trad["applicant_account"]["payment_status_enum"] = "حالة الدفع";
        return $trad;
        }

        public static function getInstance()
	{
		return new ApplicantAccount();
	}
}
