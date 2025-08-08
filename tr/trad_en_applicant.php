<?php

class ApplicantEnTranslator{
    public static function initData()
    {
        $trad = [];
		$trad["applicant"]["step1"] = "Indetity infos";
		$trad["applicant"]["step2"] = "Personal infos";
		$trad["applicant"]["step3"] = "Qualifications & tests";
		$trad["applicant"]["step4"] = "Academic status data";
		$trad["applicant"]["step5"] = "Submission data";
		$trad["applicant"]["step6"] = "Attachments";
		$trad["applicant"]["step7"] = "Use attachments";
		$trad["applicant"]["step8"] = "Link attachments";

		$trad["applicant"]["apis"] = "Electronic services";
		
		$trad["applicant"]["applicationList"] = "Applications";
		$trad["applicant"]["applicantApiRequestList"] = "Applicant data update requests";

		$trad["applicant"]["applicantQualificationList"] = "Applicant Qualifications";
		$trad["applicant"]["qualif"] = "Academic qualifications";
		$trad["applicant"]["appl"] = "Submission data";
		$trad["applicant"]["applicantEvaluationList"] = "Achievement and aptitude tests";
		$trad["applicant"]["evaluation"] = "Achievement and aptitude tests";
		
		$trad["applicant"]["apis"] = "Apis";
		$trad["applicant"]["applicantFileList"] = "List of attachments";

		$trad["applicant"]["applicant.single"] = "Applicant";
		$trad["applicant"]["applicant.new"] = "new";
		$trad["applicant"]["applicant"] = "Applicants";

		$trad["applicant"]["applicantApiRequestList"] = "List of data refresh requests";

		$trad["applicant"]["id"] = "ID Number";
		$trad["applicant"]["idn"] = "ID Number";
		$trad["applicant"]["idn_type"] = "Identity type";
		$trad["applicant"]["id_issue_place"] = "Place of issuing the ID";
		$trad["applicant"]["id_issue_date"] = "Date of issuance of the ID";
		$trad["applicant"]["id_expiry_date"] = "Identity expiry date";
		$trad["applicant"]["gender_enum"] = "Gender";
		$trad["applicant"]["nationality_id"] = "Nationality";
		$trad["applicant"]["mother_idn"] = "Mother's identity";
		$trad["applicant"]["mother_birth_date"] = "Mother's date of birth";
		$trad["applicant"]["passeport_num"] = "passport";
		$trad["applicant"]["passeport_expiry_gdate"] = "Passport validity date";
		$trad["applicant"]["username"] = "user name";
		$trad["applicant"]["password"] = "password";
		$trad["applicant"]["email"] = "E-mail";
		$trad["applicant"]["mobile"] = "Mobile  phone";
		$trad["applicant"]["signup _acknoldgment"] = "Signup  acknoldgment";
		$trad["applicant"]["first_name_arabic"] = "First Name";
		$trad["applicant"]["father_name_arabic"] = "Name of the Father";
		$trad["applicant"]["middle_name_arabic"] = "Grandfather name";
		$trad["applicant"]["last_name_arabic"] = "family name";
		$trad["applicant"]["first_name"] = "First name in English";
		$trad["applicant"]["second_name"] = "Father's name in English";
		$trad["applicant"]["third_name"] = "Grandfather's name in English";
		$trad["applicant"]["last_name"] = "Family name in English";
		$trad["applicant"]["profile_approved"] = "Data verified";
		$trad["applicant"]["religion_enum"] = "Religion";
		$trad["applicant"]["birth_date"] = "Date of birth in Hijri";
		$trad["applicant"]["birth_gdate"] = "Date of birth in Gregorian";
		$trad["applicant"]["place_of_birth"] = "place of birth";
		$trad["applicant"]["marital status_id"] = "marital status";
		$trad["applicant"]["signup_acknoldgment"] = "Signup acknowldgment";
		$trad["applicant"]["address"] = "Adress";
		$trad["applicant"]["address_type_enum"] = "Address Type";
		$trad["applicant"]["country_code"] = "Country Code";
		$trad["applicant"]["city_id"] = "City of residence";
		$trad["applicant"]["postal_code"] = "Postal Code";
		$trad["applicant"]["has_iban"] = "do you have a bank account ?";
		$trad["applicant"]["iban"] = "IBAN number";
		$trad["applicant"]["bank_account_pledge"] = "Bank account pledge";
		$trad["applicant"]["emp_status"] = "Employment status";
		$trad["applicant"]["employer_approval"] = "Approval from the employer";
		$trad["applicant"]["employer_enum"] = "Employer";
		$trad["applicant"]["employer_approval_afile_id"] = "Approval document from the employer";
		$trad["applicant"]["guardian_name"] = "Name of guardian";
		$trad["applicant"]["guardian_phone"] = "Guardian's mobile phone";
		$trad["applicant"]["guardian_national_id"] = "Identity of the guardian";
		$trad["applicant"]["guardian_id_date"] = "The expiry date of the guardian’s ID";
		$trad["applicant"]["guardian_id_place"] = "Place of issuing the guardian’s ID";
		$trad["applicant"]["relationship_enum"] = "relative relationship";

		$trad["applicant"]["eval"] = "Test scores approved by the academic institution";
		$trad["applicant"]["weighted_percentage"] = "weighted percentage";
		$trad["applicant"]["weighted_percentage_details"] = "weighted percentage calculation details";

		$trad["applicant"]["rayat"] = "Academic status in the training system";
		$trad["applicant"]["hrsd"] = "Data imported from the Ministry of Human Resources";
		$trad["applicant"]["moe"] = "Attendance at university";
		$trad["applicant"]["moegraduate"] = "University graduate status";
		$trad["applicant"]["qiyas"] = "Data imported from Qyias";

		$trad["applicant"]["favorite"] = "Application settings";
		$trad["applicant"]["preferred_program_track_id"] = "Favorite track";
		$trad["applicant"]["application_model_id"] = "Favorite application model";
		$trad["applicant"]["applicant_group_id"] = "Applicant group";
		$trad["applicant"]["application_model_branch_mfk"] = "Favorite branchs";
		$trad["applicant"]["log"] = "Log application and sorting details";
		$trad["applicant"]["disability_ind"] = "There are disabilities ?";
		$trad["applicant"]["disability"] = "Disabilities";
		$trad["applicant"]["disability_mfk"] = "Disabilities list";

		$trad["applicant"]["qiyas_achievement_th"] = "Academic achievement test score - theoretical";
		$trad["applicant"]["qiyas_achievement_th_date"] = "Date of the achievement test - theoretical";
		$trad["applicant"]["qiyas_aptitude_sc"] = "General aptitude test score - scientific";
		$trad["applicant"]["qiyas_aptitude_sc_date"] = "Date of the general aptitude test - scientific";
		$trad["applicant"]["qiyas_aptitude_th"] = "General aptitude test score - theoretical";
		$trad["applicant"]["qiyas_aptitude_th_date"] = "Date of general aptitude testing - theoretical";
		$trad["applicant"]["qiyas_achievement_sc"] = "Academic achievement test score - scientific";
		$trad["applicant"]["qiyas_achievement_sc_date"] = "Date of the achievement test - scientific";
		$trad["applicant"]["profile_populated"] = "Profile populated";

		return $trad;
    }

    public static function getInstance()
	{
		return new Applicant();
	}
}