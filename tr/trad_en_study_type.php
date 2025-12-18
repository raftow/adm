<?php

class StudyTypeEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["study_type"]["studytype.single"] = "Study type";
		$trad["study_type"]["studytype.new"] = "new";
		$trad["study_type"]["study_type"] = "Study types";
		$trad["study_type"]["name_ar"] = "Arabic Workflow entity name";
		$trad["study_type"]["name_en"] = "English Workflow entity name";
		$trad["study_type"]["desc_ar"] = "Arabic Workflow entity description";
		$trad["study_type"]["desc_en"] = "English Workflow entity description";
		$trad["study_type"]["validated_by"] = "Validated by";
		$trad["study_type"]["validated_at"] = "Validated at";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new StudyTypeArTranslator();
		return new StudyType();
	}
}