<?php
class AppmodelFintranEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["appmodel_fintran"]["appmodelfintran.single"] = "Appmodel fintran";
	$trad["appmodel_fintran"]["appmodelfintran.new"] = "new";
	$trad["appmodel_fintran"]["appmodel_fintran"] = "Appmodel fintrans";
	$trad["appmodel_fintran"]["fin_transaction_id"] = "Finacial Transaction";
	$trad["appmodel_fintran"]["application_model_id"] = "Application Model";
	$trad["appmodel_fintran"]["amount"] = "Amount";
	$trad["appmodel_fintran"]["process_enabled"] = "Payment Process Enabled";
        return $trad;
        }

        public static function getInstance()
	{
		return new AppmodelFintran();
	}
}