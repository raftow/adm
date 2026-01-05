<?php

class ProgramRequirementArTranslator
{
	public static function initData()
	{
		$trad = [];

		$trad['program_requirement']['programrequirement.single'] = 'متطلب برنامج';
		$trad['program_requirement']['programrequirement.new'] = 'جديد(ة)';
		$trad['program_requirement']['program_requirement'] = 'متطلبات البرامج';
		$trad['program_requirement']['academic_program_id'] = 'البرنامج الدراسي';
		$trad['program_requirement']['application_category_enum'] = 'صنف طلب التقديم';
		$trad['program_requirement']['application_class_enum'] = 'قسم طلب التقديم';
		$trad['program_requirement']['application_requirement_mfk'] = 'متطلبات التقديم';
		// steps
		return $trad;
	}

	public static function getInstance()
	{
		if (false)
			return new ProgramRequirementEnTranslator();
		return new ProgramRequirement();
	}
}
