<?php

class ApplicantArTranslator{
    public static function initData()
    {
        $trad = [];
      
		$trad["applicant"]["step1"] = "هوية المتقدم";
		$trad["applicant"]["step2"] = "بيانات المتقدم";
		$trad["applicant"]["step3"] = "المؤهلات والاختبارات";
		$trad["applicant"]["step4"] = "الحالة الاكاديمية";
		$trad["applicant"]["step5"] = "الترشحات";
		$trad["applicant"]["step6"] = "رفع المرفقات";
		$trad["applicant"]["step7"] = "استخدام المرفقات";
		$trad["applicant"]["step8"] = "التحقق من الربط";

		$trad["applicant"]["apis"] = "الخدمات الالكترونية";
		$trad["applicant"]["applicantFileList"] = "قائمة مرفقات المتقدم";
		
		$trad["applicant"]["applicationList"] = "طلبات التقديم";
		$trad["applicant"]["applicantApiRequestList"] = "طلبات تحديث بيانات متقدم";

		$trad["applicant"]["applicantEvaluationList"] = "اختبارات التحصيلي و القدرات";
		$trad["applicant"]["applicantQualificationList"] = "مؤهلات المتقدم";

		$trad["applicant"]["applicantEvaluationsNoFile"] = "اختبارات التحصيلي و القدرات التي لا تزال تحتاج الربط مع الملف المرفق";
		$trad["applicant"]["applicantQualificationsNoFile"] = "مؤهلات المتقدم التي لا تزال تحتاج الربط مع الملف المرفق";
		$trad["applicant"]["qualif"] = "المؤهلات العلمية";
		$trad["applicant"]["appl"] = "بيانات التقديم";
		$trad["applicant"]["evaluation"] = "اختبارات التحصيلي و القدرات";
		

		$trad["applicant"]["applicant.single"] = "متقدم";
		$trad["applicant"]["applicant.new"] = "جديد";
		$trad["applicant"]["applicant"] = "المتقدمون";
		$trad["applicant"]["applicant_"] = "المتقدمين";
		$trad["applicant"]["applicant.short_"] = "المتقدمين";

		$trad["applicant"]["id"] = "رقم الهوية";
		$trad["applicant"]["idn"] = "رقم الهوية";
		$trad["applicant"]["idn-infos"] = "اعدادات ملف المتقدم"; //معلومات الهوية
		$trad["applicant"]["idn_type_id"] = "نوع الهوية";
		$trad["applicant"]["id_issue_place"] = "مكان إصدار الهوية";
		$trad["applicant"]["id_issue_date"] = "تاريخ إصدار الهوية";
		$trad["applicant"]["id_expiry_date"] = "تاريخ إنتهاء الهوية";
		$trad["applicant"]["gender_enum"] = "الجنس";
		$trad["applicant"]["country_id"] = "الجنسية";
		$trad["applicant"]["mother_idn"] = "هوية الام";
		$trad["applicant"]["mother_birth_date"] = "تاريخ ميلاد الام";
		$trad["applicant"]["passeport_num"] = "جواز السفر";
		$trad["applicant"]["passeport_expiry_gdate"] = "تاريخ إنتهاء جواز السفر";
		$trad["applicant"]["username"] = "اسم المستخدم";
		$trad["applicant"]["password"] = "كلمة المرور";
		$trad["applicant"]["email"] = "البريد الالكتروني الشخصي";
		$trad["applicant"]["mobile"] = "الجوال الشخصي";
		$trad["applicant"]["signup _acknoldgment"] = "تعهد بصحة البيانات";
		$trad["applicant"]["first_name_ar"] = "الاسم الأول";
		$trad["applicant"]["father_name_ar"] = "اسم الأب";
		$trad["applicant"]["middle_name_ar"] = "اسم الجد";
		$trad["applicant"]["last_name_ar"] = "اسم العائلة";
		$trad["applicant"]["first_name_en"] = "الاسم الأول بالإنجليزية";
		$trad["applicant"]["father_name_en"] = "اسم الأب بالإنجليزية";
		$trad["applicant"]["middle_name_en"] = "اسم الجد بالإنجليزية";
		$trad["applicant"]["last_name_en"] = "اسم العائلة بالإنجليزية";
		$trad["applicant"]["profile_approved"] = "تم التحقق من البيانات";
		$trad["applicant"]["religion_enum"] = "الديانة";
		$trad["applicant"]["birth_date"] = "تاريخ الميلاد بالهجري";
		$trad["applicant"]["birth_gdate"] = "تاريخ الميلاد بالميلادي";
		$trad["applicant"]["place_of_birth"] = "مكان الميلاد";
		$trad["applicant"]["marital_status_enum"] = "الحالة الاجتماعية";
		
		$trad["applicant"]["signup_acknowldgment"] = "تعهد بصحة البيانات";
		$trad["applicant"]["signup_acknowldgment.EUH"] = "ليس بعد";
		/* $trad["applicant"]["signup_acknoldgment"] = "إقرار الاشتراك";
		$trad["applicant"]["signup_acknoldgment.EUH"] = "ليس بعد";*/
		$trad["applicant"]["comm"] = "بيانات التواصل";
		$trad["applicant"]["account-infos"] = "بيانات الحساب";
		$trad["applicant"]["profile"] = "البيانات الشخصية";
		$trad["applicant"]["job_status"] = "بيانات حالة التوظيف";
		$trad["applicant"]["profile-other"] = "بيانات أخرى";

		$trad["applicant"]["eval"] = "درجات الاختبارات المعتمدة للمؤسسة الأكاديمية";
		$trad["applicant"]["weighted_percentage"] = "النسبة الموزونة";
		$trad["applicant"]["weighted_percentage_details"] = "تفاصيل حساب النسبة الموزونة";
		
		
		
		$trad["applicant"]["bank"] = "بيانات الحساب البنكي";
		$trad["applicant"]["address-infos"] = "العنوان";
		$trad["applicant"]["address"] = "العنوان";
		$trad["applicant"]["address_type_enum"] = "نوع العنوان";
		$trad["applicant"]["country_code"] = "الرمز الدولي";
		$trad["applicant"]["city_id"] = "مدينة الإقامة";
		$trad["applicant"]["postal_code"] = "الرمز البريدي";
		$trad["applicant"]["has_iban"] = "هل لديك حساب بنكي ؟";
		$trad["applicant"]["iban"] = "الحساب البنكي(آيبان)";
		$trad["applicant"]["bank_account_pledge"] = "التعهد بصحة بيانات الحساب البنكي";
		$trad["applicant"]["job_status_enum"] = "الحالة الوظيفية";
		$trad["applicant"]["employer_approval"] = "موافقة من جهة العمل";
		$trad["applicant"]["employer_enum"] = "جهة التوظيف";
		$trad["applicant"]["employer_approval_afile_id"] = "اثبات الموافقة من جهة العمل";
		$trad["applicant"]["guardian"] = "بيانات اتصال الطوارئ";
		$trad["applicant"]["guardian_name"] = "الاسم";
		$trad["applicant"]["guardian_phone"] = "رقم الجوال";
		$trad["applicant"]["guardian_idn"] = "هوية وليّ الأمر";
		$trad["applicant"]["guardian_id_date"] = "تاريخ إنتهاء هوية وليّ الأمر";
		$trad["applicant"]["guardian_id_place"] = "مكان إصدار هوية وليّ الأمر";
		$trad["applicant"]["relationship_enum"] = "صلة القرابة";

		// additional fields
		$trad["applicant"]["rayat"] = "الحالة الأكاديمية في نظام التدريب";
		$trad["applicant"]["hrsd"] = "بيانات مستوردة من وزارة الموارد البشرية";
		$trad["applicant"]["moe"] = "الانتظام بالجامعة";
		$trad["applicant"]["moegraduate"] = "حالة الخريج من الجامعة";
		$trad["applicant"]["qiyas"] = "بيانات مستوردة من هيئة قياس";
		$trad["applicant"]["favorite"] = "إعدادات التقديم المفضلة";
		$trad["applicant"]["preferred_program_track_id"] = "المسار المفضل";
		$trad["applicant"]["application_model_id"] = "نموذج القبول المفضل";
		$trad["applicant"]["applicant_group_id"] = "مجموعة المتقدمين";
		$trad["applicant"]["application_model_branch_mfk"] = "الفروع المفضلة";
		$trad["applicant"]["log"] = "تتبع تفاصيل التقديم والفرز";


		$trad["applicant"]["qiyas_achievement_th"] = "درجةاختبار التحصيل الدراسي-التخصصات النظرية";
		$trad["applicant"]["qiyas_achievement_th_date"] = "تاريخ اختبار التحصيلي-التخصصات النظرية";
		$trad["applicant"]["qiyas_aptitude_sc"] = "درجة اختبار القدرات العامة-التخصصات العلمية";
		$trad["applicant"]["qiyas_aptitude_sc_date"] = "تاريخ اختبار القدرات العامة-التخصصات العلمية";
		$trad["applicant"]["qiyas_aptitude_th"] = "درجة اختبار القدرات العامة-التخصصات النظرية";
		$trad["applicant"]["qiyas_aptitude_th_date"] = "تاريخ اختبار القدرات العامة-التخصصات النظرية";
		$trad["applicant"]["qiyas_achievement_sc"] = "درجةاختبار التحصيل الدراسي-التخصصات العلمية";
		$trad["applicant"]["qiyas_achievement_sc_date"] = "تاريخ اختبار التحصيلي-التخصصات العلمية";
		
		$trad["applicant"]["achievement_score"] = "درجة التحصيلي";
		$trad["applicant"]["aptitude_score"] = "درجة القدرات العامة";
		$trad["applicant"]["secondary_cumulative_pct"] = "درجة الثانوية التراكمية";
		
		 

		// additional fields steps
		// $start_additional_step = 2;
		// $additional_step = $start_additional_step + 1;
		// $trad["applicant"]["step".$additional_step] = "المؤهلات العلمية والاختبارات";// "التربية والتعليم";
		// $additional_step++;
		// $trad["applicant"]["step".$additional_step] = "بيانات الحالة الاكاديمية";//"نظام رايات";
		// $additional_step++;
		/*$trad["applicant"]["step".$additional_step] = "الموارد البشرية";
		$additional_step++;
		$trad["applicant"]["step".$additional_step] = "هيئة قياس";
		$additional_step++;*/

		return $trad;
    }

    public static function getInstance()
	{
		return new Applicant();
	}
}
