<?php
class TuitionBaseEnTranslator{

    public static function initData()
    {
        $trad = [];
	$trad["tuition_base"]["step1"] = "Definition";

	$trad["tuition_base"]["tuitionbase.single"] = "Tuition base";
	$trad["tuition_base"]["tuitionbase.new"] = "new";
	$trad["tuition_base"]["tuition_base"] = "Tuition bases";
	$trad["tuition_base"]["residency_enum"] = "Residency";
	$trad["tuition_base"]["semester_type"] = "Semester type";
	$trad["tuition_base"]["tuition_model"] = "Tuition Model";
	$trad["tuition_base"]["amount"] = "Rate Amount";
	$trad["tuition_base"]["program_id"] = "Academic Program";
	$trad["tuition_base"]["program_specific "] = "program-specific surcharges";
	$trad["tuition_base"]["mandatory_fees"] = "Mandatory Fees";
	$trad["tuition_base"]["notes"] = "Notes";
        return $trad;
        }

        public static function getInstance()
	{
                if(false) return new TuitionBaseArTranslator();
		return new TuitionBase();
	}
}
