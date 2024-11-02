
<?php
class FintransPaymentArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["fintrans_payment"]["fintranspayment.single"] = "دفع رسوم";
	$trad["fintrans_payment"]["fintranspayment.new"] = "جديد ة";
	$trad["fintrans_payment"]["fintrans_payment"] = "دفوعات الرسوم";
	$trad["fintrans_payment"]["applicant_fintrans_id"] = "الحركة المالية";
	$trad["fintrans_payment"]["amount  "] = "المبلغ المدفوع";
	$trad["fintrans_payment"]["payment_status_enum"] = "حالة الدفع";
	$trad["fintrans_payment"]["payment_method_enum"] = "طريقة الدفع";
        return $trad;
        }

        public static function getInstance()
	{
		return new FintransPayment();
	}
}
