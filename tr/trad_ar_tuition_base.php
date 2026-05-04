<?php
class TuitionBaseArTranslator{

    public static function initData()
    {
        $trad = [];
	$trad["tuition_base"]["step1"] = "التعريف";

	$trad["tuition_base"]["tuitionbase.single"] = "قاعدة حساب الرسوم";
	$trad["tuition_base"]["tuitionbase.new"] = "جديد ة";
	$trad["tuition_base"]["tuition_base"] = "قواعد حساب الرسوم";
	$trad["tuition_base"]["residency_enum"] = "الإقامة";
	$trad["tuition_base"]["semester_type"] = "نوع الفصل الدراسي";
	$trad["tuition_base"]["tuition_model"] = "نموذج الرسوم الدراسية";
	$trad["tuition_base"]["amount"] = "المبلغ";
	$trad["tuition_base"]["program_id"] = "البرنامج";
	$trad["tuition_base"]["program_specific "] = "الرسوم الإضافية الخاصة بالبرنامج";
	$trad["tuition_base"]["mandatory_fees"] = "الرسوم الإلزامية";
	$trad["tuition_base"]["notes"] = "ملاحظات";
	$trad["tuition_base"]["degree_id"] = "الشهادة";
	$trad["tuition_base"]["currency_ar"] = "العملة - العربية";
	$trad["tuition_base"]["currency_en"] = "العملة - الإنجليزية";
	$trad["tuition_base"]["financial_transaction_id"] = "المعاملة المالية";


        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new TuitionBaseEnTranslator();
		return new TuitionBase();
	}
}