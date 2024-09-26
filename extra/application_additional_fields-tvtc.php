<?php
global $application_additional_fields;

$application_additional_fields = [
    'attribute_1' => array('type' => 'INT', 'css' => 'width_pct_25', 'size' => 64, 'step' => 1, 
                            'field_code' => 'applicant_age', 'optional' => false, 'readonly' =>true,
                            'title_ar' => 'عمر المتقدم', 'title_en' => 'applicant age', 
                            'category' => 'FORMULA',
                            'formula' => 'calcApplicantAge', ),
                            
    'attribute_2' => array('type' => 'INT', 'css' => 'width_pct_25', 'size' => 64, 'step' => 1, 
                            'field_code' => 'applicant_age', 'optional' => false, 'readonly' =>true,
                            'title_ar' => 'عمر المؤهل', 'title_en' => 'qualification age', 
                            'category' => 'FORMULA',
                            'formula' => 'calcQualificationAge', ),
    
];

class ApplicationFormulaManager
{
    public static function calcApplicantAge($applicationObj)
    {
        // die("here calcApplicantAge");
        try
        {
            $age = -1;
            $age_aparameter_id = 10;
            $application_model_id = $applicationObj->getVal("application_model_id");
            $application_plan_id = $applicationObj->getVal("application_plan_id");
            // date of calculation of age
            $objPV = AparameterValue::loadByMainIndex($age_aparameter_id, $application_model_id, $application_plan_id, $training_unit_id = 0, $department_id = 0, $application_model_branch_id = 0);
            if($objPV)
            {
                $start_gdate = $objPV->getVal("value");
                $applicantObj = $applicationObj->het("applicant_id"); 
                if($applicantObj)
                {
                    $birth_gdate = $applicantObj->getVal("birth_gdate");
                    if(AfwDateHelper::isCorrectGregDate($birth_gdate) and AfwDateHelper::isCorrectGregDate($start_gdate))
                    {
                        $ageInDays = AfwDateHelper::diff_date($start_gdate,$birth_gdate,false);
                        $age = round(10 * $ageInDays / 365) / 10;
                    }
                    else $age = -4; // applicant birth date format incorrect
                }
                else $age = -3; // no applicant 
            }
            else $age = -2; // no start date to calculate age
    
            return $age;
        }
        catch(Exception $e)
        {
            return -99;
        }
    }
    
    public static function calcQualificationAge($applicationObj)
    {
        try
        {
            $age = -1;
            $age_aparameter_id = 9;
            $application_model_id = $applicationObj->getVal("application_model_id");
            $application_plan_id = $applicationObj->getVal("application_plan_id");
            // date of calculation of age
            $objPV = AparameterValue::loadByMainIndex($age_aparameter_id, $application_model_id, $application_plan_id, $training_unit_id = 0, $department_id = 0, $application_model_branch_id = 0);
            if($objPV)
            {
                $start_gdate = $objPV->getVal("value");
                $qualifObj = $applicationObj->het("applicant_qualification_id"); 
                if($qualifObj)
                {
                    $qual_date = $qualifObj->getVal("date");
                    if(AfwDateHelper::isCorrectGregDate($qual_date) and AfwDateHelper::isCorrectGregDate($start_gdate))
                    {
                        $ageInDays = AfwDateHelper::diff_date($start_gdate, $qual_date,false);
                        $age = round(10 * $ageInDays / 365) / 10;
                        if($age<=0) $age = 0;
                    }
                    else $age = -4;                    
                }
                else $age = -3;
            }
            else $age = -2; // no start date to calculate age
    
            return $age;
        }
        catch(Exception $e)
        {
            return -99;
        }
    }
    
}
