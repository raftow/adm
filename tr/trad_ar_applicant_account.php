<?php
class ApplicantAccountArTranslator
{

	public static function initData()
	{
		$trad = [];

		$trad["applicant_account"]["applicantaccount.single"] = "رسوم متقدم";
		$trad["applicant_account"]["applicantaccount.new"] = "جديد ة";
		$trad["applicant_account"]["applicant_account"] = "رسوم المتقدمين";
		$trad["applicant_account"]["applicant_id"] = "المتقدم";
		$trad["applicant_account"]["application_plan_id"] = "خطة التقديم";
		$trad["applicant_account"]["application_simulation_id"] = "نوع التقديم";
		$trad["applicant_account"]["application_model_financial_transaction_id"] = "نوع الحركة المالية";
		$trad["applicant_account"]["total_amount"] = "المبلغ الإجمالي";
		$trad["applicant_account"]["payment_status_enum"] = "حالة الدفع";
		$trad["applicant_account"]["activated_fee"] = "تفعيل الدفع للمتقدم";
		$trad["applicant_account"]["due_date"] = "تاريخ الاستحقاق";
		$trad["applicant_account"]["academic_period_id"] = "فترة التقديم";
		$trad["applicant_account"]["payment_deadline"] = "آخر تاريخ للدفع";
		
		return $trad;
		if(false) return ApplicantAccountEnTranslator::initData();
	}

	public static function getInstance()
	{		
		return new ApplicantAccount();
	}
}
