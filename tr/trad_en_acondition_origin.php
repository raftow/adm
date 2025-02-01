<?php

class AconditionOriginEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["acondition_origin"]["aconditionorigin.single"] = "Regulation";
		$trad["acondition_origin"]["aconditionorigin.new"] = "new";
		$trad["acondition_origin"]["acondition_origin"] = "Regulations";
		$trad["acondition_origin"]["acondition_origin_type_id"] = "Regulation type";
		$trad["acondition_origin"]["acondition_origin_order"] = "Order";
		$trad["acondition_origin"]["general"] = "General for all branchs";
		$trad["acondition_origin"]["acondition_origin_name_ar"] = "Regulation name arabic";
		$trad["acondition_origin"]["acondition_origin_name_en"] = "Regulation name english";
		$trad["acondition_origin"]["afile_id"] = "The file";
		$trad["acondition_origin"]["valid_from_date"] = "Valid from";
		$trad["acondition_origin"]["valid_to_date"] = "Valid to";
		$trad["acondition_origin"]["cvalid"] = "Valid now";
		$trad["acondition_origin"]["acondition_origin_desc_ar"] = "Regulation description arabic";
		$trad["acondition_origin"]["acondition_origin_desc_en"] = "Regulation description english";
		$trad["acondition_origin"]["application_model_mfk"] = "????? ?????? ???????";
		$trad["acondition_origin"]["academic_program_mfk"] = "??????? ???????";
		$trad["acondition_origin"]["aconditionOriginScopeList"] = "List of Acondition origin scopes";
		$trad["acondition_origin"]["aconditionList"] = "List of ??????";
		$trad["acondition_origin"]["composedAconditionList"] = "?????? ???????";
		$trad["acondition_origin"]["otherAconditionList"] = "???? ????";

		$trad["acondition_origin"]["aconditionOriginScopeList"] = "مجالات التطبيق";

		$trad["acondition_origin"]["general"] = "General";
		
		$trad["acondition_origin"]["general.short"] = "General";
		$trad["acondition_origin"]["afile_id"] = "file";
		$trad["acondition_origin"]["valid_from_date"] = "valid from";
		$trad["acondition_origin"]["valid_to_date"] = "valid to";
		$trad["acondition_origin"]["cvalid"] = "currently valid";
		
		$trad["acondition_origin"]["acondition_origin_desc_ar"] = "Arabic Text of the regulation or decision";
		$trad["acondition_origin"]["acondition_origin_desc_en"] = "English Text of the regulation or decision";

		$trad["acondition_origin"]["application_model_mfk"] = "Concerned application models";
		$trad["acondition_origin"]["academic_program_mfk"] = "Concerned programs";
		$trad["acondition_origin"]["program_track_mfk"] = "Concerned program tracks";

		
        // steps
		$trad["acondition_origin"]["step1"] = "Definiion";
		$trad["acondition_origin"]["step2"] = "Applying scope";
		$trad["acondition_origin"]["step3"] = "Admission conditions";
		$trad["acondition_origin"]["step4"] = "Other conditions";
        return $trad;
    }

    public static function getInstance()
	{
		return new AconditionOrigin();
	}
}