<?php
class FinancialTransactionEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["financial_transaction"]["financialtransaction.single"] = "financial transaction";
	$trad["financial_transaction"]["financialtransaction.new"] = "new";
	$trad["financial_transaction"]["financial_transaction"] = "financial transactions";
	$trad["financial_transaction"]["fee_code"] = "Fee Code";
	$trad["financial_transaction"]["fee_description_ar"] = "Fee Description -Ar";
	$trad["financial_transaction"]["fee_description_en"] = "Fee Description -En";
	$trad["financial_transaction"]["sis_charge_code"] = "Accounting Fee Code";
	$trad["financial_transaction"]["sis_payment_code"] = "Payment Code";
        return $trad;
        }

        public static function getInstance()
	{
		return new FinancialTransaction();
	}
}
