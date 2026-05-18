<?php
class FinancialTransactionArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["financial_transaction"]["financialtransaction.single"] = "رمز قيد محاسبي";
	$trad["financial_transaction"]["financialtransaction.new"] = "جديد";
	$trad["financial_transaction"]["financial_transaction"] = "رموز القيود المحاسبية";
	$trad["financial_transaction"]["fee_code"] = "رمز الرسوم";
	$trad["financial_transaction"]["fee_description_ar"] = "بيان الرسوم - عربي";
    $trad["financial_transaction"]["fee_description_en"] = "بيان الرسوم - الإنجليزي";
	$trad["financial_transaction"]["sis_charge_code"] = "رمز الرسوم المحاسبي";
	$trad["financial_transaction"]["sis_payment_code"] = "رمز  الدفع";
	$trad["financial_transaction"]["financial_element_unit_enum"] = "وحدة السعر";
	$trad["financial_transaction"]["add_charge_ind"] = "إضافة مطالبة ؟";
        return $trad;
        }

        public static function getInstance()
	{
		return new FinancialTransaction();
	}
}