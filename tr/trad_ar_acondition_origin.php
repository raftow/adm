<?php
class AconditionOriginArTranslator{
    public static function initData()
    {
        $trad = [];
		$trad["acondition_origin"]["step1"] = "التعريف";
		$trad["acondition_origin"]["step2"] = "مجال التطبيق";
		$trad["acondition_origin"]["step3"] = "شروط القبول";
		$trad["acondition_origin"]["step4"] = "أجزاء الشروط";
		
		$trad["acondition_origin"]["otherAconditionList"] = "أجزاء الشروط";
		

		$trad["acondition_origin"]["aconditionorigin.single"] = "لائحة أوقرار";
		$trad["acondition_origin"]["aconditionorigin.new"] = "جديد";
		$trad["acondition_origin"]["acondition_origin"] = "القرارات و اللوائح";
		$trad["acondition_origin"]["acondition_origin_name_ar"] = "مسمى اللائحة أوالقرار";
		
		$trad["acondition_origin"]["acondition_origin_order"] = "ترقيم اللائحة أوالقرار";
		$trad["acondition_origin"]["acondition_origin_order.short"] = "ترقيم";
		$trad["acondition_origin"]["acondition_origin_name_en"] = "مسمى اللائحة أوالقرار انجليزي";
		$trad["acondition_origin"]["acondition_origin_type_id"] = "نوع اللائحة أوالقرار";
		$trad["acondition_origin"]["aconditionList"] = "الشروط البسيطة";
		$trad["acondition_origin"]["composedAconditionList"] = "الشروط المركبة";
		
		$trad["acondition_origin"]["aconditionOriginScopeList"] = "مجالات التطبيق";

		$trad["acondition_origin"]["general"] = "تطبيق الشروط على مستوى";
		$trad["acondition_origin"]["general.YES"] = "المتقدم";
		$trad["acondition_origin"]["general.EUH"]  = "المتقدم وملف الترشح";
		$trad["acondition_origin"]["general.NO"] = "المتقدم وملف الترشح والرغبة";
		
		$trad["acondition_origin"]["general.short"] = "عام";
		$trad["acondition_origin"]["afile_id"] = "الملف";
		$trad["acondition_origin"]["valid_from_date"] = "الصلاحية من تاريخ";
		$trad["acondition_origin"]["valid_to_date"] = "إلى تاريخ";
		$trad["acondition_origin"]["cvalid"] = "صالح حاليا";
		
		$trad["acondition_origin"]["acondition_origin_desc_ar"] = "نص اللائحة أوالقرار";
		$trad["acondition_origin"]["acondition_origin_desc_en"] = "نص اللائحة أوالقرار انجليزي";

		$trad["acondition_origin"]["application_model_mfk"] = "نماذج القبول المعنية";
		$trad["acondition_origin"]["academic_program_mfk"] = "البرامج المعنية";
		$trad["acondition_origin"]["program_track_mfk"] = "المسارات المعنية";
	
		return $trad;
    }

    public static function getInstance()
	{
		return new AconditionOrigin();
	}
}


	
?>