<?php
class FinancialTransactionArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["financial_transaction"]["financialtransaction.single"] = "حركة مالية";
	$trad["financial_transaction"]["financialtransaction.new"] = "جديدة";
	$trad["financial_transaction"]["financial_transaction"] = "الحركات المالية";
	$trad["financial_transaction"]["fee_code"] = "رمز الرسوم";
	$trad["financial_transaction"]["fee_description_ar"] = "بيان الرسوم - عربي";
    $trad["financial_transaction"]["fee_description_en"] = "بيان الرسوم - الإنجليزي";
	$trad["financial_transaction"]["sis_charge_code"] = "رمز الرسوم المحاسبي";
	$trad["financial_transaction"]["sis_payment_code"] = "رمز  الدفع";
        return $trad;
        }

        public static function getInstance()
	{
		return new FinancialTransaction();
	}
}