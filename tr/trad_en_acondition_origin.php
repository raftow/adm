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
        // steps
		$trad["acondition_origin"]["step1"] = "التعريف";
		$trad["acondition_origin"]["step2"] = "مجال التطبيق";
		$trad["acondition_origin"]["step3"] = "شروط القبول";
		$trad["acondition_origin"]["step4"] = "شروط اخرى";
        return $trad;
    }

    public static function getInstance()
	{
		return new AconditionOrigin();
	}
}