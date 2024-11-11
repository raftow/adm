
<?php
class ApplicantPaymentArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["applicant_payment"]["applicantpayment.single"] = "دفع رسوم";
	$trad["applicant_payment"]["applicantpayment.new"] = "جديد ة";
	$trad["applicant_payment"]["applicant_payment"] = "دفوعات الرسوم";
	$trad["applicant_payment"]["applicant_account_id"] = "الحركة المالية";
	$trad["applicant_payment"]["amount  "] = "المبلغ المدفوع";
	$trad["applicant_payment"]["payment_status_enum"] = "حالة الدفع";
	$trad["applicant_payment"]["payment_method_enum"] = "طريقة الدفع";
        return $trad;
        }

        public static function getInstance()
	{
		return new ApplicantPayment();
	}
}
