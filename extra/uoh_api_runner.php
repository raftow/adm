<?php
class UohApiRunner {

    public static function register_apis()
    {
        return ['offline_data', 'moi_person_info'];
    }

    public static function run_api_mlsd_disability($applicantObject)
    {
        // return [$error, $info, $warning, $tech]
        return ["not implemented", "", "", ""];
    }


    

    public static function run_api_mohe_graduate_record($applicantObject)
    {
        // return [$error, $info, $warning, $tech]
        // return ["not implemented", "", "", ""];
        return ["", "done", "", ""];
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

    public static function run_api_qiyas_exam_result($applicantObject)
    {
        
        $at27 = $applicantObject->getVal("attribute_27");
        if($at27==0)
        {
            $new_at27 ="N";
            
        }
        else 
        {
            $r = random_int(0,100);
            $new_at27 = ($r < 93) ? "Y" : "N";
            
        }
        $applicantObject->set("attribute_27", $new_at27);

        $at11 = $applicantObject->getVal("attribute_11");
        if($at11==0)
        {
            $new_at11 ="N";
            
        }
        else 
        {
            $r = random_int(0,100);
            $new_at11 = ($r > 93) ? "Y" : "N";
            
        }
        $applicantObject->set("attribute_11", $new_at11);
        

        $applicantObject->commit();
        return ["", "done attribute_27 was $at27 and become $new_at27, attribute_11 was $at11 and become $new_at11", "", ""];
        
    }

    public static function run_api_rayat_api($applicantObject)
    {
        // return [$error, $info, $warning, $tech]
        // return ["not implemented", "", "", ""];
        return ["", "done", "", ""];
    }

    

    

    



}