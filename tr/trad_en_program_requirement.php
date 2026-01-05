<?php

class ProgramRequirementEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["program_requirement"]["programrequirement.single"] = "Program Requirement";
		$trad["program_requirement"]["programrequirement.new"] = "new";
		$trad["program_requirement"]["program_requirement"] = "Program Requirements";
		$trad["program_requirement"]["name_ar"] = "Arabic Program requirement name";
		$trad["program_requirement"]["name_en"] = "English Program requirement name";
		$trad["program_requirement"]["desc_ar"] = "Arabic Program requirement description";
		$trad["program_requirement"]["desc_en"] = "English Program requirement description";
		$trad["program_requirement"]["academic_program_id"] = "Academic program";
		$trad["program_requirement"]["application_class_enum"] = "Application class enum";
		$trad["program_requirement"]["application_requirement_mfk"] = "Application requirements";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new ProgramRequirementArTranslator();
		return new ProgramRequirement();
	}
}