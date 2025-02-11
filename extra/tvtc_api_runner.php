<?php
class TvtcApiRunner {

    public static function register_apis()
    {
        return ['offline_data', 'moi_person_info'];
    }

    public static function run_api_mlsd_disability($applicantObject)
    {
        // return [$error, $info, $warning, $tech]
        return ["not implemented", "", "", ""];
    }


    public static function randomizeYNAttribute($attribute, $applicantObject, $maxProbabilityForYes=50)
    {
        $old = $applicantObject->getVal($attribute);
        if($old==0)
        {
            $new ="N";
        }
        else 
        {
            $r = random_int(0,100);
            $new = ($r <= $maxProbabilityForYes) ? "Y" : "N";
            
        }
        $applicantObject->set($attribute, $new);

        return [$old, $new];
    }

    public static function run_api_mohe_graduate_record($applicantObject)
    {
        $rand_YN_attributes = [
                "attribute_1" => ['maxProb'=>20],
        ];
        $info_arr = [];
        foreach($rand_YN_attributes as $attribute => $attributeConfig)
        {
            $maxProbabilityForYes = $attributeConfig['maxProb'];
            list($old, $new) = self::randomizeYNAttribute($attribute, $applicantObject, $maxProbabilityForYes);        
            $info_arr[] = "$attribute done : value (with probability for Yes = $maxProbabilityForYes), old value was $old and now become $new";
        }

        $info = implode("<br>\n",$info_arr);

        $applicantObject->commit();
        return ["", $info, "", ""];


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
        if (!class_exists("TvtcCopyFromProspect", false)) {
            $file_dir_name = dirname(__FILE__);
            require($file_dir_name . "/tvtc_copy_from_prospect.php");
        }
        $res = TvtcCopyFromProspect::copyFromProspect($applicantObject->id, $applicantObject);
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
        $rand_YN_attributes = [
            "attribute_27" => ['maxProb'=>93],
            "attribute_11" => ['maxProb'=>93],
        ];
        $info_arr = [];
        foreach($rand_YN_attributes as $attribute => $attributeConfig)
        {
            $maxProbabilityForYes = $attributeConfig['maxProb'];
            list($old, $new) = self::randomizeYNAttribute($attribute, $applicantObject, $maxProbabilityForYes);        
            $info_arr[] = "$attribute done : value (with probability for Yes = $maxProbabilityForYes), old value was $old and now become $new";
        }

        $info = implode("<br>\n",$info_arr);

        $applicantObject->commit();
        return ["", $info, "", ""];
        
    }

    public static function run_api_rayat_api($applicantObject)
    {

        $rand_YN_attributes = [
            "attribute_5" => ['maxProb'=>20],
            "attribute_8" => ['maxProb'=>10],
        ];
        $info_arr = [];
        foreach($rand_YN_attributes as $attribute => $attributeConfig)
        {
            $maxProbabilityForYes = $attributeConfig['maxProb'];
            list($old, $new) = self::randomizeYNAttribute($attribute, $applicantObject, $maxProbabilityForYes);        
            $info_arr[] = "$attribute done : value (with probability for Yes = $maxProbabilityForYes), old value was $old and now become $new";
        }

        $info = implode("<br>\n",$info_arr);

        $applicantObject->commit();
        return ["", $info, "", ""];
    }


    public static function run_api_noor_api($applicantObject)
    {
        // return [$error, $info, $warning, $tech]
        // return ["not implemented", "", "", ""];
        return ["", "done", "", ""];
    }

    

    

    



}