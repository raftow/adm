<?php
class ApplicationModelFinancialTransactionEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["application_model_financial_transaction"]["applicationmodelfinancialtransaction.single"] = "Application model financial transaction";
	$trad["application_model_financial_transaction"]["applicationmodelfinancialtransaction.new"] = "new";
	$trad["application_model_financial_transaction"]["application_model_financial_transaction"] = "Application model financial transactions";
	$trad["application_model_financial_transaction"]["financial_transaction_id"] = "Finacial Transaction";
	$trad["application_model_financial_transaction"]["application_model_id"] = "Application Model";
	$trad["application_model_financial_transaction"]["amount"] = "Amount";
	$trad["application_model_financial_transaction"]["process_enabled"] = "Payment Process Enabled";
        return $trad;
        }

        public static function getInstance()
	{
		return new ApplicationModelFinancialTransaction();
	}
}