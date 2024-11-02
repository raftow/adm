<?php
class FintransPaymentEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["fintrans_payment"]["fintranspayment.single"] = "Fintrans payment";
	$trad["fintrans_payment"]["fintranspayment.new"] = "new";
	$trad["fintrans_payment"]["fintrans_payment"] = "Fintrans payments";
	$trad["fintrans_payment"]["applicant_fintrans_id"] = "Transaction Id";
	$trad["fintrans_payment"]["amount"] = "Total Amount";
	$trad["fintrans_payment"]["payment_status_enum"] = "Payment Status";
	$trad["fintrans_payment"]["payment_method_enum"] = "Payment Method";
        return $trad;
        }

        public static function getInstance()
	{
		return new FintransPayment();
	}
}