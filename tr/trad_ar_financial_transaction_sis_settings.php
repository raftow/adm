<?php

class FinancialTransactionSisSettingsArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["financial_transaction_sis_settings"]["financialtransactionsissettings.single"] = "إعدادت معاملة مالية";
		$trad["financial_transaction_sis_settings"]["financialtransactionsissettings.new"] = "جديد(ة)";
		$trad["financial_transaction_sis_settings"]["financial_transaction_sis_settings"] = "إعدادت المعاملات المالية";
		$trad["financial_transaction_sis_settings"]["name_ar"] = "مسمى  بالعربية";
		$trad["financial_transaction_sis_settings"]["name_en"] = "مسمى  بالانجليزية";
		$trad["financial_transaction_sis_settings"]["desc_ar"] = "وصف  بالعربية";
		$trad["financial_transaction_sis_settings"]["desc_en"] = "وصف  بالانجليزية";
		$trad["financial_transaction_sis_settings"]["financial_transaction_id"] = "الحركة المالية";
		$trad["financial_transaction_sis_settings"]["application_class_id"] = "تصنيف التقديم";
		$trad["financial_transaction_sis_settings"]["add_charge_ind"] = "إضافة المطالبات";
		$trad["financial_transaction_sis_settings"]["add_payment_ind"] = "يمكن الإلغاء";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new FinancialTransactionSisSettingsEnTranslator();
		return new FinancialTransactionSisSettings();
	}
}