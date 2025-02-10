<?php
class UohCopyFromProspect {

    public static function checkProspect($idn)
    {
        $prospect = AfwDatabase::db_recup_rows("select * from ".$server_db_prefix."adm.prospect_applicant where idn = '".$idn."'");
        return $prospect;
    }

    public static function copy_from_prospect($idn)
    {
        $prospect = $this->checkProspect($idn);
        if($prospect["id"]){
            $applicantObj = Applicant::loadByMainIndex($idn);
            
            $applicantObj->set("id",$prospect["idn"]);
            $applicantObj->set("created_at",$prospect["created_at"]);
            $applicantObj->set("email",$prospect["email"]);
            $applicantObj->set("mobile",$prospect["mobile"]);
            $applicantObj->set("country_id",$prospect["country_id"]);
            $applicantObj->set("idn_type_id",$prospect["idn_type_id"]);
            $applicantObj->set("idn",$prospect["idn"]);
            $applicantObj->set("id_issue_place",$prospect["id_issue_place"]);
            $applicantObj->set("id_issue_date",$prospect["id_issue_date"]);
            $applicantObj->set("id_expiry_date",$prospect["id_expiry_date"]);
            $applicantObj->set("gender_enum",$prospect["gender_enum"]);
            $applicantObj->set("mother_saudi_ind",$prospect["mother_saudi_ind"]);
            $applicantObj->set("mother_idn",$prospect["mother_idn"]);
            $applicantObj->set("mother_birth_date",$prospect["mother_birth_date"]);
            $applicantObj->set("passeport_num",$prospect["passeport_num"]);
            $applicantObj->set("passeport_expiry_gdate",$prospect["passeport_expiry_gdate"]);
            $applicantObj->set("religion_enum",$prospect["religion_enum"]);
            $applicantObj->set("first_name_ar",$prospect["first_name_ar"]);
            $applicantObj->set("father_name_ar",$prospect["father_name_ar"]);
            $applicantObj->set("middle_name_ar",$prospect["middle_name_ar"]);
            $applicantObj->set("last_name_ar",$prospect["last_name_ar"]);
            $applicantObj->set("first_name_en",$prospect["first_name_en"]);
            $applicantObj->set("father_name_en",$prospect["father_name_en"]);
            $applicantObj->set("middle_name_en",$prospect["middle_name_en"]);
            $applicantObj->set("last_name_en",$prospect["last_name_en"]);
            $applicantObj->set("birth_date",$prospect["birth_date"]);
            $applicantObj->set("birth_gdate",$prospect["birth_gdate"]);
            $applicantObj->set("place_of_birth",$prospect["place_of_birth"]);
            $applicantObj->set("marital_status_enum",$prospect["marital_status_enum"]);
            $applicantObj->set("profile_approved",$prospect["profile_approved"]);
            $applicantObj->set("address_type_enum",$prospect["address_type_enum"]);
            $applicantObj->set("address",$prospect["address"]);
            $applicantObj->set("city_id",$prospect["city_id"]);
            $applicantObj->set("postal_code",$prospect["postal_code"]);
            $applicantObj->set("country_code",$prospect["country_code"]);
            //$applicantObj->set("username",$prospect["idn"]);
            //$applicantObj->set("password",$prospect["idn"]);
            $applicantObj->set("signup_acknowldgment",$prospect["signup_acknowldgment"]);
            $applicantObj->set("has_iban",$prospect["has_iban"]);
            $applicantObj->set("iban",$prospect["iban"]);
            $applicantObj->set("bank_account_pledge",$prospect["bank_account_pledge"]);
            $applicantObj->set("job_status_enum",$prospect["job_status_enum"]);
            $applicantObj->set("employer_approval",$prospect["employer_approval"]);
            $applicantObj->set("employer_enum",$prospect["employer_enum"]);
            $applicantObj->set("employer_approval_afile_id",$prospect["employer_approval_afile_id"]);
            $applicantObj->set("guardian_name",$prospect["guardian_name"]);
            $applicantObj->set("guardian_phone",$prospect["guardian_phone"]);
            $applicantObj->set("guardian_idn",$prospect["guardian_idn"]);
            $applicantObj->set("guardian_id_date",$prospect["guardian_id_date"]);
            $applicantObj->set("guardian_id_place",$prospect["guardian_id_place"]);
            $applicantObj->set("relationship_enum",$prospect["relationship_enum"]);
            
            $applicantObj->set("attribute_1",$prospect["mohe_regular"]);
            $applicantObj->set("attribute_2",$prospect["mohe_Institution"]);
            $applicantObj->set("attribute_3",$prospect["mohe_activity_date"]);
            $applicantObj->set("attribute_4",$prospect["Universities_Graduated_ind"]);
            $applicantObj->set("attribute_5",$prospect["rayat_closed"]);
            $applicantObj->set("attribute_6",$prospect["rayat_closed_semester"]);
            $applicantObj->set("attribute_8",$prospect["rayat_dismissed"]);
            $applicantObj->set("attribute_9",$prospect["rayat_dismissed_semester"]);
            $applicantObj->set("attribute_11",$prospect["rayat_continuing_ind"]);
            $applicantObj->set("attribute_12",$prospect["rayat_EN_graduated_ind"]);
            $applicantObj->set("attribute_13",$prospect["rayat_DP_graduated_ind"]);
            $applicantObj->set("attribute_14",$prospect["rayat_UG_graduated_ind"]);
            $applicantObj->set("attribute_15",$prospect["rayat_PR_graduated_ind"]);
            $applicantObj->set("attribute_16",$prospect["rayat_AS_graduated_ind"]);
            $applicantObj->set("attribute_17",$prospect["rayat_activity_date"]);
            $applicantObj->set("attribute_18",$prospect["children_of_martyrs"]);
            $applicantObj->set("attribute_19",$prospect["children_of_martyrs_check_method_id"]);
            $applicantObj->set("attribute_20",$prospect["children_of_martyrs_afile_id"]);
            $applicantObj->set("attribute_21",$prospect["saudi_ind"]);
            $applicantObj->set("attribute_22",$prospect["is_deaf"]);
            $applicantObj->set("attribute_23",$prospect["high_inst_qualified_ind"]);
            $applicantObj->set("attribute_24",$prospect["medium_Proficiency_cert_ind"]);
            $applicantObj->set("attribute_25",$prospect["tech_College_diploma_ind"]);
            $applicantObj->set("attribute_26",$prospect["sec_school_ind"]);
            $applicantObj->set("attribute_27",$prospect["qiyas_aptitude_ind"]);
            $applicantObj->set("attribute_28",$prospect["qiyas_achievement_ind"]);
            $applicantObj->set("attribute_29",$prospect["qiyas_achievement_th"]);
            $applicantObj->set("attribute_30",$prospect["qiyas_achievement_th_date"]);
            $applicantObj->set("attribute_31",$prospect["qiyas_aptitude_sc"]);
            $applicantObj->set("attribute_32",$prospect["qiyas_aptitude_sc_date"]);
            $applicantObj->set("attribute_33",$prospect["qiyas_aptitude_th"]);
            $applicantObj->set("attribute_34",$prospect["qiyas_aptitude_th_date"]);
            $applicantObj->set("attribute_35",$prospect["qiyas_achievement_sc"]);
            $applicantObj->set("attribute_36",$prospect["qiyas_achievement_sc_date"]);
            $applicantObj->set("attribute_37",$prospect["qiyas_activity_date"]);
            $applicantObj->set("sci_id",$prospect["SISId"]); 
            
            $applicantObj->commit();
            $qualifications = $this->getProspectQualification($prospect["id"]);
            foreach($qualifications as $qual){
                $applicant_qualification = ApplicantQualification::loadByMainIndex($prospect["idn"], $prospect["qualification_id"], $prospect["major_category_id"], true);
                $applicant_qualification->set("applicant_id",$prospect["idn"]);
                $applicant_qualification->set("qualification_id",$applicant_qualification["qualification_id"]);
                $applicant_qualification->set("major_category_id",$applicant_qualification["major_category_id"]);
                $applicant_qualification->set("major_path_id",$applicant_qualification["major_path_id"]);
                $applicant_qualification->set("qualification_major_id",$applicant_qualification["qualification_major_id"]);
                $applicant_qualification->set("gpa",$applicant_qualification["gpa"]);
                $applicant_qualification->set("gpa_from",$applicant_qualification["gpa_from"]);
                $applicant_qualification->set("date",$applicant_qualification["date"]);
                $applicant_qualification->set("source",$applicant_qualification["source"]);
                $applicant_qualification->set("imported",$applicant_qualification["imported"]);
                $applicant_qualification->set("qualification_major_desc",$applicant_qualification["qualification_major_desc"]);

                $applicant_qualification->commit();
            }
            return true;
        }else{
            return false;
        }
    }

    public function getProspectQualification($id){
        $prospect_qualification = AfwDatabase::db_recup_rows("select * from ".$server_db_prefix."adm.prospect_qualification where applicant_id = '".$id."'");
        return $prospect_qualification;
    }
     



}