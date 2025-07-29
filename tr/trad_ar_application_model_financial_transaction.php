<?php
class ApplicationModelFinancialTransactionArTranslator{

    public static function initData()
    {
        $trad = [];
	$trad["application_model_financial_transaction"]["step1"] = "البنود المالية";

	$trad["application_model_financial_transaction"]["applicationmodelfinancialtransaction.single"] = "رسم نموذج قبول";
	$trad["application_model_financial_transaction"]["applicationmodelfinancialtransaction.new"] = "جديد ة";
	$trad["application_model_financial_transaction"]["application_model_financial_transaction"] = "رسوم نماذج القبول";
	$trad["application_model_financial_transaction"]["financial_transaction_id"] = "الحركة المالية";
	$trad["application_model_financial_transaction"]["application_model_id"] = "نموذج القبول";
	$trad["application_model_financial_transaction"]["amount"] = "المبلغ";
	$trad["application_model_financial_transaction"]["process_enabled"] = "تفعيل معالجة الدفع";
	$trad["application_model_financial_transaction"]["phase_enum"] = "المرحلة";
	
        return $trad;
        }

        public static function getInstance()
	{
		return new ApplicationModelFinancialTransaction();
	}
}
