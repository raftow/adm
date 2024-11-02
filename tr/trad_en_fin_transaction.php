<?php
class FinTransactionEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["fin_transaction"]["fintransaction.single"] = "Fin transaction";
	$trad["fin_transaction"]["fintransaction.new"] = "new";
	$trad["fin_transaction"]["fin_transaction"] = "Fin transactions";
	$trad["fin_transaction"]["fee_code"] = "Fee Code";
	$trad["fin_transaction"]["fee_description_ar"] = "Fee Description -Ar";
	$trad["fin_transaction"]["fee_description_en"] = "Fee Description -En";
	$trad["fin_transaction"]["sis_charge_code"] = "Accounting Fee Code";
	$trad["fin_transaction"]["sis_payment_code"] = "Payment Code";
        return $trad;
        }

        public static function getInstance()
	{
		return new FinTransaction();
	}
}
