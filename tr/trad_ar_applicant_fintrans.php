<?php
class ApplicantFintransArTranslator{

    public static function initData()
    {
        $trad = [];

	$trad["applicant_fintrans"]["applicantfintrans.single"] = "رسوم متقدم";
	$trad["applicant_fintrans"]["applicantfintrans.new"] = "جديد ة";
	$trad["applicant_fintrans"]["applicant_fintrans"] = "رسوم المتقدمين";
	$trad["applicant_fintrans"]["applicant_id"] = "المتقدم";
	$trad["applicant_fintrans"]["application_id"] = "طلب التقديم";
	$trad["applicant_fintrans"]["appmodel_fintran_id"] = "نوع الحركة المالية";
	$trad["applicant_fintrans"]["total_amount  "] = "المبلغ الإجمالي";
	$trad["applicant_fintrans"]["payment_status_enum"] = "حالة الدفع";
        return $trad;
        }

        public static function getInstance()
	{
		return new ApplicantFintrans();
	}
}
