<?php
class ScholarshipBillArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["scholarship_bill"]["scholarshipbill.single"] = "بند منحة دراسية";
	$trad["scholarship_bill"]["scholarshipbill.new"] = "جديد";
	$trad["scholarship_bill"]["scholarship_bill"] = "بنود المنح الدراسية";
	$trad["scholarship_bill"]["scholarship_id"] = "المنحة الدراسية";
	$trad["scholarship_bill"]["financial_transaction_id"] = "نوع الرسوم";
	$trad["scholarship_bill"]["percentage"] = "نسبة مائوية";
	$trad["scholarship_bill"]["amount"] = "المبلغ المالي";
	$trad["scholarship_bill"]["remarks"] = "ملاحظات";
        return $trad;
        }

        public static function getInstance()
	{
		return new ScholarshipBill();
	}
}