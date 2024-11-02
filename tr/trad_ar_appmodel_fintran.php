<?php
class AppmodelFintranArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["appmodel_fintran"]["appmodelfintran.single"] = "رسم نموذج قبول";
	$trad["appmodel_fintran"]["appmodelfintran.new"] = "جديد ة";
	$trad["appmodel_fintran"]["appmodel_fintran"] = "رسوم نماذج القبول";
	$trad["appmodel_fintran"]["fin_transaction_id"] = "الحركة المالية";
	$trad["appmodel_fintran"]["application_model_id"] = "نموذج القبول";
	$trad["appmodel_fintran"]["amount"] = "المبلغ";
	$trad["appmodel_fintran"]["process_enabled"] = "تفعيل معالجة الدفع";
        return $trad;
        }

        public static function getInstance()
	{
		return new AppmodelFintran();
	}
}
