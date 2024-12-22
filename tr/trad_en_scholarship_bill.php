<?php
class ScholarshipBillEnTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["scholarship_bill"]["scholarshipbill.single"] = "Scholarship bill";
	$trad["scholarship_bill"]["scholarshipbill.new"] = "new";
	$trad["scholarship_bill"]["scholarship_bill"] = "Scholarship bills";
	$trad["scholarship_bill"]["scholarship_id"] = "Scholarship";
	$trad["scholarship_bill"]["financial_transaction_id"] = "Bill item";
	$trad["scholarship_bill"]["percentage"] = "Percentage";
	$trad["scholarship_bill"]["amount"] = "Cap Amount";
	$trad["scholarship_bill"]["remarks"] = "Remarks";
        return $trad;
        }

        public static function getInstance()
	{
		return new ScholarshipBill();
	}
}