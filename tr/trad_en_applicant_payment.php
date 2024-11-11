<?php
class ApplicantPaymentEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["applicant_payment"]["applicantpayment.single"] = "Fintrans payment";
	$trad["applicant_payment"]["applicantpayment.new"] = "new";
	$trad["applicant_payment"]["applicant_payment"] = "Fintrans payments";
	$trad["applicant_payment"]["applicant_account_id"] = "Transaction Id";
	$trad["applicant_payment"]["amount"] = "Total Amount";
	$trad["applicant_payment"]["payment_status_enum"] = "Payment Status";
	$trad["applicant_payment"]["payment_method_enum"] = "Payment Method";
        return $trad;
        }

        public static function getInstance()
	{
		return new ApplicantPayment();
	}
}