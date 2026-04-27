<?php

class FinancialTransactionSisSettingsEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["financial_transaction_sis_settings"]["financialtransactionsissettings.single"] = "Financial transaction sis settings";
		$trad["financial_transaction_sis_settings"]["financialtransactionsissettings.new"] = "new";
		$trad["financial_transaction_sis_settings"]["financial_transaction_sis_settings"] = "Financial transaction sis settings";
		$trad["financial_transaction_sis_settings"]["name_ar"] = "Arabic Financial transaction sis settings name";
		$trad["financial_transaction_sis_settings"]["name_en"] = "English Financial transaction sis settings name";
		$trad["financial_transaction_sis_settings"]["desc_ar"] = "Arabic Financial transaction sis settings description";
		$trad["financial_transaction_sis_settings"]["desc_en"] = "English Financial transaction sis settings description";
		$trad["financial_transaction_sis_settings"]["financial_transaction_id"] = "Financial transaction";
		$trad["financial_transaction_sis_settings"]["application_class_id"] = "Application class";
		$trad["financial_transaction_sis_settings"]["add_charge_ind"] = "char.1";
		$trad["financial_transaction_sis_settings"]["add_payment_ind"] = "char.1";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new FinancialTransactionSisSettingsArTranslator();
		return new FinancialTransactionSisSettings();
	}
}