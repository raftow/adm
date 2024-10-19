<?php

class ApplicantEnTranslator{
    public static function initData()
    {
        $trad = [];
		$trad["applicant"]["step1"] = "Indetity infos";
		$trad["applicant"]["step2"] = "Personal infos";
		$trad["applicant"]["step3"] = "Advanced infos";

		$trad["applicant"]["applicant.single"] = "Applicant";
		$trad["applicant"]["applicant.new"] = "new";
		$trad["applicant"]["applicant"] = "Applicants";

		$trad["applicant"]["applicantApiRequestList"] = "List of data refresh requests";

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
		return $trad;
    }

    public static function getInstance()
	{
		return new Applicant();
	}
}