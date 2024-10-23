<?php
class TvtcApiRunner {

    public static function register_apis()
    {
        return ['offline_data', 'moi_personal'];
    }

    public static function run_api_mlsd_disability($applicantObject)
    {
        // return [$error, $info, $warning, $tech]
        return ["not implemented", "", "", ""];
    }


    

    public static function run_api_moe_academic_infos($applicantObject)
    {
        $at27 = $applicantObject->getVal("attribute_27");
        if($at27==0)
        {
            $applicantObject->set("attribute_27","N");
            
        }
        else 
        {
            $r = random_int(0,100);
            $at27 = ($r < 93) ? "Y" : "N";
            $applicantObject->set("attribute_27", $at27);
        }
        // return [$error, $info, $warning, $tech]

        $applicantObject->commit();
        return ["", "done attribute_27 was $at27", "", ""];
    }


    public static function run_api_moe_qualifications($applicantObject)
    {
        // return [$error, $info, $warning, $tech]
        return ["", "done", "", ""];
    }


    public static function run_api_moi_person_info($applicantObject)
    {
        // return [$error, $info, $warning, $tech]
        return ["", "done", "", ""];
    }


    public static function run_api_tvtc_academic_infos($applicantObject)
    {
        // return [$error, $info, $warning, $tech]
        // return ["not implemented", "", "", ""];
        return ["", "done", "", ""];
    }


    public static function run_api_offline_data($applicantObject)
    {
        // return [$error, $info, $warning, $tech]
        // return ["not implemented", "", "", ""];
        return ["", "done", "", ""];
    }

    public static function run_api_msc_employee_info($applicantObject)
    {
        // return [$error, $info, $warning, $tech]
        // return ["not implemented", "", "", ""];
        return ["", "done", "", ""];
    }


    



}