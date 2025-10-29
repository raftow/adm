<?php
class TuitionBaseArTranslator{

    public static function initData()
    {
        $trad = [];
	$trad["tuition_base"]["step1"] = "التعريف";

	$trad["tuition_base"]["tuitionbase.single"] = "قاعدة رسوم دراسية";
	$trad["tuition_base"]["tuitionbase.new"] = "جديد ة";
	$trad["tuition_base"]["tuition_base"] = "قواعد رسوم دراسية";
	$trad["tuition_base"]["residency_enum"] = "الإقامة";
	$trad["tuition_base"]["semester_type"] = "نوع الفصل الدراسي";
	$trad["tuition_base"]["tuition_model"] = "نموذج الرسوم الدراسية";
	$trad["tuition_base"]["amount"] = "المبلغ";
	$trad["tuition_base"]["program_id"] = "البرنامج";
	$trad["tuition_base"]["program_specific "] = "الرسوم الإضافية الخاصة بالبرنامج";
	$trad["tuition_base"]["mandatory_fees"] = "الرسوم الإلزامية";
	$trad["tuition_base"]["notes"] = "ملاحظات";
	$trad["tuition_base"]["degree_id"] = "الشهادة";

        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new TuitionBaseEnTranslator();
		return new TuitionBase();
	}
}