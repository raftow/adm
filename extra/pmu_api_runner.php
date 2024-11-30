<?php
class PmuApiRunner {

    public static function register_apis()
    {
        return [];
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

    



}