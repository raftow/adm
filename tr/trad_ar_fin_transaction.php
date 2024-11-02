<?php
class FinTransactionArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["fin_transaction"]["fintransaction.single"] = "حركة مالية";
	$trad["fin_transaction"]["fintransaction.new"] = "جديدة";
	$trad["fin_transaction"]["fin_transaction"] = "الحركات المالية";
	$trad["fin_transaction"]["fee_code"] = "رمز الرسوم";
	$trad["fin_transaction"]["fee_description_ar"] = "بيان الرسوم - عربي";
    $trad["fin_transaction"]["fee_description_en"] = "بيان الرسوم - الإنجليزي";
	$trad["fin_transaction"]["sis_charge_code"] = "رمز الرسوم المحاسبي";
	$trad["fin_transaction"]["sis_payment_code"] = "رمز  الدفع";
        return $trad;
        }

        public static function getInstance()
	{
		return new FinTransaction();
	}
}